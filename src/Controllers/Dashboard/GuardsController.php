<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Majazeh\Dashboard\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Guard;


class GuardsController extends Controller
{
	use \Majazeh\Dashboard\Controllers\Requests;
	public $resource = 'dashboard.guards';

	public $validator = [
        'title'  => 'required|string|min:3|unique:guards'
    ];

	public function __construct(Request $request)
    {
		parent::__construct($request);
	}

	public function access($method, $request, ...$args)
	{
		switch ($method) {
			case 'index':
			case 'show' :
				return \Auth::guardio('guardio.view|guardio.create|guardio.edit');
				break;
			case 'create' :
				return \Auth::guardio('guardio.create');
				break;
			case 'edit' :
				return \Auth::guardio('guardio.edit|guardio.create');
				break;
			case 'delete' :
				return \Auth::guardio('guardio.delete');
				break;
		}
		return false;
	}

	public function fast_search($request, &$model)
	{
		$model->where('title', 'like', "%{$request->q}%");
	}
	public function show(Request $request, $id)
	{
		return redirect()->route('dashboard.guards.positions.index', $id);
	}
}
?>