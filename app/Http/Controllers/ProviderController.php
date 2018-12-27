<?php

namespace App\Http\Controllers;

use App\Provider;
use Carbon\Carbon;
use App\AccountProvider;
use Illuminate\Http\Request;
use App\Imports\ProvidersImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\RegisterProviderRequest;

class ProviderController extends Controller
{
    /**
    *   Muestra el listado de proveedores.
    */
    public function index()
    {
        $providers = Provider::all();

        return view('providers.index', compact('providers'));
    }

    /**
    *   Crea un nuevo proveedor.
    */
    public function store(RegisterProviderRequest $request)
    {
        DB::beginTransaction();

        $provider = Provider::create($request->all());

        if ($provider) {
            DB::commit();
            return back()->with('success', 'El proveedor se registró correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar el proveedor.');
        }
    }

    /**
    *   Muestra la información del proveedor.
    */
    public function show($id)
    {
        $provider = Provider::findOrFail($id);

        return view('providers.show', compact('provider'));
    }

    /**
    *   Busca la información del proveedor.
    */
    public function findById($id)
    {
        $provider = Provider::findOrFail($id);

        return $provider;
    }

    /**
    *   Actualiza la información del proveedor.
    */
    public function update(Request $request, $id)
    {
        //
    }

    /**
    *   Actualiza la información del proveedor.
    */
    public function modificar(Request $request)
    {
        DB::beginTransaction();

        $provider = Provider::findOrFail($request->input('provider_id'))->update($request->all());

        if ($provider) {
            DB::commit();
            return back()->with('success', 'La información del proveedor se guardó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información del proveedor.');
        }

    }

    /**
    *   Activa el proveedor.
    */
    public function activate(Request $request)
    {
        DB::beginTransaction();

        $provider = Provider::findOrFail($request->provider_id);
        $provider->activate();

        if ($provider) {
            DB::commit();
            return back()->with('success', 'El proveedor se activó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al activar el proveedor.');
        }
    }

    /**
    *   Desactiva el proveedor.
    */
    public function deactivate(Request $request)
    {
        DB::beginTransaction();

        $provider = Provider::findOrFail($request->provider_id);
        $provider->deactivate();

        if ($provider) {
            DB::commit();
            return back()->with('success', 'El proveedor se desactivó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al desactivar el proveedor.');
        }
    }

    public function searchAccounts(Request $request)
    {
        // dd($request->all());
        $accounts = AccountProvider::where('provider_id', $request->provider_id)
                                   ->where('inactive_at', null)->get();

        return $accounts;
    }

    /**
    *   Importa proveedores a la BD.
    */
    public function importProvider(Request $request)
    {
        DB::beginTransaction();

        $import = Excel::import(new ProvidersImport, request()->file('excel'), \Maatwebsite\Excel\Excel::XLSX);

        if ($import) {
            DB::commit();
            return back()->with('success', 'Los proveedores se cargaron correctamente en el sistema.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cargar los proveedores en el sistema.');
        }
    }
}
