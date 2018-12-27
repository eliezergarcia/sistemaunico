<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountProvider extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'provider_id', 'account', 'currency', 'name_bank', 'inactive_at'
    ];

    public function invoices()
    {
    	return $this->belongsToMany(InvoiceProvider::class);
    }
}
