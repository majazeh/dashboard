<?php
namespace Majazeh\Dashboard\Controllers;
use Illuminate\Http\Request;
trait Validator
{
	public $en_rules = ['date', 'date_equals', 'date_format', 'digits', 'digits_between', 'dimensions', 'email', 'integer', 'numeric', 'en_number'];

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
		$validator = $this->getValidationFactory()->make($this->get_fields('inputs', $request, $update), $this->get_fields('validate', $request, $update));

		$this->en_numbers($validator, $request);

		return $validator;
	}

	public function en_numbers(&$validator, Request $request = null)
	{
        foreach ($validator->getRules() as $key => $value) {
            if(!key_exists($key, $validator->getData())) continue;
            foreach ($value as $k => $v) {
				if(in_array($v, $this->en_rules))
                {
                    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                    $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

                    $num = range(0, 9);
                    $convertedPersianNums = str_replace($persian, $num, $validator->getData()[$key]);
                    $englishNumbers = str_replace($arabic, $num, $convertedPersianNums);
					$validator->setData(array_merge($validator->getData(), [$key => $englishNumbers]));
					if($request && $request->has($key))
					{
						$request->merge([$key => $englishNumbers]);
					}
                    if(strtolower($v) == 'en_number')
                    {
                        unset($value[$k]);
                        $validator->setRules([$key => $value]);
                    }
                }
            }
		}
	}

	public function validated(Request $request, $id = null){}

}
?>