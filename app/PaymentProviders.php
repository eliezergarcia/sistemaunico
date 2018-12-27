<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentProviders extends Model
{
	protected $fillable = ['monto', 'fecha_pago', 'comentarios'];

	use SoftDeletes;

	public function invoices(){
		return $this->belongsToMany(InvoiceProvider::class, 'assigned_payments_providers');
	}
}
