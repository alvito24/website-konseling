<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRef extends Model
{
    protected $table = 'students_ref';
    
    protected $fillable = [
        'nis',
        'name',
        'class'
    ];
}