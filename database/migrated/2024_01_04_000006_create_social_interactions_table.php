<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_interactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('interactable'); // For posts, reviews, announcements, etc.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // like, comment, share
            $table->text('content')->nullable(); // For comments
            $table->json('metadata')->nullable(); // For share data, reaction type, etc.
            $table->timestamps();
            
            // Ensure a user can only like/comment once per item
            $table->unique(['interactable_type', 'interactable_id', 'user_id', 'type'], 'social_interactions_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_interactions');
    }
}; 