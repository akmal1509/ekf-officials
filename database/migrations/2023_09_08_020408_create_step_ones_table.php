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
            $table->unsignedBigInteger('schoolId')->nullable();
            $table->string('schoolName')->nullable();
            $table->string('headmaster')->nullable();
            $table->string('phoneHeadmaster')->nullable();
            $table->string('schoolOperator')->nullable();
            $table->string('phoneOperator')->nullable();
            $table->string('chairman')->nullable();
            $table->string('phoneChairman')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('verify')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('userId')
                ->references('id')
                ->on('users');
            $table->foreign('villageId')
                ->references('id')
                ->on('indonesia_villages');
            // $table->foreign('schoolId')
            //     ->references('id')
            //     ->on('schools');
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
