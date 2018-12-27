<?php

namespace App\Http\Controllers;

use App\Client;
use App\Housebl;
use App\Operation;
use Carbon\Carbon;
use App\ContainersHousebl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HouseblController extends Controller
{
    /**
    *   Muestra el listado de housebl.
    */
    public function index()
    {
        $housebls = Housebl::orderBy('id', 'desc')->get();

        return view('housebls.index', compact('housebls'));
    }

    /**
    *   Crea un nuevo housebl.
    */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $fecha = Housebl::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->first();

        if($fecha)
        {
            $housebl = (new Housebl)->fill($request->all());
            $housebl->number = ($fecha->number) + 1;
        }else{
            $housebl = (new Housebl)->fill($request->all());
            $housebl->number = 1;
        }

        $housebl->save();

        if($request->has('containers'))
        {
            for ($i=0; $i < count($request->input('containers')); $i++) {
                $containers = new ContainersHousebl();
                $idcontainer = $request->input('containers')[$i];

                $containers->housebl_id = $housebl->id;
                $containers->operation_id = $request->input('operation_id');
                $containers->container_id = $idcontainer;
                $containers->save();
            }
        }

        if ($housebl && $containers) {
            DB::commit();
            return back()->with('success', 'El house bl se creó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al crear el house bl.');
        }

    }

    /**
    *   Muestra el housbl.
    */
    public function show($id)
    {
        $housebl = Housebl::with(['operation'])->findOrFail($id);

        // dd($housebl->containershousebl->toArray());

        // $containers = ContainersHousebl::where('housebl_id', $housebl->id)->get();

        return view('operations.pdf.housebl', compact('housebl'));
    }
}
