<?php

function _d($text, $args = []){
	return Lang::has("dashboard.$text") ? _("dashboard.$text") : trans("dashio::messages.$text");
}

?>