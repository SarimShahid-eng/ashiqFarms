<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    use softDeletes;

    protected $table = 'agreements';

    public function childSchedule(){
        return $this->hasMany('App\Schedule','agreement_id');
    }
}
