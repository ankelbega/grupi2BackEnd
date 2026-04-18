<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('DEPARTAMENT', function (Blueprint $table) {
            $table->increments('DEP_ID');
            $table->string('DEP_EM', 150);
            $table->integer('FAK_ID');
            $table->integer('PERD_ID')->nullable();

            $table->foreign('FAK_ID')->references('FAK_ID')->on('FAKULTET');
            $table->foreign('PERD_ID')->references('PERD_ID')->on('PERDORUES');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('DEPARTAMENT');
    }
};
