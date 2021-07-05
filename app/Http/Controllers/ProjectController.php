<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Bus\DispatchesJobs;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Contacts;
use App\Models\ConfigsProject;
use App\Models\ConfigsProjectDocument;
use App\Models\Masters;
use App\Models\Projects;
use App\Models\ProjectsActivity;
use App\Models\ProjectsBudget;
use App\Models\ProjectsDocument;
use App\Models\ProjectsGrouping;
use App\Models\ProjectsGroupingDetail;
use App\Models\ProjectsInvestmentBudget;
use App\Models\ProjectsInvestmentBudgetHeader;
use App\Models\ProjectsPlan;
use App\Models\ProjectsReturn;
use App\Models\vContacts;
use App\Models\vProjects;
use App\Models\vProjectsActivity;
use App\Models\vProjectsBudget;
use App\Models\vProjectsDocument;
use App\Models\vUsers;

class ProjectController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get($project_id)
    {
        $data['project'] = vProjects::where('project_id', $project_id)->firstOr(function(){
            return new vProjects;
        });

        return response()->json($data);
    }

    public function search(Request $request)
    {
        $data['ministrys'] = Masters::where('type', 'Ministry')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['departments'] = Masters::where('type', 'DepartmentProject')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['investments'] = Masters::where('type', 'Investment')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['provinces'] = Masters::where('type', 'Province')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();

        // ดึงข้อมูลโครงการที่สถานะเป็น "ครม.อนุมัติแล้ว"
        $data['projects'] = vProjects::where('status_code', '17004')
            ->where('description', 'LIKE', '%' . $request->input('nameproject') . '%')
            ->where(function ($query) use ($request) {
                if ($request->filled('year'))
                {
                    $query->where('plan_begin_year', '<=', $request->input('year'));
                    $query->where('plan_end_year', '>=', $request->input('year'));
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('ministry_code'))
                {
                    $query->where('ministry_code', $request->input('ministry_code'));
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('department_code'))
                {
                    $query->where('department_code', $request->input('department_code'));
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('investment_code'))
                {
                    $query->where('investment_code', $request->input('investment_code'));
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('area'))
                {
                    $query->where('area', 'LIKE', '%' . $request->input('area') . '%');
                }
            })
            ->get();

        return view('project.search', $data);
    }

    public function info($project_id)
    {
        $data['project'] = vProjects::where('project_id', $project_id)->first();
        return view('project.modal_search', $data);
    }

    public function list(Request $request)
    {
        $data['prefixes'] = Masters::where('type', 'Prefix')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['departments_contact'] = Masters::where('type', 'DepartmentContact')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['books'] = Masters::where('type', 'Book')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['statuses'] = Masters::where('type', 'Status')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['divisions'] = Masters::where('type', 'Division')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['ministrys'] = Masters::where('type', 'Ministry')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['departments_project'] = Masters::where('type', 'DepartmentProject')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['investments'] = Masters::where('type', 'Investment')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        
        $data['projects'] = vProjects::where('description', 'LIKE', '%'.$request->input('description').'%')
            ->where(function ($query) use ($request) {
                if ($request->filled('registration_number'))
                {
                    $query->where('registration_number', 'LIKE', '%'.$request->input('registration_number').'%');
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('book_issued_at'))
                {
                    $query->whereDate('book_issued_at', $request->input('book_issued_at'));
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('book_number'))
                {
                    $query->where('book_number', 'LIKE', '%'.$request->input('book_number').'%');
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('contact_fullname'))
                {
                    $query->where('contact_fullname', 'LIKE', '%'.$request->input('contact').'%');
                }
            })
            ->get();

        return view('project.list', $data);
    }

    public function add($project_id)
    {
        $data['prefixes'] = Masters::where('type', 'Prefix')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['departments_contact'] = Masters::where('type', 'DepartmentContact')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['books'] = Masters::where('type', 'Book')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['project_types'] = Masters::where('type', 'ProjectType')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['divisions'] = Masters::where('type', 'Division')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['ministrys'] = Masters::where('type', 'Ministry')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['departments_project'] = Masters::where('type', 'DepartmentProject')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['investments'] = Masters::where('type', 'Investment')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        
        $data['projects_parent'] = vProjects::whereNull('project_parent')->get();
        $data['project'] = vProjects::where('project_id', $project_id)->firstOr(function(){
            return new vProjects;
        });

        $data['contact'] = vContacts::where('contact_id', $data['project']->contact_id)->firstOr(function(){
            return new vContacts;
        });

        return view('project.modal_add', $data);
    }

    public function adding(Request $request)
    {
        try 
        {
            DB::beginTransaction();

            $contact = Contacts::firstOrNew(
                [
                    'fname' => $request->input('fname'),
                    'lname' => $request->input('lname')
                ],[
                    'prefix_code' => $request->input('prefix'),
                    'position' => $request->input('position'),
                    'department_code' => $request->input('department'),
                    'email_division' => $request->input('email_division'),
                    'email' => $request->input('email'),
                    'tel' => $request->input('tel'),
                    'fax' => $request->input('fax'),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]
            );
            $contact->save();

            if ($request->filled('project_id'))
            {
                $project_id = $request->input('project_id');

                $project = Projects::where('project_id', $project_id)->first();

                // หา id ขอ project parent
                $parent = vProjects::where('description', $request->input('project_parent'))
                    ->whereNull('project_parent')
                    ->firstOr(function(){
                        $obj = new \StdClass();
                        $obj->project_id = null;
                        return $obj;
                    });

                $result = Projects::where('project_id', $project_id)
                    ->update([
                        'description' => $request->input('description'),
                        'project_parent' => $parent->project_id,
                        'contact_id' => $contact->contact_id,
                        'type_code' => $request->input('project_type'),
                        'registration_number' => $request->input('regis'),
                        'book_issued_at' => $request->input('date_book'),
                        'book_number' => $request->input('book_number'),
                        'book_code' => $request->input('cat_book'),
                        'division_code' => $request->input('cat_division'),
                        'ministry_code' => $request->input('cat_ministry'),
                        'department_code' => $request->input('cat_department'),
                        'investment_code' => $request->input('cat_investment'),
                        'updated_by' => Auth::user()->id,
                    ]);
                if ($result == 0)
                {
                    DB::rollback();
                    return redirect('/project/manage')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลโครงการได้'));
                }

                if (empty($project->type_code) && $request->filled('project_type'))
                {
                    $config_project = ConfigsProject::where('type_code', $request->input('project_type'))->first();
        
                    Projects::where('project_id', $project->project_id)->update([
                        'operating_begin' => Carbon::now(),
                        'operating_deadline' => dateAddDays($config_project->operating_duration),
                    ]);
                }
            }
            else
            {
                $config_project = ConfigsProject::where('type_code', $request->input('project_type'))->first();

                $parent = vProjects::where('description', $request->input('project_parent'))
                    ->whereNull('project_parent')
                    ->firstOr(function(){
                        $obj = new \StdClass();
                        $obj->project_id = null;
                        return $obj;
                    });

                $project = Projects::create([
                    'description' => $request->input('description'),
                    'project_parent' => $parent->project_id,
                    'contact_id' => $contact->contact_id,
                    'type_code' => $request->input('project_type'),
                    'status_code' => '17001',
                    'registration_number' => $request->input('regis'),
                    'book_issued_at' => $request->input('date_book'),
                    'book_number' => $request->input('book_number'),
                    'book_code' => $request->input('cat_book'),
                    'division_code' => $request->input('cat_division'),
                    'ministry_code' => $request->input('cat_ministry'),
                    'department_code' => $request->input('cat_department'),
                    'investment_code' => $request->input('cat_investment'),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                if (empty($project))
                {
                    DB::rollback();
                    return redirect('/project/list')->with('response', response_error('ไม่สามารถเพิ่มข้อมูลโครงการได้'));
                }
                
                if ($request->filled('project_type'))
                {
                    $config_project = ConfigsProject::where('type_code', $request->input('project_type'))->first();

                    Projects::where('project_id', $project->project_id)->update([
                        'operating_begin' => Carbon::now(),
                        'operating_deadline' => dateAddDays($config_project->operating_duration),
                    ]);
                }
            }

            DB::commit();
            return redirect('/project/list')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect('/project/list')->with('response', response_error($e->getMessage()));
        }
    }

    public function manage(Request $request)
    {
        $data['project_types'] = Masters::where('type', 'ProjectType')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['statuses'] = Masters::where('type', 'Status')->where('actived', 1)->whereNotIn('code', ['17009'])->orderBy('ranking')->orderBy('description')->get();
        $data['projects'] = vProjects::where('description', 'LIKE', '%'.$request->input('description').'%')
            ->where(function ($query) use ($request) {
                if ($request->filled('registration_number'))
                {
                    $query->where('registration_number', 'LIKE', '%'.$request->input('registration_number').'%');
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('book_issued_at'))
                {
                    $query->whereDate('book_issued_at', $request->input('book_issued_at'));
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('book_number'))
                {
                    $query->where('book_number', 'LIKE', '%'.$request->input('book_number').'%');
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('type_code'))
                {
                    $query->where('type_code', $request->input('type_code'));
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('contact'))
                {
                    $query->where('contact_fullname', 'LIKE', '%'.$request->input('contact').'%');
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->filled('status_code'))
                {
                    $query->where('status_code', $request->input('status_code'));
                }
            })
            ->get();
            // print_array($data['projects']);

        return view('project.manage', $data);
    }

    public function detail($project_id)
    {
        $data['project'] = vProjects::firstWhere('project_id', $project_id);
        $data['budget'] = vProjectsBudget::where('project_id', $project_id)->firstOr(function(){
            return new vProjectsBudget;
        });
        $data['investments'] = DB::table('masters as m')
            ->leftJoin('projects_investment_budget as b', function($join) use ($project_id){
                $join->on('m.code', '=', 'b.fund_code')
                    ->where('b.project_id', '=', $project_id);
            })
            ->select(['b.project_id', 'm.code AS fund_code', 'm.description AS fund_desc', 'b.budget AS fund_value'])
            ->where('m.type', DB::Raw('"SourceOfFund"'))
            ->get();
        $data['activities'] = vProjectsActivity::info($project_id, $data['project']->plan_begin_year, $data['project']->plan_end_year);
        $data['finances'] = ProjectsReturn::where('project_id', $project_id)->where('type', 'Finance')->get();
        $data['economics'] = ProjectsReturn::where('project_id', $project_id)->where('type', 'Economic')->get();

        return view('project.detail', $data);
    } 

    public function edit($project_id)
    {
        $data['departments'] = Masters::where('type', 'DepartmentProject')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['provinces'] = Masters::where('type', 'Province')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['documents'] = Masters::where('type', 'Document')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['arealevels'] = Masters::where('type', 'AreaLevel')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['project'] = vProjects::firstWhere('project_id', $project_id);

        // Tab: ข้อเสนอเพื่อพิจารณา
        $data['project_documents'] = vProjectsDocument::where('project_id', $project_id)->orderBy('imported_at')->get();

        // Tab: สาระสำคัญของโครงการ
        $data['plans'] = ProjectsPlan::where('project_id', $project_id)->get();
        $data['investments'] = DB::table('masters as m')
            ->leftJoin('projects_investment_budget as b', function($join) use ($project_id){
                $join->on('m.code', '=', 'b.fund_code')
                    ->where('b.project_id', '=', $project_id);
            })
            ->select(['b.project_id', 'm.code AS fund_code', 'm.description AS fund_desc', 'b.budget AS fund_value'])
            ->where('m.type', DB::Raw('"SourceOfFund"'))
            ->get();
        $data['investment_header'] = ProjectsInvestmentBudgetHeader::where('project_id', $project_id)->firstOr(function(){
            return new ProjectsInvestmentBudgetHeader;
        });

        $data['activities'] = vProjectsActivity::info($project_id, $data['project']->plan_begin_year, $data['project']->plan_end_year);
        $data['finances'] = ProjectsReturn::where('project_id', $project_id)->where('type', 'Finance')->get();
        $data['economics'] = ProjectsReturn::where('project_id', $project_id)->where('type', 'Economic')->get();
        
        // Tab: โครงการย่อย
        $data['project_children'] = vProjects::where('project_parent', $project_id)->get();

        return view('project.edit', $data);
    }

    public function editing(Request $request, $project_id)
    {
// print_array($request->all());
// exit;
        try
        {
            DB::beginTransaction();

            unset($result);
            $result = Projects::where('project_id', $request->input('project_id'))
                ->update([
                    'proposal' => $request->input('proposal'),
                    'area_level_code' => $request->input('area_level_code'),
                    'area' => is_array($request->input('areas')) ? implode(';', $request->input('areas')) : $request->input('areas'),
                    'area_detail' => $request->input('area_detail'),
                    'budget' => $request->input('budget_total'),
                    'plan_begin_day' => $request->input('begin_day'),
                    'plan_begin_month' => $request->input('begin_month'),
                    'plan_begin_year' => $request->input('begin_year'),
                    'plan_end_day' => $request->input('end_day'),
                    'plan_end_month' => $request->input('end_month'),
                    'plan_end_year' => $request->input('end_year'),
                    'story' => $request->input('story'),
                    'objective' => $request->input('objective'),
                    'goal' => $request->input('goal'),
                    'updated_by' => Auth::user()->id,
                ]);
            if ($result == 0)
            {
                DB::rollback();
                return redirect('project/' . $project_id . '/edit')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลโครงการได้'));
            }

            if ($request->hasFile('document'))
            {
                $document = $request->file('document');
                $filename = $document->storeAs($request->input('project_id'), $document->getClientOriginalName());
                if (empty($filename))
                {
                    return redirect('project/' . $project_id . '/edit')->with('response', response_error('ไม่สามารถนำเข้าเอกสารได้'));
                }

                $result = ProjectsDocument::create([
                        'project_id' => $request->input('project_id'),
                        'book_code' => $request->input('doc_type'),
                        'imported_at' => $request->input('doc_imported_at'),
                        'detail' => $request->input('doc_detail'),
                        'filename' => $filename,
                        'extension' => $document->getClientOriginalExtension(),
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                if (empty($result))
                {
                    DB::rollback();
                    return redirect('project/' . $project_id . '/edit')->with('response', response_error('ไม่สามารถนำเข้าเอกสารได้'));
                }

                // Set project status
                $this->setProjectStatus($request->get('project_id'), $request->get('doc_type'));
            }
            
            $result = ProjectsInvestmentBudgetHeader::updateOrCreate([
                    'project_id' => $project_id
                ],[
                    'investment_type' => $request->input('investment_type'),
                    'included_vat' => (bool)$request->input('included_vat'),
                    'remark' => $request->input('budget_others_desc')
                ]);
            if (empty($result))
            {
                DB::rollback();
                return redirect('project/' . $project_id . '/edit')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลแหล่งเงินทุนได้'));
            }

            if ($request->filled('investments'))
            {
                unset($result);
                foreach ($request->input('investments') as $fund_code => $investment)
                {
                    $result = ProjectsInvestmentBudget::updateOrCreate([
                            'project_id' => $project_id,
                            'fund_code' => $fund_code
                        ],[
                            'budget' => $investment['budget'],
                        ]);
                    if (empty($result))
                    {
                        DB::rollback();
                        return redirect('project/' . $project_id . '/edit')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลแหล่งเงินทุนได้'));
                    }
                }
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
                        $result = ProjectsActivity::updateOrCreate([
                                'project_id' => $project_id,
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

            // if ($request->filled('activities'))
            // {
            //     unset($result);
            //     foreach ($request->input('activities') as $activity)
            //     {
            //         foreach ($activity['period'] as $period => $budget)
            //         {
            //             $result = ProjectsActivity::updateOrCreate([
            //                     'project_id' => $request->input('project_id'),
            //                     'activity_code' => $activity['activity_code'],
            //                     'sub_activity_desc' => $activity['sub_activity_desc'],
            //                     'period' => $period,
            //                 ],[
            //                     'budget' => $budget['budget'],
            //                 ]);
            //             if (empty($result))
            //             {
            //                 DB::rollback();
            //                 return redirect('project/' . $project_id . '/edit')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลกรอบเงินลงทุนกิจกรรมได้'));
            //             }
            //         }
            //     }
            // }

            if ($request->filled('returns'))
            {
                unset($result);
                foreach ($request->input('returns') as $returns)
                {
                    foreach ($returns as $return)
                    {
                        if (empty($return['description']))
                        {
                            continue;
                        }

                        $result = ProjectsReturn::updateOrCreate([
                                'project_id' => $request->input('project_id'),
                                'type' => ucfirst($return['type']),
                                'description' => $return['description'],
                            ],[
                                'value' => $return['value'],
                                'unit' => $return['unit'],
                                'remark' => $return['remark'],
                            ]);
                        if (empty($result))
                        {
                            DB::rollback();
                            return redirect('project/' . $project_id . '/edit')->with('response', response_error('ไม่สามารถแก้ไขข้อมูลผลตอบแทนการลงทุนโครงการได้'));
                        }
                    }
                }
            }
            
            DB::commit();
            return redirect('/project/manage')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect('project/' . $project_id . '/edit')->with('response', response_error($e->getMessage()));
        }
    }

    public function update($project_id)
    {
        $data['documents'] = Masters::where('type', 'Document')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['project_documents'] = vProjectsDocument::where('project_id', $project_id)->orderBy('imported_at')->get();
        $data['project'] = vProjects::where('project_id', $project_id)->first();
        return view('project.modal_manage', $data);
    }

    public function updating(Request $request)
    {
        try 
        {
            $document = $request->file('document');
            $filename = $document->storeAs($request->input('project_id'), $document->getClientOriginalName());
            if (empty($filename))
            {
                return redirect('/project/manage')->with('response', response_error('ไม่สามารถนำเข้าเอกสารได้'));
            }

            $result = ProjectsDocument::create([
                    'project_id' => $request->input('project_id'),
                    'book_code' => $request->input('doc_type'),
                    'imported_at' => $request->input('doc_imported_at'),
                    'detail' => $request->input('doc_detail'),
                    'filename' => $filename,
                    'extension' => $document->getClientOriginalExtension(),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
            if (empty($result))
            {
                return redirect('/project/manage')->with('response', response_error('ไม่สามารถนำเข้าเอกสารได้'));
            }

            // Set project status
            $this->setProjectStatus($request->input('project_id'), $request->input('doc_type'));

            // Set project operating date
            $this->setProjectOperatingDate($request->input('project_id'), $request->input('doc_type'));
            
            return redirect('/project/manage')->with('response', response_success('บันทึกข้อมูลเรียบร้อยแล้ว'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect('/project/manage')->with('response', response_error($e->getMessage()));
        }
    }

    public function status()
    {
        // ติดตามสถานะการพิจารณาโครงการ
        $data['count_all_projects'] = vProjects::count();
        $data['projects_by_status'] = Projects::getSummaryByStatus();
        $data['projects_by_department'] = Projects::getSummaryByDepartmentContact();
        $data['projects_warning'] = Projects::getWarningByDepartmentContact();

        // ติดตามดำเนินการงาน
        $data['departments_contact'] = Masters::where('type', 'DepartmentContact')->where('actived', 1)->orderBy('ranking')->orderBy('description')->get();
        $data['users'] = vUsers::whereNotIn('role', ['23001', '23002'])->orderBy('fullname')->get();
        $data['projects_by_contact'] = Projects::getSummaryByContact();

        return view('project.status', $data);
    }

    public function status_followup($user_id)
    {
        $data['user'] = vUsers::where('id', $user_id)->first();
        $data['projects'] = vProjects::where('contact_id', $user_id)->get();

        return view('project.modal_status', $data);
    }

    private function setProjectStatus($project_id, $document_code)
    {
        $project = vProjects::where('project_id', $project_id)->first();
        if (empty($project))
        {
            return false;
        }

        // สถานะ: โครงการใหม่ => นำเข้า "หนังสือต้นเรื่อง"
        if ($project->status_code == '17001' && $document_code == '16001')
        {
            // => สถานะ: วิเคราะห์โครงการ
            Projects::where('project_id', $project_id)->update(['status_code' => '17002']);
        }
        // สถานะ: วิเคราะห์โครงการ, ประเภทงาน: "ขอความเห็นประกอบการพิจารณา" => นำเข้า "ใบนำส่ง"
        elseif ($project->type_code == '10002' && $document_code == '16009')
        {
            // => สถานะ: เห็นชอบและลงนาม
            Projects::where('project_id', $project_id)->update(['status_code' => '17003']);
        }
        // นำเข้า "หนังสือครุฑแจ้งความเห็น"
        elseif ($document_code == '16011')
        {
            // => สถานะ: เห็นชอบและลงนาม
            Projects::where('project_id', $project_id)->update(['status_code' => '17003']);
        }
        // นำเข้า "มติ ครม."
        elseif ($document_code == '16013')
        {
            // => สถานะ: ครม.อนุมัติโครงการ
            Projects::where('project_id', $project_id)->update(['status_code' => '17004']);
        }

        return true;
    }

    private function setProjectOperatingDate($project_id, $document_code)
    {
        $project = vProjects::where('project_id', $project_id)->first();
        if (empty($project))
        {
            return false;
        }

        $config_document = ConfigsProjectDocument::where('type_code', $project->type_code)
            ->where('document_code', $document_code)
            ->first();
        if ($config_document->operating_duration_reset == 1)
        {
            $config_project = ConfigsProject::where('type_code', $project->type_code)->first();

            Projects::where('project_id', $project_id)->update([
                'operating_begin' => Carbon::now(),
                'operating_deadline' => dateAddDays($config_project->operating_duration)
            ]);
        }

        return true;
    }
}
