<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class vProjectsActivityActual extends Model
{
    use HasFactory;

    public static function info($project_id, $beginning, $endding, $expansion_id = null)
    {
        $fields = [
            'a.project_id', 
            'm.code', 
            'm.description', 
            'a.sub_activity_desc',
            'a.selected',
            'm.ranking',
            'a.expansion_id',
        ];
        for ($i=$beginning; $i<=$endding; $i++)
        {
            $fields_sum[] = DB::Raw("SUM(CASE WHEN a.period = '$i' THEN a.budget ELSE 0 END) AS `$i`");
        }
        for ($i=$beginning; $i<=$endding; $i++)
        {
            $fields_month_begin[] = DB::Raw("MAX(CASE WHEN a.period = '$i' THEN a.month_begin ELSE '' END) AS `{$i}_month_begin`");
            $fields_month_end[] = DB::Raw("MAX(CASE WHEN a.period = '$i' THEN a.month_end ELSE '' END) AS `{$i}_month_end`");
        }

        $result = DB::table('masters as m')
            ->leftJoin('projects_activity_actual as a', function ($join) use ($project_id, $expansion_id) {
                $join->on('a.activity_code', '=', 'm.code')
                    ->where('a.project_id', $project_id);
                if ( ! empty($expansion_id))
                {
                    $join->where('a.expansion_id', $expansion_id);
                }
            })
            ->select(array_merge($fields, $fields_sum, $fields_month_begin, $fields_month_end))
            ->where('m.type', DB::Raw('"Activity"'))
            ->where('m.actived', 1)
            ->groupBy($fields)
            ->orderBy('m.code')
            ->orderBy('a.sub_activity_desc')
            ->get();

        return $result;
    }
}
