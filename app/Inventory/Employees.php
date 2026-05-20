<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table="employees";
    protected $fillable=[
        'name',
        'employees_type_id'
    ];
    public function type()
    {
        return $this->belongsTo(Employees_type::class, 'employees_type_id');
    }
    public function stock()
    {
        return $this->hasMany(Stock::class,'employees_id','id');
    }
}
