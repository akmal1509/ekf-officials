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
        Schema::create('dapil_districts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dapilCategoryId');
            $table->unsignedBigInteger('provinceId');
            $table->unsignedBigInteger('cityId');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dapilCategoryId')
                ->references('id')
                ->on('dapil_categories');
            $table->foreign('provinceId')
                ->references('id')
                ->on('indonesia_provinces');
            $table->foreign('cityId')
                ->references('id')
                ->on('indonesia_cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dapil_districts');
    }
};
