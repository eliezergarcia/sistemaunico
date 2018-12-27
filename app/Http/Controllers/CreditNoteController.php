<?php

namespace App\Http\Controllers;

use App\Client;
use App\CreditNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditNoteController extends Controller
{
    /**
    *   Muestra el listado de notas de crédito.
    */
    public function index()
    {
        $creditnotes = CreditNote::withTrashed()->get();

        $clients = Client::all();

        return view('creditnotes.index', compact('creditnotes', 'clients'));
    }

    /**
    *   Crea una nueva nota de crédito.
    */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $creditnote = CreditNote::create($request->all());

        if ($creditnote) {
            DB::commit();
            return back()->with('success', 'La nota de crédito se registró correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar la nota de crédito.');
        }
    }

    /**
    *   Busca la información de la nota de crédito.
    */
    public function show($id)
    {
        $creditnote = CreditNote::findOrFail($id);

        return $creditnote;
    }

    /**
    *   Actualiza la información de la nota de crédito.
    */
    public function modificar(Request $request)
    {
        DB::beginTransaction();

        $creditnote = CreditNote::findOrFail($request->input('creditnote_id'))->update($request->all());

        if ($creditnote) {
            DB::commit();
            return back()->with('success', 'La información de la nota de crédito se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información de la nota de crédito.');
        }
    }

    /**
    *   Cancela la nota de crédito.
    */
    public function deactivate(Request $request)
    {
        DB::beginTransaction();

        $creditnote = CreditNote::findOrFail($request->input('creditnote_id'))->delete();

        if ($creditnote) {
            DB::commit();
            return back()->with('success', 'La nota de crédito se canceló correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cancelar la nota de crédito.');
        }
    }
}
