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
        Schema::create('PROVIM', function (Blueprint $table) {
            $table->increments('PRV_ID');
            $table->integer('SEK_ID');
            $table->integer('SEM_ID');
            $table->integer('SALLE_ID')->nullable();
            $table->string('PRV_EMER', 200)->nullable();
            $table->string('PRV_TIPI', 30)->default('final');
            $table->date('PRV_DATA');
            $table->time('PRV_ORA_FILL');
            $table->smallInteger('PRV_KOHEZGJATJE')->default(120);
            $table->decimal('PRV_PIKE_MAX', 5, 2)->default(100);
            $table->decimal('PRV_PIKE_KAL', 5, 2)->default(50);

            $table->foreign('SEK_ID')->references('SEK_ID')->on('SEKSION');
            $table->foreign('SALLE_ID')->references('SALLE_ID')->on('SALLE');
        });

        // FK to SEMESTËR requires DB::statement due to special character in table name
        DB::statement("
            ALTER TABLE [PROVIM]
            ADD CONSTRAINT [FK_PROVIM_SEMESTËR]
            FOREIGN KEY ([SEM_ID]) REFERENCES [SEMESTËR] ([SEM_ID])
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('PROVIM');
    }
};
