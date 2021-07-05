<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsDocumentActual extends Model
{
    use HasFactory;

    protected $table = 'projects_document_actual';

    protected $fillable = [
        'project_id',
        'filename',
        'filepath',
        'created_by',
        'updated_by',
    ];
}
