<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsPlan extends Model
{
    use HasFactory;

    protected $table = 'projects_plan';

    protected $fillable = [
        'project_id',
        'description',
        'duration',
    ];
}
