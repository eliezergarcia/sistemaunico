<?php

namespace App\Http\Controllers;

use App\Concepts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterConceptRequest;

class ConceptController extends Controller
{
    /**
    *   Mostrar un listado de los conceptos de cliente.
    */
    public function index()
    {
        $concepts = Concepts::all();

        return view('concepts.index')->with(compact('concepts'));
    }

    /**
    *   Crea un nuevo concepto de cliente.
    */
    public function store(RegisterConceptRequest $request)
    {
        DB::beginTransaction();

        $concept = Concepts::create($request->all());

        if($concept){
            DB::commit();
            return back()->with('success', 'El concepto se registró correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al intentar registrar el concepto.');
        }
    }

    /**
    *   Buscar la información del concepto.
    */
    public function findById($id)
    {
        $concept = Concepts::findOrFail($id);

        return $concept;
    }

    /**
    *   Actualiza la información del concepto.
    */
    public function update(Request $request)
    {
        DB::beginTransaction();

        $concept = Concepts::findOrFail($request->input('concept_id'))->update($request->all());

        if($concept){
            DB::commit();
            return back()->with('success', 'La información del concepto se guardó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al actualizar la información del concepto.');
        }
    }

    /**
    *   Activa el concepto.
    */
    public function activate(Request $request)
    {
        DB::beginTransaction();

        $concept = Concepts::findOrFail($request->concept_id)->update(['inactive_at' => null]);

        if($concept){
            DB::commit();
            return back()->with('success', 'El concepto se activó correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrió un problema al desactivar el concepto.');
        }
    }

    /**
    *   Desactiva el concepto.
    */
    public function deactivate(Request $request)
    {
        DB::beginTransaction();

        $concept = Concepts::findOrFail($request->input('concept_id'))->update(['inactive_at' => Carbon::now()]);

        if($concept){
            DB::commit();
            return back()->with('success', 'El concepto se desactivó correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrió un problema al activar el concepto.');
        }
    }
}
