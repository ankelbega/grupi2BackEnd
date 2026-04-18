<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('STUDENT_PROGRAM', function (Blueprint $table) {
            $table->increments('STD_PRG_ID');
            $table->integer('STD_ID');
            $table->integer('KURR_VER_ID');
            $table->date('STD_PRG_DTF');
            $table->date('STD_PRG_DTM')->nullable();
            $table->string('STD_PRG_STATUS', 20)->default('aktiv');

            $table->foreign('STD_ID')->references('STD_ID')->on('STUDENT');
            $table->foreign('KURR_VER_ID')->references('KURR_VER_ID')->on('VERSION_KURRIKULE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('STUDENT_PROGRAM');
    }
};
