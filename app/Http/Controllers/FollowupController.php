<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Bus\DispatchesJobs;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

// Model
use App\Models\Contacts;
use App\Models\ConfigsProject;
use App\Models\ConfigsProjectDocument;
use App\Models\Masters;
use App\Models\Projects;
use App\Models\ProjectsActivityActual;
use App\Models\ProjectsActivityDisbursement;
use App\Models\ProjectsActivityExpansion;
use App\Models\ProjectsActivityIssue;
use App\Models\ProjectsActivityPerformance;
use App\Models\ProjectsActual;
use App\Models\ProjectsBudget;
use App\Models\ProjectsDocument;
use App\Models\ProjectsDocumentActual;
use App\Models\ProjectsGrouping;
use App\Models\ProjectsInvestmentActual;
use App\Models\ProjectsInvestmentActualDetail;
use App\Models\ProjectsInvestmentActualHeader;
use App\Models\ProjectsInvestmentBudgetHeader;
use App\Models\ProjectsPlan;
use App\Models\ProjectsReturn;
use App\Models\vContacts;
use App\Models\vProjects;
use App\Models\vProjectsActivity;
use App\Models\vProjectsActivityActual;
use App\Models\vProjectsActivityExpansion;
use App\Models\vProjectsBudget;
use App\Models\vProjectsDocument;
use App\Models\vProjectsInvestmentActual;

// Excel
use App\Exports\ProjectsActivityPerformanceExport;

class FollowupController extends BaseController
{
    public function index()
    {
        $data['cnt_projects'] = vProjects::whereIn('status_code', ['17004','17005'])->count();
        
        $auth = Auth::user();
        $data['projects'] = vProjects::whereNull('project_parent')
            ->whereIn('status_code', ['17004','17005'])
            ->where(function ($query) use ($auth) {
                if ($auth->role != '23001')
                {
                    $query->where('contact_id', $auth->id);
                }
            })
            ->get();
        foreach ($data['projects'] as $idx => $project)
        {
            $data['projects'][$idx]->children = vProjects::where('project_parent', $project->project_id)
                ->whereIn('status_code', ['17004','17005'])
                ->get();
        }

        return view('followup.index', $data);
    }

    public function timeline($project_id)
    {
        $data['doc_groups'] = Masters::where('type', 'DocumentGroup')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        foreach ($data['doc_groups'] as $group)
        {
            $data['documents'][$group->code] = vProjectsDocument::where('project_id', $project_id)
                ->where('book_group_code', $group->code)
                ->orderBy('imported_at')
                ->get();
        }

        return view('followup.modal_timeline', $data);
    }

    public function document_add($project_id)
    {
        $data['documents'] = Masters::where('type', 'Document')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['project_id'] = $project_id;
        return view('followup.modal_document_add', $data);
    }

    public function info($project_id)
    {
        $data['project'] = vProjects::where('project_id', $project_id)->first();
        
        // พิจารณาโครงการ
        // $data['budget'] = vProjectsBudget::where('project_id', $project_id)->firstOr(function(){
        //     return new vProjectsBudget;
        // });
        // $data['activities'] = vProjectsActivity::info($project_id, $data['project']->plan_begin_year, $data['project']->plan_end_year);
        // $data['finances'] = ProjectsReturn::where('project_id', $project_id)->where('type', 'Finance')->get();
        // $data['economics'] = ProjectsReturn::where('project_id', $project_id)->where('type', 'Economic')->get();

        // ติดตามโครงการ
        $data['current_expansion'] = ProjectsActivityExpansion::where('project_id', $project_id)->max('id');
        $data['expansion'] = vProjectsActivityExpansion::where('project_id', $project_id)
            ->where('id', $data['current_expansion'])
            ->first();
        $data['actual_begin_year'] = !empty($data['expansion']->begin_date) ? substr($data['expansion']->begin_date, -4) : date('Y') + 543;
        $data['actual_end_year'] = !empty($data['expansion']->end_date) ? substr($data['expansion']->end_date, -4) : date('Y') + 543;
        $data['activities'] = vProjectsActivityActual::info($project_id, $data['actual_begin_year'], $data['actual_end_year'], $data['current_expansion']);
        
        $data['investments'] = vProjectsInvestmentActual::where('project_id', $project_id)->get();
        $data['investment_header'] = ProjectsInvestmentActualHeader::where('project_id', $project_id)->first();
        return view('followup.modal_info', $data);
    }

