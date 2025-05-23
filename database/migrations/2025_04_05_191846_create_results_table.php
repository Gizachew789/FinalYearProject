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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id'); 
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->foreignId('tested_by')->constrained('users')->onDelete('cascade');
            $table->string('disease_type');
            $table->enum('sample_type',['Blood', 'Saliva', 'Tissue', 'Waste'])->default('Blood');
            $table->enum('result', ['Positive', 'Negative']);
            $table->string('Recommendation')->Nullable();
            $table->date('result_date')->Nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result');
    }
};
