<?php
namespace Majazeh\Dashboard\Controllers\API;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class Controller {
	use AuthenticatesUsers;
	use DispatchesJobs;
	use ValidatesRequests;
	public $successStatus = 200;

	public function __construct()
	{
		if(!isset($this->table))
		{
			preg_match("#\\\([^\\\]*[^s])s?Controller$#", get_class($this), $model_name);
			$this->table = $model_name[1];
		}
	}

	public function response($result, $data = [], $code = 200)
	{
		$response = ['is_ok' => true, 'message' => ':)'];
		$result = is_object($result) ? $result->toArray() : $result;
		$response = is_array($result) ? array_merge($response, $result) : array_merge($response, ['message' => $result]);
		if(is_object($result))
		{
			$response = array_merge($response, $result->toArray());
		}
		if(!empty($data))
		{
			$response['data'] = $data;
		}
		$response['message'] = str_replace(" ", "_", strtoupper($response['message']));
		if($code != 200)
		{
			$response['is_ok'] = false;
		}
		return response()->json($response, $code);
	}

	public function get_model()
	{
		return "\App\\" . $this->table;
	}

	public function get_fields($type, $request = null, $update = false)
	{
		switch ($type) {
			case 'keys':
			return array_keys($this->fields($request));
			break;
			case 'inputs':
			$inputs = [];
			foreach ($this->fields($request, $update) as $key => $value) {
				if($value && $request->has($key))
				{
					$inputs[$key] = $request->input($key);
				}
			}
			return $inputs;
			break;
			case 'validate':
			$inputs = [];
			foreach ($this->fields($request, $update) as $key => $value) {
				if($value)
				{
					$inputs[$key] = $value;
				}
			}
			return $inputs;
			break;
		}
	}

	public function validator(Request $request, $update = false)
	{
		return $this->getValidationFactory()->make($this->get_fields('inputs', $request, $update), $this->get_fields('validate', $request, $update));
	}

	public function notFound($title = null)
	{
		throw new \Majazeh\Dashboard\MajazehJsonException($this->response($title ?: $this->table . " not found", null, 404));
	}

	public function findOrFail($id, $model_name = null)
	{
		$model = $model_name ? '\App\\' . $model_name : $this->get_model();
		$model_name = $model_name ?: $this->table;
		if(is_null($id))
		{
			return $this->notFound($model_name . " not found");
		}
		if(is_string($id) || is_int($id))
		{
			$table = $model::find($id);
			if(!$table)
			{
				return $this->notFound($model_name . " not found");
			}
			return $table;
		}
		return $id;
	}

	public function index(Request $request)
	{
		return $this->response($this->get_model()::paginate());
	}

	public function paginate_order(Request $request, $model, $order_list = ['id'])
	{
		$keys = array_keys($order_list);
		$order = $request->input('order') && in_array($request->input('order'), $keys) ? strtolower($request->input('order')) : 'id';
		if(isset($order_list[$order]))
		{
			$order = $order_list[$order];
		}
		$sort = strtolower($request->input('sort')) == 'desc' ? 'desc' : 'asc';
		if($order != 'id' || $sort != 'asc')
		{
			$model->orderBy($order, $sort);
			$paginate = $model->paginate();
	        $paginate->appends($request->all('order', 'sort'));
			return $paginate;
		}
		else
		{
			return $model->paginate();
		}

	}

	public function show(Request $request, $id)
	{
		$table = $this->findOrFail($id);
		return $this->response("show successfully", $table->toArray());
	}


	public function destroy(Request $request, $id)
	{
		$table = $this->findOrFail($id);
		$table->delete();
		return $this->response($this->table . " deleted");
	}

	public function validated(Request $request, $id = null){}

	public function store(Request $request)
	{
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
		return $this->response($this->table . " created successfully", $create->toArray());
	}

	public function update(Request $request, $id)
	{
		$table = $this->findOrFail($id);
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
		return $this->response(empty($changed) ? "Unchanged" : substr($table->getTable(), 0, -1) . " changed successfully", [
			'old' => empty($changed) ? null : $original,
			'changed' => empty($changed) ? null : $changed,
			'new' => $table->toArray()
		]);
	}
}
?>