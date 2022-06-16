<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $primaryKey = "payroll";
    public $incrementing = false;
    protected $guarded = [];
    protected function setPrimaryKey($key)
    {
        $this->primaryKey = $key;
    }
    public function files()
    {
        /* return $this->belongsToMany(File::class, 'files')->withPivot('created_at', 'finished_at')->orderByPivot('created_at', 'desc'); */
        return $this->hasMany(File::class, 'employee_payroll');
    }
    /* 
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_group');
    } */
}
