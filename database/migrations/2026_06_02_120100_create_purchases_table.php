<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Note;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Note::class)->constrained()->cascadeOnDelete();
            $table->decimal('amount', 8, 2);
            $table->string('payment_method')->default('card');
            $table->string('status')->default('completed');
            $table->string('transaction_ref')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'note_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
