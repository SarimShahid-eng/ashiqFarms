<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerBankBranch extends Model
{   use SoftDeletes;
    protected $table = 'customer_banks_branches';

    public function parentCustomer(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function parentBank(){
        return $this->belongsTo('App\Bank','bank_id');
    }

    public function parentBankBranch(){
        return $this->belongsTo('App\BankBranch','branch_id');
    }
}
