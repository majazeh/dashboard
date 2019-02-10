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
		'token' => 'string',
		'user_id' => null,
		'device' => 'in:android,web,ios',
		'service' => null,
	];
	public function __construct(Request $request)
	{
		if($request->header('Authorization'))
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
			'user_id' => \Auth::id()
		]);
		return parent::store($request);
	}

}
?>