<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (!Schema::hasTable('promotion_participators')) {
            Schema::create('promotion_participators', function (Blueprint $table) {
                $table->id();
                $table->string('full_name', 255)->nullable(false);
                $table->string('phone', 14)->nullable(false);
                $table->string('check_number', 255)->nullable(false);
                $table->string('check_sum', 255)->nullable(false);
                $table->timestamp('check_time')->nullable(false);
                $table->unsignedBigInteger('promotion_id')->nullable(false);
                $table->timestamp('created_at')->nullable(false)->useCurrent();
            });
        }
    }


    public function down(): void
    {
        Schema::dropIfExists('promotion_participators');
    }
};
