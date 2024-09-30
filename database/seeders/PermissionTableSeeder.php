<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Reset cached roles and permissions
        //app()[PermissionRegistrar::class]->forgetCachedPermissions();


        $permissions = [
            'dashboard-list',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'employee-list',
            'employee-create',
            'employee-edit',
            'employee-delete',
            'aboutus-list',
            'aboutus-create',
            'aboutus-edit',
            'aboutus-delete',
            'activity-list',
            'activity-create',
            'activity-edit',
            'activity-delete',
            'booknow-list',
            'booknow-create',
            'booknow-edit',
            'booknow-delete',
            'volunteer-list',
            'volunteer-create',
            'volunteer-edit',
            'volunteer-delete',
            'customer-list',
            'customer-create',
            'customer-edit',
            'customer-delete',
            'announcement-list',
            'announcement-create',
            'announcement-edit',
            'announcement-delete',
            'qrcode-list',
            'qrcode-create',
            'qrcode-edit',
            'qrcode-delete',
            'accomodation-list',
            'accomodation-create',
            'accomodation-edit',
            'accomodation-delete',
        ];

        // foreach ($permissions as $permission) {
        //      Permission::create(['name' => $permission]);
        // }
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
