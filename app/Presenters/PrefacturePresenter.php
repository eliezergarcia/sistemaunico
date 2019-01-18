<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class PrefacturePresenter extends Presenter
{
    public function statusBadge()
    {
        if ($this->model->canceled_at) {
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }else{
            if($this->model->invoices->isEmpty()){
                return new HtmlString('<span class="badge badge-warning-lighten">Pendiente factura</span>');
            }elseif($this->model->invoicepayments->pluck('monto')->sum() != number_format($this->model->invoices->first()->neto + $this->model->invoices->first()->iva, 2, '.', '')){

                return new HtmlString('<span class="badge badge-warning-lighten">Pendiente pago</span>');
            }else{
                return new HtmlString('<span class="badge badge-success-lighten">Finalizado</span>');
            }
        }
    }

    public function colorInvoiceTable()
    {
        if ($this->model->invoices->isEmpty()) {
            return 'table-info';
        }
    }
}