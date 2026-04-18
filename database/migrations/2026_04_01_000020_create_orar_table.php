<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('ORAR', function (Blueprint $table) {
            $table->increments('ORAR_ID');
            $table->integer('SEK_ID');
            $table->tinyInteger('ORAR_DITA');
            $table->time('ORAR_ORA_FILL');
            $table->time('ORAR_ORA_MBA');
            $table->integer('SALLE_ID')->nullable();
            $table->string('ORAR_LLOJI', 20)->nullable();

            $table->foreign('SEK_ID')->references('SEK_ID')->on('SEKSION');
            $table->foreign('SALLE_ID')->references('SALLE_ID')->on('SALLE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ORAR');
    }
};
