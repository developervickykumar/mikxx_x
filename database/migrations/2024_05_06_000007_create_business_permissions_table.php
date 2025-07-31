<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('module')->nullable();
            $table->string('page')->nullable();
            $table->timestamps();

            $table->unique(['business_id', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_permissions');
    }
}; 