<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Housebl;
use App\Payment;
use Carbon\Carbon;
use App\DebitNote;
use App\Operation;
use App\Prefacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterInvoiceRequest;

class InvoiceController extends Controller
{
    /**
    *   Muestra el listado de facturas de cliente.
    */
    public function index()
    {
        $invoices = Invoice::orderBy('id', 'desc')->get();

        return view('invoices.index', compact('invoices'));
    }

    /**
    *   Crea una nueva factura de cliente.
    */
    public function store(RegisterInvoiceRequest $request)
    {
        DB::beginTransaction();

        if($request->has('debit_note_id')){
            $debitnote = DebitNote::findOrFail($request->input('debit_note_id'));
            $invoice = (new Invoice)->fill($request->all());

            $invoice->operation_id = $debitnote->operation_id;
            $invoice->client_id = $debitnote->client_id;
            $invoice->tipo = $debitnote->operation->impo_expo;
            $invoice->lugar = "MTY";

            $invoice->save();
            $invoice->assignedInvoices($debitnote, $request);
            $invoice->markAsReadNotification($debitnote);

        }elseif ($request->has('prefacture_id')) {
            $prefacture = Prefacture::findOrFail($request->input('prefacture_id'));
            $invoice = (new Invoice)->fill($request->all());

            $invoice->operation_id = $prefacture->operation_id;
            $invoice->client_id = $prefacture->client_id;
            $invoice->tipo = $prefacture->operation->impo_expo;
            $invoice->lugar = "MTY";

            $invoice->save();
            $invoice->save();
            $invoice->assignedInvoices($prefacture, $request);
            $invoice->markAsReadNotification($prefacture);
        }

        if ($invoice) {
            DB::commit();
            return back()->with('success', 'La factura se registró correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar la factura.');
        }
    }

    /**
    *   Muestra la información de la factura.
    */
    public function show($id)
    {
        $invoice = Invoice::where('factura', $id)->first();

        $payments = Payment::where('invoice_id', $invoice->id)->get();

        if($invoice->debitnotes->isNotEmpty()){
            $solicitado = DebitNote::findOrFail($invoice->debitnotes->first()->id);
        }else{
            $solicitado = Prefacture::findOrFail($invoice->prefactures->first()->id);
        }

        $operation = Operation::findOrFail($solicitado->operation_id);

        return view('invoices.show', compact('invoice', 'payments', 'solicitado', 'operation'));
    }

    /**
    *   Busca la información de la factura.
    */
    public function findById($id)
    {
        $invoice = Invoice::findOrFail($id);
        $pagado = $invoice->payments->pluck('monto')->sum();

        $data['invoice'] = $invoice;
        $data['pagado'] = $pagado;

        return $data;
    }

    /**
    *   Actualiza la información de la factura.
    */
    public function modificar(Request $request)
    {
        DB::beginTransaction();

        $invoice = Invoice::findOrFail($request->input('invoice_id'));
        $invoice->update($request->all());

        if ($invoice) {
            DB::commit();
            return redirect()->route('facturas.show', $invoice->factura)->with('success', 'La información de la factura se guardó correctamente.');
        } else {
            DB::rollBack();
            return redirect()->route('facturas.show', $invoice->factura)->with('error', 'Ocurrió un problema al guardar la información de la factura.');
        }
    }

    /**
    *   Cancela la factura.
    */
    public function cancel(Request $request)
    {
        DB::beginTransaction();

        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice->canceled();

        if ($invoice) {
            DB::commit();
            return back()->with('success', 'La factura se canceló correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema la cancelar la factura.');
        }


    }
}
