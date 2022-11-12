<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $fillable = ['id', 'name', 'email', 'age', 'designation', 'created'];
    protected $table = 'Employee';
}
