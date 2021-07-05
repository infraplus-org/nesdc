<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'fname',
        'lname',
        'prefix_code',
        'position',
        'department_code',
        'email_division',
        'email',
        'tel',
        'fax',
        'created_by',
        'updated_by',
    ];
}
