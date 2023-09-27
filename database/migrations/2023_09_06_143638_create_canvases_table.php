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
        Schema::create('canvases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('createdBy');
            $table->unsignedBigInteger('updatedBy');
            $table->unsignedBigInteger('villageId');
            $table->string('name');
            $table->bigInteger('nik');
            $table->string('phone');
            $table->integer('rt');
            $table->integer('rw');
            $table->text('address');
            $table->integer('tps');
            $table->string('ktpImage')->nullable();
            $table->string('ktpImageR1')->nullable();
            $table->string('ktpImageR2')->nullable();
            $table->string('rumahImage')->nullable();
            $table->string('withImage')->nullable();
            $table->string('withImageR1')->nullable();
            $table->string('withImageR2')->nullable();
            $table->string('kkImage')->nullable();
            $table->string('kkImage2')->nullable();
            $table->string('kkImage3')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('createdBy')
                ->references('id')
                ->on('users');
            $table->foreign('updatedBy')
                ->references('id')
                ->on('users');
            $table->foreign('villageId')
                ->references('id')
                ->on('indonesia_villages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canvases');
    }
};
