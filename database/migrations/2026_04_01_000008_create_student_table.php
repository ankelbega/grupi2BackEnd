<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('STUDENT', function (Blueprint $table) {
            $table->increments('STD_ID');
            $table->integer('PERD_ID')->nullable();
            $table->integer('DEP_ID');
            $table->string('STD_KOD', 20)->unique();
            $table->string('STD_STATUSI', 30)->default('aktiv');
            $table->decimal('STD_GPA', 4, 2)->nullable();
            $table->smallInteger('STD_KREDIT_FITUAR')->default(0);

            $table->foreign('PERD_ID')->references('PERD_ID')->on('PERDORUES');
            $table->foreign('DEP_ID')->references('DEP_ID')->on('DEPARTAMENT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('STUDENT');
    }
};
