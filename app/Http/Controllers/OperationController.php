<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Role;
use App\Client;
use App\Provider;
use App\Concepts;
use App\Operation;
use App\DebitNote;
use App\Container;
use Carbon\Carbon;
use App\Prefacture;
use App\InvoiceProvider;
use App\ConceptsOperation;
use App\ConceptsProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Requests\RegisterOperationRequest;
use App\Http\Requests\UpdateOperationRequest;

class OperationController extends Controller
{
    /**
    *   Muestra el listado de las operaciones.
    *   Muestra el listado de clientes.
    */
    public function index()
    {
        if(auth()->user()->present()->isAdmin()){
            $operations = Operation::orderBy('id', 'desc')->get();
        }else{
            $operations = Operation::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        }

        $clients = Client::where('inactive_at', null)->get();

        return view('operations.index', compact('operations', 'clients'));
    }

    /**
    *   Crea una nueva operación.
    */
    public function store(RegisterOperationRequest $request)
    {
        DB::beginTransaction();

        $operation = (new Operation)->fill($request->except(['c_invoice', 'h_bl']));
        $operation->createOperation($request);

        if ($operation) {
            DB::commit();
            return back()->with('success', 'La operación se registró correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar la operación.');
        }

    }

    /**
    *   Muestra la información de la operación.
    */
    public function show($id)
    {
        $operation = Operation::findOrFail($id);

        $containers = Container::where('operation_id', $id)->get();

        $concepts = Concepts::where('inactive_at', '=', null)->get();

        $conceptsinvoices = ConceptsProviders::where('inactive_at', '=', null)->get();

        $clients = Client::where('inactive_at', '=', null)->get();;

        $providers = Provider::where('inactive_at', '=', null)->get();;

        return view('operations.show', compact('operation', 'containers', 'concepts', 'conceptsoperation', 'conceptsinvoices', 'clients', 'providers'));
    }

    /**
    *   Actualiza la información de la operación.
    */
    public function update(UpdateOperationRequest $request, $id)
    {
        DB::beginTransaction();

        $operation = Operation::findOrFail($id)->update($request->all());

        if ($operation) {
            DB::commit();
            return back()->with('success', 'La información de la operación se guardó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información de la operación.');
        }

    }

    /**
    *   Actualiza el status de la operación.
    */
    public function update_status(Request $request, $id)
    {
        DB::beginTransaction();

        $operation = Operation::findOrFail($id)->update($request->all());

        if ($operation) {
            DB::commit();
            return back()->with('success', 'La información del status se guardó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar el status.');
        }
    }

    /**
    *   Muestra la información de el debit note.
    */
    public function debitnote($id)
    {
        $debitnote = DebitNote::with(['operation', 'conceptsoperations'])->findOrFail($id);

        return view('operations.pdf.debitnote', compact('debitnote'));

        // $pdf = PDF::loadView('operations.pdf.debitnote', compact('debitnote'));
        // return $pdf->stream();

        // $pdf = new PDF();
        // $pdf = PDF::loadView('operations.pdf', compact('debitnote'));
        // return \PDF::loadFile('http://www.github.com')->stream('github.pdf');
        // $pdf = \App::make('operations.pdf', compact('debitnote'));
        // $pdf->loadHTML($this);
        // $pdf = PDF::loadHTML('operations.pdf', compact('debitnote'));
        // $pdf->save('operations.pdf', compact('debitnote'));
        // $pdf->render();
        // return $pdf->stream();
        // $dompdf->loadView('operations.pdf.debitnote', compact('debitnote'));

        // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        // $dompdf->render();

        // Output the generated PDF to Browser
        // $dompdf->stream();
    }

    /**
    *   Muestra la información de la prefactura.
    */
    public function prefactura($id)
    {
        $prefacture = Prefacture::with(['operation', 'conceptsoperations'])->findOrFail($id);

        return view('operations.pdf.prefactura', compact('prefacture'));

    }

