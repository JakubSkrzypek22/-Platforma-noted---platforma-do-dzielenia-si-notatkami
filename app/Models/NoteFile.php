<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteFile extends Model
{
    protected $fillable = [
        'note_id', 'path', 'file_type', 'original_name', 'is_main', 'position',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    public function isPdf(): bool
    {
        return $this->file_type === 'pdf';
    }
}
