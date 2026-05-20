<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;
    
    protected $table = "expenses";

    public function parentHead(){
        return $this->belongsTo('App\Head','head_id');
    }

    public function parentSubhead(){
        return $this->belongsTo('App\Head','subhead_id');
    }
    
    public function parentChildSubhead(){
        return $this->belongsTo('App\Head','child_subhead_id');
    }
    public function parentForthSubhead(){
        return $this->belongsTo('App\Head','forth_head');
    }
    public function parentUser(){
        return $this->belongsTo('App\User','user_id');
    }
}
