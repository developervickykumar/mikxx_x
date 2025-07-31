<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classified_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('category');
            $table->string('condition')->nullable(); // new, used, etc.
            $table->string('location');
            $table->json('images')->nullable();
            $table->json('contact_info');
            $table->enum('status', ['draft', 'active', 'pending', 'sold', 'expired', 'reported', 'removed'])->default('pending');
            $table->dateTime('expires_at');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('last_viewed_at')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('inquiry_count')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['category', 'status']);
            $table->index('location');
            $table->index('expires_at');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classified_posts');
    }
}; 