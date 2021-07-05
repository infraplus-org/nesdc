<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsActivity extends Model
{
    use HasFactory;

    protected $table = 'projects_activity';

    protected $fillable = [
        'project_id',
        'activity_code',
        'sub_activity_desc',
        'selected',
        'period',
        'month_begin',
        'month_end',
        'budget',
    ];
}
