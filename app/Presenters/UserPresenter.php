<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class UserPresenter extends Presenter
{
    public function roles()
    {
      return $this->model->roles->pluck('display_name')->implode(', ');
    }

}
