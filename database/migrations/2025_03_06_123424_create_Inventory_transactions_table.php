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
        if (!Schema::hasTable('inventory_transaction')) {
            Schema::create('inventory_transaction', function (Blueprint $table) {
                $table->id(); // Primary key
                $table->string('item_name', 100); // Name of the inventory item
                $table->unsignedBigInteger('category_id'); // Foreign key for category
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); // Cascade on delete
                $table->enum('unit', ['pcs', 'boxes', 'vials', 'liters', 'kg'])->default('pcs'); // Unit of measurement
                $table->unsignedInteger('quantity'); // Quantity in stock
                $table->text('description')->nullable(); // Optional description
                $table->date('expiry_date')->nullable(); // Expiry date for items like medications
                $table->timestamps(); // Created and updated timestamps
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transaction');
    }
};