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
        Schema::table('users', function (Blueprint $table) {

               if (!Schema::hasColumn('users', 'role')) {
            $table->enum('role', ['admin', 'Bsc_Nurse', 'patient', 'reception', 'lab_technician', 'Health_Officer', 'pharmacist'])->after('password')->notNull();
    }

    if (!Schema::hasColumn('users', 'phone')) {
        $table->string('phone', 255)->after('role')->notNull();
    }
                //$table->enum('role', ['admin', 'physician', 'patient', 'reception', 'lab_technician', 'pharmacist'])->after('password');
           
           // $table->string('phone')->notNullable()->after('role');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'status']);
        });
    }
};

