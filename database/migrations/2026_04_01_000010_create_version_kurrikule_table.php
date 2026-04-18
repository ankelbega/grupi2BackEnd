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
        Schema::create('VERSION_KURRIKULE', function (Blueprint $table) {
            $table->increments('KURR_VER_ID');
            $table->integer('PROG_ID');
            $table->smallInteger('KURR_VER_NR');
            $table->boolean('KURR_VER_AKTIV')->default(true);
            $table->date('KURR_VER_DATA')->default(DB::raw('CONVERT([date],getdate())'));

            $table->foreign('PROG_ID')->references('PROG_ID')->on('PROGRAM_STUDIMI');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('VERSION_KURRIKULE');
    }
};
