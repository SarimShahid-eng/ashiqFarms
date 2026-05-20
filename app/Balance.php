<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model
{
    use SoftDeletes;

    protected $table ='balances';

    public function parentBank(){
        return $this->belongsTo('App\Bank','bank_id');
    }

    public function parentBankBranch(){
        return $this->belongsTo('App\BankBranch','bank_branch_id');
    }

    public function parentCustomer(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function parentTransaction(){
        return $this->belongsTo('App\Transaction','transaction_id');
    }
    
    public function parentReason(){
        return $this->belongsTo('App\EntryReason','reason_id');
    }
}
