<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\ExpenseStatementPresenter;

class ExpenseStatement extends Model
{
    use GeneralFunctions;

	protected $guarded = ['expense_id', 'total', 'created_at', 'updated_at', 'canceled_at'];

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

    public function getCreatedAtFormatAttribute()
    {
        $meses = array("ene","feb","mar","abril","mayo","jun","jul","ago","sep","oct","nov","dic");
        $fecha = Carbon::parse($this->created_at);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . '-' . $mes;
    }

    public function present()
    {
      return new ExpenseStatementPresenter($this);
    }
}
