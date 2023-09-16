<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::findById(1);
        $permissions = Permission::get();
        $admin->syncPermissions($permissions);

        // $admin->givePermissionTo('create');
        // $admin->givePermissionTo('read');
        // $admin->givePermissionTo('update');
        // $admin->givePermissionTo('delete');

        $editor = Role::findById(2);
        $editor->givePermissionTo('create');
        $editor->givePermissionTo('read');
    }
}
