<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'transfer'])->nullable()->after('status');
            $table->string('payment_proof')->nullable()->after('payment_method');
            $table->text('payment_notes')->nullable()->after('payment_proof');
            $table->timestamp('payment_confirmed_at')->nullable()->after('payment_notes');
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('payment_confirmed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_proof',
                'payment_notes',
                'payment_confirmed_at',
                'confirmed_by'
            ]);
        });
    }
};
