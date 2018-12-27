<?php

namespace App\Presenters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class Presenter
{
  	protected $model;

  	public function __construct(Model $model)
  	{
    	$this->model = $model;
  	}

   //  public function activate()
  	// {
 		// $this->inactive_at = Carbon::now();
   //  	$this->model->save();
  	// }

   //  public function deactivate()
   //  {
   //      $this->inactive_at = null;
   //      $this->model->save();
   //  }
}