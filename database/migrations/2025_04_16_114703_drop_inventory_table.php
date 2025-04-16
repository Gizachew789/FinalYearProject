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
        // Drop the foreign key constraint first
        if (Schema::hasTable('prescription_items')) {
            Schema::table('prescription_items', function (Blueprint $table) {
                $table->dropForeign('prescription_items_medication_id_foreign');
            });
        }

        // Drop the inventory table
        if (Schema::hasTable('inventory')) {
            Schema::drop('inventory');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the inventory table
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Recreate the foreign key constraint
        Schema::table('prescription_items', function (Blueprint $table) {
            $table->foreign('medication_id')->references('id')->on('inventory')->onDelete('cascade');
        });
    }
};