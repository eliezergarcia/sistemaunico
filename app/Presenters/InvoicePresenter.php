<?php

namespace App\Presenters;

use Carbon\Carbon;
use Illuminate\Support\HtmlString;

class InvoicePresenter extends Presenter
{
    public function statusBadge()
    {
        if($this->model->canceled_at){
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }else{
            if(number_format($this->model->payments->pluck('monto')->sum(), 2, '.', ',') != number_format($this->model->neto + $this->model->iva, 2, '.', ',')){
                return new HtmlString('<span class="badge badge-warning-lighten">Pendiente pago</span>');

            }else{
                return new HtmlString('<span class="badge badge-success-lighten">Finalizado</span>');
            }
        }
    }

    public function fechaPagos()
    {
		foreach($this->model->payments as $payment){
            echo new HtmlString('<span data-toggle="tooltip" data-placemente="top" data-original-title="$'.$payment->monto.'">'.Carbon::parse($payment->fecha_pago)->format('d-m-Y').'</span><br>');
		}
    }
}