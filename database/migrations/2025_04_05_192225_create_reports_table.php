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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignID('Reported_By')->constrained('users')->onDelete('cascade');
            $table->enum('Report_type', ['Total_cases_report', 'staff_status_report', 'inventory_report', 'lab_report'])->notNullable();
            $table->json('Report_data')->notNullable();
            $table->date('Report_date')->notNullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
