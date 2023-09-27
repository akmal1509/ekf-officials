<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dapil_district_gos', function (Blueprint $table) {
            $table->id();
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dapil_ditrict_gos');
    }
};
