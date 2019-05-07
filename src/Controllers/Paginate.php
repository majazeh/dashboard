<?php
namespace Majazeh\Dashboard\Controllers;
use Illuminate\Http\Request;

trait Paginate
{
	public function paginate_order(Request $request, $model, $order_list = ['id'], $default = ['id', 'desc'])
	{
		$keys = array_keys($order_list);
		$order_string = $request->input('order') && in_array($request->input('order'), $keys) ? strtolower($request->input('order')) : $default[0];
		$orders = explode(',', $order_string);
		
		$sort_string = $request->sort ?: $default[1];
		$sorts = explode(',', $sort_string);
		foreach($orders as $key => $order)
		{
			if(isset($order_list[$order]) || in_array($order, $order_list))
			{
				$order = isset($order_list[$order]) ? $order_list[$order] : $order;
				$sort = isset($sorts[$key]) && in_array(strtolower($sorts[$key]), ['asc', 'desc']) ? strtolower($sorts[$key]) : 'desc';
				$model->orderBy($order, $sort);
			}
		}
		$paginate = $model->paginate();
		if($order_string != $default[0] || $sort_string != $default[1])
		{
	        $paginate->appends($request->all('order', 'sort'));
		}
		return $paginate;
	}
}
?>