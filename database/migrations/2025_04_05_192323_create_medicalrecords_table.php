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
        Schema::create('medicalrecords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->text('diagnosis')->notNullable(); //Description of the patient's diagnosis
            $table->text('treatment')->notNullable(); //Summary of the treatment provided or prescribed
            $table->text('prescription')->notNullable(); //Any medication prescribed
            $table->date('visit_date')->notNullable(); //The date of the medical visit
            $table->date('follow_up_date')->notNullable();
            $table->foreignId('lab_results_id')->constrained('results')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicalrecordss');
    }
};
