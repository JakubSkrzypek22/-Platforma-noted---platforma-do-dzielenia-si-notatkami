<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Note extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'category', 'university',
        'price', 'file_path', 'file_type', 'original_name', 'page_count',
        'views', 'downloads',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isFree(): bool
    {
        return (float) $this->price <= 0;
    }

    public function isPdf(): bool
    {
        return $this->file_type === 'pdf';
    }

    /**
     * Czy dany użytkownik kupił już tę notatkę.
     */
    public function isPurchasedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->purchases()->where('user_id', $user->id)->exists();
    }

    /**
     * Czy użytkownik ma pełny dostęp (autor, kupujący lub notatka darmowa).
     */
    public function isAccessibleBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->isFree()
            || $this->user_id === $user->id
            || $this->isPurchasedBy($user);
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }
}
