<?php

namespace App\Http\Controllers;

use App\Container;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Container::create($request->all());

        return back()->with('success', 'El contenedor se registró correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $container = Container::findOrFail($id);

        return $container;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        dd($request->all());
    }

    public function modificar(Request $request)
    {
        DB::beginTransaction();

        $container = Container::findOrFail($request->container_id);
        $container->update($request->all());

        if ($container->operation->impo_expo == "IMPO") {
            if ($container->port_etd != null) {
                $readNotification = DB::table('notifications')->where('data', 'like', '%'.'OA'.$container->id.'%')
                                                              ->where('read_at', null)->get();
                if ($readNotification || $readNotification->isNotEmpty()) {
                    $container->markAsReadNotificationOA();
                }
            }

            if ($container->port_etd != null && $container->dlv_day != null) {
                $readNotification = DB::table('notifications')->where('data', 'like', '%'.'OD'.$container->id.'%')
                                                              ->where('read_at', null)->get();
                if ($readNotification || $readNotification->isNotEmpty()) {
                    $container->markAsReadNotificationOD();
                }
            }
        }

        if ($container) {
            DB::commit();
            return back()->with('success', 'La información del contenedor se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información del contenedor.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        Container::findOrFail($id)->update(['canceled_at' => Carbon::now()]);

        return back()->with('success', 'La información del contenedor se eliminó correctamente.');
    }
}
