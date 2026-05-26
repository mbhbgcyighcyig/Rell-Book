<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // borrower_id = user yang meminjam (peminjam)
            // user_id tetap = petugas yang memproses
            $table->unsignedBigInteger('borrower_id')->nullable()->after('user_id');
            $table->foreign('borrower_id')->references('id')->on('users')->onDelete('set null');
        });

        // Isi borrower_id dari relasi member → user (via email)
        DB::statement('
            UPDATE loans l
            JOIN members m ON l.member_id = m.id
            JOIN users u ON m.email = u.email
            SET l.borrower_id = u.id
        ');
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['borrower_id']);
            $table->dropColumn('borrower_id');
        });
    }
};
