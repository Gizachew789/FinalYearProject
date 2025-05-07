<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define permissions
        $permissions = [
            'inventory-manage', 
            'prescription-make',
            'prescription-list',
            'prescription-edit',
            'prescription-delete',
            'prescription-manage',
            'prescription-view',
            'prescription-create',
            'prescription-accept',
            'patient-create',
            'medical-history-create',
            'medical-history-view',
            'medical-history-list',
            'medical-history-edit',
            'medical-history-delete',
            'medical-history-manage',
            'medical-data-upload',
            'medical-data-download',
            'medical-data-view',
            'appointments-accept',
            'appointments-cancel',
            'appointments-reschedule',
            'appointments-view',
            'appointments-manage',
            'user-register',
            'user-login',
            'user-logout',
            'user-manage',
            'patient-list',
            'patient-edit',
            'patient-delete',
            'patient-manage',
            'inventory-create',
            'inventory-list',
            'inventory-edit',
            'inventory-delete',
            'inventory-view',
            'inventory-update',
            'attendance-create',
            'attendance-view',
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
            'appointments-book',
            'patient-register',
            'labtst-request-list',
            'labtest-request-edit',
            'labtest-request-delete',
            'labtest-request-manage',
            'labtest-request-view',
            'labtest-request-create',
            'labtest-request-accept',
            'labtest-request-make',
            'labtest-results-create',
            'labtest-results-list',
            'labtest-results-edit',
            'labtest-results-delete',
            'labtest-results-manage',
            'labtest-results-download',
            'labtest-results-upload',
            'labtest-results-view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Define roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $reception = Role::firstOrCreate(['name' => 'Reception']);
        $nurse = Role::firstOrCreate(['name' => 'Nurse']);
        $healthofficer = Role::firstOrCreate(['name' => 'Health_Officer']);
        $labtechnician = Role::firstOrCreate(['name' => 'Lab_Technician']);
        $pharmacist = Role::firstOrCreate(['name' => 'Pharmacist']);
        $nurse = Role::firstOrCreate(['name' => 'Nurse']);
        

        // Assign permissions to roles
        $admin->givePermissionTo([
        'inventory-manage', 'appointments-view', 'user-register',
         'user-manage', 'patient-delete','patient-manage',
         'patient-edit', 'patient-list', 'inventory-create',
         'inventory-list', 'inventory-edit', 'inventory-delete',
         'inventory-view', 'inventory-update', 'report-create',
         'attendance-list', 'attendance-edit', 'attendance-delete',
         'attendance-manage', 'report-list', 'report-edit', 'report-delete',
         'report-manage', 'user-list', 'user-create', 'user-edit',
         'user-delete', 'attendance-view', 'attendance-create', 'user-logout',
         
        ]);
        $pharmacist->givePermissionTo([
        'prescription-accept', 'prescription-list', 'inventory-update',
        'prescription-view', 'inventory-list', 'inventory-edit', 'inventory-view', 
        'user-login', 'user-logout', 'attendance-view',     
    ]);
        $nurse->givePermissionTo([
        'appointments-view', 'medical-history-create', 'appointments-accept', 'medical-history-view',
        'medical-history-list', 'medical-history-edit', 'medical-history-delete',
        'medical-history-manage', 'medical-data-upload', 'medical-data-download',
        'medical-data-view', 'labtst-request-list', 'labtest-request-edit',
        'labtest-request-delete', 'labtest-request-manage', 'labtest-request-view',
        'labtest-request-create', 'labtest-results-download', 'labtest-results-view',
        'prescription-make', 'prescription-list', 'prescription-edit',
        'prescription-delete', 'prescription-manage', 'prescription-view', 'prescription-create',
        'user-login', 'user-logout', 'attendance-view',
    ]);
        $reception->givePermissionTo(['patient-list', 'attendance-view', 'patient-register',
        'appointments-book', 'appointments-view','appointments-cancel', 'appointments-reschedule',
        'appointments-manage', 'user-login', 'user-logout', 
    
    ]);
        $healthofficer->givePermissionTo([
        'appointments-view', 'medical-history-create', 'appointments-accept', 'medical-history-view',
        'medical-history-list', 'medical-history-edit', 'medical-history-delete',
        'medical-history-manage', 'medical-data-upload', 'medical-data-download',
        'medical-data-view', 'labtst-request-list', 'labtest-request-edit',
        'labtest-request-delete', 'labtest-request-manage', 'labtest-request-view',
        'labtest-request-create', 'labtest-results-download', 'labtest-results-view',
        'prescription-make', 'prescription-list', 'prescription-edit',
        'prescription-delete', 'prescription-manage', 'prescription-view', 'prescription-create',
        'user-login', 'user-logout', 'attendance-view',
    ]);
        $labtechnician->givePermissionTo([
        'labtest-results-create', 'labtest-results-list', 'labtest-results-edit',
        'labtest-results-delete', 'labtest-results-manage', 'labtest-results-download',
        'labtest-results-upload','labtest-results-view', 'labtest-request-view',
        'labtest-request-accept', 'labtst-request-list', 'medical-data-view',
        'medical-history-view', 'attendance-view', 'user-login', 'user-logout',
    ]);
    }
}