    public function invoiceProvider($id)
    {

        // $pdf = \App::make('operations.pdf');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->inline();

        $invoice = InvoiceProvider::findOrFail($id);

        return view('operations.pdf.invoiceprovider', compact('invoice'));
        // return $pdf->stream();

        // return \PDF::loadFile('http://www.github.com')->stream('github.pdf');
    }

    public function guaranteeRequest($id)
    {

        // $pdf = \App::make('operations.pdf');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->inline();

        $invoice = InvoiceProvider::findOrFail($id);

        return view('operations.pdf.guaranteerequest', compact('invoice'));
        // return $pdf->stream();

        // return \PDF::loadFile('http://www.github.com')->stream('github.pdf');
    }

    public function advanceRequest($id)
    {

        // $pdf = \App::make('operations.pdf');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->inline();

        $invoice = InvoiceProvider::findOrFail($id);

        return view('operations.pdf.advancerequest', compact('invoice'));
        // return $pdf->stream();

        // return \PDF::loadFile('http://www.github.com')->stream('github.pdf');
    }

    /**
    *   Muestra la gráfica de operaciones de usuario.
    */
    public function chart_user()
    {
        $operations_user_impo = Operation::where('user_id', auth()->user()->id)->where('impo_expo', '=', 'IMPO')->orderBy('id', 'asc')->get();
        $chart_user_impo = $operations_user_impo->toArray();
        // dd(count($chart_user_impo));
        $recibir = 0;
        $revision = 0;
        $mandar = 0;
        $revalidacion = 0;
        $tocapiso = 0;
        $proforma = 0;
        $pagoproforma = 0;
        $soltransporte = 0;
        $despuerto = 0;
        $portetd = 0;
        $dlvday = 0;
        $solicitud = 0;
        $facturaunmx = 0;
        $fechafactura = 0;

        for ($i=0; $i < count($chart_user_impo); $i++) {
            if ($chart_user_impo[$i]['recibir'] != null && $chart_user_impo[$i]['revision'] == null) {
                $recibir++;
            }
            if ($chart_user_impo[$i]['revision'] != null && $chart_user_impo[$i]['mandar'] == null) {
                $revision++;
            }
            if ($chart_user_impo[$i]['mandar'] != null && $chart_user_impo[$i]['revalidacion'] == null) {
                $mandar++;
            }
            if ($chart_user_impo[$i]['revalidacion'] != null && $chart_user_impo[$i]['toca_piso'] == null) {
                $revalidacion++;
            }
            $containers = Container::where('operation_id', $chart_user_impo[$i]['id'])->orderBy('id', 'desc')->get();
            if ($chart_user_impo[$i]['toca_piso'] != null && $containers->pluck('proforma')->contains(null)) {
                $tocapiso++;
            }
            if (!$containers->pluck('proforma')->contains(null) && $containers->pluck('pago_proforma')->contains(null)) {
                $proforma++;
            }
            if (!$containers->pluck('pago_proforma')->contains(null) && $containers->pluck('solicitud_transporte')->contains(null)) {
                $pagoproforma++;
            }
            if (!$containers->pluck('solicitud_transporte')->contains(null) && $containers->pluck('despachado_puerto')->contains(null)) {
                $soltransporte++;
            }
            if (!$containers->pluck('despachado_puerto')->contains(null) && $containers->pluck('port_etd')->contains(null)) {
                $despuerto++;
            }
            if (!$containers->pluck('port_etd')->contains(null) && $containers->pluck('dlv_day')->contains(null)) {
                $portetd++;
            }
            $debitnotes = DebitNote::where('operation_id', $chart_user_impo[$i]['id'])->get();
            $prefactures = Prefacture::where('operation_id', $chart_user_impo[$i]['id'])->get();
            if (!$containers->pluck('dlv_day')->contains(null) && ($debitnotes->isEmpty() && $prefactures->isEmpty())) {
                $dlvday++;
            }
            if (($debitnotes->isNotEmpty() || $prefactures->isNotEmpty()) && $containers->pluck('factura_unmx')->contains(null)) {
                $solicitud++;
            }
            if (!$containers->pluck('factura_unmx')->contains(null) && $containers->pluck('fecha_factura')->contains(null)) {
                $facturaunmx++;
            }
            if (!$containers->pluck('factura_unmx')->contains(null) && !$containers->pluck('fecha_factura')->contains(null)) {
                $fechafactura++;
            }
        }

        $chart['impo'] = array(
            'totales' => count($chart_user_impo),
            'recibir' => $recibir,
            'revision' => $revision,
            'mandar' => $mandar,
            'revalidacion' => $revalidacion,
            'tocapiso' => $tocapiso,
            'proforma' => $proforma,
            'pagoproforma' => $pagoproforma,
            'soltransporte' => $soltransporte,
            'despuerto' => $despuerto,
            'portetd' => $portetd,
            'dlvday' => $dlvday,
            'solicitud' => $solicitud,
            'facturaunmx' => $facturaunmx,
            'fechafactura' => $fechafactura
        );

        $operations_user_expo = Operation::where('user_id', auth()->user()->id)->where('impo_expo', '=', 'EXPO')->orderBy('id', 'asc')->get();
        $chart_user_expo = $operations_user_expo->toArray();
        // dd(count($chart_user_expo));
        $booking = 0;
        $confbooking = 0;
        $progrecoleccion = 0;
        $recoleccion = 0;
        $llegadapuerto = 0;
        $cierredocumental = 0;
        $pesaje = 0;
        $ingreso = 0;
        $despacho = 0;
        $zarpe = 0;
        $enviopapelera = 0;
        $solicitud = 0;

        for ($i=0; $i < count($chart_user_expo); $i++) {
            if ($chart_user_expo[$i]['booking'] != null && $chart_user_expo[$i]['conf_booking'] == null) {
                $booking++;
            }
            if ($chart_user_expo[$i]['conf_booking'] != null && $chart_user_expo[$i]['prog_recoleccion'] == null) {
                $confbooking++;
            }
            if ($chart_user_expo[$i]['prog_recoleccion'] != null && $chart_user_expo[$i]['recoleccion'] == null) {
                $progrecoleccion++;
            }
            if ($chart_user_expo[$i]['recoleccion'] != null && $chart_user_expo[$i]['llegada_puerto'] == null) {
                $recoleccion++;
            }
            if ($chart_user_expo[$i]['llegada_puerto'] != null && $chart_user_expo[$i]['cierre_documental'] == null) {
                $llegada_puerto++;
            }
            if ($chart_user_expo[$i]['cierre_documental'] != null && $chart_user_expo[$i]['pesaje'] == null) {
                $cierredocumental++;
            }
            if ($chart_user_expo[$i]['pesaje'] != null && $chart_user_expo[$i]['ingreso'] == null) {
                $pesaje++;
            }
            if ($chart_user_expo[$i]['ingreso'] != null && $chart_user_expo[$i]['despacho'] == null) {
                $ingreso++;
            }
            if ($chart_user_expo[$i]['despacho'] != null && $chart_user_expo[$i]['zarpe'] == null) {
                $despacho++;
            }
            if ($chart_user_expo[$i]['zarpe'] != null && $chart_user_expo[$i]['envio_papelera'] == null) {
                $zarpe++;
            }
            $debitnotes = DebitNote::where('operation_id', $chart_user_expo[$i]['id'])->get();
            $prefactures = Prefacture::where('operation_id', $chart_user_expo[$i]['id'])->get();
            if ($chart_user_expo[$i]['envio_papelera'] != null && ($debitnotes->isEmpty() && $prefactures->isEmpty())) {
                $enviopapelera++;
            }
            if (($debitnotes->isNotEmpty() || $prefactures->isNotEmpty()) && $chart_user_expo[$i]['envio_papelera'] != null) {
                $solicitud++;
            }
        }

        $chart['expo'] = array(
            'totales' => count($chart_user_expo),
            'booking' => $booking,
            'confbooking' => $confbooking,
            'progrecoleccion' => $progrecoleccion,
            'recoleccion' => $recoleccion,
            'llegadapuerto' => $llegadapuerto,
            'cierredocumental' => $cierredocumental,
            'pesaje' => $pesaje,
            'ingreso' => $ingreso,
            'despacho' => $despacho,
            'zarpe' => $zarpe,
            'enviopapelera' => $enviopapelera,
            'solicitud' => $solicitud
        );

        return $chart;
    }

