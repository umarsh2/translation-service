<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->string('key')->unique();
            $table->text('content');
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->index(['locale', 'key']);  // Index the locale and key for faster querying
            $table->index('tags');             // Index the tags field for faster searches, though this will be slower with JSON
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
