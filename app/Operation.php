<?php

namespace App;

use App\Client;
use Carbon\Carbon;
use App\ConceptsOperations;
use App\Presenters\OperationPresenter;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{

    protected $fillable = ['user_id', 'shipper', 'master_consignee', 'house_consignee', 'etd', 'eta', 'impo_expo', 'pol', 'pod', 'destino', 'incoterm', 'booking', 'custom_cutoff', 'vessel', 'o_f', 'c_invoice', 'm_bl', 'h_bl', 'cntr', 'type', 'size', 'qty', 'weight_measures', 'modalidad', 'aa', 'recibir', 'revision', 'mandar', 'revalidacion', 'toca_piso', 'booking_expo', 'conf_booking', 'prog_recoleccion', 'recoleccion', 'llegada_puerto', 'cierre_documental', 'pesaje', 'ingreso', 'despacho', 'zarpe', 'envio_papelera'];


    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getContainersAttribute()
    {
        $containers = Container::where('operation_id', $this->id)->where('canceled_at', null)->get();

        return $containers;
    }

    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    public function debitnotes()
    {
        return $this->hasMany(DebitNote::class);
    }

    public function prefactures()
    {
        return $this->hasMany(Prefacture::class);
    }

    public function concepts()
    {
        return $this->belongsToMany(Concepts::class, 'concepts_operations', 'operation_id', 'concept_id');
    }

    public function housebls()
    {
        return $this->hasMany(Housebl::class);
    }

    public function invoicesproviders()
    {
        return $this->hasMany(InvoiceProvider::class);
    }

    public function invoicesclients()
    {
        return $this->hasMany(Invoice::class);
    }

    public function present()
    {
        return new OperationPresenter($this);
    }

    public function getShipAttribute()
    {
        $ship = Client::findOrFail($this->shipper);

        return $ship;
    }

    public function getMasterAttribute()
    {
        $master = Client::findOrFail($this->master_consignee);

        return $master;
    }

    public function getHouseAttribute()
    {
        $house = Client::findOrFail($this->house_consignee);

        return $house;
    }

    public function getEtdFormatAttribute()
    {
        return $this->etd = Carbon::parse($this->etd)->format('d-m-Y');
    }

    public function getEtaFormatAttribute()
    {
        return $this->eta = Carbon::parse($this->eta)->format('d-m-Y');
    }

    public function getCustomCutoffFormatAttribute()
    {
        if ($this->custom_cutoff != null) {
            return $this->custom_cutoff = Carbon::parse($this->custom_cutoff)->format('d-m-Y');
        }
    }

    public function setEtdAttribute($etd)
    {
        $this->attributes['etd'] = Carbon::parse($etd)->format('Y-m-d');
    }

    public function setEtaAttribute($eta)
    {
        $this->attributes['eta'] = Carbon::parse($eta)->format('Y-m-d');
    }

    public function setCustomCutoffAttribute($custom_cutoff)
    {
        $this->attributes['custom_cutoff'] = Carbon::parse($custom_cutoff)->format('Y-m-d');
    }

    function createOperation($request)
    {
        $this->user_id = auth()->user()->id;

        $c_invoice = collect();
        for ($i=0; $i < count($request->input('c_invoice')); $i++) {
            $c_invoice->push($request->input('c_invoice')[$i]);
        }

        $h_bl = collect();
        for ($i=0; $i < count($request->input('h_bl')); $i++) {
            $h_bl->push($request->input('h_bl')[$i]);
        }

        $this->c_invoice = $c_invoice->flatten()->implode(' // ');
        $this->h_bl = $h_bl->flatten()->implode(' // ');

        $this->save();
    }
}
