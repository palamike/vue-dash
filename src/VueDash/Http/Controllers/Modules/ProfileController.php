<?php

namespace Palamike\VueDash\Http\Controllers\Modules;

use Palamike\VueDash\Exceptions\ObjectNotFoundException;
use Palamike\VueDash\Http\Controllers\Controller;
use Palamike\VueDash\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

	/**
	 *
	 * Module Main Page
	 *
	 */
	public function index(){
		return view('vueDash::modules.profile', [ 'menu' => 'profile' ]);
	}

	public function view() {
		$user = auth()->user();

		return response()->json(['status' => 'success', 'object' => $user]);
	}

	/**
	 *
	 * Update entry in database
	 *
	 * @param  Request $request
	 */
	public function update(Request $request) {

		$request->validate($this->getValidationRules($request,true), $this->getValidationMessages());

		$input = $request->all();

		$user = User::find($input['id']);

		if (is_null($user)) {
			throw new ObjectNotFoundException();
		}

		if(isset($input['password']) && ! empty($input['password'])){
			$input['password'] = Hash::make($input['password']);
		}//if

		$user->update($input);

		return response()->json([ 'status' => 'success', 'object' => $user ]);

	}

	public function getValidationRules(Request $request, $edit = false) {
		$rules = [
			'name' => 'bail|required|max:255|alpha_dash|unique:users,name',
			'email' => 'bail|required|email|max:255|unique:users,email',
			'password' => 'confirmed'

		];

		$rules['name'] .= ','.auth()->user()->id;
		$rules['email'] .= ','.auth()->user()->id;

		return $rules;
	}

	public function getValidationMessages() {
		return [];
	}


}
