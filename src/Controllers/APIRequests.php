<?php
namespace Majazeh\Dashboard\Controllers;
use Illuminate\Http\Request;
use App\GuardPosition;
trait APIRequests
{
	public function index(Request $request)
	{
		$this->access_check('index', ...func_get_args());
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			$parent = $this->getParent()::findOrFail($parent);
			$this->response->put(strtolower($this->parent), $parent);
		}
		$list_name = strtolower(str_plural($this->table));
		$model = $this->index_query($request, $parent ?: null);
		if($request->q)
		{
			$this->fast_search($request, $model);
		}
		$this->response = $this->response->merge($this->paginate_order($request, $model, isset($this->ordering) ? $this->ordering : ['id']));
		return $this->response($this->response);
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
			$this->response->put(strtolower($this->parent), $this->getParent()::findOrFail($parent));
		}
		$table = $this->show_query($request, $id, $parent);
		$this->response->put('data', $table);
		return $this->response($this->response);
	}

	public function show_query($request, $id, $parent = null)
	{
		return $this->findOrFail($id);
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
			$this->response->put(strtolower($this->parent), $this->getParent()::findOrFail($parent));
		}
		$table = $this->show_query($request, $id, $parent);
		$table->delete();
		$this->response->put('message', $this->table . ' deleted');
		return $this->response($this->response);
	}

	public function store(Request $request)
	{
		$this->access_check('create', ...func_get_args());
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			$this->response->put(strtolower($this->parent), $this->getParent()::findOrFail($parent));
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
		$this->response->put('message', $this->table . " created successfully");
		$this->response->put('data', $create);
		return $this->response($this->response);
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
			$this->response->put(strtolower($this->parent), $this->getParent()::findOrFail($parent));
		}
		$table = $this->show_query($request, $id, $parent);
		$this->validator($request, $table)->validate();
		$this->validated($request, $table);
		$original_all = $table->toArray();
		foreach ($this->get_fields('inputs', $request, true) as $key => $value) {
			$table->$key = $value;
		}
		$table->save();
		$changed = $table->getChanges();
		$original = [];
		foreach ($changed as $key => $value) {
			$original[$key] = $original_all[$key];
		}
		$this->response->put('message', empty($changed) ? "Unchanged" : substr($table->getTable(), 0, -1) . " changed successfully");
		$this->response->put('old', empty($changed) ? null : $original);
		$this->response->put('changed', empty($changed) ? null : $changed);
		$this->response->put('data', $table);

		$response = $this->response_update($request, $table, $parent, $original_all);
		return $this->response($this->response);
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