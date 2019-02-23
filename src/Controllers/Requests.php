<?php
namespace Majazeh\Dashboard\Controllers;
use Illuminate\Http\Request;
use App\GuardPosition;
trait Requests
{
	public function index(Request $request)
	{
		$this->access_check('index', ...func_get_args());
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			$parent = $this->getParent()::findOrFail($parent);
			\Data::set(strtolower($this->parent), $parent);
		}
		$list_name = str_plural($this->table);
		$model = $this->index_query($request, $parent ?: null);
		if($request->q)
		{
			$this->fast_search($request, $model);
		}
		\Data::set($list_name, $this->paginate_order($request, $model, isset($this->ordering) ? $this->ordering : ['id']));
		return $this->view("{$this->resource}.index");
	}

	public function index_query($request, $parent = null)
	{
		return $this->get_model()::select('*');
	}

	public function show(Request $request, $id)
	{
		$this->access_check('show', ...func_get_args());
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
		$table = $this->show_query($request, $id, $parent);
		\Data::set(strtolower($this->table), $table);
		\Data::set("id", $table->id);
		return $this->view("{$this->resource}.show");
	}

	public function show_query($request, $id, $parent = null)
	{
		return $this->findOrFail($id);
	}

	public function create(Request $request)
	{
		$this->access_check('create', ...func_get_args());
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			\Data::set(strtolower($this->parent), $this->getParent()::findOrFail($parent));
		}
		return $this->view("{$this->resource}.create");
	}

	public function edit(Request $request, $id)
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
			\Data::set(strtolower($this->parent), $this->getParent()::findOrFail($parent));
		}
		$table = $this->show_query($request, $id, $parent);
		\Data::set(strtolower($this->table), $table);
		\Data::set("id", $table->id);
		\Data::set("action", 'edit');
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
		$table = $this->findOrFail($id);
		$table->delete();
		$response = $this->response_destroy($request, $table, $parent);
		return $this->response($response);
	}
	public function response_destroy($request, $id, $parent)
	{
		return [
			'message' => $this->table . ' deleted',
			'redirect' => route("{$this->resource}.index")
		];
	}

	public function store(Request $request)
	{
		$this->access_check('create', ...func_get_args());
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			$this->getParent()::findOrFail($parent);
		}
		$this->validator($request)->validate();
		$this->validated($request);
		$data = [];
		foreach ($this->get_fields('keys', $request) as $key => $value) {
			if($request->input($value))
			{
				$data[$value] = $request->input($value);
			}
		}
		$create = $this->get_model()::create($data);
		$response = $this->response_store($request, $create, $parent);
		return $this->response($response);
	}
	public function response_store($request, $create, $parent)
	{
		$return = [
			'message' => $this->table . " created successfully",
			'data' => $create,
			'redirect' => route("{$this->resource}.create")
		];

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
		$table = $this->findOrFail($id);
		$this->validator($request, $table)->validate();
		$this->validated($request, $table);
		$original_all = $table->toArray();
		foreach ($this->get_fields('inputs', $request, true) as $key => $value) {
			$table->$key = $value;
		}
		$table->save();
		$response = $this->response_update($request, $table, $parent, $original_all);
		return $this->response($response);
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