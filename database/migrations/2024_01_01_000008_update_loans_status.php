<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: ubah enum dengan menambah nilai baru
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending_approval','borrowed','returned','overdue','rejected') NOT NULL DEFAULT 'pending_approval'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('borrowed','returned','overdue') NOT NULL DEFAULT 'borrowed'");
    }
};
