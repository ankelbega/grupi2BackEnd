<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('PROGRAM_STUDIMI', function (Blueprint $table) {
            $table->increments('PROG_ID');
            $table->integer('DEP_ID');
            $table->string('PROG_EM', 200);
            $table->string('PROG_NIV', 50);
            $table->smallInteger('PROG_KRD')->default(0);

            $table->foreign('DEP_ID')->references('DEP_ID')->on('DEPARTAMENT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PROGRAM_STUDIMI');
    }
};
