<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\AccountProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountProviderController extends Controller
{
    /**
    *   Crea una nueva cuenta de proveedor.
    */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $account = AccountProvider::create($request->all());

        if ($account) {
            DB::commit();
            return back()->with('success', 'La cuenta se registró correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar la cuenta de banco.');
        }
    }

    /**
    *   Busca la información de la cuenta.
    */
    public function findById($id)
    {
        $account = AccountProvider::findOrFail($id);

        return $account;
    }

    /**
    *   Actualiza la información de la cuenta.
    */
    public function update(Request $request)
    {
        DB::beginTransaction();

        $account = AccountProvider::findOrFail($request->input('account_id'));
        $account->update($request->all());

        if ($account) {
            DB::commit();
            return back()->with('success', 'La información de la cuenta se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información de la cuenta.');
        }
    }

    /**
    *   Activa la cuenta.
    */
    public function activate(Request $request)
    {
        // return $request->all();
        AccountProvider::withTrashed()->findOrFail($request->account_id)->update(['inactive_at' => null]);

        return back()->with('success', 'La cuenta se activó correctamente.');
    }

    /**
    *   Desactiva la cuenta.
    */
    public function deactivate(Request $request)
    {
        AccountProvider::findOrFail($request->account_id)->update(['inactive_at' => Carbon::now()]);

        return back()->with('success', 'La cuenta se desactivó correctamente.');
    }
}
