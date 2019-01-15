<?php

function _d($text, $args = []){
	return Lang::has("dashboard.$text") ? __("dashboard.$text") : trans("dashio::messages.$text");
}

function order_link($order, $sort)
{
	$query = request()->all();
	$query['order'] = $order;
	$query['sort'] = $sort;
	return Request::create(url()->current(), 'GET', $query)->getUri();
}

?>