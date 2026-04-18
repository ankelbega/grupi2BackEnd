<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('PREZENCE', function (Blueprint $table) {
            $table->increments('PREZ_ID');
            $table->integer('REGJ_ID');
            $table->integer('ORAR_ID');
            $table->date('PREZ_DATA');
            $table->string('PREZ_STATUS', 20)->default('pranishem');
            $table->string('PREZ_ARSYE', 255)->nullable();

            $table->foreign('REGJ_ID')->references('REGJ_ID')->on('REGJISTRIM');
            $table->foreign('ORAR_ID')->references('ORAR_ID')->on('ORAR');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PREZENCE');
    }
};
