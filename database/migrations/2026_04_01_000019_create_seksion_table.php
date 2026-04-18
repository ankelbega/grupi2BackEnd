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
        Schema::create('SEKSION', function (Blueprint $table) {
            $table->increments('SEK_ID');
            $table->integer('LEN_ID');
            $table->integer('SEM_ID');
            $table->integer('PED_ID');
            $table->integer('SALLE_ID')->nullable();
            $table->string('SEK_KOD', 20)->nullable()->unique();
            $table->smallInteger('SEK_KAPACITET')->default(30);
            $table->string('SEK_MENYRE', 20)->default('prezence');
            $table->string('SEK_STATUS', 20)->default('aktiv');

            $table->foreign('LEN_ID')->references('LEN_ID')->on('LENDE');
            $table->foreign('PED_ID')->references('PED_ID')->on('PEDAGOG');
            $table->foreign('SALLE_ID')->references('SALLE_ID')->on('SALLE');
        });

        // FK to SEMESTËR requires DB::statement due to special character in table name
        DB::statement("
            ALTER TABLE [SEKSION]
            ADD CONSTRAINT [FK_SEKSION_SEMESTËR]
            FOREIGN KEY ([SEM_ID]) REFERENCES [SEMESTËR] ([SEM_ID])
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('SEKSION');
    }
};
