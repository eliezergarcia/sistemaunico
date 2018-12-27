<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class ContainerPresenter extends Presenter
{
    public function statusBadge()
    {
        if(!$this->model->canceled_at){
            if($this->model->operation->recibir && !$this->model->operation->revision) echo new HtmlString('<span class="badge badge-primary-lighten">Recibir</span>');
            if($this->model->operation->revision && !$this->model->operation->mandar) echo new HtmlString('<span class="badge badge-primary-lighten">Revisión</span>');
            if($this->model->operation->mandar && !$this->model->operation->revalidacion) echo new HtmlString('<span class="badge badge-primary-lighten">Mandar</span>');
            if($this->model->operation->revalidacion && !$this->model->operation->toca_piso) echo new HtmlString('<span class="badge badge-primary-lighten">Revalidación</span>');
            if($this->model->operation->toca_piso && !$this->model->proforma) echo new HtmlString('<span class="badge badge-primary-lighten">Toca piso</span>');
            if($this->model->proforma && !$this->model->pago_proforma) echo new HtmlString('<span class="badge badge-primary-lighten">Proforma</span>');
            if($this->model->pago_proforma && !$this->model->despachado_puerto) echo new HtmlString('<span class="badge badge-primary-lighten">Pago proforma</span>');
            if($this->model->despachado_puerto && !$this->model->solicitud_transporte) echo new HtmlString('<span class="badge badge-primary-lighten">Desp. puerto</span>');
            if($this->model->solicitud_transporte && !$this->model->port_etd) echo new HtmlString('<span class="badge badge-primary-lighten">Sol. transporte</span>');
            if($this->model->port_etd && !$this->model->dlv_day) echo new HtmlString('<span class="badge badge-primary-lighten">Port etd</span>');
            if(($this->model->operation->debitnotes->isEmpty() && $this->model->dlv_day) && ($this->model->operation->prefactures->isEmpty() && $this->model->dlv_day)) echo new HtmlString('<span class="badge badge-primary-lighten">Dlv day</span>');
            if(($this->model->operation->debitnotes->isNotEmpty() || $this->model->operation->prefactures->isNotEmpty()) && !$this->model->factura_unmx)
                if($this->model->operation->debitnotes->isNotEmpty()) echo new HtmlString('<span class="badge badge-primary-lighten">Debit Note</span>');
                if($this->model->operation->debitnotes->isNotEmpty() && $this->model->operation->prefactures->isNotEmpty()) echo new HtmlString('<br>');

                if($this->model->operation->prefactures->isNotEmpty()) echo new HtmlString('<span class="badge badge-primary-lighten">Prefactura</span>');
            if($this->model->factura_unmx && !$this->model->fecha_factura) echo new HtmlString('<span class="badge badge-primary-lighten">Factura unmx</span>');
            if($this->model->fecha_factura && $this->model->factura_unmx) echo new HtmlString('<span class="badge badge-success-lighten">Fecha factura</span>');
        }
        else{
            echo new HtmlString('<span class="badge badge-danger-lighten">Cancelado</span>');
        }
    }
}