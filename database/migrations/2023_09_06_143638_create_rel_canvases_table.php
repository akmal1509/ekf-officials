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
        Schema::create('rel_canvases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('canvasId');
            $table->string('name');
            $table->bigInteger('nik')->unique();
            $table->bigInteger('nkk')->unique();
            $table->string('ktpImage')->nullable();
            $table->string('kkImage')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('canvasId')
                ->references('id')
                ->on('canvases');
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
