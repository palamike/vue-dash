<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$permissions = $this->getPermissions();
		foreach($permissions as $perm => $list){
			$this->addPermission($perm, $list);
		}
    }

    public function getPermissions() {
        return [
            'user' => 'default',
            'role' => 'default',
            'general_setting' => ['update'],
            'profile' => ['update']
	    ];
    }

	/**
	 *
	 * @param $name string permission group name
	 * @param $permissions string|array permission list
	 *
	 */
    public function addPermission($name, $permissions = 'default')
    {

        $list = ['add', 'edit', 'delete', 'view' ];

        if(is_array($permissions)) {
			$list = $permissions;
	    }

	    foreach($list as $perm){
    	    $permission = $name.'_'.$perm;
		    Permission::create([ 'name' => $permission, 'group' => $name ]);
	    }
    }
}
