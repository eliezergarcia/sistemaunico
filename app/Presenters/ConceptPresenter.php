<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class ConceptPresenter extends Presenter
{
    public function statusBadge()
    {
        if(!$this->model->inactive_at){
            return new HtmlString('<span class="badge badge-success-lighten">Activo</span>');
        }else{
            return new HtmlString('<span class="badge badge-danger-lighten">Inactivo</span>');
        }
    }
}