<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('PEDAGOG', function (Blueprint $table) {
            $table->increments('PED_ID');
            $table->integer('DEP_ID');
            $table->integer('PERD_ID')->nullable();
            $table->string('PED_KOD', 20)->nullable()->unique();
            $table->string('PED_SPECIALIZIM', 200)->nullable();
            $table->date('PED_DATA_PUNESIMIT')->nullable();
            $table->string('PED_LLOJ_KONTRATE', 50)->nullable();

            $table->foreign('DEP_ID')->references('DEP_ID')->on('DEPARTAMENT');
            $table->foreign('PERD_ID')->references('PERD_ID')->on('PERDORUES');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PEDAGOG');
    }
};
