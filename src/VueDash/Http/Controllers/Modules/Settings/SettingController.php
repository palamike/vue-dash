<?php

namespace Palamike\VueDash\Http\Controllers\Modules\Settings;

use Palamike\VueDash\Models\Setting;
use Illuminate\Http\Request;
use Palamike\VueDash\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

abstract class SettingController extends Controller
{

	/**
	 *
	 * sub class must override this value
	 *
	 * @var string
	 */
	protected $settingGroup = 'general';

	/**
	 *
	 * Module Main Page
	 *
	 */
	public abstract function index();

	/**
	 *
	 * View Action for Ajax
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function view() {

		$settings = Setting::where('group','=', $this->settingGroup)->get();

		$settingObject = $this->transformSettings($settings);

		return response()->json([ 'status' => 'success', 'object' => $settingObject ]);

	}

	/**
	 *
	 * Save Action for Ajax
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function save(Request $request) {

		$request->validate($this->getValidationRules(), $this->getValidationMessages());

		$input = $request->all();

		$settingList = $this->getSettingList();

		DB::transaction(function () use ($settingList, $input) {
			foreach($settingList as $key) {
				Setting::where('key','=',$key)->update([ 'value' => $input[$key] ]);
			}
		});

		return response()->json([ 'status' => 'success' ]);

	}

	/**
	 *
	 * Settings List for the group
	 *
	 * @return array
	 */
	public abstract function getSettingList();

	/**
	 *
	 * Request Validation Rules
	 *
	 * @return array
	 */
	public abstract function getValidationRules();

	/**
	 *
	 * Request Validation Message
	 *
	 * @return array
	 */
	public function getValidationMessages() {
		return [];
	}

	/**
	 *
	 * Transform Setting Collection to Object
	 *
	 * @param $settings
	 *
	 * @return array
	 */
	public function transformSettings($settings){

		$object = [];

		foreach ($settings as $setting) {
			$object[$setting->key] = $setting->value;
		}

		return $object;

	}
}
