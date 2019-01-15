<?php

namespace Majazeh\Dashboard\Controllers;

class Data
{
	public static $Data = [];

	public static function set($key, $value)
	{
		return self::$Data[$key] = $value;
	}

	public static function get($key)
	{
		return isset(self::$Data[$key]) ? self::$Data[$key] : null;
	}


	public static function all(){
		return self::$Data;
	}

	public static function __callStatic($name, $arguments)
	{
		if(substr($name, 0, 3) == 'set')
		{
			$key = lcfirst(substr($name, 3));
			if(!isset(self::$Data[$key]) || !is_object(self::$Data[$key]))
			{
				self::$Data[$key] = new StdClass;
			}
			self::$Data[$key]->{$arguments[0]} = $arguments[1];
		}
		elseif(substr($name, 0, 3) == 'get')
		{
			$key = lcfirst(substr($name, 3));
			if(!isset(self::$Data[$key]->{$arguments[0]}))
			{
				return null;
			}
			return self::$Data[$key]->{$arguments[0]};
		}
	}
}
