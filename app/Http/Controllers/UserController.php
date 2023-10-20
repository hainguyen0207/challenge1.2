<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_users = \App\Models\User::all();
        return view('users.home', compact('all_users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role === 1) {
            return view('users.create');
        } else {
            return redirect()->route('users.index')->with(
                'error',
                'You do not have this right !'
            );
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */public function store(Request $request)
    {
        if (Auth::user()->role === 1) {
            if (User::where('email', $request->get('email'))->exists()) {
                return redirect('/users')->with('error', 'Email already exists');
            }

            if (User::where('username', $request->get('username'))->exists()) {
                return redirect('/users')->with('error', 'Username already exists');
            }

            if (User::where('phoneNumber', $request->get('phoneNumber'))->exists()) {
                return redirect('/users')->with('error', 'Phone number already exists');
            }

            $student = new \App\Models\User([
                'username' => $request->get('username'),
                'password' => bcrypt($request->get('password')),
                'fullname' => $request->get('fullname'),
                'email' => $request->get('email'),
                'phoneNumber' => $request->get('phoneNumber')
            ]);

            $student->save();
            return redirect('/users')->with('success', 'Student saved');
        } else {
            return redirect()->route('users.index')->with(
                'error',
                'You do not have this right!'
            );
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
        $user = User::findOrFail($id);

        $all_message = \App\Models\Message::where('user_id', Auth::user()->id)
            ->where('receiver_id', $user->id)
            ->get();

        return view('users.detail', compact('user', 'all_message'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->role !== 1 && Auth::user()->id !== $user->id) {
            return redirect()->route('users.index')->with(
                'error',
                'You do not have this right !.'
            );
        } else {
            return view('users.edit', compact('user'));
        }
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
        $user = User::find($id);

        if (Auth::user()->role === 1) {
            $user->username = $request->input('username');
            $user->password = bcrypt($request->input('password'));
            $user->fullname = $request->input('fullname');
            $user->email = $request->input('email');
            $user->phoneNumber = $request->input('phoneNumber');
        } else {
            // $user->password = bcrypt($request->input('password'));
            $user->email = $request->input('email');
            $user->phoneNumber = $request->input('phoneNumber');
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Update Success !');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->route('users.index')->with(
                'error',
                'You cannot delete your own account!'
            );
        } elseif (Auth::user()->role === 1) {
            $user = \App\Models\User::find($id);
            $user->delete();
            return redirect('/users')->with(
                'success',
                'Deleted Success!'
            );
        } else {
            return redirect()->route('users.index')->with(
                'error',
                'You do not have this right !'
            );
        }
    }

    public function profile()
    {
        return view('users.profile');
    }
}