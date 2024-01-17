<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('description', 1024)->nullable();
            $table->string('reference_url', 1024)->nullable();
            $table->longText('body');
            $table->string('image', 1024)->nullable();
            $table->boolean('is_head')->default(0);
            $table->integer('provider_id');
            $table->integer('source_id');
            $table->integer('category_id');
            $table->integer('author_id');
            $table->integer('language_id');
            $table->integer('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('articles');
    }
};
