<?php

namespace App;

use Carbon\Carbon;
use App\Presenters\ClientPresenter;
use App\Presenters\GeneralPresenter;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use GeneralFunctions;

    protected $fillable = [
        'codigo_cliente', 'razon_social', 'rfc', 'numero_interior', 'numero_exterior', 'calle', 'colonia', 'codigo_postal', 'pais', 'estado', 'ciudad', 'municipio', 'telefono1', 'telefono2', 'inactive_at'
    ];

    public function shippers()
    {
    	return $this->belongsToMany(Operation::class, 'shipper', 'id');
    }

    public function creditnotes()
    {
    	return $this->hasMany(CreditNote::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function debitnotes()
    {
        return $this->hasMany(DebitNote::class);
    }

    public function prefactures()
    {
        return $this->hasMany(Prefacture::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'assigned_clients');
    }

    public function payments($balance)
    {
        return $this->hasManyThrough(Payment::class, Invoice::class)->whereDate('payments.created_at', '=', $balance->created_at);
        // $payments = Payment::join("invoices","payments.invoice_id","=","invoices.id")
        //     ->whereDate('payments.created_at','=', $balance->created_at)
        //     ->select('client_id')->distinct()->get();

        // dd($payments->toArray());
    }

    public function present()
    {
      return new ClientPresenter($this);
    }
}
