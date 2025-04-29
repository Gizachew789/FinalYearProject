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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescriber_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medication_id')->constrained('inventory_transactions')->onDelete('cascade');
            $table->string('dosage')->notNullable();
            $table->string('frequency')->notNullable();
            $table->string('duration')->notNullable();
            $table->text('instructions')->notNullable();
            $table->integer('quantity')->default(1);
            $table->enum('status', ['confirmeed', 'waiting', 'cancelled'])->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};

