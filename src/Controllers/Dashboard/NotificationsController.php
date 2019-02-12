<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Majazeh\Dashboard\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Notification;


class NotificationsController extends Controller
{
	use \Majazeh\Dashboard\Controllers\Requests;
	public $resource = 'dashboard.notifications';

	public $validator = [
        'title'  => 'required|string|min:3|unique:guards'
	];

	public $ordering = [
		'id',
		'from' => 'from_id',
		'to' => 'to_id',
		'time' => 'created_at',
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
				return true;
				// return \Auth::guardio('notification.view|notification.create|guarnotificationdnotificationio.edit');
				break;
			case 'create' :
				return \Auth::guardio('notification.create|#broker');
				break;
			case 'edit' :
				return \Auth::guardio('notification.edit|notification.create|#broker');
				break;
			case 'delete' :
				return \Auth::guardio('notification.delete|#broker');
				break;

			case 'check' :
				return \Auth::guardio('notification.all|#broker') || $args[1]->from_id == \Auth::id() || $args[1]->to_id == \Auth::id();
				break;
		}
		return false;
	}

	public function fast_search($request, &$model)
	{
		$model->where('title', 'like', "%{$request->q}%");
	}
}
?>