<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsInvestmentBudgetHeader extends Model
{
    use HasFactory;

    protected $table = 'projects_investment_budget_header';

    protected $fillable = [
        'project_id',
        'investment_type',
        'included_vat',
        'remark',
    ];
}
