<?php
namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockConsume extends Model
{
    protected $table='stock_consumes';
    protected $fillable=['stock_consume'];

    //

public function stocks() {
return $this->hasMany(Stock::class,'stock_consume_id','id');
}

}
