<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function trips()
    {
        // Assuming user_trip table or relation. There is a user_country table though.
        // I will use user_country since it was mentioned in migrations, maybe the user wants that?
        // Wait, 'user_country' exists. Let's add countries()
        return $this->belongsToMany(Country::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'seller_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function sellerRating(): float
    {
        return round((float) $this->reviewsReceived()->avg('rating'), 1);
    }

    public function sellerReviewsCount(): int
    {
        return $this->reviewsReceived()->count();
    }
}
