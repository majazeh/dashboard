<?php
namespace Majazeh\Dashboard\Controllers;
use Illuminate\Http\Request;

trait Paginate
{
	public function paginate_order(Request $request, $model, $order_list = ['id'])
	{
		$keys = array_keys($order_list);
		$order = $request->input('order') && in_array($request->input('order'), $keys) ? strtolower($request->input('order')) : 'id';
		if(isset($order_list[$order]))
		{
			$order = $order_list[$order];
		}
		$sort = strtolower($request->input('sort')) == 'asc' ? 'asc' : 'desc';
		$model->orderBy($order, $sort);
		$paginate = $model->paginate();
		if($order != 'id' || $sort != 'desc')
		{
	        $paginate->appends($request->all('order', 'sort'));
		}
		return $paginate;
	}
}
?>