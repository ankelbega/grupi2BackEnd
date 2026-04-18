<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('VIT_AKADEMIK', function (Blueprint $table) {
            $table->increments('VIT_ID');
            $table->string('VIT_EM', 20);
            $table->date('VIT_DT_FILL');
            $table->date('VIT_DT_MBR');
            $table->string('VIT_STATUS', 20)->default('aktiv');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('VIT_AKADEMIK');
    }
};
