<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Majazeh\Dashboard\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Notification;
use \Majazeh\Dashboard\Controllers\Requests;
use \App\FirebaseToken;

class NotificationsController extends Controller
{
	use Requests
	{
		Requests::store as request_store;
	}
	public $resource = 'dashboard.notifications';

	public $validator = [
				'title'  => 'required|string|min:3',
				'from_id'  => 'required',
				'to_id'  => 'required',
				'services'  => 'required',
				'content'  => 'required',
				'trigger'  => 'required',
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
				return \Auth::guardio('notifications.create');
				break;
			case 'edit' :
				return \Auth::guardio('notifications.edit|notifications.create');
				break;
			case 'delete' :
				return \Auth::guardio('notifications.delete');
				break;

			case 'check' :
				return \Auth::guardio('notifications.all') || $args[1]->from_id == \Auth::id() || $args[1]->to_id == \Auth::id();
				break;
		}
		return false;
	}

	public function store(Request $request)
	{
		$request->request->add(['from_id' => \Auth::id()]);
		$request->request->add(['trigger' => 'global']);
		$return = $this->request_store($request);
		if($request->services == 'google')
		{
			foreach (FirebaseToken::where('user_id', $request->to_id)->get() as $key => $value) {
					dispatch(new \Majazeh\Dashboard\Jobs\CloudMessage('https://fcm.googleapis.com/fcm/send', [
							"to" => $value->token,
							"notification" => [
								"title" => $request->title,
								"body" => $request->content,
								"priority" => "high",
								"content_available" => true,
								"sound" => "default",
								]
					]));
			}
		}
		return $return;
	}

	public function fast_search($request, &$model)
	{
		$model->where('title', 'like', "%{$request->q}%");
	}
}
?>