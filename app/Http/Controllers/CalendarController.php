<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterEventRequest;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Role::all();
        $users = User::where('inactive_at', null)->get();
        return view('calendars.index', compact('departments', 'users'));
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
    public function store(RegisterEventRequest $request)
    {
        DB::beginTransaction();

        $start = Carbon::parse($request->startdate)->format('Y-m-d');
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $start.' '.$request->start_time);
        $end = Carbon::parse($request->enddate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $end.' '.$request->end_time);

        $event = Calendar::create($request->all());
        $event->created_by = auth()->user()->id;
        $event->start_date = $startDate;
        $event->end_date = $endDate;
        $event->save();

        if ($request->has('share_departments')) {
            for ($i=0; $i < count($request->input('share_departments')); $i++) {
                $role_id = $request->input('share_departments')[$i];
                DB::table('assigned_events_departments')->insert([
                    ['role_id' => $role_id, 'calendar_id' => $event->id],
                ]);
            }
        }

        if ($request->has('share_users')) {
            for ($i=0; $i < count($request->input('share_users')); $i++) {
                $user_id = $request->input('share_users')[$i];
                DB::table('assigned_events_users')->insert([
                    ['user_id' => $user_id, 'calendar_id' => $event->id],
                ]);
            }
        }

        if ($request->has('share_users') && $request->has('share_departments')) {
            for ($i=0; $i < count($request->input('share_users')); $i++) {
                $user_id = $request->input('share_users')[$i];
                $user = User::find($user_id);
                if ($request->has('share_departments')) {
                    for ($j=0; $j < count($request->input('share_departments')); $j++) {
                        $role_id = $request->input('share_departments')[$j];
                        if(auth()->user()->id != $user_id){
                            if ($user->roles->pluck('id')->intersect($role_id)->isEmpty()) {
                                DB::table('assigned_events_users')->insert([
                                    ['user_id' => $user_id, 'calendar_id' => $event->id],
                                ]);
                            }
                        }
                    }
                }
            }
        }

        if ($event) {
            DB::commit();
            return back()->with('success', 'El evento se registró correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar el evento.');
        }

    }

    public function findEvents()
    {
        $events = Calendar::where('created_by', auth()->user()->id)->get();

        $eventsusers = DB::table('assigned_events_users')->where('user_id', auth()->user()->id)->get();

        foreach ($eventsusers as $event) {
            $events[] = Calendar::find($event->calendar_id);
        }

        foreach (auth()->user()->roles as $role) {
            $eventsdepartments= DB::table('assigned_events_departments')->where('role_id', $role->id)->get();
            foreach ($eventsdepartments as $event) {
                $evento = Calendar::find($event->calendar_id);
                if ($events->pluck('id')->intersect($evento->id)->isEmpty()) {
                     $events[] = $evento;
                }
            }
        }

        if (!isset($events) || $events->isEmpty()) {
            $data[] = array();
        } else {
            foreach ($events as $event) {
                $data[] = array(
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->message,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'className' => $event->color
                );
            }
        }

        return $data;
    }

    public function findEvent($id)
    {
        $event = Calendar::findOrFail($id);

        if ($event->created_by == auth()->user()->id) {
            $createdby = 1;
        } else {
            $createdby = 0;
        }

        $users = DB::table('assigned_events_users')->select('user_id')->where('calendar_id', $event->id)->get();
        $departments = DB::table('assigned_events_departments')->select('role_id')->where('calendar_id', $event->id)->get();

        $data[] = array(
            'created_by' => $createdby,
            'id' => $event->id,
            'title' => $event->title,
            'share_users' => $users,
            'share_departments' => $departments,
            'startdate' => Carbon::parse($event->start_date)->format('d-m-Y'),
            'enddate' => Carbon::parse($event->end_date)->format('d-m-Y'),
            'start_time' => Carbon::parse($event->start_date)->format('H:i:s'),
            'end_time' => Carbon::parse($event->end_date)->format('H:i:s'),
            'color' => $event->color,
            'message' => $event->message
        );

        return $data;
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        $event = Calendar::findOrFail($request->id);
        $event->deleteUserEvents();
        $event->deleteDepartmentsEvents();
        $event->delete();

        if ($event) {
            DB::commit();
            return "El evento se eliminó correctamente";
        } else {
            DB::rollBack();
        }
    }

    public function modificar(Request $request)
    {
        // dd($request->all());

        $start = Carbon::parse($request->startdate)->format('Y-m-d');
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $start.' '.$request->start_time);
        $end = Carbon::parse($request->enddate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $end.' '.$request->end_time);

        $event = Calendar::find($request->calendar_id);
        $event->update($request->all());
        $event->created_by = auth()->user()->id;
        $event->start_date = $startDate;
        $event->end_date = $endDate;
        $event->save();

        $event->deleteUserEvents();
        $event->deleteDepartmentsEvents();

        if ($request->has('share_departments')) {
            for ($i=0; $i < count($request->input('share_departments')); $i++) {
                $role_id = $request->input('share_departments')[$i];
                DB::table('assigned_events_departments')->insert([
                    ['role_id' => $role_id, 'calendar_id' => $event->id],
                ]);
            }
        }

        if ($request->has('share_users')) {
            for ($i=0; $i < count($request->input('share_users')); $i++) {
                $user_id = $request->input('share_users')[$i];
                DB::table('assigned_events_users')->insert([
                    ['user_id' => $user_id, 'calendar_id' => $event->id],
                ]);
            }
        }

        if ($request->has('share_users') && $request->has('share_departments')) {
            for ($i=0; $i < count($request->input('share_users')); $i++) {
                $user_id = $request->input('share_users')[$i];
                $user = User::find($user_id);
                if ($request->has('share_departments')) {
                    for ($j=0; $j < count($request->input('share_departments')); $j++) {
                        $role_id = $request->input('share_departments')[$j];
                        if(auth()->user()->id != $user_id){
                            if ($user->roles->pluck('id')->intersect($role_id)->isEmpty()) {
                                DB::table('assigned_events_users')->insert([
                                    ['user_id' => $user_id, 'calendar_id' => $event->id],
                                ]);
                            }
                        }
                    }
                }
            }
        }

        if ($event) {
            DB::commit();
            return back()->with('success', 'El evento se guardó correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar el evento.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
