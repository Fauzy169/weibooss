<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->nullableMorphs('item'); // adds item_type & item_id (nullable)
            $table->unique(['item_type', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropUnique(['item_type', 'item_id']);
            $table->dropMorphs('item');
        });
    }
};
