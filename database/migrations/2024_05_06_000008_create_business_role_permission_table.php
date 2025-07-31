<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_role_id')->constrained('business_roles')->onDelete('cascade');
            $table->foreignId('business_permission_id')->constrained('business_permissions')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['business_role_id', 'business_permission_id'], 'brp_role_permission_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_role_permission');
    }
}; 