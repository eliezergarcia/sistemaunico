<?php

namespace App\Presenters;

use Carbon\Carbon;
use Illuminate\Support\HtmlString;

class GeneralPresenter extends Presenter
{
    public function activate()
  	{
 		$this->model->inactive_at = Carbon::now();
    	$this->model->save();
  	}

    public function deactivate()
    {
        $this->model->inactive_at = null;
        $this->model->save();
    }
}