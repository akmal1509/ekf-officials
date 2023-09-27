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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('levelId');
            $table->unsignedBigInteger('villageId');
            $table->string('name');
            $table->text('address')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('levelId')
                ->references('id')
                ->on('education_levels');
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
        Schema::dropIfExists('schools');
    }
};
