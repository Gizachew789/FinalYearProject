<?php
// database/migrations/xxxx_xx_xx_create_dispensations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispensationsTable extends Migration
{
    public function up()
    {
        Schema::create('dispensations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
            $table->foreignId('inventory_transaction_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_used');
            $table->foreignId('pharmacist_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dispensations');
    }
}
