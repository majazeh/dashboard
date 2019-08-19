<?php
namespace Majazeh\Dashboard\Controllers;
trait Response
{
	public function response($result, $data = [], $code = 200)
	{
		$response = ['is_ok' => true, 'message' => ':)'];
		$object_result = $data;
		if(is_object($result))
		{
			$object_result = $result;
			$result = $result->toArray();
		}
		elseif(is_object($data))
		{
			$object_result = $data;
			$data = $data->toArray();
		}
		$response = is_array($result) ? array_merge($response, $result) : array_merge($response, ['message' => $result]);
		if(!empty($data))
		{
			$response['data'] = $data;
		}
		$response['message'] = _d(str_replace(" ", "_", strtoupper($response['message'])));
		if($code != 200)
		{
			$response['is_ok'] = false;
		}
		$response['message_text'] = _d($response['message']);
		$json = response()->json($response, $code);
		$json->object_result = $object_result;
		return $json;
	}
}
?>