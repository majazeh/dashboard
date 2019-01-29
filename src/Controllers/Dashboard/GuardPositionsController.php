<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Majazeh\Dashboard\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Guard;
use App\GuardPosition;

class GuardPositionsController extends Controller
{
	use \Majazeh\Dashboard\Controllers\Requests;
	public $parent = 'Guard';
	public $resource = 'dashboard.guards.positions';
	public $validator = [
		'guard_id' => 'required|integer',
		'guard' => 'required|string',
		'position' => 'required|string',
	];


	public function __construct(Request $request)
    {
		parent::__construct($request);
	}


	public function access($method, $request, ...$args)
	{
		switch ($method) {
			case 'edit' :
			case 'delete' :
			case 'create':
				return \Auth::guardio('guardio.create|guardio.edit');
				break;
			case 'index':
			case 'show' :
				return \Auth::guardio('guardio.view|guardio.create|guardio.edit');
				break;
		}
		return false;
	}


	public function index(Request $request)
	{
		$guard = Guard::findOrFail(func_get_arg(1));
		$guardpositions = GuardPosition::where('guard_id', func_get_arg(1))->get();
		$positions = [];


		foreach (config('guardio.positions') as $key => $value) {
			$list = [];
			$this->arrayToConfString($value, $list, $key);
			$keys = array_fill_keys($list, null);
			foreach ($keys as $k => $v) {
				if($request->q)
				{
					if(!strpos($k, $request->q))
					{
						unset($keys[$k]);
						continue;
					}
				}
				if($guardpositions->where('position', $k)->first())
				{
					$keys[$k] = $guardpositions->where('position', $k)->first();
				}
			}
			if(!empty($keys))
			{
				$positions[$key] = $keys;
			}
		}
		\Data::set('guard', $guard);
		\Data::set('positions', $positions);
		return $this->view('dashboard.guards.positions.index');
	}

	public function arrayToConfString($arr, &$new_arr, $prefix)
	{
		return $this->_arrayToConfString($arr, [], $new_arr, $prefix);
	}
	public function _arrayToConfString($arr, $pointer, &$new_arr, $prefix)
	{
		foreach ($arr as $key => $value) {
			if(!is_array($value))
			{
				$new_key = $pointer;
				array_push($new_key, ctype_digit($key) || is_integer($key) ? $value : $key);
				array_push($new_arr, $prefix . '.' .join('.', $new_key));
			}
			else {
				$new_key = $pointer;
				array_push($new_key, $key);
				$this->_arrayToConfString($value, $new_key, $new_arr, $prefix);
			}
		}
	}

	public function update(Request $request)
	{
		$this->access_check('edit', ...func_get_args());
		$guard = $this->findOrFail(func_get_arg(1), 'Guard');
		$position = func_get_arg(2);
		$elo = GuardPosition::where('position', $position)->first();
		if($request->status && !$elo)
		{
			$request->request->add([
				'guard_id' => $guard->id,
				'guard'    => $guard->title,
				'position' => $position,
			]);
			return $this->store($request);

		}
		elseif(!$request->status)
		{
			return $this->destroy($request, $elo);
		}
	}
}
?>