<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsGroupingDetail extends Model
{
    use HasFactory;

    protected $table = 'projects_grouping_detail';

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'grouping_id',
    ];
}
