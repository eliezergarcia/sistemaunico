<?php

namespace App\Http\Controllers;

use App\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Imports\ClientsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\RegisterClientRequest;

class ClientController extends Controller
{
    /**
    *   Muestra el listado de clientes.
    */
    public function index()
    {
        // $client = Client::findOrFail(3);
        // dd($client->payments->toArray());

        $clients = Client::orderBy('codigo_cliente', 'asc')->get();

        return view('clients.index', compact('clients'));
    }

    /**
    *   Crea un nuevo cliente.
    */
    public function store(RegisterClientRequest $request)
    {
        DB::beginTransaction();

        $client = Client::create($request->all());

        if ($client) {
            DB::commit();
            return back()->with('success', 'El cliente se registró correctamente.');
        }else{
            DB::rollBack();
            return back()->with('success', 'Ocurrió un problema al registrar el cliente.');
        }

    }

    /**
    *   Busca la información del cliente.
    */
    public function findById($id)
    {
        $client = Client::findOrFail($id);

        return $client;
    }

    /**
    *   Actualiza la información del cliente.
    */
    public function update(Request $request, $id)
    {
        //
    }

    /**
    *   Actualiza la información del cliente.
    */
    public function modificar(Request $request)
    {
        DB::beginTransaction();

        $client = Client::findOrFail($request->input('client_id'))->update($request->all());

        if ($client) {
            DB::commit();
            return back()->with('success', 'La información del cliente se guardó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información del usuario.');
        }
    }

    /**
    *   Activa el cliente.
    */
    public function activate(Request $request)
    {
        DB::beginTransaction();

        $client = Client::findOrFail($request->client_id);
        $client->activate();

        if ($client) {
            DB::commit();
            return back()->with('success', 'El cliente se activó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al activar el usuario.');
        }
    }

    /**
    *   Desactiva el cliente.
    */
    public function deactivate(Request $request)
    {
        DB::beginTransaction();

        $client = Client::findOrFail($request->client_id);
        $client->deactivate();

        if ($client) {
            DB::commit();
            return back()->with('success', 'El cliente se desactivó correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al desactivar el usuario.');
        }
    }

    /**
    *   Importa clientes a la BD.
    */
    public function importClients(Request $request)
    {
        DB::beginTransaction();

        $import = Excel::import(new ClientsImport, request()->file('excel'), \Maatwebsite\Excel\Excel::XLSX);

        if ($import) {
            DB::commit();
            return back()->with('success', 'Los clientes se cargaron correctamente en el sistema.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al cargar los clientes en el sistema.');
        }
    }

    // public function importClients(Request $request)
    // {
    //     \Excel::load($request->excel, function($reader) {

    //         $excel = $reader->get();

    //         $reader->each(function($row) {
    //             dd($row->codigo_cliente);
    //             $client = new Client;
    //             $client->codigo_cliente = $row->codigo_cliente;
    //             $client->razon_social = $row['razon_social'];
    //             $client->rfc = $row['rfc'];
    //             $client->numero_interior = $row['calle'];
    //             $client->numero_exterior = $row['numero_interior'];
    //             $client->calle = $row['numero_exterior'];
    //             $client->colonia = $row['colonia'];
    //             $client->codigo_postal = $row['codigo_postal'];
    //             $client->pais = $row['pais'];
    //             $client->estado = $row['estado'];
    //             $client->ciudad = $row['ciudad'];
    //             $client->municipio = $row['municipio'];
    //             $client->save();
    //         });

    //     });

    //     return back()->with('info', 'Los usuarios se cargaron correctamente en la base de datos.');
    // }
}
