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
        Schema::create('patients', function (Blueprint $table) {
            $table->string('patient_id')->primary(); // manually set string ID as primary key
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->integer('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique(); // ensure email is unique
            $table->string('department')->nullable();
            $table->string('year_of_study')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

