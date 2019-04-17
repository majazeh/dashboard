<?php

function _d($text, $args = []){
	$trans = __("$text");
	return $trans == "$text" ? $text : $trans;
}

function order_link($order, $sort)
{
	$query = request()->all();
	$query['order'] = $order;
	$query['sort'] = $sort;
	return Request::create(url()->current(), 'GET', $query)->getUri();
}

?>