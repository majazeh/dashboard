<?php

namespace App;
use Illuminate\Support\Facades\Auth;

class GuardioAuth extends Auth
{
	public static $guardio;
	public static function guardio($access)
	{
		if(!self::check())
		{
			return false;
		}
		if(self::user()->type == 'admin')
		{
			return true;
		}

		$access = !is_array($access) ? [$access] : $access;
		$guardioConfig = config('guardio');

		$groups = self::groups();
		if(!self::$guardio)
		{
			self::$guardio = GuardPosition::whereIn('guard', $groups)->get();
		}

		$permissions = [];
		foreach ($groups as $key => $value) {
			$permissions = array_merge($permissions, config("guardio.groups.{$value}") ?: []);
		}
		$permissions = array_unique($permissions);
		foreach ($access as $key => $value) {
			$value = str_replace(" ", "", $value);
			if(strpos($value, '|'))
			{
				$OrValue = explode('|', $value);
				$check = false;
				foreach ($OrValue as $okey => $ovalue) {
					if(substr($ovalue, 0, 1) == '@')
					{
						if(self::inGroup(substr($ovalue, 1)))
						{
							$check = true;
							break;
						}
					}
					else {
						if(in_array($ovalue, $permissions))
						{
							$check = true;
							break;
						}
					}
				}
				if(!$check)
				{
					return false;
				}
				continue;
			}
			elseif(substr($value, 0, 1) == '@')
			{
				if(!self::inGroup(substr($value, 1)))
				{
					return false;
				}
			}
			elseif(!in_array($value, $permissions))
			{
				return false;
			}
		}
		return true;
	}

	public static function type($search = null)
	{
		if(!self::check())
		{
			return false;
		}
		if($search)
		{
			return self::user()->type == $search;
		}
		return self::user()->type;
	}

	public static function groups($search = null)
	{
		if(!self::check())
		{
			return false;
		}
		$groups = self::user()->groups ? explode('|', self::user()->groups) : [];
		if(!in_array(self::user()->type ,$groups)){
			array_push($groups, self::user()->type);
		}
		return $groups;
	}

	public static function inGroup($search)
	{
		if(!self::check())
		{
			return false;
		}
		if(in_array($search, self::groups()))
		{
			return true;
		}
		return false;
	}
}