    public function general(Request $request, $project_id)
    {
        $data['project_id'] = $project_id;
        $data['provinces'] = Masters::where('type', 'Province')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['arealevels'] = Masters::where('type', 'AreaLevel')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['divisions'] = Masters::where('type', 'Division')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['projects_desc'] = vProjects::whereIn('status_code', ['17004','17005'])->select('description')->orderBy('description')->get();
        // $data['project'] = vProjects::where('description', $request->input('current_project_desc'))->firstOr(function(){
        $data['project'] = vProjects::where('project_id', $project_id)->firstOr(function(){
            return new vProjects;
        });
        
        $data['investments'] = DB::table('masters as m')
            ->leftJoin('projects_investment_actual as a', function($join) use ($project_id){
                $join->on('m.code', '=', 'a.fund_code')
                    ->where('a.project_id', '=', $project_id);
            })
            ->select(['a.project_id', 'm.code AS fund_code', 'm.description AS fund_desc', 'a.actual AS fund_value'])
            ->where('m.type', DB::Raw('"SourceOfFund"'))
            ->get();
        $data['investment'] = ProjectsInvestmentActualHeader::where('project_id', $project_id)->firstOr(function() use ($project_id){
            return ProjectsInvestmentBudgetHeader::where('project_id', $project_id)->firstOr(function(){
                return new ProjectsInvestmentBudgetHeader;
            });
        });
        $data['investment_details'] = ProjectsInvestmentActualDetail::where('project_id', $project_id)->get();
        $data['current_expansion'] = $request->filled('expansion_id') ? $request->input('expansion_id') : ProjectsActivityExpansion::where('project_id', $project_id)->max('id');
        $data['expansion'] = vProjectsActivityExpansion::where('project_id', $project_id)
            ->where('id', $data['current_expansion'])
            ->first();
        $data['actual_begin_year'] = !empty($data['expansion']->begin_date) ? substr($data['expansion']->begin_date, -4) : date('Y') + 543;
        $data['actual_end_year'] = !empty($data['expansion']->end_date) ? substr($data['expansion']->end_date, -4) : date('Y') + 543;
        $data['activities'] = vProjectsActivityActual::info($project_id, $data['actual_begin_year'], $data['actual_end_year'], $data['current_expansion']);

        // This section is additional information for general final page
        $data['expansions'] = vProjectsActivityExpansion::where('project_id', $project_id)->get();
        $data['division'] = Masters::where('type', 'Division')->where('code', $data['project']->division_code)->first();
        $data['document'] = ProjectsDocumentActual::where('project_id', $project_id)->first();

        // This section is for trigger button "แก้ไขข้อมูล" from confirm page
        if ($request->input('rollback') == 1)
        {
            $data['project']->description = $request->input('project_desc');
            $data['project']->division_code = $request->input('division_code');
            $data['project']->actual = $request->input('actual_all');
            $data['project']->area_level_code = $request->input('area_level_code');
            $data['project']->area = is_array($request->input('areas')) ? implode(';', $request->input('areas')) : $request->input('areas');
            $data['project']->area_detail = $request->input('area_detail');

            $data['document_path'] = $request->input('document_path');
            $data['document_name'] = $request->input('document_name');
            $data['investment']->included_vat = $request->input('included_vat');
            $data['investment']->investment_type = $request->input('investment_type');
            foreach ($data['investment_details'] as $idx => $investment)
            {
                $data['investment_details'][$idx]->fund_value = $request->input('investments.'.$investment->fund_code.'.actual');
            }
            
            $data['expansion']->begin_date = $request->input('date_start');
            $data['expansion']->end_date = $request->input('date_end');

            $activities_keyin = [];
            $req_activities = $request->input('activities');
            foreach ($data['activities'] as $idx => $activity)
            {
                // Sub activity records, ignore data from database
                if (isset($activity->sub_activity_desc) && ! empty($activity->sub_activity_desc))
                {
                    continue;
                }

                // Activity records
                if (empty($activity->sub_activity_desc) && isset($req_activities[$activity->code]))
                {
                    $activity->selected = $req_activities[$activity->code]['selected'];
                    foreach ($req_activities[$activity->code]['period'] as $year => $req_activity)
                    {
                        $activity->{$year} = $req_activity['actual'];
                        $activity->{$year . '_month_begin'} = $req_activity['begin'];
                        $activity->{$year . '_month_end'} = $req_activity['end'];
                    }
                }

                // Declare activity record
                $activities_keyin[] = $activity;

                // Sub activity records, push data from request data
                foreach ($req_activities as $idy => $req_activity)
                {
                    if (empty($req_activity['sub_activity_desc']))
                    {
                        continue;
                    }

                    if ($activity->code !== substr($idy, 0, 5))
                    {
                        continue;
                    }

                    $sub_activity = new \stdClass();
                    $sub_activity->code = $req_activity['activity_code'];
                    $sub_activity->sub_activity_desc = $req_activity['sub_activity_desc'];
                    $activities_keyin[] = $sub_activity;
                }
            }

            $data['activities'] = $activities_keyin;
        }

        if ($request->input('project_expansion') == 1)
        {
            $data['project_expansion'] = $request->input('project_expansion');
            $data['expansion_code'] = $request->input('expansion_code');
            $data['project']->status_code = '17004';

            $data['expansions'] = Masters::where('type', 'Expansion')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        }

        $data['uri'] = $request->path();
        return view('followup.main', $data);
    }

