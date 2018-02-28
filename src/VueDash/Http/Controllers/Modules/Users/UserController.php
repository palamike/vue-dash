<?php

namespace Palamike\VueDash\Http\Controllers\Modules\Users;

use Palamike\VueDash\Exceptions\BusinessException;
use Palamike\VueDash\Exceptions\ObjectNotFoundException;
use Palamike\VueDash\Http\Controllers\Modules\ModuleController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Palamike\VueDash\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends ModuleController
{

	public function getGridSortOrder(){
		return [ 'id' => 'users.id', 'name' => 'users.name', 'email' => 'users.email', 'status' => 'users.status' ,'role' => 'roles.name' ];
	}

	public function performGridDefaultSort( &$grid ) {
		$grid->orderBy('users.id','DESC');
	}

	/**
	 *
	 * Process Grid where Switch
	 *
	 * @param  $grid Builder
	 * @param  $field
	 * @param  $value
	 */
	public function getWhereSwitchProcessor(&$grid, $field, $value) {

		switch($field) {
			case 'id': $grid->where('users.id', '=', $value); break;
			case 'name': $grid->where('users.name', 'like', "%{$value}%"); break;
			case 'email': $grid->where('users.email', 'like', "%{$value}%"); break;
			case 'status': $grid->where('users.status', '=', "%".strtolower($value)."%"); break;
			case 'role': $grid->where('roles.name', 'like', "%{$value}%"); break;
		}

	}

	/**
	 *
	 * Module Main Page
	 *
	 */
	public function index(){
		return view('vueDash::modules.users.users', [ 'menu' => 'users' ]);
	}

	/**
	 *
	 * Grid Control Function
	 *
	 * @param  Request $request
	 */
	public function grid(Request $request){

		$grid = User::leftJoin('model_has_roles', function($join) {
			$join->on('users.id','=','model_has_roles.model_id')
				->where('model_has_roles.model_type','=','App\Models\User');
		})
		->leftJoin('roles','model_has_roles.role_id','=','roles.id')
		->select('users.id','users.name', 'users.email', 'users.status' ,'roles.name as role');

		//all request parameters
		$params = $request->all();

		$this->processGridWhere($grid, $request, $params);

		$this->sortGrid($grid, $request, $params);

		$result = $this->getGridPaginationResult($grid, $request, $params);

		return response()->json([ 'status' => 'success', 'grid' => $result ]);

	}

	/**
	 *
	 * View the requested object
	 *
	 * @param  Request $request
	 *
	 * @return  \Illuminate\Http\JsonResponse
	 */
	public function view(Request $request) {

		$id = $request->get('id');

		$user = User::find($id)->load('roles');

		return response()->json([ 'status' => 'success', 'object' => $user ]);
	}

	/**
	 *
	 * Delete the requested object
	 *
	 * @param  Request $request
	 *
	 * @return  \Illuminate\Http\JsonResponse
	 */
	public function delete(Request $request) {

		$id = $request->get('id');

		$user = User::find($id);

		$current_id = auth()->user()->id;

		if( $user->id == $current_id){
			throw new BusinessException(trans('exception.self_delete'));
		}

		if(! is_null($user)){
			$user->delete();
		}

		return response()->json([ 'status' => 'success', 'id' => $id ]);
	}

	/**
	 *
	 * Delete the requested selected object
	 *
	 * @param  Request $request
	 *
	 * @return  \Illuminate\Http\JsonResponse
	 */
	public function deleteSelected(Request $request) {

		$ids = $request->get('ids');

		$current_id = auth()->user()->id;

		if( in_array($current_id, $ids) ){
			throw new BusinessException(trans('exception.self_delete'));
		}

		User::destroy($ids);

		return response()->json([ 'status' => 'success', 'ids' => $ids ]);
	}

	/**
	 *
	 * Create entry in database
	 *
	 * @param  Request $request
	 */
	public function create(Request $request) {

		$request->validate($this->getValidationRules($request, false), $this->getValidationMessages());

		$input = $request->all();

		$input['password'] = Hash::make($input['password']);

		$user = null;

		DB::transaction(function() use (&$user, $input) {
			$user = User::create($input);
			$user->syncRoles([ $input['role_id'] ]);
			$user->load('roles');
		});



		return response()->json([ 'status' => 'success', 'object' => $user ]);

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

		DB::transaction(function() use (&$user, $input) {
			$user->update($input);
			$user->syncRoles([ $input['role_id'] ]);
			$user->load('roles');
		});

		return response()->json([ 'status' => 'success', 'object' => $user ]);

	}

	public function roles(Request $request) {
		$roles = Role::all();
		return response()->json([ 'status' => 'success', 'objects' => $roles ]);
	}

	public function getValidationRules(Request $request, $edit = false) {
		$rules = [
			'name' => 'bail|required|max:255|alpha_dash|unique:users,name',
			'email' => 'bail|required|email|max:255|unique:users,email',
			'status' => 'bail|required',
			'password' => 'bail|required|confirmed',
			'password_confirmation' => 'bail|required',
			'role_id' => 'bail|required'

		];

		if($edit){
			$rules['name'] .= ','.$request->get('id');
			$rules['email'] .= ','.$request->get('id');
			$rules['password'] = 'confirmed';
			unset($rules['password_confirmation']);
		}

		return $rules;
	}

	public function getValidationMessages() {
		return [];
	}

}
