<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'user-register',
            'user-login',
            'user-logout',
            'user-manage',
            'role-create',
            'patient-create',
            'patient-list',
            'patient-edit',
            'patient-delete',
            'patient-manage',
            'inventory-create',
            'inventory-list',
            'inventory-edit',
            'inventory-delete',
            'inventory-manage',
            'attendance-create',
            'attendance-list',
            'attendance-edit',
            'attendance-delete',
            'attendance-manage',
            'appointment-create',
            'appointment-list',
            'appointment-edit',
            'appointment-delete',
            'appointment-manage',
            'report-create',
            'report-list',
            'report-edit',
            'report-delete',
            'report-manage',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'appointment-book',
            'patient-register',
            'medical-history-create',
            'medical-history-list',
            'medical-history-edit',
            'medical-history-delete',
            'medical-history-manage',
            'medical-data-upload',
            'medical-data-download',
            'medical-data-view',
            'lab-test-results-view',
            'lab-test-request-make',
            'prescription-make',
            'appointments-accept',
            'roles-edit',
            'roles-show',
            'roles-delete',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
