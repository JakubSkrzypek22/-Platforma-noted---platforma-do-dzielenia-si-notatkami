<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model for storing chat analytics (user queries and whether results were found).
 */
class ChatAnalytics extends Model
{
    protected $table = 'chat_analytics';

    // We only use created_at for analytics; disable updated_at
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'query',
        'results_found',
        'created_at',
    ];

    /**
     * Optional relation to `User` if available.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
