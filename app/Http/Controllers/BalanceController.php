<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountManagementBalance;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function index()
    {
    	$balances = AccountManagementBalance::all();

    	return view('balances.index', compact('balances'));
    }

    public function findById($id)
    {
    	$balance = AccountManagementBalance::findOrFail($id);

    	return $balance;
    }

    public function update(Request $request)
    {
    	DB::beginTransaction();

    	$balance = AccountManagementBalance::findOrFail($request->balance_id);
    	$balance->update($request->all());

    	if ($balance) {
    		DB::commit();
    		return back()->with('success', 'La información del balance se guardó correctamente.');
    	} else {
    		DB::rollBack();
    		return back()->with('error', 'Ocurrió un problema al guardar la información del balance.');
    	}
    }
}
