<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (!Schema::hasTable('promotions')) {
            Schema::create('promotions', function (Blueprint $table) {
                $table->id();
                $table->string('picture')->nullable()->comment('Путь к картинке');
                $table->timestamps();
            });
        }
    }


    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
