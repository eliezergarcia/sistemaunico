<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConceptsInvoiceProviders extends Model
{
	protected $fillable = ['concept_id', 'operation_id', 'invoice_id', 'rate', 'iva', 'qty', 'foreign'];

	public function invoice()
	{
		return $this->belongsTo(InvoiceProvider::class);
	}

	public function concept()
    {
    	return $this->belongsTo(ConceptsProviders::class);
    }
}
