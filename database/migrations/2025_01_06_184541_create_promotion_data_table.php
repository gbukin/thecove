<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('promotion_data')) {
            Schema::create('promotion_data', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('promotion_id')->index()->nullable(false);
                $table->string('title', 255)->nullable(false)->comment('Заголовок');
                $table->string('description', 500)->nullable(false)->comment('Краткое описание');
                $table->text('body')->nullable(false)->comment('Полное описание акции');
                $table->string('language', 2)->default('en')->nullable(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_data');
    }
};
