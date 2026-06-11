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
        'is_vip', // Dodane z naszej migracji dla kont premium
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
            'is_vip' => 'boolean', // Automatycznie zamienia 0/1 z bazy na true/false
        ];
    }

    // --- RELACJE ---

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function trips()
    {
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

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteNotes()
    {
        return $this->belongsToMany(Note::class, 'favorites')->withTimestamps();
    }

    public function purchasedNotes()
    {
        return $this->belongsToMany(Note::class, 'purchases')->withTimestamps();
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'seller_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    // --- FUNKCJE DO SPRAWDZANIA RÓL I UPRAWNIEŃ ---

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isModerator()
    {
        // Sprawdzamy czy rola to moderator LUB admin (admin zazwyczaj może to, co moderator)
        return $this->role && in_array($this->role->name, ['admin', 'moderator']);
    }

    public function isVip()
    {
        return $this->is_vip === true;
    }

    // --- STATYSTYKI SPRZEDAWCY ---

    public function sellerRating(): float
    {
        return round((float) $this->reviewsReceived()->avg('rating'), 1);
    }

    public function sellerReviewsCount(): int
    {
        return $this->reviewsReceived()->count();
    }
}