<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // para URLs amigables
            $table->string('author');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->string('isbn')->unique();
            $table->string('category');
            $table->string('cover_image')->nullable(); // imagen de portada
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('publication_date')->nullable();
            $table->string('publisher')->nullable();
            $table->string('language', 20)->default('es');
            $table->integer('pages')->default(0);
            $table->decimal('rating', 2, 1)->default(0); // ejemplo: 4.5
            $table->integer('downloads_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
