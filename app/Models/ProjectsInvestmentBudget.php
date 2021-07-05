<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsInvestmentBudget extends Model
{
    use HasFactory;

    protected $table = 'projects_investment_budget';

    protected $fillable = [
        'project_id',
        'fund_code',
        'budget',
    ];
}
