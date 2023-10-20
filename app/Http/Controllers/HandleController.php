<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Handle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleController extends Controller
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
        $currentUserId = Auth::id();
        $originalUserId = $request->user_id;
        $originalChallengeId = $request->challenge_id;
        $answer = $request->answer;

        if ($currentUserId != $originalUserId) {
            return redirect()->route('challenges.index')->with('error', 'Invalid user ID.');
        }

        $challenge = \App\Models\Challenge::find($originalChallengeId);
        if (!$challenge) {
            return redirect()->route('challenges.index')->with('error', 'Challenge ID not found.');
        }

        // $existingHandle = \App\Models\Handle::where([
        //     ['challenge_id', '=', $originalChallengeId],
        //     ['user_id', '=', $currentUserId],
        // ])->first();


        // if ($existingHandle) {
        //     return redirect()->route('challenges.index')->with('error', 'You have already submitted this assignment.');
        // }
        $expectedAnswer = pathinfo($challenge->file_path, PATHINFO_FILENAME);
        if ($answer === $expectedAnswer) {
            \App\Models\Handle::create([
                'user_id' => $currentUserId,
                'challenge_id' => $originalChallengeId,
            ]);
            $content = file_get_contents(public_path($challenge->file_path));
            return redirect()->route('challenges.index')->with('alert', 'Correct Answer: ' . $content);

            // return redirect()->route('challenges.index')->with('success', 'Solved successfully');
        } else {
            return redirect()->back()->with('error', 'Incorrect answer. Please try again.');
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
        $challenge = Challenge::findOrFail($id);
        $all_handle = Handle::where('challenge_id', $id)->get();
        return view('handles.detail', compact('challenge', 'all_handle'));
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
