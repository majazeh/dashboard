<?php

namespace App;

trait Model
{
	public function getMetaAttribute()
	{
		if(!isset($this->attributes['meta']) || empty($this->attributes['meta']))
		{
			return (object) [];
		}

		return json_decode($this->attributes['meta']);
	}

	public function setMetaAttribute($value)
	{
		return $this->attributes['meta'] = json_encode($value);
	}
}
