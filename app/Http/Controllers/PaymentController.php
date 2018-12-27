<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
    *   Muestra el listado de pagos.
    */
    public function index()
    {
        $payments = Payment::withTrashed()->orderBy('fecha_pago', 'desc')->get();

        $invoices = Invoice::where('canceled_at', null)->get();

        return view('payments.index', compact('payments', 'invoices'));
    }

    /**
    *   Crea un nuevo pago.
    */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $payment = Payment::create($request->all());
        $option = "add";
        $payment->updateAccountManagementBalance($request, $option);

        if ($payment) {
            DB::commit();
            return back()->with('success', 'El pago se registró correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar el pago.');
        }
    }

    /**
    *   Busca la información del pago.
    */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return $payment;
    }

    /**
    *   Actualiza la información del pago.
    */
    public function modificar(Request $request)
    {
        DB::beginTransaction();

        $payment = Payment::findOrFail($request->input('payment_id'));
        $payment->update($request->all());
        // $option = "update";
        // $payment->updateAccountManagementBalance($request, $option);

        if ($payment) {
            DB::commit();
            return back()->with('success', 'La información del pago se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información del pago.');
        }
    }

    /**
    *   Cancela el pago.
    */
    public function cancel(Request $request)
    {
        DB::beginTransaction();

        $payment = Payment::findOrFail($request->input('payment_id'));
        $payment->delete();
        $option = "sub";
        $payment->updateAccountManagementBalance($request, $option);

        if ($payment) {
            DB::commit();
            return back()->with('success', 'El pago se canceló correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cancelar el pago.');
        }

    }
}
