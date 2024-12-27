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
        if (!Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->tinyInteger('show')->default(1);
                $table->string('title_ru', 255)->nullable(false);
                $table->string('title_en', 255)->nullable(false);
                $table->text('announce_ru')->nullable(false);
                $table->text('announce_en')->nullable(false);
                $table->text('text_ru')->nullable(false);
                $table->text('text_en')->nullable(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
