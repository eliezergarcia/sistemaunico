<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\CreditNotePresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditNote extends Model
{
	protected $fillable = ['client_id', 'folio', 'monto', 'moneda', 'fecha_pago', 'comentarios'];

    use SoftDeletes;

    public function invoice()
    {
    	return $this->belongsTo(Invoice::class);
    }

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function getFechaAttribute()
    {
        return $this->fecha_pago = Carbon::parse($this->fecha_pago)->format('d/m/Y');
    }

    public function present()
    {
        return new CreditNotePresenter($this);
    }
}