    public function general_confirm(Request $request)
    {
        // Save upload file as temporary
        $data['document_path'] = $request->input('document_path');
        $data['document_name'] = $request->input('document_name');
        if ($request->hasFile('document'))
        {
            $document = $request->file('document');
            $data['document_path'] = Storage::putFileAs('tmp', $document, $document->getClientOriginalName());
            $data['document_name'] = substr($data['document_path'], strpos($data['document_path'], '/') + 1, strlen($data['document_path']));
        }
        
        $data['request'] = (object)$request->all();
        $data['division'] = Masters::where('type', 'Division')->where('code', $request->input('division_code'))->first();
        $data['area_level'] = Masters::where('type', 'AreaLevel')->where('code', $request->input('area_level_code'))->first();
        $data['activities'] = Masters::where('type', 'Activity')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();

        return view('followup.general_confirm', $data);
    }

    public function general_save(Request $request)
    {
        try {
            DB::beginTransaction();

            $project_id = $request->input('project_id');

            if ($request->input('project_notfound') == 1)
            {
                $project = Projects::create([
                    'description' => $request->input('project_desc'),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                if (empty($project))
                {
                    DB::rollback();
                    return redirect('followup/' . $project_id . '/general')->with('response', response_error('ไม่สามารถเพิ่มข้อมูลโครงการได้'));
                }

                $project_id = $project->project_id;
            }

            $result = Projects::updateOrCreate([
                    'project_id' => $project_id,
                ],[
                    'description' => $request->input('project_desc'),
                    'status_code' => '17005',
                    'division_code' => $request->input('division_code'),
                    'area_level_code' => $request->input('area_level_code'),
                    'area' => is_array($request->input('areas')) ? implode(';', $request->input('areas')) : $request->input('areas'),
                    'area_detail' => $request->input('area_detail'),
                    'actual' => $request->input('actual_all'),
                    'updated_by' => Auth::user()->id,
                ]);
            if (empty($result))
            {
                DB::rollback();
                return redirect('followup/' . $project_id . '/general')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลโครงการได้'));
            }

            // Upload attached file
            if ($request->filled('document_name'))
            {
                // Move file to NESDC folder. Before move, check file name existing or not
                $document_name = (Storage::exists($project_id.'/'.$request->input('document_name')) ? str_replace('.', '_' . time() . '.', $request->input('document_name')) : $request->input('document_name'));
                Storage::move($request->input('document_path'), $document);
        
                unset($result);
                $result = ProjectsDocumentActual::create([
                    'project_id' => $project_id,
                    'filename' => $document_name,
                    'filepath' => $project_id . '/' . $document_name,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                if (empty($result))
                {
                    DB::rollback();
                    return redirect('followup/' . $project_id . '/general')->with('response', response_error('ไม่สามารถแก้ไขบันทึกไฟล์แนบได้'));
                }
            }

            $result = ProjectsInvestmentActualHeader::updateOrCreate([
                    'project_id' => $project_id
                ],[
                    'investment_type' => $request->input('investment_type'),
                    'included_vat' => (bool)$request->input('included_vat')
                ]);
            if (empty($result))
            {
                DB::rollback();
                return redirect('followup/' . $project_id . '/general')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลแหล่งเงินทุนได้'));
            }

            if ($request->filled('investments'))
            {
                unset($result);
                foreach ($request->input('investments') as $fund_code => $investment)
                {
                    $result = ProjectsInvestmentActual::updateOrCreate([
                            'project_id' => $project_id,
                            'fund_code' => $fund_code
                        ],[
                            'actual' => $investment['actual'],
                        ]);
                    if (empty($result))
                    {
                        DB::rollback();
                        return redirect('followup/' . $project_id . '/general')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลแหล่งเงินทุนได้'));
                    }
                }
            }

            $expansion = ProjectsActivityExpansion::create([
                'project_id' => $project_id,
                'expansion_code' => $request->input('expansion_code'),
                'begin_date' => $request->input('date_start'),
                'end_date' => $request->input('date_end'),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);
            if (empty($expansion))
            {
                DB::rollback();
                return redirect('followup/' . $project_id . '/general')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลแผนการดำเนินโครงการได้'));
            }

            if ($request->filled('activities'))
            {
                unset($result);
                foreach ($request->input('activities') as $activity)
                {
                    if ( ! isset($activity['period']))
                    {
                        continue;
                    }

                    foreach ($activity['period'] as $period => $budget)
                    {
                        $result = ProjectsActivityActual::updateOrCreate([
                                'project_id' => $project_id,
                                'expansion_id' => $expansion->id,
                                'activity_code' => $activity['activity_code'],
                                'sub_activity_desc' => $activity['sub_activity_desc'],
                                'period' => $period,
                            ],[
                                'selected' => isset($activity['selected']) ? (bool)$activity['selected'] : 0,
                                'month_begin' => $budget['begin'],
                                'month_end' => $budget['end'],
                                'budget' => isset($budget['actual']) ? $budget['actual'] : 0,
                            ]);
                        if (empty($result))
                        {
                            DB::rollback();
                            return redirect('followup/' . $project_id . '/general')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลแผนการดำเนินโครงการได้'));
                        }
                    }
                }
            }

            DB::commit();
            return redirect('followup/' . $project_id . '/general')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect('followup/' . $project_id . '/general')->with('response', response_error($e->getMessage()));
        }
    }

    public function performance(Request $request, $project_id)
    {
        $data['project_id'] = $project_id;
        $data['project'] = vProjects::where('project_id', $data['project_id'])->firstOr(function(){
            return new vProjects;
        });
        $data['current_expansion'] = $request->filled('expansion_id') ? $request->input('expansion_id') : ProjectsActivityExpansion::where('project_id', $data['project']->project_id)->max('id');
        $data['expansion'] = vProjectsActivityExpansion::where('project_id', $data['project']->project_id)
            ->where('id', $data['current_expansion'])
            ->first();
        $data['actual_begin_year'] = !empty($data['expansion']->begin_date) ? substr($data['expansion']->begin_date, -4) : date('Y') + 543;
        $data['actual_end_year'] = !empty($data['expansion']->end_date) ? substr($data['expansion']->end_date, -4) : date('Y') + 543;

        // This section is additional information for performange page
        $data['config_nesdc_months'] = config('custom.data_nesdc_months');
        $data['activities_actual'] = DB::table('projects_activity_actual as a')
            ->leftJoin('masters as m', function ($join) {
                $join->on('m.type', '=', DB::Raw('"Activity"'));
                $join->on('m.code', '=', 'a.activity_code');
            })
            ->where('a.project_id', $data['project']->project_id)
            ->where('a.selected', 1)
            ->where('a.expansion_id', $data['current_expansion'])
            ->orderBy('a.period')
            ->orderBy('m.code')
            ->get();
        $data['performances'] = ProjectsActivityPerformance::where('project_id', $data['project']->project_id)
            ->selectRaw('project_id, period, SUM(budget) AS budget, SUM(actual) AS actual')
            ->groupBy(['project_id', 'period'])
            ->get();
        foreach ($data['activities_actual'] as $id => $tmpdata)
        {
            $data['activities_actual'][$id]->detail = ProjectsActivityPerformance::where('project_id', $data['project']->project_id)
                ->where('period', $tmpdata->period)
                ->where('activity_code', $tmpdata->activity_code)
                ->orderBy('id')
                ->get()
                ->toArray();
        }
        $data['issues'] = ProjectsActivityIssue::where('project_id', $data['project']->project_id)->where('issue_activity', 'ผลการดำเนินงาน')->get();

        $data['uri'] = $request->path();
        return view('followup.main', $data);
    }

    public function performance_export(Request $request, $project_id, $period)
    {
        $project = vProjects::where('project_id', $project_id)->first();

        $filename = 'แผนและผลการดำเนินงาน ' . $project->description . ' (ปี ' . $period . ').xlsx';
        return Excel::download(new ProjectsActivityPerformanceExport($project_id, $period), $filename);
    }

    public function performance_import()
    {
        $excel = Excel::toCollection(new UsersImport, request()->file('your_file'));
        print_array($excel);
    }

    public function performance_issue($project_id)
    {
        $data['project_id'] = $project_id;
        $data['issues'] = ProjectsActivityIssue::where('project_id', $project_id)->where('issue_activity', 'ผลการดำเนินการงาน')->get();
        $data['url_add'] = url('api/followup/' . $project_id . '/performance/issue/add');
        return view('followup.modal_issue', $data);
    }

    public function performance_issue_add(Request $request, $project_id)
    {
        try {
            if ( ! $request->filled('issue_desc'))
            {
                return response()->json(['result' => false, 'message' => 'กรุณากรอกรายละเอียดของปัญหา/อุปสรรค']);
            }

            DB::beginTransaction();

            $result = ProjectsActivityIssue::create([
                'project_id' => $project_id,
                'issue_activity' => 'ผลการดำเนินงาน',
                'issue_date' => $request->input('issue_date'),
                'issue_desc' => $request->input('issue_desc'),
            ]);
            if (empty($result))
            {
                DB::rollback();
                return response()->json(['result' => false, 'message' => 'ไม่สามารถเพิ่มข้อมูลได้']);
            }

            DB::commit();
            return response()->json([
                'result' => true, 
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว', 
                'data' => [
                    DateFormat($request->input('issue_date'), 'MMM YYYY', false),
                    $request->input('issue_desc')
                ]
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result' => false, 'message' => $e->getMessage()]);
        }
    }

    public function performance_confirm()
    {
        return view('followup.modal_confirm');
    }

    public function performance_save(Request $request, $project_id)
    {
        try {
            DB::beginTransaction();

            foreach ($request->input('performances') as $period => $yearly)
            {
                foreach ($yearly as $month => $monthly)
                {
                    foreach ($monthly as $activity_code => $_data)
                    {
                        $result = ProjectsActivityPerformance::updateOrCreate([
                                'project_id' => $project_id,
                                'period' => $period,
                                'month' => $month,
                                'activity_code' => $activity_code,
                            ],[
                                'budget' => $_data['budget'],
                                'actual' => isset($_data['actual']) ? $_data['actual'] : 0,
                            ]);
                        if (empty($result))
                        {
                            DB::rollback();
                            return redirect('/followup/'.$project_id.'/performance')->with('response', response_error('ไม่สามารถบันทึกข้อมูลได้'));
                        }
                    }
                }
            }

            DB::commit();
            return redirect('/followup/'.$project_id.'/performance')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect('/followup/'.$project_id.'/performance')->with('response', response_error($e->getMessage()));
        }
    }

    public function disbursement_money(Request $request, $project_id)
    {
        $data['project_id'] = $project_id;
        $data['project'] = vProjects::where('project_id', $data['project_id'])->firstOr(function(){
            return new vProjects;
        });
        $data['current_expansion'] = $request->filled('expansion_id') ? $request->input('expansion_id') : ProjectsActivityExpansion::where('project_id', $project_id)->max('id');
        $data['expansion'] = vProjectsActivityExpansion::where('project_id', $project_id)
            ->where('id', $data['current_expansion'])
            ->first();
        $data['actual_begin_year'] = !empty($data['expansion']->begin_date) ? substr($data['expansion']->begin_date, -4) : date('Y') + 543;
        $data['actual_end_year'] = !empty($data['expansion']->end_date) ? substr($data['expansion']->end_date, -4) : date('Y') + 543;

        // This section is additional information for performange page
        $data['config_nesdc_months'] = config('custom.data_nesdc_months');
        $data['investments_detail'] = [];
        for ($i=$data['actual_begin_year']; $i<=$data['actual_end_year']; $i++)
        {
            $investments = DB::table('projects_investment_actual as a')
                ->leftJoin('masters as m', function ($join) {
                    $join->on('m.type', '=', DB::Raw('"SourceOfFund"'));
                    $join->on('m.code', '=', 'a.fund_code');
                })
                ->select(['a.*', 'm.*', DB::Raw('"' . $i . '" AS period')])
                ->where('a.project_id', $project_id)
                ->whereNotNull('a.actual')
                ->orderBy('m.code')
                ->get()->toArray();

            $data['investments_detail'] = (object)array_merge((array)$data['investments_detail'], $investments);
        }
        foreach ($data['investments_detail'] as $id => $tmpdata)
        {
            $data['investments_detail']->{$id}->detail = ProjectsInvestmentActualDetail::where('project_id', $project_id)
                ->where('period', $tmpdata->period)
                ->where('fund_code', $tmpdata->fund_code)
                ->orderBy('id')
                ->get()
                ->toArray();
        }
        $data['disbursements'] = ProjectsInvestmentActualDetail::where('project_id', $project_id)
            ->selectRaw('project_id, period, SUM(budget) AS budget, SUM(actual) AS actual')
            ->groupBy(['project_id', 'period'])
            ->get();
        $data['total_disbursement'] = ProjectsInvestmentActualDetail::where('project_id', $project_id)->sum('actual');
        $data['issues'] = ProjectsActivityIssue::where('project_id', $project_id)->where('issue_activity', 'ผลการเบิกจ่าย (แหล่งเงิน)')->get();

        $data['uri'] = $request->path();
        return view('followup.main', $data);
    }

    public function disbursement_money_save(Request $request, $project_id)
    {
        try {
            DB::beginTransaction();

            foreach ($request->input('disbursements') as $period => $yearly)
            {
                foreach ($yearly as $month => $monthly)
                {
                    foreach ($monthly as $fund_code => $_data)
                    {
                        $result = ProjectsInvestmentActualDetail::updateOrCreate([
                                'project_id' => $project_id,
                                'period' => $period,
                                'month' => $month,
                                'fund_code' => $fund_code,
                            ],[
                                'budget' => $_data['budget'],
                                'actual' => isset($_data['actual']) ? $_data['actual'] : 0,
                            ]);
                        if (empty($result))
                        {
                            DB::rollback();
                            return redirect('/followup/'.$project_id.'/disbursement/money')->with('response', response_error('ไม่สามารถบันทึกข้อมูลได้'));
                        }
                    }
                }
            }

            DB::commit();
            return redirect('/followup/'.$project_id.'/disbursement/money')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect('/followup/'.$project_id.'/disbursement/money')->with('response', response_error($e->getMessage()));
        }
    }
    
    public function disbursement_money_issue($project_id)
    {
        $data['project_id'] = $project_id;
        $data['issues'] = ProjectsActivityIssue::where('project_id', $project_id)->where('issue_activity', 'ผลการเบิกจ่าย (แหล่งเงิน)')->get();
        $data['url_add'] = url('api/followup/' . $project_id . '/disbursement/money/issue/add');
        return view('followup.modal_issue', $data);
    }

    public function disbursement_money_issue_add(Request $request, $project_id)
    {
        try {
            if ( ! $request->filled('issue_desc'))
            {
                return response()->json(['result' => false, 'message' => 'กรุณากรอกรายละเอียดของปัญหา/อุปสรรค']);
            }

            DB::beginTransaction();

            $result = ProjectsActivityIssue::create([
                'project_id' => $project_id,
                'issue_activity' => 'ผลการเบิกจ่าย (แหล่งเงิน)',
                'issue_date' => $request->input('issue_date'),
                'issue_desc' => $request->input('issue_desc'),
            ]);
            if (empty($result))
            {
                DB::rollback();
                return response()->json(['result' => false, 'message' => 'ไม่สามารถเพิ่มข้อมูลได้']);
            }

            DB::commit();
            return response()->json([
                'result' => true, 
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว', 
                'data' => [
                    DateFormat($request->input('issue_date'), 'MMM YYYY', false),
                    $request->input('issue_desc')
                ]
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result' => false, 'message' => $e->getMessage()]);
        }
    }

    public function disbursement_money_confirm()
    {
        return view('followup.modal_confirm');
    }

    public function disbursement_activity(Request $request, $project_id)
    {
        $data['project_id'] = $project_id;
        $data['project'] = vProjects::where('project_id', $data['project_id'])->firstOr(function(){
            return new vProjects;
        });
        $data['current_expansion'] = $request->filled('expansion_id') ? $request->input('expansion_id') : ProjectsActivityExpansion::where('project_id', $project_id)->max('id');
        $data['expansion'] = vProjectsActivityExpansion::where('project_id', $project_id)
            ->where('id', $data['current_expansion'])
            ->first();
        $data['actual_begin_year'] = !empty($data['expansion']->begin_date) ? substr($data['expansion']->begin_date, -4) : date('Y') + 543;
        $data['actual_end_year'] = !empty($data['expansion']->end_date) ? substr($data['expansion']->end_date, -4) : date('Y') + 543;

        // This section is additional information for performange page
        $data['config_nesdc_months'] = config('custom.data_nesdc_months');
        $data['activities_actual'] = DB::table('projects_activity_actual as a')
            ->leftJoin('masters as m', function ($join) {
                $join->on('m.type', '=', DB::Raw('"Activity"'));
                $join->on('m.code', '=', 'a.activity_code');
            })
            ->where('a.project_id', $project_id)
            ->where('a.selected', 1)
            ->where('a.expansion_id', $data['current_expansion'])
            ->orderBy('a.period')
            ->orderBy('m.code')
            ->get();
        $data['disbursements'] = ProjectsActivityDisbursement::where('project_id', $project_id)
            ->selectRaw('project_id, period, SUM(budget) AS budget, SUM(actual) AS actual')
            ->groupBy(['project_id', 'period'])
            ->get();
        foreach ($data['activities_actual'] as $id => $tmpdata)
        {
            $data['activities_actual'][$id]->detail = ProjectsActivityDisbursement::where('project_id', $project_id)
                ->where('period', $tmpdata->period)
                ->where('activity_code', $tmpdata->activity_code)
                ->orderBy('id')
                ->get()
                ->toArray();
        }
        $data['total_disbursement'] = ProjectsActivityDisbursement::where('project_id', $project_id)->sum('actual');
        $data['issues'] = ProjectsActivityIssue::where('project_id', $project_id)->where('issue_activity', 'ผลการเบิกจ่าย (รายกิจกรรม)')->get();

        $data['uri'] = $request->path();
        return view('followup.main', $data);
    }

    public function disbursement_activity_export(Request $request, $project_id, $period)
    {
        // return Excel::download(new UsersExport, 'users-list.xlsx');
        return Excel::download(new ProjectsActivityPerformanceExport($project_id, $period), 'users-list.xlsx');
    }

    public function disbursement_activity_import()
    {
        return view();
    }

    public function disbursement_activity_issue($project_id)
    {
        $data['project_id'] = $project_id;
        $data['issues'] = ProjectsActivityIssue::where('project_id', $project_id)->where('issue_activity', 'ผลการเบิกจ่าย (รายกิจกรรม)')->get();
        $data['url_add'] = url('api/followup/' . $project_id . '/disbursement/activity/issue/add');
        return view('followup.modal_issue', $data);
    }

    public function disbursement_activity_issue_add(Request $request, $project_id)
    {
        try {
            if ( ! $request->filled('issue_desc'))
            {
                return response()->json(['result' => false, 'message' => 'กรุณากรอกรายละเอียดของปัญหา/อุปสรรค']);
            }

            DB::beginTransaction();

            $result = ProjectsActivityIssue::create([
                'project_id' => $project_id,
                'issue_activity' => 'ผลการเบิกจ่าย (รายกิจกรรม)',
                'issue_date' => $request->input('issue_date'),
                'issue_desc' => $request->input('issue_desc'),
            ]);
            if (empty($result))
            {
                DB::rollback();
                return response()->json(['result' => false, 'message' => 'ไม่สามารถเพิ่มข้อมูลได้']);
            }

            DB::commit();
            return response()->json([
                'result' => true, 
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว', 
                'data' => [
                    DateFormat($request->input('issue_date'), 'MMM YYYY', false),
                    $request->input('issue_desc')
                ]
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result' => false, 'message' => $e->getMessage()]);
        }
    }

    public function disbursement_activity_confirm()
    {
        return view('followup.modal_confirm');
    }

    public function disbursement_activity_save(Request $request, $project_id)
    {
        try {
            DB::beginTransaction();

            foreach ($request->input('disbursements') as $period => $yearly)
            {
                foreach ($yearly as $month => $monthly)
                {
                    foreach ($monthly as $activity_code => $_data)
                    {
                        $result = ProjectsActivityDisbursement::updateOrCreate([
                                'project_id' => $project_id,
                                'period' => $period,
                                'month' => $month,
                                'activity_code' => $activity_code,
                            ],[
                                'budget' => $_data['budget'],
                                'actual' => isset($_data['actual']) ? $_data['actual'] : 0,
                            ]);
                        if (empty($result))
                        {
                            DB::rollback();
                            return redirect('/followup/'.$project_id.'/disbursement/activity')->with('response', response_error('ไม่สามารถบันทึกข้อมูลได้'));
                        }
                    }
                }
            }

            DB::commit();
            return redirect('/followup/'.$project_id.'/disbursement/activity')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect('/followup/'.$project_id.'/disbursement/activity')->with('response', response_error($e->getMessage()));
        }
    }

    public function delete(Request $request)
    {
        try {
            $result = Projects::where('project_id', $request->input('project_id'))->update([
                'status_code' => '17009',
                'updated_by' => Auth::user()->id,
            ]);
            if ($result == 0)
            {
                DB::rollback();
                return redirect('/project/followup')->with('response', response_error('ไม่สามารถลบข้อมูลโครงการได้'));
            }

            return redirect('/project/followup')->with('response', response_success('ลบข้อมูลเรียบร้อยแล้ว'));
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect('/project/followup')->with('response', response_error($e->getMessage()));
        }
    }
}
