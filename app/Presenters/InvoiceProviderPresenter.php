<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class InvoiceProviderPresenter extends Presenter
{
     public function statusBadge()
    {
        if($this->model->canceled_at){
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }else{
            if (!$this->model->aut_oper) {
                echo new HtmlString('<span class="badge badge-success-lighten">Pendiente autorización</span><br>');
            }elseif(!$this->model->aut_fin){
                echo new HtmlString('<span class="badge badge-info-lighten">Pendiente revisión</span><br>');
            }else{
                $sinfacturaunico = 0;
                if($this->model->operation->debitnotes->isEmpty() && $this->model->operation->prefactures->isEmpty()){
                    $sinfacturaunico = 1;
                }
                foreach ($this->model->operation->debitnotes as $debitnote) {
                    if($debitnote->invoices->isEmpty()){
                        $sinfacturaunico = 1;
                    }
                }
                foreach ($this->model->operation->prefactures as $prefacture) {
                    if($prefacture->invoices->isEmpty()){
                        $sinfacturaunico = 1;
                    }
                }

                if($sinfacturaunico > 0){
                    echo new HtmlString('<span class="badge badge-info-lighten">Pendiente factura UNICO</span>');
                }else{
                    if($this->model->payments->pluck('monto')->sum() >= $this->model->total){
                        echo new HtmlString('<span class="badge badge-success-lighten">Finalizado</span>');
                    }else{
                        echo new HtmlString('<span class="badge badge-info-lighten">Pendiente pago</span>');
                    }
                }
            }
        }
    }

     public function statusBadgeGuarantee()
    {
        if($this->model->canceled_at){
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }else{
            if (!$this->model->aut_oper) {
                echo new HtmlString('<span class="badge badge-success-lighten">Pendiente autorización</span><br>');
            }elseif(!$this->model->aut_fin){
                echo new HtmlString('<span class="badge badge-info-lighten">Pendiente revisión</span><br>');
            }elseif(!$this->model->factura){
                echo new HtmlString('<span class="badge badge-info-lighten">Pendiente factura</span><br>');
            }
        }
    }

    public function statusBadgeAdvance()
    {
        if($this->model->canceled_at){
            return new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }else{
            if (!$this->model->aut_oper) {
                echo new HtmlString('<span class="badge badge-success-lighten">Pendiente autorización</span><br>');
            }elseif(!$this->model->aut_fin){
                echo new HtmlString('<span class="badge badge-info-lighten">Pendiente revisión</span><br>');
            }elseif(!$this->model->factura){
                echo new HtmlString('<span class="badge badge-info-lighten">Pendiente factura</span><br>');
            }
        }
    }

    public function colorPriorityTable()
    {
        if ($this->model->priority == 1 && $this->model->payments->isEmpty()) {
            return 'table-danger';
        }
    }
}