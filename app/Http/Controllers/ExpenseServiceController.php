<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExpensesServicesImport;

class ExpenseServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = ExpenseService::all();

        return view('expenseservices.index', compact('services'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();

        $service = ExpenseService::create($request->all());

        if ($service) {
            DB::commit();
            return back()->with('success', 'El servicio se registró correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar el servicio');
        }
    }

    public function findById($id)
    {
        $service = ExpenseService::find($id);

        return $service;
    }

    public function modificar(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();

        $service = ExpenseService::find($request->service_id);
        $service->update($request->all());

        if ($service) {
            DB::commit();
            return back()->with('success', 'La información del servicio se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información del servicio.');
        }
    }

    /**
    *   Activa el servicio.
    */
    public function activate(Request $request)
    {
        DB::beginTransaction();

        $service = ExpenseService::find($request->service_id);
        $service->activate();

        if($service){
            DB::commit();
            return back()->with('success', 'El servicio se activó correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrió un problema al desactivar el servicio.');
        }
    }

    /**
    *   Desactiva el servicio.
    */
    public function deactivate(Request $request)
    {
        DB::beginTransaction();

        $service = ExpenseService::find($request->service_id);
        $service->deactivate();

        if($service){
            DB::commit();
            return back()->with('success', 'El servicio se desactivó correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrió un problema al activar el servicio.');
        }
    }

    /**
    *   Importa servicios de gastos a la BD.
    */
    public function importServices(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        $import = Excel::import(new ExpensesServicesImport, request()->file('excel'), \Maatwebsite\Excel\Excel::XLSX);

        if ($import) {
            DB::commit();
            return back()->with('success', 'Los servicios de gastos se cargaron correctamente en el sistema.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cargar los servicios de gastos en el sistema.');
        }
    }
}
