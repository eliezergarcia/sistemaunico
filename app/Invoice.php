<?php

namespace App;

use App\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Presenters\InvoicePresenter;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use GeneralFunctions;

	protected $fillable = ['factura', 'fecha_factura', 'operation_id', 'cliente_id', 'tipo', 'lugar', 'moneda', 'neto', 'iva', 'comentarios', 'canceled_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function debitnotes()
    {
    	return $this->belongsToMany(DebitNote::class, 'assigned_invoices');
    }

    public function prefactures()
    {
    	return $this->belongsToMany(Prefacture::class, 'assigned_invoices');
    }

    public function housebls()
    {
    	return $this->hasMany(Housebl::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function creditnotes()
    {
        return $this->hasMany(CreditNote::class);
    }

    public function getOperadorAttribute()
    {
        $debitnote = $this->debitnotes()->pluck('operation_id');
        $prefacture = $this->prefactures()->pluck('operation_id');

        if($debitnote->isNotEmpty())
        {
            $operation = Operation::findOrFail($debitnote);
            $operador = User::findOrFail($operation->pluck('user_id'));
        }
        else
        {
            $operation = Operation::findOrFail($prefacture);
            $operador = User::findOrFail($operation->pluck('user_id'));
        }
        return $operador->pluck('name')->implode("");
    }

    public function getFechaFacturaFormatAttribute()
    {
        return $this->fecha_factura = Carbon::parse($this->fecha_factura)->format('d-m-Y');
    }

    public function getPagadoAttribute()
    {
        return $this->payments->pluck('monto')->sum();
    }

    public function getTotalAttribute()
    {
        return $this->neto + $this->iva;
    }

    public function present()
    {
        return new InvoicePresenter($this);
    }

    public function assignedInvoices($solicitado, $request)
    {
        if($request->has('debit_note_id')){
            DB::table('assigned_invoices')->insert(['invoice_id' => $this->id, 'debit_note_id' => $solicitado->id]);
        }elseif ($request->has('prefacture_id')) {
            DB::table('assigned_invoices')->insert(['invoice_id' => $this->id, 'prefacture_id' => $solicitado->id]);
        }
    }

    public function markAsReadNotification($solicitado)
    {
        DB::table('notifications')->where('data', 'like', '%'.$solicitado->numberformat.'%')->update(array('read_at' => Carbon::now()));
    }
}
