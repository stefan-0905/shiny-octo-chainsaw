<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;

class UsersController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\User::orderBy('name')->paginate(5);
        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateUserRequest $request)
    {
        \App\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'password' => bcrypt($request->password)
        ]);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
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
        $user = \App\User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($user)
    {
        $user = \App\User::findOrFail($user);

        $user->name = request()->name;
        $user->email = request()->email;
        $user->bio = request()->bio;

        if(request()->password_confirmation)
            $user->password = bcrypt(request()->password_confirmation);

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests\DeleteUserRequest $request, $user)
    {

        //dd($user);
        $user = \App\User::findOrFail($user);
        $deleteOption = $request->delete_option;
        $selectedUser = $request->selected_user;

        if($deleteOption == 'delete') {
            // delete user posts 
            $user->posts()->withTrashed()->forceDelete();
        } elseif($deleteOption == 'attribute') {
            $user->posts()->update(['author_id' => $selectedUser]);
        }
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function confirmDelete(Request $request, $user)
    {
        $user = \App\User::findOrFail($user);
        $users = \App\User::where('id', '!=', $user->id)->pluck('name', 'id');
        
        return view('backend.users.confirm_delete', compact('user', 'users'));
    }
}