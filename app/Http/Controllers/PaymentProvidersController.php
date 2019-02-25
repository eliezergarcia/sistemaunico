<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\InvoiceProvider;
use App\PaymentProviders;
use App\ExpenseStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = PaymentProviders::withTrashed()->orderBy('fecha_pago', 'desc')->get();
        $expenses = ExpenseStatement::where('template', null)->get();

        $invoices = InvoiceProvider::where('canceled_at', null)->get();

        return view('paymentsproviders.index', compact('payments', 'expenses', 'invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $payment = PaymentProviders::create($request->all());

        $payment->invoices()->attach($request->invoice_id);

        if($payment){
            DB::commit();
            return back()->with('success', 'El pago se registró correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar el pago.');
        }
    }

    public function facturas(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();

        $payment = PaymentProviders::create($request->all());

        $payment->invoices()->attach($request->invoices);

        if (!$request->has('option') && $request->option != "guarantee") {
            foreach ($request->invoices as $id) {
                $invoice = InvoiceProvider::findOrFail($id);
                $invoice->return_day = $request->fecha_pago;
                $invoice->save();
                $option = "sub";
                $invoice->updateAccountManagementBalance($request, $option, $invoice->return_day);
            }
        }

        // dd($request->all());
        if($payment && $invoice){
            DB::commit();
            return 'El pago se registró correctamente.';
        }else{
            DB::rollBack();
            return 'Ocurrió un problema al registrar el pago.';
        }
    }

    public function facturasTotal(Request $request)
    {
        $neto = 0;
        $vat = 0;
        $retention = 0;
        $others = 0;
        $total = 0;
        if($request->invoices){
           foreach ($request->invoices as $invoice_id) {
               $invoice = InvoiceProvider::findOrFail($invoice_id);

                $neto = $neto + $invoice->neto;
                $vat = $vat + $invoice->vat;
                $retention = $retention + $invoice->retention;
                $others = $others + $invoice->others;
                // $total = $total + (($invoice->neto + $invoice->vat + $invoice->others) - $invoice->retention);
                $total = $total + $invoice->sntotal;
           }
        }
        $data['neto'] = number_format($neto, 2, '.', ',');
        $data['vat'] = number_format($vat, 2, '.', ',');
        $data['retention'] = number_format($retention, 2, '.', ',');
        $data['others'] = number_format($others, 2, '.', ',');
        $data['total'] = number_format($total, 2, '.', ',');

       return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = PaymentProviders::findOrFail($id);

        return $payment;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function modificar(Request $request)
    {
        PaymentProviders::findOrFail($request->input('payment_id'))->update($request->all());

        return back()->with('success', 'La información del pago se guardó correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deactivate(Request $request)
    {
        DB::beginTransaction();

        $payment = PaymentProviders::findOrFail($request->input('payment_id'));
        // dd($payment->invoices->toArray());
        foreach ($payment->invoices as $invoice) {
            if ($invoice->return_day != null) {
                $option = "add";
                $invoice->updateAccountManagementBalance($request, $option, $invoice->return_day);
                if ($invoice) {
                    $invoice->return_day = null;
                    $invoice->save();
                }
            }
        }
        $payment->delete();

        if ($payment && $invoice) {
            DB::commit();
            return back()->with('success', 'El pago se canceló correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cancelar el pago.');
        }

    }
}
