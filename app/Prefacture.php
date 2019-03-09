<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Presenters\PrefacturePresenter;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\CreatedPrefacture;

class Prefacture extends Model
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
        return $this->belongsToMany(Concepts::class, 'concepts_operations', 'prefacture_id', 'concept_id');
    }

    public function conceptsoperations(){
        return $this->hasMany(ConceptsOperation::class);
    }

	public function getNumberFormatAttribute()
    {
        if ($this->number < 10) {
            $number = "0".$this->number;
        } else {
            $number = $this->number;
        }

        return "SOLFAC".substr($this->created_at->format('Ymd')."-".$number, 2);
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

    public function getClientLimitAttribute()
    {
        return substr($this->client->razon_social, 0, 16);
    }

    public function getMblLimitAttribute()
    {
        return substr($this->operation->m_bl, 0, 16);
    }

    public function getHblLimitAttribute()
    {
        return substr($this->operation->h_bl, 0, 16);
    }

    public function present()
    {
        return new PrefacturePresenter($this);
    }

    public function createNotificationPrefacture()
    {
        $users = User::all();

        foreach ($users as $user) {
            if($user->roles->pluck('name')->contains('facturador') || $user->roles->pluck('name')->contains('administradorgeneral')){
                $user->notify(new CreatedPrefacture($this));
            }
        }
    }

    public function markAsReadNotificationSOLFAC()
    {
        DB::table('notifications')->where('data', 'like', '%'.'SOLFAC'.$this->controlcode.'%')->update(array('read_at' => Carbon::now()));
    }
}
