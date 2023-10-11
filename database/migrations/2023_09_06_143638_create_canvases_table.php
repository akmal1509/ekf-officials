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
            $table->bigInteger('parentId')->default(0);
            $table->unsignedBigInteger('createdBy');
            $table->unsignedBigInteger('villageId');
            $table->string('name');
            $table->bigInteger('nik')->unique();
            $table->bigInteger('nkk')->unique();
            $table->string('phone')->nullable();
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->text('address')->nullable();
            $table->integer('tps')->nullable();
            $table->string('ktpImage')->nullable();
            $table->string('rumahImage')->nullable();
            $table->string('withImage')->nullable();
            $table->string('kkImage')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('createdBy')
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
