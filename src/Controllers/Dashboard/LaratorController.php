<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Majazeh\Dashboard\Controllers\Controller;
use Illuminate\Http\Request;
use Data;
use Majazeh\Dashboard\Controllers\Response;

class LaratorController extends Controller
{
	use Response;
	public $resource = 'dashboard.larators';

	public static $db;
	public static $file = 'app/larators.json';
	public function index()
	{
		self::storage();
		Data::set('larators', self::$db);
		return $this->view("{$this->resource}.index");
	}
	public static function checkOrSave($text)
	{
		self::storage();
		if(!isset(self::$db->translates->{$text}))
		{
			$trans = self::$db->translates->{$text} = (object) [];
			self::save();
		}
		else {
			$trans = self::$db->translates->{$text};
		}
		if(isset($trans->reference))
		{
			return self::checkOrSave($trans->reference);
		}
		if(isset($trans->{config('app.locale')}))
		{
			return $trans->{config('app.locale')};
		}
		return $text;
	}

	public function update(Request $request, $original)
	{
		self::storage();
		$gets = self::$db->langs;
		array_unshift($gets, 'reference');
		$gets = $request->all($gets);
		foreach ($gets as $key => $value) {
			if(!$request->has($key)) continue;
			if(!isset(self::$db->translates->$original)) continue;
			self::$db->translates->$original->$key = $value;
		}
		self::save();
		return $this->response(['message' => ':)']);

	}

	public static function storage()
	{
		if(self::$db) return;
		$larator_file = storage_path(self::$file);
		if (!file_exists($larator_file)) {
			file_put_contents($larator_file, json_encode([
				"langs" => config('larator.langs', ['fa', 'ar', 'en']),
				"translates" => (object) []
			]));
		}
		self::$db = json_decode(file_get_contents($larator_file));
		if(!isset(self::$db->langs))
		{
			unlink($larator_file);
			return self::storage();
		}
		self::$db = self::$db;
		if(!isset(self::$db->translates))
		{
			self::$db->translates = (object) [];
			self::save();
		}
	}
	public static function save()
	{
		file_put_contents(storage_path(self::$file), json_encode(self::$db));
	}
}
?>
