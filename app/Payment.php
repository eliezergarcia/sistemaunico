<?php

namespace App;

use Carbon\Carbon;
use App\Presenters\PaymentPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
	protected $fillable = ['invoice_id', 'monto', 'fecha_pago', 'comentarios'];

    use SoftDeletes;

    public function invoice()
    {
    	return $this->belongsTo(Invoice::class);
    }

    public function present()
    {
    	return new PaymentPresenter($this);
    }

    public function updateAccountManagementBalance($request, $option)
    {
        $date = Carbon::now();
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
        }
        $balances = AccountManagementBalance::whereDate('created_at', '>=', $date)->get();
        foreach ($balances as $balance) {
            if($option == "add"){
                if($this->invoice->moneda == "MXN"){
                    $balanceUpdate = AccountManagementBalance::find($balance->id);
                    $balanceUpdate->update([
                        'mxn' => $balanceUpdate->mxn + $request->monto
                    ]);
                }else{
                    $balanceUpdate = AccountManagementBalance::find($balance->id);
                    $balanceUpdate->update([
                        'usd' => $balanceUpdate->usd + $request->monto
                    ]);
                }
            }elseif($option == "sub"){
                if($this->invoice->moneda == "MXN"){
                    $balanceUpdate = AccountManagementBalance::find($balance->id);
                    $balanceUpdate->update([
                        'mxn' => $balanceUpdate->mxn - $this->monto
                    ]);
                }else{
                    $balanceUpdate = AccountManagementBalance::find($balance->id);
                    $balanceUpdate->update([
                        'usd' => $balanceUpdate->usd - $this->monto
                    ]);
                }
            }
        }
        // dd($balance);
        // dd($this->toArray());
        // dd($this->toArray());
    }

    public function client()
    {
        return Client::findOrFail($this)->first();
    }
}
