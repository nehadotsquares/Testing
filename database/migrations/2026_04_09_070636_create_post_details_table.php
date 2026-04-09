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
        Schema::create('post_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');

            $table->text('ckeditor')->nullable();
            $table->integer('number')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->nullable();
            $table->json('tags')->nullable();
            $table->date('publish_date')->nullable();
            $table->time('publish_time')->nullable();
            $table->integer('rating')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_details');
    }
};
