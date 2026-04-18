<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('LENDE_PROGRAMI', function (Blueprint $table) {
            $table->increments('LP_ID');
            $table->integer('LEN_ID');
            $table->integer('KURR_VER_ID');
            $table->tinyInteger('LP_KREDIT')->default(0);
            $table->tinyInteger('LP_SEMESTRI');
            $table->tinyInteger('LP_VITI');
            $table->tinyInteger('LP_SEMESTRI_LLOJ')->default(1);
            $table->boolean('LP_ZGJEDHORE')->default(false);

            $table->foreign('LEN_ID')->references('LEN_ID')->on('LENDE');
            $table->foreign('KURR_VER_ID')->references('KURR_VER_ID')->on('VERSION_KURRIKULE');

            $table->unique(['LEN_ID', 'KURR_VER_ID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('LENDE_PROGRAMI');
    }
};
