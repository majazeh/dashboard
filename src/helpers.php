<?php

function _d($text, $args = []){
	return Lang::has("dashboard.$text") ? __("dashboard.$text") : trans("dashio::messages.$text");
}

?>