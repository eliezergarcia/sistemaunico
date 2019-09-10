<?php

namespace App;

use App\Operation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Presenters\ContainerPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'operation_id', 'cntr', 'seal_no', 'type', 'size', 'qty', 'modalidad', 'weight', 'measures','proforma', 'pago_proforma', 'solicitud_transporte', 'despachado_puerto', 'port_etd', 'dlv_day', 'factura_unmx', 'fecha_factura', 'canceled_at'
    ];

    public function operation()
    {
    	return $this->belongsTo(Operation::class);
    }

    public function housebl()
    {
    	return $this->belongsToMany(Housebl::class);
    }

    public function present()
    {
        return new ContainerPresenter($this);
    }

    public function getProformaFormatAttribute()
    {
        return $this->proforma = Carbon::parse($this->proforma)->format('d-m-Y');
    }

    public function getPagoproformaFormatAttribute()
    {
        return $this->pago_proforma = Carbon::parse($this->pago_proforma)->format('d-m-Y');
    }

    public function getSolicitudtransporteFormatAttribute()
    {
        return $this->solicitud_transporte = Carbon::parse($this->solicitud_transporte)->format('d-m-Y');
    }

    public function getDespachadopuertoFormatAttribute()
    {
        return $this->despachado_puerto = Carbon::parse($this->despachado_puerto)->format('d-m-Y');
    }

    public function getPortetdFormatAttribute()
    {
        return $this->port_etd = Carbon::parse($this->port_etd)->format('d-m-Y');
    }

    public function getDlvdayFormatAttribute()
    {
        return $this->dlv_day = Carbon::parse($this->dlv_day)->format('d-m-Y');
    }

    public function markAsReadNotificationOA()
    {
        DB::table('notifications')->where('data', 'like', '%'.'OA'.$this->id.'%')->update(array('read_at' => Carbon::now()));
    }

    public function markAsReadNotificationOD()
    {
        DB::table('notifications')->where('data', 'like', '%'.'OD'.$this->id.'%')->update(array('read_at' => Carbon::now()));
    }
}
