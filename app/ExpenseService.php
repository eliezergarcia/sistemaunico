<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ExpenseServicePresenter;

class ExpenseService extends Model
{
	use GeneralFunctions;

    protected $fillable = ['numero_usuario', 'servicio', 'concepto_pago', 'inactive_at'];

    public function present()
    {
    	return new ExpenseServicePresenter($this);
    }

    public function expensesPerMonth($month)
    {
    	$expenses = ExpenseStatement::where('description', $this->servicio)->where('template', null)->where('canceled_at', null)->whereMonth('invoice_date', $month)->get();

    	$total = 0;
    	foreach ($expenses as $expense) {
    		$total = $total + (($expense->neto + $expense->vat + $expense->others) - $expense->retention);
     	}

    	return $total;
    }
}
