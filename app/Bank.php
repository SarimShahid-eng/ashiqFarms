<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';

    public function childBankBranches(){
        return $this->hasMany('App\BankBranch','bank_id');
    }
}
