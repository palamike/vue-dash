<?php
/**
 * Project : aluminumz
 * User: palagornp
 * Date: 16/1/2018 AD
 * Time: 10:50
 */

namespace Palamike\VueDash\Http\Controllers\Modules;


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

}