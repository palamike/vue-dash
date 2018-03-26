<?php
/**
 * Project : aluminumz
 * User: palagornp
 * Date: 16/1/2018 AD
 * Time: 10:50
 */

namespace Palamike\VueDash\Http\Controllers\Modules;


use Illuminate\Support\Carbon;
use Palamike\VueDash\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ModuleController extends Controller {

	/**
	 *
	 * Process Grid where condition
	 *
	 * @param $grid Builder
	 * @param $request Request
	 * @param $params array
	 */
	public function processGridWhere(&$grid, $request, $params){
		if($request->has('search')){

			$search = $params['search'];

			if(array_key_exists('field',$search) && array_key_exists('value',$search)){
				$this->getWhereSwitchProcessor($grid, $search['field'],$search['value']);
			}

		}
	}

	/**
	 *
	 * Process the grid date range
	 *
	 * @param $grid Builder
	 * @param $field string field name
	 * @param $request Request the http request
	 * @param $params array input parameters
	 */
	public function processGridDateRange(&$grid, $field, $request, $params) {

		$start = new Carbon();
		$end = new Carbon();

		if( $request->has('search') && isset($params['search']['startDate']) && isset($params['search']['endDate']) ){

			try {
				$start = new Carbon($params['search']['startDate']);
			} catch (\Exception $e) {
				$start = (new Carbon())->subDays(intval(config('setting.general_query_date_range')));
			}

			try {
				$end = new Carbon($params['search']['endDate']);
			} catch (\Exception $e) {
				$end = new Carbon();
			}
		}

		$grid->where($field, '>=', $start->format('Y-m-d'))
		     ->where($field, '<=', $end->format('Y-m-d'));

	}

	/**
	 *
	 * get Grid Pagination Result
	 *
	 * @param $grid Builder
	 * @param $request Request
	 * @param $params array
	 */
	public function getGridPaginationResult(&$grid, $request, $params){

		if($request->has('pagination')){

			$pagination = $params['pagination'];

			if(is_int($pagination)){
				return $grid->paginate($pagination);
			}//if
			else{
				return $grid->paginate($this->getSettingPaginationNumber());
			}
		}
		else{

			return $grid->paginate($this->getSettingPaginationNumber());

		}
	}

	/**
	 *
	 * Sort Data by Order list and sort parameters
	 * The field name from frontend is only placeholder to retrieve order by field in backend.
	 *
	 * @param $grid Builder
	 * @param $request Request
	 * @param $params array
	 */
	public function sortGrid(&$grid, $request, $params) {
		if ($request->has('sort') && (count($params['sort']) > 0)) {
			$sorts = $params['sort'];
			$sortOrders = $this->getGridSortOrder();

			foreach($sortOrders as $key => $value) {
				if ( array_key_exists($key, $sorts) ){
					$this->performGridSort($grid, $value, $sorts[$key] == 'asc' ? 'ASC' : 'DESC' );
				}//if key exist
			}//foreach
		}//if
		else {
			$this->performGridDefaultSort($grid);
		}
	}//sortGrid

	/**
	 *
	 * Perform grid sorting for individual column
	 *
	 * @param $grid
	 * @param $column
	 * @param $order
	 */
	public function performGridSort(&$grid, $column, $order) {
		$grid->orderBy($column, $order );
	}

	/**
	 *
	 * get Pagination Number
	 *
	 * @return int
	 */
	public function getSettingPaginationNumber() {
		return intval( config('setting.general_list_pagination') );
	}

	/**
	 *
	 * Perform Default Sort Function can be override.
	 *
	 * @param $grid
	 */
	public function performGridDefaultSort(&$grid) {
		$grid->orderBy('id', 'DESC' );
	}

	/**
	 *
	 * Check if client has sent specific command.
	 *
	 * @param Request $request
	 * @param $command
	 *
	 * @return bool
	 */
	public function hasClientCommand(Request $request, $command){
		if($request->has('_command') && ( $request->get('_command') === $command ) ){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 *
	 * Create subitems of parent
	 *
	 * @param $parent object parent document item
	 * @param $relationship string relationship name
	 * @param $request Request input array extract from request
	 * @param $options array options
	 */
	public function createSubItems($parent, $relationship, Request $request, $options = []){

		$input = [];
		$input[$relationship] = $request->get($relationship);

		if(! (isset($input[$relationship]) && !empty($input[$relationship]) && (sizeof($input[$relationship]) > 0)) ){
			return;
		}//if

		$created_id = auth()->user()->id;
		$itemSize = count($input[$relationship]);
		for($i = 0; $i < $itemSize; $i++){
			$input[$relationship][$i]['created_id'] = $created_id;
		}

		$parent->{$relationship}()->createMany( $input[ $relationship]);
	}

	/**
	 *
	 * Update subitems of parent
	 *
	 * @param $parent object parent document item
	 * @param $relationship string relationship name
	 * @param $request Request input array extract from request
	 * @param $options array options
	 */
	public function updateSubItems($parent, $relationship, Request $request, $options = []) {

		$input = [];
		$input[$relationship] = $request->get($relationship);

		if(!isset($input[$relationship])){
			return;
		}//if

		$userId = auth()->user()->id;
		$itemSize = count($input[$relationship]);
		$className = config('vueDash.modelNamespace').'\\'.str_singular(studly_case($relationship));

		$input[$relationship.'_create'] = [];
		$input[$relationship.'_update'] = [];
		$updateIds = [];
		$input[$relationship.'_delete'] = [];

		for($i = 0; $i < $itemSize; $i++){
			if(  isset($input[$relationship][$i]['id']) && !is_null($input[$relationship][$i]['id']) ){
				//update
				$input[$relationship][$i]['updated_id'] = $userId;
				array_push($input[$relationship.'_update'], $input[$relationship][$i]);
				array_push($updateIds, $input[$relationship][$i]['id']);
			}
			else{
				//create
				$input[$relationship][$i]['created_id'] = $userId;
				array_push($input[$relationship.'_create'], $input[$relationship][$i]);
			}
		}

		$oldItems = $parent->{$relationship};
		foreach($oldItems as $old){
			if(!in_array(strval($old->id), $updateIds)){
				array_push($input[$relationship.'_delete'], $old->id);
			}
		}


		if(count($input[$relationship.'_create']) > 0) {
			$parent->{$relationship}()->createMany( $input[ $relationship . '_create']);
		}

		if(count($input[$relationship.'_update']) > 0){

			foreach($input[$relationship.'_update'] as $update){
				$id = $update['id'];
				call_user_func([$className, 'find'],$id)->update($update);
			}
		}

		if(count($input[$relationship.'_delete']) > 0){
			call_user_func([$className, 'whereIn'],'id', $input[$relationship.'_delete'])->delete();
		}
	}
}