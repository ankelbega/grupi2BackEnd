<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $connection = 'sqlsrv';

    public function up(): void
    {
        DB::statement("
            CREATE TABLE [SEMESTËR] (
                [SEM_ID]       INT           IDENTITY(1,1) NOT NULL,
                [VIT_ID]       INT           NOT NULL,
                [SEM_NR]       TINYINT       NOT NULL,
                [SEM_DT_FILL]  DATE          NOT NULL,
                [SEM_DT_MBR]   DATE          NOT NULL,
                CONSTRAINT [PK_SEMESTËR] PRIMARY KEY ([SEM_ID]),
                CONSTRAINT [FK_SEMESTËR_VIT_AKADEMIK] FOREIGN KEY ([VIT_ID])
                    REFERENCES [VIT_AKADEMIK] ([VIT_ID]),
                CONSTRAINT [UQ_SEMESTËR_VIT_SEM] UNIQUE ([VIT_ID], [SEM_NR])
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TABLE IF EXISTS [SEMESTËR]");
    }
};
