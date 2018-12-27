<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionBank extends Model
{
    protected $fillable = ['commission'];

	public function invoices(){
		return $this->belongsToMany(InvoiceProvider::class, 'assigned_commissions_bank');
	}
}
