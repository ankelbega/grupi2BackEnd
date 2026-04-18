<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('SALLE', function (Blueprint $table) {
            $table->increments('SALLE_ID');
            $table->string('SALLE_EM', 100);
            $table->smallInteger('SALLE_KAP')->default(0);
            $table->integer('FAK_ID')->nullable();

            $table->foreign('FAK_ID')->references('FAK_ID')->on('FAKULTET');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('SALLE');
    }
};
