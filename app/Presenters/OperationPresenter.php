<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class OperationPresenter extends Presenter
{
    public function statusBadgeImpo()
    {
		if($this->model->containers->isNotEmpty()){
            if($this->model->recibir && !$this->model->revision) return new HtmlString('<span class="badge badge-primary-lighten">Recibir</span>');
            if($this->model->revision && !$this->model->mandar) return new HtmlString('<span class="badge badge-primary-lighten">Revisión</span>');;
            if($this->model->mandar && !$this->model->revalidacion) return new HtmlString('<span class="badge badge-primary-lighten">Mandar</span>');
            if($this->model->revalidacion && !$this->model->toca_piso) return new HtmlString('<span class="badge badge-primary-lighten">Revalidación</span>');
            if($this->model->toca_piso && $this->model->containers->pluck('proforma')->contains(null)) return new HtmlString('<span class="badge badge-primary-lighten">Toca piso</span>');
            if(!$this->model->containers->pluck('proforma')->contains(null) && $this->model->containers->pluck('pago_proforma')->contains(null)) return new HtmlString('<span class="badge badge-primary-lighten">Proforma</span>');
            if(!$this->model->containers->pluck('pago_proforma')->contains(null) && $this->model->containers->pluck('despachado_puerto')->contains(null)) return new HtmlString('<span class="badge badge-primary-lighten">Pago proforma</span>');
            if(!$this->model->containers->pluck('despachado_puerto')->contains(null) && $this->model->containers->pluck('solicitud_transporte')->contains(null)) return new HtmlString('<span class="badge badge-primary-lighten">Desp. puerto</span>');
            if(!$this->model->containers->pluck('solicitud_transporte')->contains(null) && $this->model->containers->pluck('port_etd')->contains(null)) return new HtmlString('<span class="badge badge-primary-lighten">Sol. transporte</span>');
            if(!$this->model->containers->pluck('port_etd')->contains(null) && $this->model->containers->pluck('dlv_day')->contains(null)) return new HtmlString('<span class="badge badge-primary-lighten">Port etd</span>');
            if(($this->model->debitnotes->isEmpty() && !$this->model->containers->pluck('dlv_day')->contains(null)) && ($this->model->prefactures->isEmpty() && !$this->model->containers->pluck('dlv_day')->contains(null))) return new HtmlString('<span class="badge badge-primary-lighten">Dlv day</span>');
            if($this->model->debitnotes->isNotEmpty() || $this->model->prefactures->isNotEmpty()){
                $debitnotenofacturado = 0;
                $prefacturanofacturado = 0;
            }else{
                $debitnotenofacturado = 1;
                $prefacturanofacturado = 1;
            }
            foreach($this->model->debitnotes as $debitnote){
                if (!$debitnote->canceled_at) {
                    if($debitnote->invoices->isEmpty()){
                        $debitnotenofacturado++;
                    }
                }else{
                    $debitnotenofacturado--;
                }
            }
            foreach($this->model->prefactures as $prefacture){
                if (!$prefacture->canceled_at) {
                    if($prefacture->invoices->isEmpty()){
                        $prefacturanofacturado++;
                    }
                }else{
                    $prefacturanofacturado--;
                }
            }
            $badge = "";
            if(($this->model->debitnotes->isNotEmpty() || $this->model->prefactures->isNotEmpty()) && ($debitnotenofacturado != 0 || $prefacturanofacturado != 0)){
				if($this->model->debitnotes->isNotEmpty() && $debitnotenofacturado != 0) $badge = '<span class="badge badge-primary-lighten">Debit note</span>';
                if($this->model->debitnotes->isNotEmpty() && $this->model->prefactures->isNotEmpty()) $badge = $badge.'<br>';
				if($this->model->prefactures->isNotEmpty() && $prefacturanofacturado != 0) $badge = $badge.'<span class="badge badge-primary-lighten">Prefactura</span>';
				return new HtmlString($badge);
            }
            if($debitnotenofacturado == 0 && $prefacturanofacturado == 0) return new HtmlString('<span class="badge badge-success-lighten">Facturado</span>');
		}
    }

    public function statusBadgeExpo()
    {
		if($this->model->containers->isNotEmpty()){
	        if($this->model->booking_expo && !$this->model->conf_booking) return new HtmlString('<span class="badge badge-info-lighten">Booking</span>');
	        if($this->model->conf_booking && !$this->model->prog_recoleccion) return new HtmlString('<span class="badge badge-info-lighten">Conf. booking</span>');
	        if($this->model->prog_recoleccion && !$this->model->recoleccion) return new HtmlString('<span class="badge badge-info-lighten">Prog. recolección</span>');
	        if($this->model->recoleccion && !$this->model->llegada_puerto) return new HtmlString('<span class="badge badge-info-lighten">Recolección</span>');
	        if($this->model->llegada_puerto && !$this->model->cierre_documental) return new HtmlString('<span class="badge badge-info-lighten">Llegada puerto</span>');
	        if($this->model->cierre_documental && !$this->model->pesaje) return new HtmlString('<span class="badge badge-info-lighten">Cierre documental</span>');
	        if($this->model->pesaje && !$this->model->ingreso) return new HtmlString('<span class="badge badge-info-lighten">Pesaje</span>');
	        if($this->model->ingreso && !$this->model->despacho) return new HtmlString('<span class="badge badge-info-lighten">Ingreso</span>');
	        if($this->model->despacho && !$this->model->zarpe) return new HtmlString('<span class="badge badge-info-lighten">Despacho</span>');
	        if($this->model->zarpe && !$this->model->envio_papelera) return new HtmlString('<span class="badge badge-info-lighten">Zarpe</span>');
	        if($this->model->envio_papelera && ($this->model->debitnotes->isEmpty() && $this->model->prefactures->isEmpty())) return new HtmlString('<span class="badge badge-info-lighten">Envio prealerta</span>');
            if($this->model->debitnotes->isNotEmpty() || $this->model->prefactures->isNotEmpty()){
                $debitnotenofacturado = 0;
                $prefacturanofacturado = 0;
            }else{

                $debitnotenofacturado = 1;
                $prefacturanofacturado = 1;
            }
            foreach($this->model->debitnotes as $debitnote){
                if (!$debitnote->canceled_at) {
                    if($debitnote->invoices->isEmpty()){
                        $debitnotenofacturado++;
                    }
                }else{
                    $debitnotenofacturado--;
                }
            }
            foreach($this->model->prefactures as $prefacture){
                if (!$prefacture->canceled_at) {
                    if($prefacture->invoices->isEmpty()){
                        $prefacturanofacturado++;
                    }
                }else{
                    $prefacturanofacturado--;
                }
            }
            $badge = "";
            if(($this->model->debitnotes->isNotEmpty() || $this->model->prefactures->isNotEmpty()) && ($debitnotenofacturado != 0 || $prefacturanofacturado != 0)){
				if($this->model->debitnotes->isNotEmpty() && $debitnotenofacturado != 0) $badge = '<span class="badge badge-primary-lighten">Debit note</span>';
                if($this->model->debitnotes->isNotEmpty() && $this->model->prefactures->isNotEmpty()) $badge = $badge.'<br>';
				if($this->model->prefactures->isNotEmpty() && $prefacturanofacturado != 0) $badge = $badge.'<span class="badge badge-primary-lighten">Prefactura</span>';
				return new HtmlString($badge);
            }
            if($debitnotenofacturado == 0 && $prefacturanofacturado == 0) return new HtmlString('<span class="badge badge-success-lighten">Facturado</span>');
		}
    }

    public function facturasProveedor()
    {
        if($this->model->invoicesproviders->isNotEmpty()){
            echo "<span class='dropdown-item'>Facturas de proveedor</span>";
            foreach($this->model->invoicesproviders as $invoiceprovider){
                if ($invoiceprovider->guarantee_request == null && $invoiceprovider->advance_request == null) {
                    if($invoiceprovider->pagado){
                        echo "<a href='".route('operations.invoiceProvider', $invoiceprovider->id)."' class='dropdown-item text-success'>Factura {$invoiceprovider->factura}</a>";
                    }elseif($invoiceprovider->canceled_at){
                        echo "<a href='".route('operations.invoiceProvider', $invoiceprovider->id)."' class='dropdown-item text-danger'>Factura {$invoiceprovider->factura}</a>";
                    }else{
                        echo "<a href='".route('operations.invoiceProvider', $invoiceprovider->id)."' class='dropdown-item'>Factura {$invoiceprovider->factura}</a>";
                    }
                }
            }
            echo '<div class="dropdown-divider"></div>';
        }
    }

    public function solicitudGarantias()
    {
        if($this->model->invoicesproviders->isNotEmpty()){
            echo "<span class='dropdown-item'>Solicitudes de garantía</span>";
            foreach($this->model->invoicesproviders as $invoiceprovider){
                if ($invoiceprovider->guarantee_request != null) {
                    if($invoiceprovider->pagado){
                        echo "<a href='".route('operations.guaranteeRequest', $invoiceprovider->id)."' class='dropdown-item text-success'>Sol. {$invoiceprovider->controlcode}</a>";
                    }elseif($invoiceprovider->canceled_at){
                        echo "<a href='".route('operations.guaranteeRequest', $invoiceprovider->id)."' class='dropdown-item text-danger'>Sol. {$invoiceprovider->controlcode}</a>";
                    }else{
                        echo "<a href='".route('operations.guaranteeRequest', $invoiceprovider->id)."' class='dropdown-item'>Sol. {$invoiceprovider->controlcode}</a>";
                    }
                }
            }
            echo '<div class="dropdown-divider"></div>';
        }
    }

    public function solicitudAnticipo()
    {
        if($this->model->invoicesproviders->isNotEmpty()){
            echo "<span class='dropdown-item'>Solicitudes de anticipo</span>";
            foreach($this->model->invoicesproviders as $invoiceprovider){
                if ($invoiceprovider->advance_request != null) {
                    if($invoiceprovider->pagado){
                        echo "<a href='".route('operations.advanceRequest', $invoiceprovider->id)."' class='dropdown-item text-success'>Sol. {$invoiceprovider->controlcode}</a>";
                    }elseif($invoiceprovider->canceled_at){
                        echo "<a href='".route('operations.advanceRequest', $invoiceprovider->id)."' class='dropdown-item text-danger'>Sol. {$invoiceprovider->controlcode}</a>";
                    }else{
                        echo "<a href='".route('operations.advanceRequest', $invoiceprovider->id)."' class='dropdown-item'>Sol. {$invoiceprovider->controlcode}</a>";
                    }
                }
            }
            echo '<div class="dropdown-divider"></div>';
        }
    }

    public function solicitudesNoFacturadas()
    {
        if($this->model->debitnotes->isNotEmpty() || $this->model->prefactures->isNotEmpty()){
            $nofacturado = 0;
        }else{
            $nofacturado = 1;
        }

        foreach($this->model->debitnotes as $debitnote){
            if (!$debitnote->canceled_at) {
                if($debitnote->invoices->isEmpty()){
                    $nofacturado++;
                }
            }else{
                $nofacturado--;
            }
        }

        foreach($this->model->prefactures as $prefacture){
            if (!$prefacture->canceled_at) {
                if($prefacture->invoices->isEmpty()){
                    $nofacturado++;
                }
            }else{
                $nofacturado--;
            }
        }

        return $nofacturado;
    }

    public function debitnotes()
    {
        if($this->model->debitnotes->isNotEmpty()){
            echo "<span class='dropdown-item'>Debit Notes</span>";
            foreach($this->model->debitnotes as $key => $debitnote){
                if(!$debitnote->canceled_at){
                    if($debitnote->invoices->contains(!null)){
                        echo "<a href='".route('operations.debitnote', $debitnote->id)."' class='dropdown-item text-success'> {$debitnote->numberFormat}</a>";
                    }elseif($debitnote->invoices->pluck('canceled_at')->contains(!null)){
                        echo "<a class='dropdown-item text-danger' href='".route('operations.debitnote', $debitnote->id)."'>{$debitnote->numberFormat}</a>";
                    }else{
                        echo "<a class='dropdown-item' href='".route('operations.debitnote', $debitnote->id)."'>{$debitnote->numberFormat }</a>";
                    }
                }else{
                    echo "<a class='dropdown-item text-danger' href='".route('operations.debitnote', $debitnote->id)."'>{$debitnote->numberFormat }</a>";
                }
            }
            echo "<div class='dropdown-divider'></div>";
        }
    }

    public function prefactures()
    {
        if($this->model->prefactures->isNotEmpty()){
            echo "<span class='dropdown-item'>Prefacturas</span>";
            foreach($this->model->prefactures as $key => $prefacture){
                if(!$prefacture->canceled_at){
                    if($prefacture->invoices->contains(!null)){
                        echo "<a href='".route('operations.prefacture', $prefacture->id)."' class='dropdown-item text-success'> {$prefacture->numberFormat}</a>";
                    }elseif($prefacture->invoices->pluck('canceled_at')->contains(!null)){
                        echo "<a class='dropdown-item text-danger' href='".route('operations.prefacture', $prefacture->id)."'>{$prefacture->numberFormat}</a>";
                    }else{
                        echo "<a class='dropdown-item' href='".route('operations.prefacture', $prefacture->id)."'>{$prefacture->numberFormat }</a>";
                    }
                }else{
                    echo "<a class='dropdown-item text-danger' href='".route('operations.prefacture', $prefacture->id)."'>{$prefacture->numberFormat }</a>";
                }
            }
            echo "<div class='dropdown-divider'></div>";
        }
    }

    public function housebls()
    {
        if($this->model->housebls->isNotEmpty()){
            echo "<span class='dropdown-item'>House B/L</span>";
            foreach($this->model->housebls as $key => $housebl){
                if (!$housebl->canceled_at) {
                    if($housebl->invoices->contains(!null)){
                        echo "<a href='".route('housebls.show', $housebl->id)."' class='dropdown-item text-success'> {$housebl->numberFormat}</a>";
                    }elseif($housebl->invoices->pluck('canceled_at')->contains(!null)){
                        echo "<a class='dropdown-item text-danger' href='".route('housebls.show', $housebl->id)."'>{$housebl->numberFormat}</a>";
                    }else{
                        echo "<a class='dropdown-item' href='".route('housebls.show', $housebl->id)."'>{$housebl->numberFormat }</a>";
                    }
                }else{
                    echo "<a class='dropdown-item text-danger' href='".route('housebls.show', $housebl->id)."'>{$housebl->numberFormat}</a>";
                }
            }
            echo '<div class="dropdown-divider"></div>';
        }
    }

    public function containersGroup()
    {
        $groupBy = $this->model->containers->unique('size')->pluck('size');
        $pluck = $this->model->containers->pluck('size');
        $container = "";
        for ($i=0; $i < count($groupBy); $i++) {
            $count = 0;
            for ($j=0; $j < count($pluck); $j++) {
                if($groupBy[$i] == $pluck[$j])
                {
                    $count++;
                }
            }
            $container = $container.", ".$groupBy[$i]." x ".$count;
        }
        $container = substr($container, 1);

        return $container;
    }
}