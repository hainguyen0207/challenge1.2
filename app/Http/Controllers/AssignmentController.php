<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_assignment = Assignment::all();
        return view('assignments.index', compact('all_assignment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role === 1) {
            return view('assignments.create');
        } else {
            return redirect()->route('assignments.index')->with(
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
                'title' => 'required',
                'description' => 'required',
                'expired_at' => 'required|date',
            ]);

            if ($request->hasFile('fileupload') && $request->file('fileupload')->isValid()) {
                $file = $request->file('fileupload');
                $fileSize = $file->getSize();
                $fileName = time() . '_' . mt_rand(100000, 999999) . '.' . $file->getClientOriginalExtension();
                if ($fileSize > 4194304) { // Kiểm tra kích thước tệp, 4MB = 4 * 1024 * 1024 bytes
                    return redirect()->route('assignments.index')->with('error', 'File size must be less than 4MB.');
                }

                $validMimes = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/gif',
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'audio/mpeg',
                    'text/plain',
                ];
                $fileMimeType = $file->getMimeType();

                $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'mp3', 'txt'];
                $fileExtension = $file->getClientOriginalExtension();

                if (!in_array($fileMimeType, $validMimes) || !in_array($fileExtension, $validExtensions)) {
                    return redirect()->route('assignments.index')->with('error', 'Invalid file type or extension.');
                }

                $file->move(public_path('uploads/assignments'), $fileName);
                Assignment::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'file_path' => 'uploads/assignments/' . $fileName,
                    'expired_at' => $request->expired_at,
                    //'created_at' => now(),
                ]);

                return redirect()->route('assignments.index')->with('success', 'Assignment created successfully');
            } else {
                return redirect()->route('assignments.index')->with('error', 'Error uploading file');
            }
        } else {
            return redirect()->route('assignments.index')->with('error', 'You do not have this right!');
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        return view('submissions.submit', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        if (Auth::user()->role !== 1) {
            return redirect()->route('assignments.index')->with(
                'error',
                'You do not have this right !.'
            );
        } else {
            return view('assignments.edit', compact('assignment'));
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
        $assignment = Assignment::findOrFail($id);

        if (!$assignment) {
            return redirect()->route('assignments.index')->with('error', 'Assignment not found');
        }

        if (Auth::user()->role === 1) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'expired_at' => 'required|date',
            ]);

            if ($request->hasFile('fileupload') && $request->file('fileupload')->isValid()) {
                $file = $request->file('fileupload');
                $fileSize = $file->getSize();


                if ($fileSize > 4194304) {
                    return redirect()->route('assignments.index')->with('error', 'File size must be less than 4MB.');
                }

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'mp3', 'txt'];
                $fileExtension = $file->getClientOriginalExtension();

                if (!in_array($fileExtension, $allowedExtensions)) {
                    return redirect()->route('assignments.index')->with('error', 'Invalid file extension.');
                }

                $allowedMimes = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/gif',
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'audio/mpeg',
                    'text/plain',
                ];
                $fileMimeType = $file->getMimeType();

                if (!in_array($fileMimeType, $allowedMimes)) {
                    return redirect()->route('assignments.index')->with('error', 'Invalid file type.');
                }

                if (!empty($assignment->file_path)) {
                    $oldFilePath = public_path($assignment->file_path);
                    if (file_exists($oldFilePath)) {
                        $newFilePath = 'uploads/old_assignments/' . basename($oldFilePath);
                        rename($oldFilePath, public_path($newFilePath));
                        $assignment->file_path = $newFilePath;
                    }
                }

                $fileName = time() . '_' . mt_rand(100000, 999999) . '.' . $fileExtension;
                $file->move(public_path('uploads/assignments'), $fileName);

                $assignment->file_path = 'uploads/assignments/' . $fileName;
                $assignment->title = $request->input('title');
                $assignment->description = $request->input('description');
                $assignment->expired_at = $request->input('expired_at');
                $assignment->save();

                return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully');
            } else {
                return redirect()->route('assignments.index')->with('error', 'Please select file upload!');
            }
        } else {
            return redirect()->route('assignments.index')->with('error', 'You do not have this right!');
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
            $assignment = \App\Models\Assignment::find($id);
            if ($assignment) {
                \App\Models\Submission::where('assignment_id', $assignment->id)->get()->each(function ($submission) {
                    $filePath = public_path($submission->file_path);
                    if (file_exists($filePath)) {
                        $newFilePath = 'uploads/old_submissions/' . basename($filePath);
                        rename($filePath, public_path($newFilePath));
                    }
                });
                \App\Models\Submission::where('assignment_id', $assignment->id)->delete();
                $filePath = public_path($assignment->file_path);
                if (file_exists($filePath)) {
                    $newFilePath = 'uploads/old_assignments/' . basename($filePath);
                    rename($filePath, public_path($newFilePath));
                }
                $assignment->delete();
                return redirect()->route('assignments.index')->with('success', 'Deleted Success!');
            } else {
                return redirect()->route('assignments.index')->with('error', 'Assignment not found.');
            }
        } else {
            return redirect()->route('assignments.index')->with('error', 'You do not have this right!');
        }
    }



}