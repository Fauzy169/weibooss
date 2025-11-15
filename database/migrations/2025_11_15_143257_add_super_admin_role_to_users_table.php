<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Untuk SQLite, kita perlu recreate table dengan constraint baru
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'administrator', 'owner', 'customer', 'keuangan', 'gudang', 'sales', 'kasir'])
                  ->default('customer')
                  ->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['administrator', 'owner', 'customer', 'keuangan', 'gudang', 'sales', 'kasir'])
                  ->default('customer')
                  ->after('email');
        });
    }
};
