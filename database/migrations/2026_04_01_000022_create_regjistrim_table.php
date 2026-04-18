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
        Schema::create('REGJISTRIM', function (Blueprint $table) {
            $table->increments('REGJ_ID');
            $table->integer('STD_ID');
            $table->integer('SEK_ID');
            $table->integer('SEM_ID');
            $table->dateTime('REGJ_DT')->default(DB::raw('getdate()'));
            $table->string('REGJ_STATUS', 20)->default('aktiv');

            $table->foreign('STD_ID')->references('STD_ID')->on('STUDENT');
            $table->foreign('SEK_ID')->references('SEK_ID')->on('SEKSION');
        });

        // FK to SEMESTËR requires DB::statement due to special character in table name
        DB::statement("
            ALTER TABLE [REGJISTRIM]
            ADD CONSTRAINT [FK_REGJISTRIM_SEMESTËR]
            FOREIGN KEY ([SEM_ID]) REFERENCES [SEMESTËR] ([SEM_ID])
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('REGJISTRIM');
    }
};
