<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->foreignId('field_type_id')->constrained('form_field_types');
            $table->string('name');
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('placeholder')->nullable();
            $table->json('options')->nullable(); // For select, radio, checkbox, etc.
            $table->json('validation')->nullable(); // Validation rules
            $table->json('attributes')->nullable(); // HTML attributes
            $table->json('config')->nullable(); // Additional configuration
            $table->boolean('required')->default(false);
            $table->text('default_value')->nullable();
            $table->text('help_text')->nullable();
            $table->integer('order')->default(0);
            $table->integer('width')->default(12); // Column width out of 12
            $table->string('wrapper_class')->nullable(); // For CSS styling
            $table->string('input_class')->nullable(); // For CSS styling
            $table->string('section')->nullable(); // Group fields into sections
            $table->integer('section_order')->default(0); // Order within section
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_enabled')->default(true);
            $table->foreignId('parent_field_id')->nullable()->constrained('form_fields')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_fields');
    }
}; 