<?php
namespace Majazeh\Dashboard\Controllers\API;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthenticatesUsers, DispatchesJobs, ValidatesRequests,
    \Majazeh\Dashboard\Controllers\Response, \Majazeh\Dashboard\Controllers\Paginate;
	public $successStatus = 200;
	public $validator = [];

	public function __construct()
	{
		if(!isset($this->table))
		{
			preg_match("#\\\([^\\\]*[^s])s?Controller$#", get_class($this), $model_name);
			$this->table = $model_name[1];
		}
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
		$model = $model_name ? '\App\\' . (is_string($model_name) ? $model_name : $model_name->getModel()->getTable()) : $this->get_model();
		$model_name = $model_name ?: $this->table;
		if(is_null($id))
		{
			return $this->notFound($model_name . " not found");
		}
		if(is_string($id) || is_int($id))
		{
			if($model_name instanceof \Illuminate\Database\Eloquent\Builder)
			{
				return $model_name->find($id) ?: $this->notFound(substr($model_name->getModel()->getTable(), 0, -1) . " not found");
			}
			$table = $model::find($id);
			if(!$table)
			{
				return $this->notFound($model_name . " not found");
			}
			return $table;
		}
		if($id instanceof \Illuminate\Database\Eloquent\Builder)
		{
			return $id->first() ?: $this->notFound(substr($id->getModel()->getTable(), 0, -1) . " not found");
		}
		return $id;
	}

	public function index(Request $request)
	{
		return $this->response($this->get_model()::paginate());
	}

	public function show(Request $request, $id)
	{
		$table = $this->findOrFail($id);
		return $this->response("show successfully", $table);
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
		return $this->response($this->table . " created successfully", $create);
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
			'new' => $table
		]);
	}

	public function fields(Request $request, $update = false)
	{
		return $this->validator;
	}

	public function id($request)
	{
		if(\Auth::id())
		{
			return \Auth::id();
		}
		elseif($request->user('api'))
		{
			return $request->user('api')->id;
		}
		return null;
	}
}
?>