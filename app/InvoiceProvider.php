<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\InvoiceProviderPresenter;
use App\Notifications\RevisionInvoiceProvider;
use App\Notifications\AuthorizeInvoiceProvider;

class InvoiceProvider extends Model
{
    use GeneralFunctions;

    protected $fillable = ['control_code', 'factura', 'operation_id', 'provider_id', 'invoice_date', 'expense_tipe', 'neto', 'vat', 'retention', 'others', 'expense_description', 'client_id', 'account_provider_id', 'm_bl', 'h_bl', 'eta', 'priority', 'notes', 'guarantee_request', 'advance_request', 'canceled_at'];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function payments(){
        return $this->belongsToMany(PaymentProviders::class, 'assigned_payments_providers');
    }

    public function conceptsinvoice()
    {
        return $this->hasMany(ConceptsInvoiceProviders::class, 'invoice_id');
    }

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function commissions(){
        return $this->hasMany(InvoiceProvider::class, CommissionBank::class, 'assigned_commissions_bank');
    }

    public function account()
    {
        $account = AccountProvider::findOrFail($this->account_provider_id);

        return $account;
    }

    public function present()
    {
        return new InvoiceProviderPresenter($this);
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

    public function getRegDateAttribute()
    {
        return $this->created_at->format('d-m-y');
    }

    public function getEtaFormatAttribute()
    {
        return \DateTime::createFromFormat('d/m/Y', $this->eta);
    }

    public function getAutFinanzasAttribute()
    {
        if ($this->aut_fin != null) {
            return $this->aut_fin = Carbon::parse($this->aut_fin)->format('d-m-Y');
        }

        return "";
    }

    public function getTotalAttribute()
    {
    	$total = ($this->neto + $this->vat + $this->others) - $this->retention;

    	return number_format($total, 2, '.', ',');
    }

    public function getPagadoAttribute()
    {
        if($this->payments->pluck('monto')->sum() >= $this->total){
            return true;
        }

        return false;
    }

    public function getPendienteAttribute()
    {
        $pendiente = (($this->neto + $this->vat + $this->others) - $this->retention) - $this->payments->pluck('monto')->sum();

        return number_format($pendiente, 2, '.', ',');
    }

    public function createConceptsInvoiceProviders($request)
    {
        if($request->has('conceptsinvoices'))
        {
            for ($i=0; $i < count($request->input('conceptsinvoices')); $i++) {
                $concepts = new ConceptsInvoiceProviders();
                $idconcept = $request->input('conceptsinvoices')[$i];
                $rateconcept = $request->input('rates')[$idconcept-1];

                $iva = 0;
                if($request->has('ivaconceptinvoices'))
                {
                    for ($j=0; $j < count($request->input('ivaconceptinvoices')); $j++) {
                        if ($request->input('ivaconceptinvoices')[$j] == $idconcept) {
                            $iva = 0.16;
                        }
                    }
                }

                $ivaconcept = $rateconcept * $iva;
                $qtyconcept = $request->input('qty')[$idconcept-1];
                $foreignconcept = ($rateconcept + $ivaconcept) * $qtyconcept;

                $concepts->operation_id = $request->operation_id;
                $concepts->invoice_id = $this->id;
                $concepts->concept_id = $idconcept;
                $concepts->rate = $rateconcept;
                $concepts->iva = $ivaconcept;
                $concepts->qty = $qtyconcept;
                $concepts->foreign = $foreignconcept;
                $concepts->save();
            }
        }

        if($request->has('conceptsguarantee'))
        {
            for ($i=0; $i < count($request->input('conceptsguarantee')); $i++) {
                $concepts = new ConceptsInvoiceProviders();
                $idconcept = $request->input('conceptsguarantee')[$i];
                $rateconcept = $request->input('rates')[$idconcept-1];

                $iva = 0;
                if($request->has('ivaconceptguarantee'))
                {
                    for ($j=0; $j < count($request->input('ivaconceptguarantee')); $j++) {
                        if ($request->input('ivaconceptguarantee')[$j] == $idconcept) {
                            $iva = 0.16;
                        }
                    }
                }

                $ivaconcept = $rateconcept * $iva;
                $qtyconcept = $request->input('qty')[$idconcept-1];
                $foreignconcept = ($rateconcept + $ivaconcept) * $qtyconcept;

                $concepts->operation_id = $request->operation_id;
                $concepts->invoice_id = $this->id;
                $concepts->concept_id = $idconcept;
                $concepts->rate = $rateconcept;
                $concepts->iva = $ivaconcept;
                $concepts->qty = $qtyconcept;
                $concepts->foreign = $foreignconcept;
                $concepts->save();
            }
        }

        if($request->has('conceptsadvance'))
        {
            for ($i=0; $i < count($request->input('conceptsadvance')); $i++) {
                $concepts = new ConceptsInvoiceProviders();
                $idconcept = $request->input('conceptsadvance')[$i];
                $rateconcept = $request->input('rates')[$idconcept-1];

                $iva = 0;
                if($request->has('ivaconceptadvance'))
                {
                    for ($j=0; $j < count($request->input('ivaconceptadvance')); $j++) {
                        if ($request->input('ivaconceptadvance')[$j] == $idconcept) {
                            $iva = 0.16;
                        }
                    }
                }

                $ivaconcept = $rateconcept * $iva;
                $qtyconcept = $request->input('qty')[$idconcept-1];
                $foreignconcept = ($rateconcept + $ivaconcept) * $qtyconcept;

                $concepts->operation_id = $request->operation_id;
                $concepts->invoice_id = $this->id;
                $concepts->concept_id = $idconcept;
                $concepts->rate = $rateconcept;
                $concepts->iva = $ivaconcept;
                $concepts->qty = $qtyconcept;
                $concepts->foreign = $foreignconcept;
                $concepts->save();
            }
        }
    }

    public function createNotificationAuthorizeInvoiceProvider()
    {
        $users = User::all();

        foreach ($users as $user) {
            if(($user->roles->pluck('name')->contains('administrador') && $user->roles->pluck('name')->contains('operador')) || $user->roles->pluck('name')->contains('administradorgeneral')){
                $user->notify(new AuthorizeInvoiceProvider($this));
            }
        }
    }

    public function createNotificationRevisionInvoiceProvider()
    {
        $users = User::all();

        foreach ($users as $user) {
            if($user->roles->pluck('name')->contains('finanzas') || $user->roles->pluck('name')->contains('administradorgeneral')){
                $user->notify(new RevisionInvoiceProvider($this));
            }
        }
    }

    public function markAsReadNotification()
    {
        if ($this->guarantee_request != null) {
            DB::table('notifications')->where('data', 'like', '%'.'AG'.$this->controlcode.'%')->update(array('read_at' => Carbon::now()));
        }
        if ($this->advance_request != null) {
            DB::table('notifications')->where('data', 'like', '%'.'AA'.$this->controlcode.'%')->update(array('read_at' => Carbon::now()));
        }
        if ($this->factura != null) {
            DB::table('notifications')->where('data', 'like', '%'.'AF'.$this->controlcode.'%')->update(array('read_at' => Carbon::now()));
        }
    }

    public function markAsReadNotificationRV()
    {
        // if ($this->guarantee_request != null && $this->factura == null) {
        //     DB::table('notifications')->where('data', 'like', '%'.'AG'.$this->controlcode.'%')->update(array('read_at' => Carbon::now()));
        // }
        // if ($this->advance_request != null && $this->factura == null) {
        //     DB::table('notifications')->where('data', 'like', '%'.'AA'.$this->controlcode.'%')->update(array('read_at' => Carbon::now()));
        // }
        // if ($this->factura != null) {
            DB::table('notifications')->where('data', 'like', '%'.'RV'.$this->controlcode.'%')->update(array('read_at' => Carbon::now()));
        // }
    }

    public function updateAccountManagementBalance($request, $option, $autFin)
    {
        if ($request->has('balanceday')) {
            if ($request->balanceday == 2) {
                $date = Carbon::now();
                $date = $date->addDay(1);
                while ($date->isWeekend()) {
                    $date = $date->addDay(1);
                }
            } else {
                $date = Carbon::now();
            }
            $created = $date;
            $balance = AccountManagementBalance::whereDate('created_at', '=', $date)->get();
            if($balance->isEmpty())
            {
                while ($balance->isEmpty()) {
                    $newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
                    $newdate = date ( 'Y-m-d' , $newdate );
                    $balance = AccountManagementBalance::whereDate('created_at', '=', $newdate)->get();
                    $date = $newdate;
                }
                $balance = $balance->toArray();
                $accountmanagementbalance = AccountManagementBalance::create([
                    'mxn' => $balance[0]['mxn'],
                    'usd' => $balance[0]['usd'],
                    'debit' => $balance[0]['debit']
                ]);

                $accountmanagementbalance->update([
                    'created_at' => $created,
                    'updated_at' => $created
                ]);
            }
        }

        $autFin = Carbon::parse($this->aut_fin)->format('Y-m-d');
        $balances = AccountManagementBalance::whereDate('created_at', '>=', $autFin)->get();
        foreach ($balances as $balance) {
            if($option == "add"){
                if($this->account()->currency == "MXN"){
                    $balanceUpdate = AccountManagementBalance::find($balance->id);
                    $balanceUpdate->update([
                        'mxn' => $balanceUpdate->mxn - (($this->neto + $this->vat + $this->others) - $this->retention)
                    ]);
                }else{
                    $balanceUpdate = AccountManagementBalance::find($balance->id);
                    $balanceUpdate->update([
                        'usd' => $balanceUpdate->usd - (($this->neto + $this->vat + $this->others) - $this->retention)
                    ]);
                }
            }elseif($option == "sub"){
                if($this->account()->currency == "MXN"){
                    $balanceUpdate = AccountManagementBalance::find($balance->id);
                    $balanceUpdate->update([
                        'mxn' => $balanceUpdate->mxn + (($this->neto + $this->vat + $this->others) - $this->retention)
                    ]);
                }else{
                    $balanceUpdate = AccountManagementBalance::find($balance->id);
                    $balanceUpdate->update([
                        'usd' => $balanceUpdate->usd + (($this->neto + $this->vat + $this->others) - $this->retention)
                    ]);
                }
            }
        }
    }
}
