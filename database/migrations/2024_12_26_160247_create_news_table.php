<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->tinyInteger('show')->default(1);
                $table->timestamps();
            });
        }
    }


    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
