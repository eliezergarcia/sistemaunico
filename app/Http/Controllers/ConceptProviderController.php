<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\ConceptsProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterConceptRequest;

class ConceptProviderController extends Controller
{
    /**
    *   Mostrar un listado de los conceptos de proveedor.
    */
    public function index()
    {
        $concepts = ConceptsProviders::all();

        return view('conceptsproviders.index', compact('concepts'));
    }

    /**
    *   Crea un nuevo concepto de proveedor.
    */
    public function store(RegisterConceptRequest $request)
    {
        DB::beginTransaction();

        $concept = ConceptsProviders::create($request->all());

        if ($concept) {
            DB::commit();
            return back()->with('success', 'El concepto se registró correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrión un problema al registar el concepto.');
        }

    }

    /**
    *   Buscar la información del concepto.
    */
    public function findById($id)
    {
        $concept = ConceptsProviders::findOrFail($id);

        return $concept;
    }

    /**
    *   Actualiza la información del conepto.
    */
    public function update(Request $request)
    {
        DB::beginTransaction();

        $concept = ConceptsProviders::findOrFail($request->input('concept_id'))->update($request->except('concept_id'));

        if ($concept) {
            DB::commit();
            return back()->with('success', 'La información del concepto se guardó correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrión un problema al guardar la información del concepto.');
        }
    }

    /**
    *   Desactiva el concepto.
    */
    public function deactivate(Request $request)
    {
        DB::beginTransaction();

        $concept = ConceptsProviders::findOrFail($request->input('concept_id'));
        $conept->deactivate();

        if ($concept) {
            DB::commit();
            return back()->with('success', 'El concepto se desactivó correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrión un problema al desactivar el concepto.');
        }
    }

    /**
    *   Activa el concepto.
    */
    public function activate(Request $request)
    {
        DB::beginTransaction();

        $concept = ConceptsProviders::findOrFail($request->concept_id);
        $conept->activate();

        if ($concept) {
            DB::commit();
            return back()->with('success', 'El concepto se activó correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrión un problema al activar el concepto.');
        }
    }
}
