<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('form_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_field_id')->constrained('form_fields')->onDelete('cascade');
            $table->string('source_field'); // The field that triggers the condition
            $table->string('condition_type'); // show, hide, enable, disable, require
            $table->string('target_field'); // The field that will be affected by the condition
            $table->string('operator'); // equals, not_equals, contains, greater_than, less_than, etc.
            $table->string('value'); // The value to compare against
            $table->json('additional_settings')->nullable(); // For complex conditions
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_conditions');
    }
}; 