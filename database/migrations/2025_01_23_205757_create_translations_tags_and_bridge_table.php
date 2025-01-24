<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create translations table
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index(); // Index for fast key lookup
            $table->text('content');
            $table->string('locale', 5)->index(); // Locale with indexing for efficient searching
            $table->timestamps();

            // Full-text index for fast content search
            $table->fullText(['key', 'content']);
        });

        // Create tags table
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Unique name for tags
        });

        // Insert default tags
        DB::table('tags')->insert([
            ['name' => 'mobile'],
            ['name' => 'desktop'],
            ['name' => 'web'],
        ]);

        // Create translation_tag pivot table for many-to-many relationship
        Schema::create('translation_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('translation_id');
            $table->unsignedBigInteger('tag_id');

            // Add indexes for performance
            $table->index(['translation_id', 'tag_id']);
            $table->index(['tag_id', 'translation_id']);

            // Foreign key constraints
            $table->foreign('translation_id')->references('id')->on('translations')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
