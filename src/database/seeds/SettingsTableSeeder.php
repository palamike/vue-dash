<?php

use Illuminate\Database\Seeder;
use Palamike\VueDash\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$settings = [
			'general' => [
				'list_pagination' => [
					'value' => '25',
					'name' => 'List Pagination',
					'description' => 'Grid Pagination Size (Record per Page)'
				]
			]
		];

		$this->createSettings($settings);
    }

    public function createSettings($groups){
    	    foreach( $groups as $group => $settings){
    	    	    foreach($settings as $key => $attrs) {
    	    	        Setting::create(array_merge([ 'key' => $group.'_'.$key, 'group' => $group ], $attrs));
		    }
	    }
    }
}
