<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Guard extends Eloquent
{
	use Model;
    protected $guarded = [];

}
