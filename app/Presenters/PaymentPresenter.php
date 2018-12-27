<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class PaymentPresenter extends Presenter
{
    public function statusBadge()
    {
        if(!$this->model->deleted_at){
            return new HtmlString('<span class="badge badge-success-lighten">Aplicado</span>');
        }else{
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }
    }
}