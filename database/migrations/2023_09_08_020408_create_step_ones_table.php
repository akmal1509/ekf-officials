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
        Schema::create('step_ones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('villageId');
            $table->unsignedBigInteger('schoolId');
            $table->string('headmaster');
            $table->string('phoneHeadmaster');
            $table->string('schoolOperator');
            $table->string('phoneOperator');
            $table->string('chairman');
            $table->string('phoneChairman');
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('userId')
                ->references('id')
                ->on('users');
            $table->foreign('villageId')
                ->references('id')
                ->on('indonesia_villages');
            $table->foreign('schoolId')
                ->references('id')
                ->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step_ones');
    }
};
