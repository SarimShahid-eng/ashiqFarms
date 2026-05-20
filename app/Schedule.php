<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Schedule extends Model
{
    use softDeletes;

    protected $table = 'schedules';

    public function parentAgreement(){
        return $this->belongsTo('App\Agreement','agreement_id');
    }
}
