<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Majazeh\Dashboard\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

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
        $users = User::paginate();
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
        $store = User::create($data);
    }

    public function edit(Request $request, User $user)
    {
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

    public function update(Request $request, User $user)
    {
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
        User::whereId($user->id)->update($data);
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

    public function validator(Request $request, User $user = null)
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
                $queryDuplicate = null;
                if($request->input('username'))
                {
                    $queryDuplicate = User::Where('username' , $request->input('username'));
                }
                if($request->input('email'))
                {
                    if($queryDuplicate)
                    {
                        $queryDuplicate->orWhere('email' , $request->input('email'));
                    }
                    else
                    {
                        $queryDuplicate = User::Where('email' , $request->input('email'));
                    }
                }
                if($request->input('mobile'))
                {
                    if($queryDuplicate)
                    {
                        $queryDuplicate->orWhere('mobile' , $request->input('mobile'));
                    }
                    else
                    {
                        $queryDuplicate = User::Where('mobile' , $request->input('mobile'));
                    }
                }
                $getDuplicate = $queryDuplicate->limit(3)->get();
                foreach ($getDuplicate as $key => $value) {
                    if($value->getAttribute('username') == $request->input('username'))
                    {
                        if(isset($user) && $user->username == $value->getAttribute('username')) continue;
                        $validator->errors()->add('username', 'username.duplicate');
                    }
                    if($value->getAttribute('email') == $request->input('email'))
                    {
                        if(isset($user) && $user->email == $value->getAttribute('email')) continue;
                        $validator->errors()->add('email', 'email.duplicate');
                    }
                    if($value->getAttribute('mobile') == $request->input('mobile'))
                    {
                        if(isset($user) && $user->mobile == $value->getAttribute('mobile')) continue;
                        $validator->errors()->add('mobile', 'mobile.duplicate');
                    }
                }
            }
        });
        return $validator;
    }
}
