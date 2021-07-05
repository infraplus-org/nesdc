<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsDocument extends Model
{
    use HasFactory;

    protected $table = 'projects_document';

    protected $fillable = [
        'project_id',
        'book_code',
        'imported_at',
        'detail',
        'filename',
        'extension',
        'created_by',
        'updated_by',
    ];
}
