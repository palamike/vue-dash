

namespace App\Http\Controllers\Modules\{{$parentPlural}};

use Palamike\VueDash\Exceptions\ObjectNotFoundException;
use Palamike\VueDash\Http\Controllers\Modules\ModuleController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\{{$moduleSingular}};

class {{$moduleSingular}}Controller extends ModuleController
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
		return view('modules.{{$parentPluralSnake}}.{{$modulePluralSnake}}', [ 'menu' => '{{$modulePluralSnake}}' ]);
	}

	/**
	 *
	 * Grid Control Function
	 *
	 * @param Request $request
	 */
	public function grid(Request $request){

		$grid = {{$moduleSingular}}::query();

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

		${{$moduleSingularLower}} = {{$moduleSingular}}::find($id);

		return response()->json([ 'status' => 'success', 'object' => ${{$moduleSingularLower}} ]);
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

		${{$moduleSingularLower}} = {{$moduleSingular}}::find($id);

		if(! is_null(${{$moduleSingularLower}})){
			${{$moduleSingularLower}}->delete();
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

		{{$moduleSingular}}::destroy($ids);

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

		$input['created_id'] = auth()->user()->id;

		${{$moduleSingularLower}} = {{$moduleSingular}}::create($input);

		return response()->json([ 'status' => 'success', 'object' => ${{$moduleSingularLower}} ]);

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

		${{$moduleSingularLower}} = {{$moduleSingular}}::find($input['id']);

		if (is_null(${{$moduleSingularLower}})) {
			throw new ObjectNotFoundException();
		}

		$input['updated_id'] = auth()->user()->id;

		${{$moduleSingularLower}}->update($input);

		return response()->json([ 'status' => 'success', 'object' => ${{$moduleSingularLower}} ]);

	}

	public function getValidationRules(Request $request, $edit = false) {
		$rules = [
			'name' => 'bail|required|max:255|unique:{{$modulePluralSnake}},name',
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
