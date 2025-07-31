<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('form_field_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('form_field_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('form_field_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('component_name');
            $table->text('description')->nullable();
            $table->json('default_config')->nullable();
            $table->json('validation_rules')->nullable();
            $table->json('supported_attributes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_field_types');
        Schema::dropIfExists('form_field_categories');
    }
}; 