<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsReturn extends Model
{
    use HasFactory;

    protected $table = 'projects_return';

    protected $fillable = [
        'project_id',
        'type',
        'description',
        'value',
        'unit',
        'remark',
    ];
}
