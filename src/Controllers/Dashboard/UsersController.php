<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Majazeh\Dashboard\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $icon = [
        'index' => 'fas fa-users',
        'create' => 'fas fa-user-plus',
        'edit' => 'fas fa-user-edit',
        'show' => 'fas fa-user-circle'
    ];

    public $validator = [
        'email'  => 'nullable|email',
        'mobile' => 'nullable|digits_between:5,15',
        'username' => 'nullable|string|min:5|regex:/^[a-zA-Z]+[\-_a-zA-Z0-9]{4,}$/',
        'password' => 'nullable|string|min:6',
        'gender' => 'in:male,female',
    ];

    public $templates = [
        'index' => 'dashboard.users.index',
        'show' => 'dashboard.users.create',
        'create' => 'dashboard.users.create',
        'edit' => 'dashboard.users.create',
    ];

    public function access($method, $request, ...$args)
    {
        switch ($method) {
			case 'index':
			case 'show' :
				return \Auth::guardio('user.view|user.create|user.edit');
				break;
            case 'create' :
                if(!\Auth::guardio('user.create'))
                {
                    return false;
                }
                if(in_array($request->type, config('guardio.admins', ['admin', 'supervisor'])) && (!\Auth::guardio('change.type.all') || !\Auth::guardio('change.type.nadmin')))
                {
                    return false;
                }
                return true;
				break;
            case 'edit' :
				return \Auth::guardio('user.edit|user.create') || \Auth::id() == $args[0];
				break;
			case 'delete' :
				return \Auth::guardio('user.delete');
				break;
		}
		return false;
    }

    /**
     * Show all users
     */
    public function index(Request $request)
    {
        $this->access_check('index', ...func_get_args());
        \Data::set('user_status_css', $this->user_status_css());
        \Data::set('userTypes', $this->user_types());
        \Data::set('userStatus', $this->user_status());
        $users = $this->index_query($request);
        if(in_array($request->status, array_keys($this->user_status())))
        {
            $users->where('status', $request->status);
        }

        if(in_array($request->type, array_keys($this->user_types())))
        {
            $users->where('type', $request->type);
        }

        if(in_array($request->gender, ['male', 'female']))
        {
            $users->where('gender', $request->gender);
        }

        if($request->q)
        {
			$this->fast_search($request, $users);
        }


        $users = $this->paginate_order($request, $users, ['id', 'name', 'username', 'status', 'type', 'gender']);
        $users->appends($request->all('status', 'type'));
        \Data::set('users', $users);
        return $this->view($this->templates['index']);
    }

    public function fast_search($request, &$model)
    {
        $model->where(function($query) use ($request){
            $query->where('username', 'like', "%{$request->q}%")
            ->orWhere('name', 'like', "%{$request->q}%")
            ->orWhere('email', 'like', "%{$request->q}%");
        });
    }

    public function index_query($request, $parent = null)
	{
        return config('auth.providers.users.model')::select('*');
	}

    /**
     * Show user creation form
     */
    public function create(Request $request)
    {
        $this->access_check('create', ...func_get_args());
        \Data::set('userTypes', $this->user_types());
        \Data::set('userStatus', $this->user_status());
        return $this->view($this->templates['create']);
    }

    public function store(Request $request)
    {
        $this->access_check('create', ...func_get_args());
        $this->validator($request)->validate();
        $data = $request->all();
        $data['password'] = Hash::make($request['password']);
        $store = config('auth.providers.users.model')::create($data);
        if($request->ajax())
        {
            return response()->json([
                'is_ok'    => true,
                'message'  => __('USER_CREATED_SUCCESSFULLY'),
                'redirect' => route('users.index')
            ]);
        }
    }

    public function edit(Request $request, $user)
    {
        $this->access_check('edit', ...func_get_args());
        $user = config('auth.providers.users.model')::findOrfail($user);
        \Data::set('user', $user);
        \Data::set('id', $user->serial);
        \Data::set('userTypes', $this->user_types());
        \Data::set('userStatus', $this->user_status());
        return $this->view($this->templates['create']);
    }

    // public function show(Request $request, User $user)
    // {
    //     return $this->view('dashboard.users.show');
    // }

    public function update(Request $request, $user)
    {
        $this->access_check('edit', ...func_get_args());
        $user = config('auth.providers.users.model')::findOrfail($user);
        $this->validator($request, $user)->validate();
        $data = $request->all();
        if (\Auth::user()->type != 'admin') {
            if(isset($data['type']))
            {
                unset($data['type']);
            }
            if(isset($data['status']))
            {
                unset($data['status']);
            }
        }
        unset($data['_token']);
        unset($data['_method']);
        if(!empty($data['password']))
        {
            $data['password'] = Hash::make($request['password']);
        }
        else
        {
            unset($data['password']);
        }
        $user->update($data);
        if($request->ajax())
        {
            return response()->json([
                'is_ok' => true,
                'message' => __('USER_CHANGED_SUCCESSFULLY'),
                'redirect' => route(\Data::getModule('resource').'.index'),
                'direct' => true
            ]);
        }
        return redirect(route(\Data::getModule('resource').'.edit', $user->id));
    }


    public function user_types(){
        $type =  config('guardio.types', [
            'admin' => 'type.admin',
            'guest' => 'type.guest',
            'user' => 'type.user'
        ]);
        foreach ($type as $key => $value) {
            $type[$key] = _d($value);
        }
        return $type;
    }

    public function user_status(){
        return [
            'waiting' => _d('status.waiting'),
            'block' => _d('status.block'),
            'active' => _d('status.active')
        ];
    }

    public function user_status_css(){
        return [
            'waiting' => 'text-warning',
            'block' => 'text-danger',
            'active' => 'text-success'
        ];
    }

    public function validator(Request $request, $user = null)
    {
        if(!isset($this->validator['type']))
        {
            $this->validator['type'] = 'in:' . join(',', array_keys($this->user_types()));
        }

        if(!isset($this->validator['status']))
        {
            $this->validator['status'] = 'in:' . join(',', array_keys($this->user_status()));
        }

        $validator = Validator::make($request->all(), $this->validator);
        $validator->after(function ($validator) use ($request, $user){
            if(!$request->input('username') && !$request->input('email') && !$request->input('mobile'))
            {
                $validator->errors()->add('email', 'enter.username.method');
            }else{
                $limit = 0;
                $queryDuplicate = null;
                if($request->input('username'))
                {
                    $limit++;
                    $queryDuplicate = config('auth.providers.users.model')::Where('username' , $request->input('username'));
                }
                if($request->input('email'))
                {
                    $limit++;
                    if($queryDuplicate)
                    {
                        $queryDuplicate->orWhere('email' , $request->input('email'));
                    }
                    else
                    {
                        $queryDuplicate = config('auth.providers.users.model')::Where('email' , $request->input('email'));
                    }
                }
                if($request->input('mobile'))
                {
                    $limit++;
                    if($queryDuplicate)
                    {
                        $queryDuplicate->orWhere('mobile' , $request->input('mobile'));
                    }
                    else
                    {
                        $queryDuplicate = config('auth.providers.users.model')::Where('mobile' , $request->input('mobile'));
                    }
                }
                $getDuplicate = $queryDuplicate->limit($limit)->get();
                foreach ($getDuplicate as $key => $value) {
                    if(isset($user) && $user->id == $value->id) continue;
                    if($value->username == $request->input('username'))
                    {
                        $validator->errors()->add('username', 'username.duplicate');
                    }
                    if($value->email == $request->input('email'))
                    {
                        $validator->errors()->add('email', 'email.duplicate');
                    }
                    if($value->mobile == $request->input('mobile'))
                    {
                        $validator->errors()->add('mobile', 'mobile.duplicate');
                    }
                }
            }
        });
        return $validator;
    }
}
