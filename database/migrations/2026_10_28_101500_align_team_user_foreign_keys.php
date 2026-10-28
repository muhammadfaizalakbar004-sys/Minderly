
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Samakan tipe kolom dengan pengguna.id_pengguna (INT signed).
        Schema::table('teams', function (Blueprint $table) {
            $table->integer('owner_id')->change();
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->integer('user_id')->change();
        });

        // Tambahkan relasi ke tabel pengguna.
        Schema::table('teams', function (Blueprint $table) {
            $table->foreign('owner_id')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnDelete();
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->unsignedInteger('owner_id')->change();
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->change();
        });
    }
};
