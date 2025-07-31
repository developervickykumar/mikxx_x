<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('settings')->nullable(); // For form-wide settings like submit button text, etc.
            $table->boolean('is_active')->default(true);
            $table->string('success_message')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('submit_button_text')->default('Submit');
            $table->string('cancel_button_text')->nullable();
            $table->json('permissions')->nullable(); // For user role permissions
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forms');
    }
}; 