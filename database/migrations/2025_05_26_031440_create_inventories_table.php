<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medication_id');
            $table->string('name');
            $table->integer('current_stock')->default(0);
            $table->integer('reorder_level')->default(0);
            $table->timestamps();
            $table->softDeletes();  // optional: allows soft deleting inventory records

            // Foreign key constraint: assumes you have a 'medications' table
            $table->foreign('medication_id')->references('id')->on('medications')->onDelete('cascade');

            // Optional: add an index to speed up queries on medication_id
            $table->index('medication_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
