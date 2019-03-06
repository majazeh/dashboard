<?php
namespace Majazeh\Dashboard\Controllers\API\Firebase;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Majazeh\Dashboard\Controllers\API\Controller;

use \App\FirebaseToken;

class MessagingController extends Controller{
	public $table = 'FirebaseToken';
	public $validator = [
		'token' => 'required|string',
		'user_id' => null,
		'device' => 'required|in:web,ios,android,anonymous',
		'service' => null,
	];
	public function __construct(Request $request)
	{
		if($request->header('authorization'))
		{
			$this->middleware('auth:api');
		}
		parent::__construct();
	}
	public function index(Request $request)
	{

	}

	public function store(Request $request)
	{
		$duplicate = FirebaseToken::where('token', $request->token)->count();
		if($duplicate)
		{
			$this->destroy($request, $request->token);
		}
		$request->token;
		$request->request->add([
			'service' => 'cloud_messaging',
			'user_id' => \Auth::id(),
			'device' => $request->header('client') ?: 'anonymous',
		]);
		$return = '';
		try {
			$return = parent::store($request);
            dispatch(new \Majazeh\Dashboard\Jobs\CloudMessage('https://iid.googleapis.com/iid/v1:batchAdd', [
				"to" => "/topics/global",
				"registration_tokens" => [$request->token]
			]));
		} catch (\Throwable $th) {
		}
		return $return;
	}

	public function update(Request $request, $token)
	{

	}

	public function show(Request $request, $token)
	{

	}

	public function destroy(Request $request, $token)
	{
		$token = FirebaseToken::where('token', $token);
		$token->delete();
		return $this->response($this->table . " deleted");
	}

}
?>