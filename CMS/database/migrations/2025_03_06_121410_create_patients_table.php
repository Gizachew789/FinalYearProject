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
            $table->id();
            $table->string('name')->notNullable();
            $table->enum('gender', ['male', 'female'])->notNullable();
            $table->integer('age')->notNullable();
            $table->string('phone_number')->notNullable();
            $table->string('email')->notNullable();
            // $table->string('emergency_contact_name')->nullable();
            // $table->string('emergency_contact_phone')->nullable();
            $table->string('department')->notNullable();
            $table->string('year_of_study')->notNullable();
            $table->string('blood_group')->notNullable();
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

