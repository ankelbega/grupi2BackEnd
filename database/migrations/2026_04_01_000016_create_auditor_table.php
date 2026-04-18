<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('AUDITOR', function (Blueprint $table) {
            $table->integer('SALLE_ID');
            $table->boolean('AUD_KA_PROJEKTOR')->default(false);
            $table->string('AUD_LLOJI', 50)->nullable();

            $table->primary('SALLE_ID');
            $table->foreign('SALLE_ID')->references('SALLE_ID')->on('SALLE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('AUDITOR');
    }
};
