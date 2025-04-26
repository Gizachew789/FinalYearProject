<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->foreignId('medication_id')->constrained('medications')->onDelete('cascade'); // Foreign key to medications table
            $table->integer('quantity'); // Quantity of the transaction
            $table->enum('transaction_type', ['in', 'out']); // Whether it's an "in" (addition) or "out" (deduction) transaction
            $table->date('transaction_date'); // Date when the transaction occurred
            $table->string('reason'); // Reason for the transaction (e.g., restock, sale, etc.)
            $table->string('batch_number')->nullable(); // Batch number (optional)
            $table->date('expiry_date')->nullable(); // Expiry date for the batch (optional)
            $table->foreignId('performed_by')->constrained('users')->onDelete('set null'); // Foreign key to users table (who performed the transaction)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_transactions');
    }
}
