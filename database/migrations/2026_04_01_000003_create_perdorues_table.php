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
        Schema::create('PERDORUES', function (Blueprint $table) {
            $table->increments('PERD_ID');
            $table->string('PERD_EMER', 100);
            $table->string('PERD_MBIEMER', 100);
            $table->string('PERD_EMAIL', 200)->unique();
            $table->string('PERD_FJKALIM', 255);
            $table->char('PERD_GJINI', 1)->nullable();
            $table->date('PERD_DTL')->nullable();
            $table->string('PERD_ADRESE', 255)->nullable();
            $table->string('PERD_TEL', 20)->nullable();
            $table->boolean('PERD_AKTIV')->default(true);
            $table->dateTime('PERD_KRIJUAR')->default(DB::raw('getdate()'));
            $table->string('PERD_TIPI', 20)->default('staf');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PERDORUES');
    }
};
