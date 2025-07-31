<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add action and resource fields to business_permissions
        Schema::table('business_permissions', function (Blueprint $table) {
            $table->string('action')->nullable()->after('slug');
            $table->string('resource_type')->nullable()->after('action');
            $table->string('resource_id')->nullable()->after('resource_type');
            $table->json('conditions')->nullable()->after('resource_id');
            $table->boolean('is_system')->default(false)->after('conditions');
            $table->integer('priority')->default(0)->after('is_system');
        });

        // Create permission_groups table
        Schema::create('business_permission_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false);
            $table->timestamps();

            $table->unique(['business_id', 'slug']);
        });

        // Create permission_group_permission pivot table
        Schema::create('business_permission_group_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_permission_group_id')->constrained('business_permission_groups')->onDelete('cascade');
            $table->foreignId('business_permission_id')->constrained('business_permissions')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['business_permission_group_id', 'business_permission_id']);
        });

        // Create permission_audit_logs table
        Schema::create('business_permission_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action');
            $table->json('details');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_permission_audit_logs');
        Schema::dropIfExists('business_permission_group_permission');
        Schema::dropIfExists('business_permission_groups');
        
        Schema::table('business_permissions', function (Blueprint $table) {
            $table->dropColumn([
                'action',
                'resource_type',
                'resource_id',
                'conditions',
                'is_system',
                'priority'
            ]);
        });
    }
}; 