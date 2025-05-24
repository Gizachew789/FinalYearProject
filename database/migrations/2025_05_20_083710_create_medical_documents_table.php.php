<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('medical_documents', function (Blueprint $table) {
            $table->id();
           
            $table->string('file_path');
            $table->enum('file_type', ['pdf', 'image']);
            $table->timestamps();

            $table->string('patient_id'); 
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_documents');
    }
}