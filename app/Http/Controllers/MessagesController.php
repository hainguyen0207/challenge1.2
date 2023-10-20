<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_message = Message::where('receiver_id', auth()->user()->id)->get();
        return view('messages.index', compact('all_message'));
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
        $message = new Message([
            'user_id' => $request->input('user_id'),
            'receiver_id' => $request->input('receiver_id'),
            'content' => $request->input('message'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        if (empty($message->content)) {
            return redirect()->route('users.index')->with('error', 'There was an error during sending !');
        } else {


            if (Auth::user()->id == $message->user_id && Auth::user()->id != $message->receiver_id) {
                $message->save();
                return redirect()->route('users.show', $message->receiver_id)->with('success', 'Send Message Success !');
            } else {
            }
            return redirect()->route('users.index')->with('error', 'There was an error during sending !');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return redirect()->route('users.index')->with('error', 'Message not found !');
        }

        if (Auth::user()->id !== $message->user_id) {
            return redirect()->route('users.index')->with('error', 'You are not authorized to edit this message !');
        }

        return view('messages.edit', compact('message'));
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
        $message = Message::find($id);

        if (!$message) {
            return redirect()->route('users.index')->with('error', 'Message not found !');
        }

        if (Auth::user()->id !== $message->user_id) {
            return redirect()->route('users.index')->with('error', 'You are not authorized to edit this message !');
        }

        $message->content = $request->input('message');
        $message->updated_at = \Carbon\Carbon::now();
        $message->save();

        return redirect()->route('users.show', $message->receiver_id)->with('success', 'Message updated successfully !');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return redirect()->route('users.index')->with('error', 'Message not found !');
        }

        $receiver_id = $message->receiver_id;
        if (Auth::user()->id !== $message->user_id) {
            return redirect()->route('users.index')->with('error', 'You are not authorized to delete this message !');
        }

        $message->delete();

        return redirect()->route('users.show', $receiver_id)->with('success', 'Deleted Message Success!');
    }
    public function receivedAllMessages(User $receiver)
    {
        if (auth()->user()->id !== $receiver->id) {
            return redirect()->route('users.index')->with('error', 'You are not authorized to view this page.');
        }

        $received_messages = Message::where('receiver_id', $receiver->id)->get();
        return view('messages.index', compact('receiver', 'received_messages'));
    }


}