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
			$parent = $this->findOrFail($parent, $this->parent);
			$parent_result = $parent;
			if (isset($this->parent_resource)) {
				$parent_result = new $this->parent_resource($parent_result);
			}
			$this->response->put(strtolower($this->parent), $parent_result);
		}
		$model = $this->index_query($request, $parent ?: null);
		if($request->q)
		{
			$this->fast_search($request, $model);
		}
		$list = $this->paginate_order($request, $model, isset($this->ordering) ? $this->ordering : ['id']);
		if (class_exists($this->resource_collection))
		{
			$list = new $this->resource_collection($list);
			$list->additional([
				'is_ok' => true,
				'message' => ':)',
				'message_text' => ':)',
			]);
			if($parent)
			{
				$list->additional([
					strtolower($this->parent) => $parent_result
				]);
			}
			return $list;
		}
		return $this->response($list);
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
			$parent = $this->findOrFail($parent, $this->parent);
			$parent_result = $parent;
			if (isset($this->parent_resource)) {
				$parent_result = new $this->parent_resource($parent_result);
			}
			$this->response->put(strtolower($this->parent), $parent_result);
		}

		$table = $this->show_query($request, $id, $parent);
		if (class_exists($this->resource)) {
			$table = new $this->resource($table);
		}
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
			$parent = $this->findOrFail($parent, $this->parent);
			$parent_result = $parent;
			if (isset($this->parent_resource)) {
				$parent_result = new $this->parent_resource($parent_result);
			}
			$this->response->put(strtolower($this->parent), $parent_result);
		}
		$table = $this->show_query($request, $id, $parent);
		$this->destroy_transaction($request, $table, $parent);
		$this->response->put('message', $this->table . ' deleted');
		return $this->response($this->response);
	}
	public function destroy_transaction($request, $row, &$parent = null)
	{
		return $row->delete();
	}

	public function store(Request $request)
	{
		$this->access_check('create', ...func_get_args());
		$parent = isset($this->parent) && isset(func_get_args()[1]) ? func_get_args()[1] : null;
		if($parent)
		{
			$parent = $this->findOrFail($parent, $this->parent);
			$parent_result = $parent;
			if(isset($this->parent_resource))
			{
				$parent_result = new $this->parent_resource($parent_result);
			}
			$this->response->put(strtolower($this->parent), $parent_result);
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
		// $create = $this->get_model()::create($data);
		$create = $this->store_transaction($request, $data, $parent);
		$this->response->put('message', $this->table . " created successfully");
		if (isset($this->resource)) {
			$create = new $this->resource($create);
		}
		$this->response->put('data', $create);
		return $this->response($this->response);
	}

	public function store_transaction($request, $data, &$parent = null){
		return $this->get_model()::create($data);
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
			$parent = $this->findOrFail($parent, $this->parent);
			$parent_result = $parent;
			if (isset($this->parent_resource)) {
				$parent_result = new $this->parent_resource($parent_result);
			}
			$this->response->put(strtolower($this->parent), $parent_result);
		}
		$row = $this->show_query($request, $id, $parent);
		$this->validator($request, $row, $parent)->validate();
		$this->validated($request, $row, $parent);
		$original_all = $row->toArray();
		foreach ($this->get_fields('inputs', $request, true) as $key => $value) {
			$row->$key = $value;
		}
		// $table->save();
		$this->update_transaction($request, $row, $parent);
		$changed = $row->getChanges();
		$original = [];
		foreach ($changed as $key => $value) {
			if(isset($original_all[$key]))
			{
				$original[$key] = $original_all[$key];
			}
			else
			{
				unset($changed[$key]);
			}
		}
		$this->response->put('message', empty($changed) ? "Unchanged" : substr($row->getTable(), 0, -1) . " changed successfully");
		$this->response->put('old', empty($changed) ? null : $original);
		$this->response->put('changed', empty($changed) ? null : $changed);
		if (isset($this->resource)) {
			$row = new $this->resource($row);
		}
		$this->response->put('data', $row);

		$response = $this->response_update($request, $row, $parent, $original_all);
		return $this->response($this->response);
	}

	public function update_transaction($request, &$row, &$parent = null){
		return $row->save();
	}

	public function response_update($request, $table, $parent, $original_all)
	{
		$changed = $table->getChanges();
		$original = [];
		foreach ($changed as $key => $value) {
			if (isset($original_all[$key])) {
				$original[$key] = $original_all[$key];
			}
			else
			{
				unset($changed[$key]);
			}
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