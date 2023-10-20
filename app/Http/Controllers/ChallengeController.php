<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_challenge = Challenge::all();
        return view('challenges.index', compact('all_challenge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role === 1) {
            return view('challenges.create');
        } else {
            return redirect()->route('challenges.index')->with(
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
     */
    public function store(Request $request)
    {
        if (Auth::user()->role === 1) {
            $request->validate([
                'name' => 'required',
                'hint' => 'required',

            ]);
            if ($request->hasFile('fileupload') && $request->file('fileupload')->isValid()) {
                $file = $request->file('fileupload');
                $fileSize = $file->getSize();
                $fileName = $file->getClientOriginalName();
                if (preg_match('/^[A-Za-z0-9\s._-]+$/', $fileName) !== 1) {
                    return redirect()->route('challenges.index')->with('error', 'File name format is not valid.');
                }
                if ($fileSize > 4194304) {
                    return redirect()->route('challenges.index')->with('error', 'File size must be less than 4MB.');
                }

                $validMimes = [
                    'text/plain'
                ];
                $fileMimeType = $file->getMimeType();

                $validExtensions = ['txt'];
                $fileExtension = $file->getClientOriginalExtension();

                if (!in_array($fileMimeType, $validMimes) || !in_array($fileExtension, $validExtensions)) {
                    return redirect()->route('challenges.index')->with('error', 'Invalid file type or extension.');
                }

                $file->move(public_path('uploads/challenges'), $fileName);
                Challenge::create([
                    'name' => $request->name,
                    'hint' => $request->hint,
                    'file_path' => 'uploads/challenges/' . $fileName
                ]);

                return redirect()->route('challenges.index')->with('success', 'Challenge created successfully');
            } else {
                return redirect()->route('challenges.index')->with('error', 'You do not have this right!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {
        return view('handles.slove', compact('challenge'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        if (Auth::user()->role !== 1) {
            return redirect()->route('challenges.index')->with(
                'error',
                'You do not have this right !.'
            );
        } else {
            return view('challenges.edit', compact('challenge'));
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
        $challenge = Challenge::findOrFail($id);

        if (!$challenge) {
            return redirect()->route('challenges.index')->with('error', 'Challenge not found !');
        }

        if (Auth::user()->role === 1) {
            $request->validate([
                'name' => 'required',
                'hint' => 'required',

            ]);

            if ($request->hasFile('fileupload') && $request->file('fileupload')->isValid()) {
                $file = $request->file('fileupload');
                $fileSize = $file->getSize();
                $fileName = $file->getClientOriginalName();
                if (preg_match('/^[A-Za-z0-9\s._-]+$/', $fileName) !== 1) {
                    return redirect()->route('challenges.index')->with('error', 'File name format is not valid.');
                }
                if ($fileSize > 4194304) {
                    return redirect()->route('challenges.index')->with('error', 'File size must be less than 4MB.');
                }

                $validMimes = [
                    'text/plain'
                ];
                $fileMimeType = $file->getMimeType();
                $validExtensions = ['txt'];
                $fileExtension = $file->getClientOriginalExtension();
                if (!in_array($fileMimeType, $validMimes) || !in_array($fileExtension, $validExtensions)) {
                    return redirect()->route('challenges.index')->with('error', 'Invalid file type or extension.');
                }
                if (!empty($challenge->file_path)) {
                    $oldFilePath = public_path($challenge->file_path);
                    if (file_exists($oldFilePath)) {
                        $newFilePath = 'uploads/old_challenges/' . basename($oldFilePath);
                        rename($oldFilePath, public_path($newFilePath));
                        $challenge->file_path = $newFilePath;
                    }
                }

                $file->move(public_path('uploads/challenges'), $fileName);

                $challenge->file_path = 'uploads/challenges/' . $fileName;
                $challenge->name = $request->input('name');
                $challenge->hint = $request->input('hint');
                $challenge->save();

                return redirect()->route('challenges.index')->with('success', 'Challenge updated successfully');
            } else {
                return redirect()->route('challenges.index')->with('error', 'You do not have this right!');
            }
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
        if (Auth::user()->role === 1) {
            $challenge = \App\Models\Challenge::find($id);

            if ($challenge) {
                \App\Models\Handle::where('challenge_id', $challenge->id)->delete();

                $filePath = public_path($challenge->file_path);
                if (file_exists($filePath)) {
                    $newFilePath = 'uploads/old_assignments/' . basename($filePath);
                    rename($filePath, public_path($newFilePath));
                }

                $challenge->delete();
                return redirect()->route('challenges.index')->with('success', 'Deleted Success!');
            } else {
                return redirect()->route('challenges.index')->with('error', 'Challenge not found.');
            }
        } else {
            return redirect()->route('challenges.index')->with('error', 'You do not have this right!');
        }
    }
}
