<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('table_builders', function (Blueprint $table) {
            $table->boolean('is_template')->default(false);
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->integer('version')->default(1);
            $table->foreignId('parent_id')->nullable()->constrained('table_builders')->onDelete('set null');
            $table->json('validation_rules')->nullable();
            $table->json('column_dependencies')->nullable();
            $table->json('column_comments')->nullable();
            $table->json('column_order')->nullable();
            $table->boolean('is_shared')->default(false);
            $table->json('shared_with')->nullable();
            $table->json('permissions')->nullable();
            $table->timestamp('last_backup_at')->nullable();
            $table->string('backup_path')->nullable();
        });
    }

    public function down()
    {
        Schema::table('table_builders', function (Blueprint $table) {
            $table->dropColumn([
                'is_template',
                'category',
                'tags',
                'version',
                'parent_id',
                'validation_rules',
                'column_dependencies',
                'column_comments',
                'column_order',
                'is_shared',
                'shared_with',
                'permissions',
                'last_backup_at',
                'backup_path'
            ]);
        });
    }
}; 