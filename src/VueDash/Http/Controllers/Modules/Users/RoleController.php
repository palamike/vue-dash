<?php

namespace Palamike\VueDash\Http\Controllers\Modules\Users;

use Palamike\VueDash\Exceptions\BusinessException;
use Palamike\VueDash\Exceptions\ObjectNotFoundException;
use Palamike\VueDash\Http\Controllers\Modules\ModuleController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends ModuleController
{

	public function getGridSortOrder(){
		return [ 'id' => 'id', 'name' => 'name', 'description' => 'description' ];
	}

	/**
	 *
	 * Process Grid where Switch
	 *
	 * @param $grid Builder
	 * @param $field
	 * @param $value
	 */
	public function getWhereSwitchProcessor(&$grid, $field, $value) {

		switch($field) {
			case 'id': $grid->where('id', '=', $value); break;
			case 'name': $grid->where('name', 'like', "%{$value}%"); break;
			case 'description': $grid->where('description', 'like', "%{$value}%"); break;
		}

	}

	/**
	 *
	 * Module Main Page
	 *
	 */
    public function index(){
    	    return view('vueDash::modules.users.roles', [ 'menu' => 'roles' ]);
    }

	/**
	 *
	 * Grid Control Function
	 *
	 * @param Request $request
	 */
    public function grid(Request $request){

        $grid = Role::query();

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
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function view(Request $request) {

		$id = $request->get('id');

		$role = Role::find($id)->load('permissions');

		return response()->json([ 'status' => 'success', 'object' => $role ]);
	}

	/**
	 *
	 * Delete the requested object
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(Request $request) {

    	$id = $request->get('id');

    	$role = Role::find($id);

		$current_role = auth()->user()->roles()->first();

		if( $role->id == $current_role->id ){
			throw new BusinessException(trans('vueDash::exception.self_delete'));
		}

    	if(! is_null($role)){
		    $role->delete();
	    }

	    return response()->json([ 'status' => 'success', 'id' => $id ]);
	}

	/**
	 *
	 * Delete the requested selected object
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteSelected(Request $request) {

		$ids = $request->get('ids');

		$current_role = auth()->user()->roles()->first();

		if( in_array($current_role->id, $ids)  ){
			throw new BusinessException(trans('vueDash::exception.self_delete'));
		}

		Role::destroy($ids);

		return response()->json([ 'status' => 'success', 'ids' => $ids ]);
	}

	/**
	 *
	 * Create entry in database
	 *
	 * @param Request $request
	 */
	public function create(Request $request) {

		$request->validate($this->getValidationRules($request, false), $this->getValidationMessages());

		$input = $request->all();

		$role = null;

		DB::transaction(function () use (&$role, $input) {

			$permissionList = $input['permissionList'];
			unset($input['permissionList']);
			unset($input['permissions']);

			$role = Role::create($input);
			$role->syncPermissions($permissionList);
		});

		$role->load('permissions');

		return response()->json([ 'status' => 'success', 'object' => $role ]);

	}

	/**
	 *
	 * Update entry in database
	 *
	 * @param Request $request
	 */
	public function update(Request $request) {

		$request->validate($this->getValidationRules($request,true), $this->getValidationMessages());

		$input = $request->all();

		$role = Role::find($input['id']);

		if (is_null($role)) {
			throw new ObjectNotFoundException();
		}

		DB::transaction(function () use (&$role, $input) {

			$permissionList = $input['permissionList'];
			unset($input['permissionList']);
			unset($input['permissions']);

			$role->update($input);
			$role->syncPermissions($permissionList);

		});

		$role->load('permissions');

		return response()->json([ 'status' => 'success', 'object' => $role ]);

	}

	public function permissions() {

		$permissions = Permission::all();

		return response()->json([ 'status' => 'success', 'objects' => $permissions ]);

	}

	public function getValidationRules(Request $request, $edit = false) {
		$rules = [
			'name' => 'bail|required|max:255|unique:roles,name',
			'redirect' => 'bail|required|max:255',
			'description' => 'string'
		];

		if($edit){
			$rules['name'] .= ','.$request->get('id');
		}

		return $rules;
	}

	public function getValidationMessages() {
		return [];
	}

}
