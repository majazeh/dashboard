<?php

namespace Majazeh\Dashboard\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,
    Response, Paginate, Validator, Extensions;

    public $icon = [
        'index' => 'fas fa-list-alt',
        'create' => 'fas fa-plus-square',
        'edit' => 'fas fa-edit',
        'show' => 'fas fa-atom'
    ];
    public function __construct(Request $request)
    {
        if(in_array('auth', \Route::current()->middleware()))
		{
			$this->middleware(function ($request, $next) {
				if($request->session()->get('dev'))
				{
					\Config::set('database.connections.mysql.database', config('database.connections.test.database'));
					\Config::set('database.connections.mysql.username', config('database.connections.test.username'));
					\Config::set('database.connections.mysql.password', config('database.connections.test.password'));
        			\DB::reconnect('mysql');
				}
				return $next($request);
			});
		}
        if(!\Route::getCurrentRoute()) return;
        if(!isset($this->table))
		{
			preg_match("#\\\([^\\\]*[^s])s?Controller$#", get_class($this), $model_name);
			$this->table = $model_name[1];
		}
        $this->resource = isset($this->resource) ? $this->resource : $request->segment(2);
        \Data::setModule('resource', $this->resource);
        \Data::setGlobal('title', _d('title.dashio') . ' | ' . _d(\Route::getCurrentRoute()->getName()));
        \Data::setModule('header', _d(\Route::getCurrentRoute()->getName()));
        \Data::setModule('action', last(explode('.', \Route::getCurrentRoute()->getName())));
        \Data::setModule('icons', $this->icon);
        $global_icon = isset($this->icon[\Route::getCurrentRoute()->getActionMethod()]) ? $this->icon[\Route::getCurrentRoute()->getActionMethod()] : 'fas fa-list-alt';
        \Data::setModule('icon', $global_icon);
        $this->data = \Data::$Data;
    }

    public function view($name)
    {
        \Data::setLayouts('mod', 'html');
        if(request()->ajax() && !strstr(request()->header('accept'), 'application/json'))
        {
            \Data::setLayouts('mod', 'xhr');
            $name =  \View::exists("$name-xhr") ? "$name-xhr" : $name;
            return json_encode(\Data::get('global')) . "\n" . view($name, \Data::all());
        }
        elseif(strstr(request()->header('accept'), 'application/json'))
        {
            if(method_exists($this, 'toArray'))
            {
                $response = $this->toArray();
                if(gettype($response) != 'null' && $response !== false) return $response;
            }
            return \Data::all();
        }
        return view($name, \Data::all());
    }

    public function API($class, $method, ...$arguments)
    {
        $corridor = new $class;
        $run = call_user_func_array([new $class, $method], $arguments);
        $data = $run->getData();
        $data->data = $run->object_result;
        $data->response =  $run;
        return $data;
    }
}