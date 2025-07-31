<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->text('description')->nullable()->after('slug');
            $table->foreignId('parent_id')->nullable()->after('description')->constrained('roles')->onDelete('set null');
            $table->boolean('status')->default(true)->after('parent_id');
            $table->boolean('is_system')->default(false)->after('status');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->text('description')->nullable()->after('slug');
            $table->string('category', 100)->after('description');
            $table->boolean('status')->default(true)->after('category');
            $table->boolean('is_system')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['description', 'parent_id', 'status', 'is_system']);
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['description', 'category', 'status', 'is_system']);
        });
    }
}; 