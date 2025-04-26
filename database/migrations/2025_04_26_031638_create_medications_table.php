<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationsTable extends Migration
{
    public function up()
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category');
            $table->string('unit');
            $table->integer('current_stock')->default(0);
            $table->integer('reorder_level')->default(0);
            $table->decimal('price', 10, 2);
            $table->date('expiry_date')->nullable();
            $table->string('manufacturer')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medications');
    }
}
