<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectsActivityIssue extends Model
{
    use HasFactory;

    protected $table = 'projects_activity_issue';
 
    protected $fillable = [
        'project_id',
        'issue_activity',
        'issue_date',
        'issue_desc',
    ];
}
