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
        Schema::create('PERDORUES_ROL', function (Blueprint $table) {
            $table->increments('PERD_ROL_ID');
            $table->integer('PERD_ID');
            $table->integer('ROL_ID');
            $table->date('PERD_ROL_DATA')->default(DB::raw('CONVERT([date],getdate())'));
            $table->boolean('PERD_ROL_AKTIV')->default(true);

            $table->foreign('PERD_ID')->references('PERD_ID')->on('PERDORUES');
            $table->foreign('ROL_ID')->references('ROL_ID')->on('ROL');

            $table->unique(['PERD_ID', 'ROL_ID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PERDORUES_ROL');
    }
};
