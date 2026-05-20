<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    public function parentBank(){
        return $this->belongsTo('App\Bank','bank_id');
    }

    // public function parentBankBranch(){
    //     return $this->belongsTo('App\BankBranch','bank_branch_id');
    // }
    public function childBalanceIn(){
        return $this->hasMany('App\Balance','customer_id')->where('type','in');
    }
    
    public function childBalanceOut(){
        return $this->hasMany('App\Balance','customer_id')->where('type','out');
    }
}
