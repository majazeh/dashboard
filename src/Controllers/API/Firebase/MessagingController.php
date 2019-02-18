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
		$request->request->add([
			'service' => 'cloud_messaging',
			'user_id' => \Auth::id(),
			'device' => $request->header('client') ?: 'anonymous',
		]);
		return parent::store($request);
	}

}
?>