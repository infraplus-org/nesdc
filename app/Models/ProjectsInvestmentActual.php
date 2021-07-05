<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsInvestmentActual extends Model
{
    use HasFactory;

    protected $table = 'projects_investment_actual';

    protected $fillable = [
        'project_id',
        'fund_code',
        'actual',
    ];
}
