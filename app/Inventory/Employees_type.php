<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;

class Employees_type extends Model
{
    protected $table="employees_type";
    protected $fillable=[
        'employees_type'
    ];
    public function employees()
    {
        return $this->hasMany(Employees::class, 'employees_type_id');
    }
}
    // public function employees()
    // {
    //     return $this->belongsTo(Employees::class);
    // }

    // public function employees()
    // {
    //     return $this->hasMany(Employees::class);
    // }
// }
