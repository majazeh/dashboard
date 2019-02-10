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
		dd(\Auth::user());
	}
}
?>