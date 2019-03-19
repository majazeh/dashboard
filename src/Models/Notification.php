<?php

namespace App;

use Illuminate\Database\Eloquent\Model as eloquent;
class Notification extends eloquent
{
	use Model;
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public static function send($from, $to, $title, $trigger, $content = null, $meta = null)
	{
		if(is_array($to))
		{
			$insert = [];
			foreach ($to as $key => $value) {
				$insert[] = [
					'from_id' => $from,
					'to_id' => $to,
					'title' => $title,
					'trigger' => $trigger,
					'content' => $content,
					'meta' => json_encode($meta),
					'status' => 'wating'
				];
				Statistic::plus(CustomUser::find($to), 'notifications', 'wating');
				Statistic::plus(CustomUser::find($to), 'notifications', $trigger);
			}
			Notification::insert($insert);
		}
		else
		{
			$notif = Notification::create([
				'from_id' => $from,
				'to_id' => $to,
				'title' => $title,
				'trigger' => $trigger,
				'content' => $content,
				'meta' => $meta,
				'status' => 'wating'
			]);
				Statistic::plus(CustomUser::find($to), 'notifications', 'wating');
				Statistic::plus(CustomUser::find($to), 'notifications', $trigger);
			return $notif;
		}
	}

	public function read()
	{
		$this->status = 'read';
		$this->save();
		Statistic::minus(CustomUser::find($this->to_id), 'notifications', 'wating');
		Statistic::minus(CustomUser::find($this->to_id), 'notifications', $this->trigger);
	}

	public static function readTrigger($user, $trigger)
	{
		$count = Statistic::where([
			'table'    => 'users',
            'table_id' => $user->id,
            'cat'      => 'notifications',
            'key'      => $trigger
		])->first();
		if(!$count) return;
		Statistic::minus($user, 'notifications', 'wating', $count->count);
		Statistic::minus($user, 'notifications', $trigger, $count->count);
	}

}
