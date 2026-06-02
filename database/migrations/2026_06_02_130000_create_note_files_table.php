<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Note;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_files', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Note::class)->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('file_type')->default('image'); // 'pdf' lub 'image'
            $table->string('original_name')->nullable();
            $table->boolean('is_main')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_files');
    }
};
