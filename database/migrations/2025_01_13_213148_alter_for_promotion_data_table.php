<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotion_data', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->string('description_first')->nullable();
            $table->string('description_second')->nullable();
            $table->string('description_third')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('promotion_data', function (Blueprint $table) {
            $table->dropColumn('description_first');
            $table->dropColumn('description_second');
            $table->dropColumn('description_third');
        });
    }
};
