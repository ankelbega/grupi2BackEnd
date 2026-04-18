<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('FAKULTET', function (Blueprint $table) {
            $table->increments('FAK_ID');
            $table->string('FAK_EM', 150);
            $table->integer('PERD_ID')->nullable(); // FK -> PERDORUES added later
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('FAKULTET');
    }
};
