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

    /**
     * Show all users
     */
    public function index(Request $request)
    {
        \Data::set('user_status_css', $this->user_status_css());
        \Data::set('userTypes', $this->user_types());
        \Data::set('userStatus', $this->user_status());
        $users = config('auth.providers.users.model')::select('*');
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

        $users = $this->paginate_order($request, $users, ['id', 'name', 'username', 'status', 'type', 'gender']);
        \Data::set('users', $users);
        return $this->view('dashboard.users.index');
    }

    /**
     * Show user creation form
     */
    public function create(Request $request)
    {
        if(\Auth::user()->type != 'admin')
        {
            return abort(404);
        }
        \Data::set('userTypes', $this->user_types());
        \Data::set('userStatus', $this->user_status());
        return $this->view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        if(\Auth::user()->type != 'admin')
        {
            return abort(404);
        }
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
        $user = config('auth.providers.users.model')::findOrfail($user);
        if(\Auth::user()->type != 'admin' && \Auth::id() != $user->id)
        {
            return abort(404);
        }
        \Data::set('user', $user);
        \Data::set('id', $user->id);
        \Data::set('userTypes', $this->user_types());
        \Data::set('userStatus', $this->user_status());
        return $this->view('dashboard.users.create');
    }

    // public function show(Request $request, User $user)
    // {
    //     return $this->view('dashboard.users.show');
    // }

    public function update(Request $request, $user)
    {
        $user = config('auth.providers.users.model')::findOrfail($user);
        if(\Auth::user()->type != 'admin' && \Auth::id() != $user->id)
        {
            return abort(404);
        }
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
                'redirect' => route(\Data::getModule('resource').'.index')
            ]);
        }
        return redirect(route(\Data::getModule('resource').'.edit', $user->id));
    }


    public function user_types(){
        return [
            'admin' => _d('type.admin'),
            'guest' => _d('type.guest'),
            'user' => _d('type.user')
        ];
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
