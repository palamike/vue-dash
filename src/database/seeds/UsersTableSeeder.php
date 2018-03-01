<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	    /**
	     * @var $admin Palamike\VueDash\Models\User
	     */
    	    $admin = factory(Palamike\VueDash\Models\User::class)->create([
	    	'name' => 'administrator',
	    	'email' => 'admin@email.com'
	    ]);

		$admin->assignRole('administrator');

	    factory(Palamike\VueDash\Models\User::class, 20)->create();

    }
}
