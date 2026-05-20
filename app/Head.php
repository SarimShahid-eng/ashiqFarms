<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Head extends Model
{

    protected $table = "heads";


    public function sub(){
        return $this->hasMany('App\Head','parent_id');
    }

    public function parent(){
        return $this->belongsTo('App\Head','parent_id');
    }

    public function child(){
        return $this->hasMany('App\Head','child_id');
    }

    public function inverseChild(){
        return $this->belongsTo('App\Head','child_id');
    }
    // public function inverseSub(){
    //     return $this->belongsTo('App\Head','parent_id');
    // }
    // public function childSubhead(){
    //     return $this->hasMany();
    // }

    // public function hasChild(){
    //     return $this->hasManyThrough('App\Head', 'App\Head AS ', 'parent_id', 'child_id', 'id');
    // }
}
