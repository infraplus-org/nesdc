<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $primaryKey = 'project_id';

    public $afterCommit = true;

    protected $fillable = [
        'description',
        'project_parent',
        'contact_id',
        'type_code',
        'status_code',
        'registration_number',
        'book_issued_at',
        'book_code',
        'book_number',
        'ministry_code',
        'division_code',
        'department_code',
        'investment_code',
        'operating_begin',
        'operating_deadline',
        'area_level_code',
        'area',
        'area_detail',
        'budget',
        'actual',
        'plan_begin_day',
        'plan_begin_month',
        'plan_begin_year',
        'plan_end_day',
        'plan_end_month',
        'plan_end_year',
        'proposal',
        'story',
        'objective',
        'goal',
        'created_by',
        'updated_by',
    ];

    public static function getSummaryByType()
    {
        $result = DB::table('masters as pt')
            ->leftJoin('projects as p', 'p.type_code', '=', 'pt.code')
            ->select('pt.ranking', 'pt.description as project_type', DB::Raw('COUNT(p.project_id) as cnt'))
            ->where('pt.type', DB::Raw('"ProjectType"'))
            ->groupBy('pt.ranking', 'pt.description')
            ->orderBy('pt.ranking')
            ->get();

        return $result;
    }

    public static function getSummaryByDepartmentContact()
    {
        $result = DB::table('masters as dept')
            ->leftJoin('users as u', 'u.department_code', '=', 'dept.code')
            ->leftJoin('projects as p', 'p.contact_id', '=', 'u.id')
            ->select(
                'dept.ranking', 
                'dept.description as department',
                DB::Raw('COUNT(p.project_id) as cnt'),
                DB::Raw("SUM(CASE WHEN p.type_code = '10001' THEN 1 ELSE 0 END) AS `type_1`"),
                DB::Raw("SUM(CASE WHEN p.type_code = '10002' THEN 1 ELSE 0 END) AS `type_2`"),
                DB::Raw("SUM(CASE WHEN p.type_code IN ('10003', '10004') THEN 1 ELSE 0 END) AS `type_3`"),
            )
            ->where('dept.type', DB::Raw('"DepartmentContact"'))
            ->groupBy('dept.ranking', 'dept.description')
            ->orderBy('dept.ranking')
            ->get();
        
        return $result;
    }

    public static function getWarningByDepartmentContact()
    {
        $result = DB::table('masters as dept')
            ->leftJoin('users as u', 'u.department_code', '=', 'dept.code')
            ->leftJoin('projects as p', function($join) {
                $join->on('p.contact_id', '=', 'u.id')
                    ->where('p.operating_deadline', '<=', Carbon::now()->addDays(config('custom.warning_project_operating')));
            })
            ->select(
                'dept.ranking', 
                'dept.description as department',
                DB::Raw('COUNT(p.project_id) as cnt'),
                DB::Raw("SUM(CASE WHEN p.type_code = '10001' THEN 1 ELSE 0 END) AS `type_1`"),
                DB::Raw("SUM(CASE WHEN p.type_code = '10002' THEN 1 ELSE 0 END) AS `type_2`"),
                DB::Raw("SUM(CASE WHEN p.type_code IN ('10003', '10004') THEN 1 ELSE 0 END) AS `type_3`"),
            )
            ->where('dept.type', DB::Raw('"DepartmentContact"'))
            ->groupBy('dept.ranking', 'dept.description')
            ->orderBy('dept.ranking')
            ->get();
        
        return $result;
    }

    public static function getSummaryByStatus()
    {
        $result = DB::table('masters as sts')
            ->leftJoin('projects as p', 'p.status_code', '=', 'sts.code')
            ->select('sts.ranking', 'sts.description as status_desc', DB::Raw('COUNT(p.project_id) as cnt'))
            ->where('sts.type', DB::Raw('"Status"'))
            ->groupBy('sts.ranking', 'sts.description')
            ->orderBy('sts.ranking')
            ->get();
        
        return $result;
    }

    public static function getSummaryByContact()
    {
        $project_status = DB::table('masters as pt')
            ->where('pt.type', DB::Raw('"Status"'))
            ->orderBy('pt.ranking')
            ->get();
        

        $fields = [
            'u.id', 
            'u.name', 
            'u.name AS fullname', 
            'dept.description AS department_desc',
            DB::Raw('COUNT(*) AS cnt_all'), 
        ];
        foreach ($project_status as $status)
        {
            $fields_sum[] = DB::Raw("SUM(CASE WHEN p.status_code = '$status->code' THEN 1 ELSE 0 END) AS `$status->description`");
        }

        $result = DB::table('projects as p')
            ->leftJoin('users as u', 'u.id', '=', 'p.contact_id')
            ->leftJoin('masters as dept', function ($join) {
                $join->on('dept.type', '=', DB::Raw('"DepartmentContact"'));
                $join->on('dept.code', '=', 'u.department_code');
            })
            ->select(array_merge($fields, $fields_sum))
            ->whereNotNull('u.name')
            ->groupBy('u.id', 'u.name', 'dept.description')
            ->orderBy('u.name')
            ->get();

        return $result;
    }
}
