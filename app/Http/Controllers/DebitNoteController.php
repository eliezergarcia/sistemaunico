<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Carbon\Carbon;
use App\DebitNote;
use App\ConceptsOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebitNoteController extends Controller
{
    /**
    *   Muestra el listado de Debit Notes.
    */
    public function index()
    {
        $debitnotes = DebitNote::orderBy('id', 'desc')->get();

        return view('debitnotes.index', compact('debitnotes'));
    }

    /**
    *   Crea un nuevo Debit Note.
    */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        $fecha = DebitNote::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->first();

        if($fecha){
            $debitnote = (new DebitNote)->fill($request->all());
            $debitnote->number = ($fecha->number) + 1;
        }else{
            $debitnote = (new DebitNote)->fill($request->all());
            $debitnote->number = 1;
        }

        $debitnote->save();

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
                $concepts->debit_note_id = $debitnote->id;
                $concepts->concept_id = $idconcept;
                $concepts->curr = $request->input('curr')[$idconcept-1];
                $concepts->rate = $rateconcept;
                $concepts->iva = $ivaconcept;
                $concepts->qty = $qtyconcept;
                $concepts->foreign = $foreignconcept;
                $concepts->save();
            }
        }

        // $debitnote->createNotificationDebitNote();

        if($debitnote && $concepts){
            DB::commit();
            return back()->with('success', 'El debit note se creó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al crear el Debi Note.');
        }
    }

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
        $debitnote = DebitNote::findOrFail($id)->get();
        foreach($debitnote as $debit){
            $data['ratetotal'] = $debit->ratetotal;
            $data['ivatotal'] = $debit->ivatotal;
        }

        return $data;
    }

    public function cancel(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        $debitnote = DebitNote::findOrFail($request->debitnote_id);
        // $debitnote->markAsReadNotificationSOLFAC();
        $debitnote->canceled();

        if($debitnote){
            DB::commit();
            return back()->with('success', 'El debit note se canceló correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cancelar el Debi Note.');
        }
    }
}
