<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectsActivityExpansion extends Model
{
    use HasFactory;

    protected $table = 'projects_activity_expansion';

    protected $fillable = [
        'project_id',
        'expansion_code',
        'begin_date',
        'end_date',
        'created_by',
        'updated_by',
    ];

    // public static function getInfo($project_id)
    // {
    //     $result = DB::table('projects_activity_expansion as e')
    //         ->leftJoin('masters as m', function($join){
    //             $join->on('m.type', '=', DB::Raw('"Expansion"'));
    //             $join->on('m.code', '=', 'e.expansion_code');
    //         })
    //         ->select(
    //             'e.id', 
    //             'e.expansion_code',
    //             'm.description',
    //             'e.begin_date',
    //             'e.end_date',
    //             'e.created_at',
    //             DB::Raw('
    //                 CASE WHEN e.expansion_code = \'40001\' 
    //                     THEN m.description 
    //                     ELSE CONCAT(m.description, \'ครั้งที่ \', ROW_NUMBER() OVER (PARTITION BY e.project_id, e.expansion_code ORDER BY e.created_at)) 
    //                 END AS description_full'),
    //             DB::Raw('ROW_NUMBER() OVER (PARTITION BY e.project_id ORDER BY e.created_at) AS ROWNUM')
    //         )
    //         ->where('e.project_id', $project_id)
    //         ->get();
        
    //     return $result;
    // }
}
