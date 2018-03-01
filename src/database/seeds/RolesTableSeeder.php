<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all = Permission::all();
	    $plucked = $all->pluck('name');
	    $allPermissionNames = $plucked->all();

	    $admin = Role::create([ 'name' => 'administrator', 'description' => 'The System Administrator', 'redirect' => '/home' ]);
	    $admin->syncPermissions($allPermissionNames);

	    factory(Role::class,55)->create();
    }
}
