<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsGrouping extends Model
{
    use HasFactory;

    protected $table = 'projects_grouping';

    protected $fillable = [
        'name',
    ];
}
