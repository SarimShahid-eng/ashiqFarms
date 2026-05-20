<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankBranch extends Model
{   
    use SoftDeletes;

    protected $table = 'bank_branches';

    public function parentBank(){
        return $this->belongsTo('App\Bank','bank_id');
    }

    // public function childCustomer(){
    //     return $this->hasMany('App\Customer',)
    // }

    public function childBalance(){
        return $this->hasMany('App\Balance','bank_branch_id');
    }
    
    public function childBalanceTypeIn(){
        return $this->childBalance()->where('type','in')->whereNull('deleted_at');
    }

    public function childBalanceTypeOut(){
        return $this->childBalance()->where('type','out')->whereNull('deleted_at');
    }
}
