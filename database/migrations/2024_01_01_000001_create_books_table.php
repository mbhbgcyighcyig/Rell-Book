<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique()->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('publisher')->nullable();
            $table->year('published_year')->nullable();
            $table->integer('stock')->default(1);
            $table->integer('total_stock')->default(1);
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->string('rack_location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('categories');
    }
};
