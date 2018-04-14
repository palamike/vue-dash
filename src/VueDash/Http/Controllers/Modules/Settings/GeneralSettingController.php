<?php

namespace Palamike\VueDash\Http\Controllers\Modules\Settings;

class GeneralSettingController extends SettingController
{

	protected $settingGroup = 'general';

	/**
	 *
	 * Module Main Page
	 *
	 */
	public function index(){
		return view('vueDash::modules.settings.general_settings', [ 'menu' => 'general_settings' ]);
	}

    public function getSettingList() {
    	return [
		    'general_list_pagination',
		    'general_query_date_range'
	    ];
    }

	public function getValidationRules() {

    	$rules = [
			'general_list_pagination' => 'bail|required',
			'general_query_date_range' => 'bail|required|numeric'
		];

		return $rules;
	}
}
