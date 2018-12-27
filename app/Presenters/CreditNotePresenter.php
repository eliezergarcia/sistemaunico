<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class CreditNotePresenter extends Presenter
{
    public function statusBadge()
    {
        if(!$creditnote->deleted_at){
            return new HtmlString('<span class="badge badge-success-lighten">Aplicado</span>');
        }else{
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }
    }
}