    /**
    *   Muestra la gráfica de operaciones de administrador.
    */
    public function chart_admin()
    {
        $operations_admin = Operation::orderBy('id', 'desc')->get();
        $chart_admin = $operations_admin->toArray();

        $users = User::all();

        foreach ($users as $user) {
            $operations_user = Operation::where('user_id', $user->id)->orderBy('id', 'asc')->get();
            $chart_user = $operations_user->toArray();
            $recibir = 0;
            $revision = 0;
            $mandar = 0;
            $revalidacion = 0;
            $tocapiso = 0;
            $proforma = 0;
            $pagoproforma = 0;
            $soltransporte = 0;
            $despuerto = 0;
            $portetd = 0;
            $dlvday = 0;
            $solicitado = 0;
            $facturaunmx = 0;
            $fechafactura = 0;

            for ($i=0; $i < count($chart_user); $i++) {
                if ($chart_user[$i]['recibir'] != null && $chart_user[$i]['revision'] == null) {
                    $recibir++;
                }
                if ($chart_user[$i]['revision'] != null && $chart_user[$i]['mandar'] == null) {
                    $revision++;
                }
                if ($chart_user[$i]['mandar'] != null && $chart_user[$i]['revalidacion'] == null) {
                    $mandar++;
                }
                if ($chart_user[$i]['revalidacion'] != null && $chart_user[$i]['toca_piso'] == null) {
                    $revalidacion++;
                }
                $containers = Container::where('operation_id', $chart_user[$i]['id'])->orderBy('id', 'desc')->get();
                if ($chart_user[$i]['toca_piso'] != null && $containers->pluck('proforma')->contains(null)) {
                    $tocapiso++;
                }
                if (!$containers->pluck('proforma')->contains(null) && $containers->pluck('pago_proforma')->contains(null)) {
                    $proforma++;
                }
                if (!$containers->pluck('pago_proforma')->contains(null) && $containers->pluck('solicitud_transporte')->contains(null)) {
                    $pagoproforma++;
                }
                if (!$containers->pluck('solicitud_transporte')->contains(null) && $containers->pluck('despachado_puerto')->contains(null)) {
                    $soltransporte++;
                }
                if (!$containers->pluck('despachado_puerto')->contains(null) && $containers->pluck('port_etd')->contains(null)) {
                    $despuerto++;
                }
                if (!$containers->pluck('port_etd')->contains(null) && $containers->pluck('dlv_day')->contains(null)) {
                    $portetd++;
                }
                if (!$containers->pluck('dlv_day')->contains(null) && $containers->pluck('factura_unmx')->contains(null)) {
                    $dlvday++;
                }
                if (!$containers->pluck('factura_unmx')->contains(null) && $containers->pluck('fecha_factura')->contains(null)) {
                    $facturaunmx++;
                }
                if (!$containers->pluck('factura_unmx')->contains(null) && !$containers->pluck('fecha_factura')->contains(null)) {
                    $fechafactura++;
                }
            }

            $data[] = array(
                'name' => $user->name,
                'data' =>[$recibir, $revision, $mandar, $revalidacion, $tocapiso, $proforma, $pagoproforma, $soltransporte, $despuerto, $portetd, $dlvday, $facturaunmx, $fechafactura]
            );
        }

        return $data;
    }
}
