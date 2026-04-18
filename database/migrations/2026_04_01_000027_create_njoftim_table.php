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
        Schema::create('NJOFTIM', function (Blueprint $table) {
            $table->increments('NJF_ID');
            $table->integer('PERD_ID')->nullable();
            $table->integer('DEP_ID')->nullable();
            $table->string('NJF_TITULLI', 300);
            $table->longText('NJF_PERMBAJTJA')->nullable();
            $table->string('NJF_AUDIENCE', 100)->nullable();
            $table->dateTime('NJF_DATA_PUB')->default(DB::raw('getdate()'));
            $table->dateTime('NJF_DATA_SKA')->nullable();
            $table->boolean('NJF_FIKSUAR')->default(false);

            $table->foreign('PERD_ID')->references('PERD_ID')->on('PERDORUES');
            $table->foreign('DEP_ID')->references('DEP_ID')->on('DEPARTAMENT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('NJOFTIM');
    }
};
