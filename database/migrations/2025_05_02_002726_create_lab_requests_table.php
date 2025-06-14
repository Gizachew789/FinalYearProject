<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id'); 
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('requested_by'); // User who requested
            $table->string('test_name');
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
    
            // Foreign keys
            
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
};
