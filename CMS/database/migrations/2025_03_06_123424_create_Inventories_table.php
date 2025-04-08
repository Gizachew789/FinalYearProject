<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //         Schema::create('inventory', function (Blueprint $table) {
    //             $table->id(); // Primary key (item id)
    //             $table->string('item_name', 100);
    //             $table->unsignedInteger('quantity'); // Non-negative value
    //             $table->string('category', 50)->nullable(); // e.g., Medicine, Equipment, Supplies
    //             // "last_updated" field; Laravel 8+ supports useCurrentOnUpdate()
    //             //$table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
    //             //$table->timestamps();
    //        });
        
    // }
    public function up()
{
    if (!Schema::hasTable('inventory')) { // Check if the table already exists
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_name', 100);
            $table->enum('category',['Medicine', 'Equipment','Reagents', 'Disposables', 'Supplies', 'Tools'])->default('Medicine');
            $table->enum('unit', ['pcs', 'boxes', 'vials', 'liters', 'kg'])->default('pcs');
            $table->unsignedInteger('quantity');
            $table->text('description')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
