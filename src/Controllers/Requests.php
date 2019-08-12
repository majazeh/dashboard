<?php
namespace Majazeh\Dashboard\Controllers;
use Illuminate\Http\Request;
use App\GuardPosition;
trait Requests
{
	public function index(Request $request)
	{
		$this->access_check('index', ...func_get_args());
		$args = func_get_args();
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			$parent = $this->getParent()::findOrFail($parent);
			\Data::set(strtolower($this->parent), $parent);
		}
		$list_name = strtolower(str_plural($this->table));
		$model = $this->index_query($request, $parent ?: null);
		if($request->q)
		{
			$this->fast_search($request, $model);
		}
		\Data::set($list_name, $this->paginate_order($request, $model, isset($this->ordering) ? $this->ordering : ['id']));
		return $this->index_view($request, $parent, array_splice($args, 2));
	}

	public function index_query($request, $parent = null)
	{
		return $this->get_model()::select('*');
	}

	public function index_view(Request $request)
	{
		return $this->view("{$this->resource}.index");
	}

	public function show(Request $request, $id)
	{
		$this->access_check('show', ...func_get_args());
		$args = func_get_args();
		$parent = null;
		if(isset($this->parent) && isset(func_get_args()[2]))
		{
			$parent = $id;
			$id = func_get_args()[2];
		}
		if($parent)
		{
			\Data::set(strtolower($this->parent), $this->getParent()::findOrFail($parent));
		}
		$table = $this->show_query($request, $id, $parent, ...array_splice($args, 3));
		\Data::set(strtolower($this->table), $table);
		\Data::set("id", $table->id);
		return $this->show_view($request, $id, $parent, ...array_splice($args, 3));
	}

	public function show_query($request, $id, $parent = null)
	{
		return $this->findOrFail($id);
	}

	public function show_view(Request $request)
	{
		return $this->view("{$this->resource}.show");
	}

	public function create(Request $request)
	{
		$this->access_check('create', ...func_get_args());
		$args = func_get_args();
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			$parent = $this->getParent()::findOrFail($parent);
			\Data::set(strtolower($this->parent), $parent);
		}
		return $this->create_view($request, $parent, ...array_splice($args, 2));
	}

	public function create_view(Request $request)
	{
		return $this->view("{$this->resource}.create");
	}

	public function edit(Request $request, $id)
	{
		$this->access_check('edit', ...func_get_args());
		$args = func_get_args();
		$parent = null;
		if(isset($this->parent) && isset(func_get_args()[2]))
		{
			$parent = $id;
			$id = func_get_args()[2];
		}
		if($parent)
		{
			\Data::set(strtolower($this->parent), $this->getParent()::findOrFail($parent));
		}
		$table = $this->show_query($request, $id, $parent, ...array_splice($args, 3));
		\Data::set(strtolower($this->table), $table);
		\Data::set("id", $table->id);
		\Data::set("action", 'edit');
		return $this->edit_view($request, $id, $parent, ...array_splice($args, 3));
	}

	public function edit_view(Request $request)
	{
		return $this->view("{$this->resource}.create");
	}


	public function destroy(Request $request, $id)
	{
		$this->access_check('delete', ...func_get_args());
		$parent = null;
		if(isset($this->parent) && isset(func_get_args()[2]))
		{
			$parent = $id;
			$id = func_get_args()[2];
		}
		if($parent)
		{
			$this->getParent()::findOrFail($parent);
		}
		$table = $this->show_query($request, $id, $parent);
		$table->delete();
		$response = $this->response_destroy($request, $table, $parent);
		return $this->response($response);
	}
	public function response_destroy($request, $id, $parent)
	{
		$return = [
			'message' => $this->table . ' deleted',
		];
		$route = ["{$this->resource}.index"];
		if($parent)
		{
			$route[] = $parent;
		}
		if(\Route::has(...$route))
		{
			try{
				$return['redirect'] = route(...$route);
			}
			catch(\Exception $e)
			{

			}
		}
		return $return;
	}

	public function store(Request $request)
	{
		$this->access_check('create', ...func_get_args());
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			$parent = $this->getParent()::findOrFail($parent);
		}
		$this->validator($request, false, $parent)->validate();
        $this->validated($request, false, $parent);
		$data = [];
		foreach ($this->get_fields('keys', $request) as $key => $value) {
			if($request->input($value))
			{
				$data[$value] = $request->input($value);
			}
		}
		$create = $this->store_transaction($request, $data, $parent);
		$response = $this->response_store($request, $create, $parent);
		return $this->response($response);
	}

	public function store_transaction($request, $data, &$parent = null){
		return $this->get_model()::create($data);
	}
	public function response_store($request, $create, $parent)
	{
		$return = [
			'message' => $this->table . " created successfully",
			'data' => $create
		];

		if(\Route::has($this->resource . '.create'))
		{
			$return['redirect'] = route($this->resource . '.create');
		}

		if(\Route::has($this->resource . '.show'))
		{
			$return['redirect'] = route($this->resource . '.show', [$parent ? $parent : $create->id, $parent ? $create->id : null]);
		}
		return $return;
	}

	public function update(Request $request, $id)
	{
		$this->access_check('edit', ...func_get_args());
		$parent = null;
		if(isset($this->parent) && isset(func_get_args()[2]))
		{
			$parent = $id;
			$id = func_get_args()[2];
		}
		if($parent)
		{
			$this->getParent()::findOrFail($parent);
		}
		$row = $this->show_query($request, $id, $parent);
		$this->validator($request, $row, $parent)->validate();
        $this->validated($request, $row, $parent);
		$original_all = $row->toArray();
		foreach ($this->get_fields('inputs', $request, true) as $key => $value) {
			$row->$key = $value;
		}
		$this->update_transaction($request, $row, $parent);
		$response = $this->response_update($request, $row, $parent, $original_all);
		return $this->response($response);
	}
	public function update_transaction($request, &$row, &$parent = null){
		return $row->save();
	}
	public function response_update($request, $table, $parent, $original_all)
	{
		$changed = $table->getChanges();
		$original = [];
		foreach ($changed as $key => $value) {
			$original[$key] = $original_all[$key];
		}
		$return = [
			'message' => empty($changed) ? "Unchanged" : substr($table->getTable(), 0, -1) . " changed successfully",
			'old' => empty($changed) ? null : $original,
			'changed' => empty($changed) ? null : $changed,
			'data' => $table
		];
		return $return;
	}
}
?>