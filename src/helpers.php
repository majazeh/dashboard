<?php

function _d($text, $args = []){
	$trans = __("$text");
	if(is_string($trans))
	{
		return $trans == $text ? $text : $trans;
	}
	return $text;
}

function order_link($order, $sort)
{
	$query = request()->all();
	$query['order'] = $order;
	$query['sort'] = $sort;
	return Request::create(url()->current(), 'GET', $query)->getUri();
}

?>