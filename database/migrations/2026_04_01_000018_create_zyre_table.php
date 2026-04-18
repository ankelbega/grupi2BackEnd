<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('ZYRE', function (Blueprint $table) {
            $table->integer('SALLE_ID');
            $table->string('ZYR_LLOJI', 100)->nullable();
            $table->string('ZYR_PERSHKRIM', 255)->nullable();
            $table->integer('PED_ID')->nullable();

            $table->primary('SALLE_ID');
            $table->foreign('SALLE_ID')->references('SALLE_ID')->on('SALLE');
            $table->foreign('PED_ID')->references('PED_ID')->on('PEDAGOG');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ZYRE');
    }
};
