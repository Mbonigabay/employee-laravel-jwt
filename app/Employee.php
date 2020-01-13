<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employeeName',
        'nationalId',
        'phoneNumber',
        'email',
        'dateOfBirth',
        'status',
        'position',
    ];
}
