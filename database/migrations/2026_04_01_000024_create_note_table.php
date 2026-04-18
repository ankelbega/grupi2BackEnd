<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('NOTE', function (Blueprint $table) {
            $table->increments('NOTE_ID');
            $table->integer('REGJ_ID');
            $table->integer('PERD_ID')->nullable();
            $table->decimal('NOTE_NDERMJET', 5, 2)->nullable();
            $table->decimal('NOTE_FINALE', 5, 2)->nullable();
            $table->decimal('NOTE_TOTALE', 5, 2)->nullable();
            $table->decimal('NOTE_DETYRE', 5, 2)->nullable();
            $table->string('NOTE_SHKRONJE', 2)->nullable();
            $table->decimal('NOTE_GPA', 5, 2)->nullable();
            $table->dateTime('NOTE_DATA')->default(DB::raw('getdate()'));

            $table->foreign('REGJ_ID')->references('REGJ_ID')->on('REGJISTRIM');
            $table->foreign('PERD_ID')->references('PERD_ID')->on('PERDORUES');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('NOTE');
    }
};
