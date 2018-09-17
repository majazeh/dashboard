<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserSocialNetwork extends Eloquent
{
	use Model;
    protected $guarded = [];
    //
    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
