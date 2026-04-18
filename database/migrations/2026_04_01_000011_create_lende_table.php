<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('LENDE', function (Blueprint $table) {
            $table->increments('LEN_ID');
            $table->integer('DEP_ID');
            $table->string('LEN_EM', 200);
            $table->string('LEN_KOD', 20)->unique();

            $table->foreign('DEP_ID')->references('DEP_ID')->on('DEPARTAMENT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('LENDE');
    }
};
