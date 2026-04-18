<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        Schema::create('ROL', function (Blueprint $table) {
            $table->increments('ROL_ID');
            $table->string('ROL_EMER', 100);
            $table->string('ROL_PERSHKRIM', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ROL');
    }
};
