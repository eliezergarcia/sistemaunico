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

    public function markAsReadNotificationOA()
    {
        DB::table('notifications')->where('data', 'like', '%'.'OA'.$this->id.'%')->update(array('read_at' => Carbon::now()));
    }

    public function markAsReadNotificationOD()
    {
        DB::table('notifications')->where('data', 'like', '%'.'OD'.$this->id.'%')->update(array('read_at' => Carbon::now()));
    }
}
