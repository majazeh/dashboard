<?php

namespace Majazeh\Dashboard\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class APIController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,
    Response, Paginate, Validator, Extensions;


    public function __construct(Request $request)
    {
        if(!isset($this->table))
		{
			preg_match("#\\\([^\\\]*[^s])s?Controller$#", get_class($this), $model_name);
			$this->table = $model_name[1];
		}

		if (!isset($this->resource) && class_exists("\App\Http\Resources\\$this->table")) {
			$this->resource = "\App\Http\Resources\\$this->table";
		}
		if (!isset($this->resource_collection) && class_exists("\App\Http\Resources\\" . str_plural($this->table))) {
			$this->resource_collection = "\App\Http\Resources\\" . str_plural($this->table);
		}

		$this->response = collect(['message' => ':)']);
		$this->status = 200;
	}
}