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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('createdBy');
            $table->unsignedBigInteger('updatedBy');
            $table->unsignedBigInteger('schoolId');
            $table->string('name');
            $table->bigInteger('nisn');
            $table->bigInteger('nik');
            $table->text('address');
            $table->date('birthday');
            $table->integer('class');
            $table->bigInteger('npsn');
            $table->string('motherName')->nullable();
            $table->string('fatherName')->nullable();
            $table->string('guardName')->nullable();
            $table->string('motherPhone')->nullable();
            $table->string('fatherPhone')->nullable();
            $table->string('guardPhone')->nullable();
            $table->string('motherJob')->nullable();
            $table->string('fatherJob')->nullable();
            $table->string('guardJob')->nullable();
            $table->decimal('fatherEarn', 20, 2)->nullable();
            $table->decimal('motherEarn', 20, 2)->nullable();
            $table->decimal('guardEarn', 20, 2)->nullable();
            $table->enum('statusSaving', ['nominasi', 'pemberian']);
            $table->string('proposerName')->nullable();
            $table->string('primerProposerName')->nullable();
            $table->string('fase')->nullable();
            $table->date('proposeDate');
            $table->boolean('worty');
            $table->string('reason');
            $table->boolean('dtksStudent');
            $table->boolean('dtksNik');
            $table->boolean('dtksPkh');
            $table->boolean('p3keNik');
            $table->boolean('p3keDesil')->nullable();
            $table->boolean('validNisn');
            $table->boolean('validDukcapil');
            $table->text('information')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('schoolId')
                ->references('id')
                ->on('schools');
            $table->foreign('createdBy')
                ->references('id')
                ->on('users');
            $table->foreign('updatedBy')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
