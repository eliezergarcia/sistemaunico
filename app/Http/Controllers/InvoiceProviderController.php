<?php

namespace App\Http\Controllers;

use App\Client;
use App\Provider;
use Carbon\Carbon;
use App\CommissionBank;
use App\InvoiceProvider;
use App\ExpenseStatement;
use Illuminate\Http\Request;
use App\ConceptsInvoiceProviders;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterInvoiceProviderRequest;

class InvoiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = InvoiceProvider::where('factura', '!=', null)->get();

        $clients = Client::where('inactive_at', null)->get();
        $providers = Provider::where('inactive_at', null)->get();

        return view('invoicesproviders.index', compact('invoices', 'clients', 'providers'));
    }

    public function guaranteerequests()
    {
        $invoices = InvoiceProvider::where('guarantee_request', '!=', null)
                                   ->where('factura', null)->get();

        $clients = Client::where('inactive_at', null)->get();
        $providers = Provider::where('inactive_at', null)->get();

        return view('invoicesproviders.guaranteerequestindex', compact('invoices', 'clients', 'providers'));
    }

    public function advancerequests()
    {
        $invoices = InvoiceProvider::where('advance_request', '!=', null)
                                   ->where('factura', null)->get();

        $clients = Client::where('inactive_at', null)->get();
        $providers = Provider::where('inactive_at', null)->get();

        return view('invoicesproviders.advancerequestindex', compact('invoices', 'clients', 'providers'));
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
        // dd($request->all());
        DB::beginTransaction();

        $fecha = ExpenseStatement::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->whereNull('template')->orderBy('id', 'desc')->limit(1)->first();
        $fecha2 = InvoiceProvider::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->first();

        dd($fecha2->number);
        dd($fecha->number);
        if($fecha || $fecha2)
        {
            $invoice = (new InvoiceProvider)->fill($request->all());
            if ($fecha != null && $fecha2 != null) {
                if ($fecha->number > $fecha2->number) {
                    $invoice->number = ($fecha->number) + 1;
                } else {
                    $invoice->number = ($fecha2->number) + 1;
                }
            } elseif ($fecha == null) {
                $invoice->number = ($fecha2->number) + 1;
            } elseif ($fecha2 == null) {
                $invoice->number = ($fecha->number) + 1;
            }
        }else{
            $invoice = (new InvoiceProvider)->fill($request->all());
            $invoice->number = 1;
        }

        $invoice->save();

        $invoice->createConceptsInvoiceProviders($request);

        $invoice->createNotificationAuthorizeInvoiceProvider();

        if ($invoice->guarantee_request == null && $invoice->advance_request == null) {
            $mensaje = "La factura se registró correctamente.";
        } elseif ($invoice->guarantee_request != null) {
            $mensaje = "La solicitud de garantía se registró correctamente.";
        } elseif ($invoice->advance_request != null) {
            $mensaje = "La solicitud de anticipo se registró correctamente.";
        }


        if ($invoice) {
            DB::commit();
            return back()->with('success', $mensaje);
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar la información.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);

        $invoice = InvoiceProvider::where('factura', $id)->first();

        $providers = Provider::where('inactive_at', null)->get();

        return view('invoicesproviders.show', compact('invoice', 'providers'));
    }

    public function buscar($id)
    {
        $invoice = InvoiceProvider::findOrFail($id);
        $pagado = $invoice->payments->pluck('monto')->sum();

        $data['invoice'] = $invoice;
        $data['pagado'] = $pagado;

        return $data;
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
        // return $request->all();

        InvoiceProvider::findOrFail($request->input('invoice_id'))->update($request->all());

        return back()->with('success', 'La información de la factura se guardó correctamente.');
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

        $invoice = InvoiceProvider::findOrFail($request->invoice_id);
        $invoice->canceled();
        $invoice->markAsReadNotification();
        $invoice->markAsReadNotificationRV();

        if($invoice){
            DB::commit();
            return back()->with('success', 'La factura se canceló correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cancelar la factura.');
        }

    }

    public function authorizeInvoice(Request $request)
    {
        DB::beginTransaction();

        $invoice = InvoiceProvider::findOrFail($request->invoice_id);
        $invoice->aut_oper = Carbon::now();
        $invoice->save();

        $invoice->markAsReadNotification();

        // if (($invoice->guarantee_request != null || $invoice->advance_request != null) && $invoice->factura == null) {
        // } else {
            $invoice->createNotificationRevisionInvoiceProvider();
        // }



        if ($invoice) {
            DB::commit();
            return back()->with('success', 'La factura se autorizó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al autorizar la factura.');
        }

    }

    public function revisionInvoice(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        if ($request->commission != 0) {
            $commission = CommissionBank::create($request->all());
            $commission->invoices()->attach($request->invoices);
        }
        // dd($commission);

        foreach ($request->invoices as $id) {
            $invoice = InvoiceProvider::findOrFail($id);
            if($request->balanceday == 2){
                $date = Carbon::now();
                $date = $date->addDay(1);
                while ($date->isWeekend()) {
                    $date = $date->addDay(1);
                }
            }else{
                $date = Carbon::now();
            }
            $invoice->aut_fin = $date;
            $invoice->save();
            $invoice->markAsReadNotificationRV();
            $option = "add";
            $invoice->updateAccountManagementBalance($request, $option, $invoice->aut_fin);
        }

        if ($invoice) {
            DB::commit();
            return 'La revisión de facturas se generó correctamente.';
        } else {
            DB::rollBack();
            return 'Ocurrió un problema al generar la revisón de facturas.';
        }
    }

    public function cancelRevision(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        $invoice = InvoiceProvider::findOrFail($request->invoice_id);
        $option = "sub";
        $invoice->updateAccountManagementBalance($request, $option, $invoice->aut_fin);
        if ($invoice) {
            $invoice->aut_fin = null;
            $invoice->save();
        }

        if ($invoice) {
            DB::commit();
             return back()->with('success', 'La revisión de la factura se canceló correctamente.');
        } else {
            DB::rollBack();
             return back()->with('error', 'Ocurrió un problema al cancelar la revisón de facturas.');
        }
    }

    public function notes(Request $request, $id)
    {
        DB::beginTransaction();

        $invoice = InvoiceProvider::findOrFail($id);
        $invoice->notes = $request->note;
        $invoice->save();

        if ($invoice) {
            DB::commit();
            return back()->with('success', 'La nota se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la nota.');
        }
    }
}
