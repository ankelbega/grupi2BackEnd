<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('REZULTAT_PROVIM', function (Blueprint $table) {
            $table->increments('REZ_ID');
            $table->integer('PRV_ID');
            $table->integer('STD_ID');
            $table->decimal('REZ_PIKE', 5, 2)->nullable();
            $table->boolean('REZ_MUNGOI')->default(false);
            $table->string('REZ_VEREJTJE', 500)->nullable();

            $table->foreign('PRV_ID')->references('PRV_ID')->on('PROVIM');
            $table->foreign('STD_ID')->references('STD_ID')->on('STUDENT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('REZULTAT_PROVIM');
    }
};
