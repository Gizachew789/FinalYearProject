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
        Schema::create('lab_reports', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->foreignId('lab_technician_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('test_type',['Blood', 'Waste', 'Tissue'])->defaul('Blood');
            $table->text('result')->notNullable();
            $table->text('test_description')->Nullable();
            $table->date('test_date')->notNullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('lab_reports', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['physician_id']);
        });
    
        Schema::dropIfExists('lab_reports');
    }
};
