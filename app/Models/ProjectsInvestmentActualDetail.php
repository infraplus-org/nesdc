<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsInvestmentActualDetail extends Model
{
    use HasFactory;

    protected $table = 'projects_investment_actual_detail';

    protected $fillable = [
        'project_id',
        'period',
        'month',
        'fund_code',
        'budget',
        'actual',
    ];
}
