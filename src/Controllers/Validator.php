<?php
namespace Majazeh\Dashboard\Controllers;
use Illuminate\Http\Request;
trait Validator
{
	public function fields($update)
	{
		return isset($this->validator) ? $this->validator : [];
	}

	public function get_fields($type, $request = null, $update = false)
	{
		switch ($type) {
			case 'keys':
			return array_keys($this->fields($request));
			break;
			case 'inputs':
			$inputs = [];
			foreach ($this->fields($request, $update) as $key => $value) {
				if($value && $request->has($key))
				{
					$inputs[$key] = $request->input($key);
				}
			}
			return $inputs;
			break;
			case 'validate':
			$inputs = [];
			foreach ($this->fields($request, $update) as $key => $value) {
				if($value)
				{
					$inputs[$key] = $value;
				}
			}
			return $inputs;
			break;
		}
	}

	public function validator(Request $request, $update = false)
	{
		return $this->getValidationFactory()->make($this->get_fields('inputs', $request, $update), $this->get_fields('validate', $request, $update));
	}

	public function validated(Request $request, $id = null){}

}
?>