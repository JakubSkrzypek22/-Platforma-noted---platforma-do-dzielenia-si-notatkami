<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'code', 'currency', 'area', 'language'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
