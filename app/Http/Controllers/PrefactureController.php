<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Carbon\Carbon;
use App\Prefacture;
use App\ConceptsOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrefactureController extends Controller
{
    /**
    *   Muestra el listado de prefacturas.
    */
    public function index()
    {
        $prefacturas = Prefacture::orderBy('id', 'desc')->get();

        return view('prefactures.index', compact('prefacturas'));
    }

    /**
    *   Crea una nueva prefactura.
    */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $fecha = Prefacture::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->first();

        if($fecha)
        {
            $prefacture = (new Prefacture)->fill($request->all());
            $prefacture->number = ($fecha->number) + 1;
        }else{
            $prefacture = (new Prefacture)->fill($request->all());
            $prefacture->number = 1;
        }

        $prefacture->save();

        if($request->has('concepts'))
        {
            for ($i=0; $i < count($request->input('concepts')); $i++) {
                $concepts = new ConceptsOperation();
                $idconcept = $request->input('concepts')[$i];
                $rateconcept = $request->input('rates')[$idconcept-1];

                $iva = 0;
                if($request->has('ivaConcept'))
                {
                    for ($j=0; $j < count($request->input('ivaConcept')); $j++) {
                        if ($request->input('ivaConcept')[$j] == $idconcept) {
                            $iva = 0.16;
                        }
                    }
                }

                $ivaconcept = $rateconcept * $iva;
                $qtyconcept = $request->input('qty')[$idconcept-1];
                $foreignconcept = ($rateconcept + $ivaconcept) * $qtyconcept;

                $concepts->operation_id = $request->input('operation_id');
                $concepts->prefacture_id = $prefacture->id;
                $concepts->concept_id = $idconcept;
                $concepts->curr = $request->input('curr')[$idconcept-1];
                $concepts->rate = $rateconcept;
                $concepts->iva = $ivaconcept;
                $concepts->qty = $qtyconcept;
                $concepts->foreign = $foreignconcept;
                $concepts->save();
            }
        }

        // $prefacture->createNotificationPrefacture();

        if ($prefacture && $concepts) {
            DB::commit();
            return back()->with('success', 'La prefactura se creó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al crear la prefactura.');
        }
    }

    /**
    *   Muestra la prefactura.
    */
    public function show($id)
    {
        $debitnote = DebitNote::findOrFail($id)->get();
        // $pdf = \PDF::loadView('operations.pdf.debitnote');
        // $pdf->render();
        // return $pdf->stream();
        return view('operations.pdf.debitnote', compact('debitnote'));
    }

    public function findById($id)
    {
        $prefacture = Prefacture::findOrFail($id)->get();
        foreach($prefacture as $pref){
            $data['ratetotal'] = $pref->ratetotal;
            $data['ivatotal'] = $pref->ivatotal;
        }

        return $data;
    }

    public function cancel(Request $request)
    {
        DB::beginTransaction();

        $prefacture = Prefacture::findOrFail($request->prefactura_id);
        $prefacture->canceled();
        // $prefacture->markAsReadNotificationSOLFAC();

        if($prefacture){
            DB::commit();
            return back()->with('success', 'La prefacura se canceló correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cancelar la prefactura.');
        }
    }
}
