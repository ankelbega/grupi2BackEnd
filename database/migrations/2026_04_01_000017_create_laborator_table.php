<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('LABORATOR', function (Blueprint $table) {
            $table->integer('SALLE_ID');
            $table->smallInteger('LAB_NR_KOMPJUTER')->default(0);
            $table->string('LAB_SISTEMI_OPERATIV', 50)->default('Windows');
            $table->string('LAB_SOFTUERET', 500)->nullable();
            $table->string('LAB_PERGJEGJESI', 200)->nullable();

            $table->primary('SALLE_ID');
            $table->foreign('SALLE_ID')->references('SALLE_ID')->on('AUDITOR');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('LABORATOR');
    }
};
