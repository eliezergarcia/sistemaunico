<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        $roles = Role::all();

        return view('users.index')->with(compact('users', 'roles'));

        // return view('users.index')->with([
        //     'paginate' => [
        //         'total' => $users->total(),
        //         'current_page' => $users->currentPage(),
        //         'per_page' => $users->perPage(),
        //         'last_page' => $users->lastPage(),
        //         'from' => $users->firstItem(),
        //         'to' => $users->lastPage(),
        //     ],
        //     'users' => $users

        // ]);
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
    public function store(RegisterUserRequest $request)
    {
        $user = (new User)->fill($request->all());

        if ($request->hasFile('avatar')) {
          $user->avatar = $request->file('avatar')->store('public');
        }

        $user->save();

        $user->roles()->attach($request->roles);

        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
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
        $user = User::findOrFail($id);        

        if ($request->hasFile('avatar')) {
          $user->avatar = $request->file('avatar')->store('public');
        }

        $user->update($request->all());

        $user->roles()->sync($request->roles);

        return back()->with('info', 'La información se ha guardado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('usuarios.index')->with('info', 'El usuario ha sido eliminado correctamente.');
    }
}
