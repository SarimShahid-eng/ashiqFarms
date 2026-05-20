<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table='notes_old';
    protected $fillable=[
        'note',
        'price',
        'updated_at',
        'created_at'
    ];

}
