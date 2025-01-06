<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('news_data')) {
            Schema::create('news_data', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('news_id')->index()->nullable(false);
                $table->string('title', 255)->nullable(false);
                $table->text('announce')->nullable(false);
                $table->text('text')->nullable(false);
                $table->string('language', 2)->nullable(false)->default('en');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('news_data');
    }
};
