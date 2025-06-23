<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_books', function (Blueprint $table) {
            $table->integer('current_page')->default(0);
            $table->integer('total_pages')->nullable();
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->timestamp('last_read_at')->nullable();
            $table->json('bookmarks')->nullable(); // Para guardar marcadores
        });
    }

    public function down()
    {
        Schema::table('user_books', function (Blueprint $table) {
            $table->dropColumn(['current_page', 'total_pages', 'progress_percentage', 'last_read_at', 'bookmarks']);
        });
    }
};