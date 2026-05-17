<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'name', 'continent', 'period', 'description', 'price', 'img', 'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
