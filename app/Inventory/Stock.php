<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
protected $fillable=[
    'name',
'price',
'qty',
'stock_consume_id',
'employees_id'
];
public function employees()
    {
        return $this->belongsTo(Employees::class,'employees_id','id');
    }
public function stock_consume()
    {
        return $this->belongsTo(StockConsume::class,'stock_consume_id','id');
    }
}
