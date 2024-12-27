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
        if (!Schema::hasTable('promotions')) {
            Schema::create('promotions', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255)->nullable(false)->comment('Заголовок');
                $table->string('description', 500)->nullable(false)->comment('Краткое описание');
                $table->text('body')->nullable(false)->comment('Полное описание акции');
                $table->string('picture')->nullable()->comment('Путь к картинке');
                $table->string('language', 2)->default('en')->nullable(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
