<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseStatement extends Model
{
	protected $guarded = ['expense_id', 'total', 'created_at', 'updated_at'];

    public function solicitadoPor()
    {
        return $this->belongsTo(User::class, 'solicited_by');
    }

    public function getControlCodeAttribute()
    {
    	if ($this->number < 10) {
    		$number = "0".$this->number;
    	} else {
    		$number = $this->number;
    	}

        return substr($this->created_at->format('Ymd')."-".$number, 2);
    }

    public function getTotalAttribute()
    {
    	return number_format(($this->neto + $this->vat + $this->others) - $this->retention, 2, '.', ',');
    }
}