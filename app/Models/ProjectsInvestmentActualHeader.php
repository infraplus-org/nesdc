<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsInvestmentActualHeader extends Model
{
    use HasFactory;

    protected $table = 'projects_investment_actual_header';

    protected $fillable = [
        'project_id',
        'investment_type',
        'included_vat',
        'remark',
    ];
}
