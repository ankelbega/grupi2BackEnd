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
        Schema::create('STAF', function (Blueprint $table) {
            $table->integer('PERD_ID');
            $table->string('STF_KOD', 20)->nullable();
            $table->string('STF_POZICION', 100);
            $table->integer('STF_DEP_ID')->nullable();
            $table->date('STF_DATA_FILL')->default(DB::raw('CONVERT([date],getdate())'));
            $table->boolean('STF_AKTIV')->default(true);

            $table->primary('PERD_ID');
            $table->foreign('PERD_ID')->references('PERD_ID')->on('PERDORUES');
            $table->foreign('STF_DEP_ID')->references('DEP_ID')->on('DEPARTAMENT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('STAF');
    }
};
