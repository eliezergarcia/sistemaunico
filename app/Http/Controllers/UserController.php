<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\RegisterUserRequest;

class UserController extends Controller
{
    /**
    *   Mostrar el listado de usuarios.
    *   Se envia el listado de roles.
    */
    public function index()
    {
        $users = User::with(['roles'])->get();

        $roles = Role::all();

        return view('users.index')->with(compact('users', 'roles'));
    }

    /**
    *   Crea un nuevo usuario.
    *   Se asignan roles al usuario creado.
    */
    public function store(RegisterUserRequest $request)
    {
        DB::beginTransaction();

        $user = (new User)->fill($request->all());

        if ($request->hasFile('avatar')) {
          $user->avatar = $request->file('avatar')->store('public');
        }

        $user->save();

        $user->roles()->attach($request->roles);

        if($user){
            DB::commit();
            return back()->with('success', 'El usuario se ha registrado correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al registrar el usuario.');
        }
    }

    /**
    *   Muestra la información del usuario.
    *   Se envía un lista de roles.
    *   Se enviía un listado de clientes.
    */
    public function show($id)
    {
        $user = User::with(['roles', 'clients'])->findOrFail($id);

        $roles = Role::all();

        $clients = Client::where('inactive_at', null)->get();

        return view('users.show', compact('user', 'roles', 'clients'));
    }

    /**
    *   Se actualiza la información del usaurio.
    *   Se actualizan los roles del usuario.
    */
    public function update(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();

        $user = User::findOrFail($id);

        if ($request->hasFile('avatar')) {
          $user->avatar = $request->file('avatar')->store('public');
        }

        $user->update($request->all());
        $user->password_encrypted = Hash::make($request->password_encrypted);

        $user->roles()->sync($request->roles);

        if($user){
            DB::commit();
            return back()->with('success', 'La información del usuario se ha guardado correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al guardar la información del usuario.');
        }
    }

    /**
    *   Se desactiva el usuario.
    */
    public function deactivate($id)
    {
        DB::beginTransaction();

        $user = User::findOrFail($id);
        $user->deactivate();

        if($user){
            DB::commit();
            return redirect()->route('usuarios.index')->with('success', 'El usuario ha sido desactivado correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al desactivar el usuario.');
        }
    }

    /**
    *   Se activar el usuario.
    */
    public function activate($id)
    {
        DB::beginTransaction();

        $user = User::findOrFail($id);
        $user->activate();

        if($user){
            DB::commit();
            return redirect()->route('usuarios.index')->with('success', 'El usuario ha sido activado correctamente.');
        }else{
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al activar el usuario.');
        }
    }

    /**
    *   Se asignan clientes al usuario.
    */
    public function assignmentclient(Request $request)
    {
        DB::beginTransaction();

        $user = User::findOrFail($request->user_id);

        $user->clients()->attach($request->client_id);

        if($user){
            DB::commit();
            return back()->with('success', 'El cliente se asignó al usuario correctamente.');
        }else{
            DB::rollback();
            return back()->with('error', 'Ocurrió un problema al asignar el cliente al usuario.');
        }
    }

    /**
    *   Se desasignan clientes al usuario.
    */
    public function disassociateclient(Request $request)
    {
        DB::beginTransaction();

        $user = User::findOrFail($request->user_id);

        $user->clients()->detach($request->client_id);

        if ($user) {
            DB::commit();
            return back()->with('success', 'El cliente se desasignó del usuario correctamente.');
        } else {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un problema al desasignar al cliente del usuario.');
        }
    }
}
