<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use App\DebitNote;
use App\CreditNote;
use Illuminate\Http\Request;

class AccountStatementsController extends Controller
{
    public function facturacion()
    {
    	$clients = Client::orderBy('codigo_cliente', 'asc')->get();

        return view('accountstatements.facturacion', compact('clients'));
    }

    public function debitnotes()
    {
        $clients = Client::orderBy('codigo_cliente', 'asc')->get();

        return view('accountstatements.debitnotes', compact('clients'));
    }

    public function facturacion_generar(Request $request)
    {
    	$invoices = Invoice::where('client_id', $request->client_id)
    						->where('canceled_at', null)
    						->where('fecha_factura', '>=', $request->input('fecha_inicio'))
    						->where('fecha_factura', '<=', $request->input('fecha_fin'))->get();

    	$client = Client::findOrFail($request->client_id);

    	$creditnotes = CreditNote::where('client_id', $request->client_id)
                                ->where('fecha_pago', '>=', $request->input('fecha_inicio'))
                                ->where('fecha_pago', '<=', $request->input('fecha_fin'))->get();

    	return view('accountstatements.facturacion_show', compact('invoices', 'client', 'creditnotes'))->with('status', $request->input('tipo'));
    }

    public function debitnotes_generar(Request $request)
    {
        $debitnotes = DebitNote::where('client_id', $request->client_id)->get();

        $client = Client::findOrFail($request->client_id);

        return view('accountstatements.debitnotes_show', compact('debitnotes', 'client'));
    }
}
