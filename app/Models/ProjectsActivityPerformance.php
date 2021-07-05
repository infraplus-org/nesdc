<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectsActivityPerformance extends Model
{
    use HasFactory;

    protected $table = 'projects_activity_performance';
 
    protected $fillable = [
        'project_id',
        'period',
        'month',
        'activity_code',
        'budget',
        'actual',
    ];

    public static function infoByMonth($project_id)
    {
        $config_nesdc_months = config('custom.data_nesdc_months');

        $fields = [
            'p.project_id', 
            'p.period', 
            'p.activity_code', 
        ];
        foreach ($config_nesdc_months as $id => $month)
        {
            $fields_budget[] = DB::Raw("SUM(CASE WHEN p.month = '$id' THEN p.budget ELSE 0 END) AS `budget_{$id}`");
            $fields_actual[] = DB::Raw("SUM(CASE WHEN p.month = '$id' THEN p.actual ELSE 0 END) AS `actual_{$id}`");
        }

        $result = DB::table('projects_activity_performance as p')
            ->select(array_merge($fields, $fields_budget))
            ->where('p.project_id', $project_id)
            ->groupBy($fields)
            ->orderBy('p.period')
            ->orderBy('p.activity_code')
            ->get();

        return $result;
    }
}
