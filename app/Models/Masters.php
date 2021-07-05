<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masters extends Model
{
    use HasFactory;

    protected $table = 'masters';
    
    protected $fillable = [
        'type',
        'code',
        'description',
        'actived',
        'ranking',
    ];
}
