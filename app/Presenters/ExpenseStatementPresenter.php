<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class ExpenseStatementPresenter extends Presenter
{
    public function statusBadge()
    {
        if ($this->model->canceled_at) {
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }else{
            if(!$this->model->aut_fin){
                return new HtmlString('<span class="badge badge-warning-lighten">Pendiente revision</span>');
            }else{
                return new HtmlString('<span class="badge badge-success-lighten">Aplicado</span>');
            }
        }
    }
}