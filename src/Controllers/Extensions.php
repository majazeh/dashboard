<?php
namespace Majazeh\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\GuardPosition;

trait Extensions
{
	public function access($method, $request, ...$args)
		{
			return true;
		}
		public function access_check($method, $request, ...$args)
		{
			if(!$this->access($method, $request, ...$args))
			{
				abort(403, 'access denided');
			}
		}

		public function notFound($message)
		{
			abort(404, $message);
		}

		public function get_model()
		{
			return "\App\\" . $this->table;
		}

		public function findOrFail($id, $model_name = null)
		{
            $model = $model_name ? (is_string($model_name) && substr($model_name, 0, 5) == '\App\\' ? $model_name : '\App\\' . (is_string($model_name) ? $model_name : $model_name->getModel()->getTable())) : $this->get_model();
			$model_name = $model_name ?: $this->table;
			if(is_null($id))
			{
				return $this->notFound($model_name . " not found");
			}
			if(is_string($id) || is_int($id))
			{
				if($model_name instanceof \Illuminate\Database\Eloquent\Builder)
				{
					return $model_name->find($id) ?: $this->notFound(substr($model_name->getModel()->getTable(), 0, -1) . " not found");
				}
				$table = $model::find($id);
				if(!$table)
				{
					return $this->notFound($model_name . " not found");
				}
				return $table;
			}
			if($id instanceof \Illuminate\Database\Eloquent\Builder)
			{
				return $id->first() ?: $this->notFound(substr($id->getModel()->getTable(), 0, -1) . " not found");
			}
			return $id;
		}

		public function fast_search($request, &$model)
		{

		}

		public function getParent()
		{
			return '\App\\' . $this->parent;
		}
	}
?>
