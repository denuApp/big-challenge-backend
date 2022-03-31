<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $patient = Role::create(['name' => 'patient']);
//        $patient->givePermissionTo('edit articles');

        $doctor = Role::create(['name' => 'doctor']);
    }
}
