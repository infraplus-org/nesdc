<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsBudget extends Model
{
    use HasFactory;

    protected $table = 'projects_budget';

    protected $primaryKey = 'budget_id';

    protected $fillable = [
        'project_id',
        'investment_type',
        'included_vat',
        'capital',
        'subsidy',
        'loan',
        'borrow',
        'finance',
        'bank',
        'bond',
        'revenue',
        'fund',
        'ppp',
        'others',
        'others_desc',
    ];
}
