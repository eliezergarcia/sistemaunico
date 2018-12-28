<?php

namespace App;

use Carbon\Carbon;
use App\Presenters\DebitNotePresenter;
use App\Notifications\CreatedDebitNote;
use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{
    use GeneralFunctions;

 	protected $fillable = [
        'operation_id', 'client_id', 'priority'
    ];

	public function operation()
	{
		return $this->belongsTo(Operation::class);
	}

	public function invoices()
	{
		return $this->belongsToMany(Invoice::class, 'assigned_invoices');
	}

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function concepts()
    {
        return $this->hasMany(Concepts::class);
    }

    public function conceptsoperations(){
        return $this->hasMany(ConceptsOperation::class);
    }

    public function present()
    {
        return new DebitNotePresenter($this);
    }

	public function getNumberFormatAttribute()
    {
        if ($this->number < 10) {
            $number = "0".$this->number;
        } else {
            $number = $this->number;
        }

        return "ULMX".substr($this->created_at->format('Ymd')."-".$number, 2);
    }

    public function getFechaAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function getInvoicePaymentsAttribute()
    {
        $payments = Payment::where('invoice_id', ($this->invoices->first()->id))->get();

        return $payments;
    }

    public function getRateTotalAttribute()
    {
        $ratetotal = 0;
        foreach($this->conceptsoperations as $key => $concept){
            $ratetotal = $ratetotal + ($concept->rate * $concept->qty);
        }
        return number_format($ratetotal ,2,".","");
    }

    public function getIvaTotalAttribute()
    {
        $ivatotal = 0;
        foreach($this->conceptsoperations as $key => $concept){
            $ivatotal = $ivatotal + ($concept->iva * $concept->qty);
        }
        return number_format($ivatotal ,2,".","");
    }

    public function getForeignTotalAttribute()
    {
        $foreigntotal = 0;
        foreach($this->conceptsoperations as $key => $concept){
            $foreigntotal = $foreigntotal + ($concept->rate * $concept->qty) + ($concept->iva * $concept->qty);
        }
        return number_format($foreigntotal ,2,".","");
    }

    public function createNotificationDebitNote()
    {
        $users = User::all();

        foreach ($users as $user) {
            if($user->roles->pluck('name')->contains('facturador') || $user->roles->pluck('name')->contains('administradorgeneral')){
                $user->notify(new CreatedDebitNote($this));
            }
        }
    }
}
