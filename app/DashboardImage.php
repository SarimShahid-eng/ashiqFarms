<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardImage extends Model
{
    protected $table = "dashboard_images";
    protected $fillable = [
        'user_id',
        'image'
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
