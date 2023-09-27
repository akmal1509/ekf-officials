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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('dapilDistrictId');
            $table->unsignedBigInteger('districtId');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dapilDistrictId')
                ->references('id')
                ->on('dapil_districts');
            $table->foreign('districtId')
                ->references('id')
                ->on('indonesia_districts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
