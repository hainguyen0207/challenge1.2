<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('submissions.submit');
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
        $originalAssignmentId = $request->assignment_id;

        if ($currentUserId != $originalUserId) {
            return redirect()->route('assignments.index')->with('error', 'Invalid user ID.');
        }

        $assignment = \App\Models\Assignment::find($originalAssignmentId);
        if (!$assignment) {
            return redirect()->route('assignments.index')->with('error', 'Assignment ID not found.');
        }

        $existingSubmission = \App\Models\Submission::where([
            ['assignment_id', '=', $originalAssignmentId],
            ['user_id', '=', $currentUserId],
        ])->first();


        if ($existingSubmission) {
            return redirect()->route('assignments.index')->with('error', 'You have already submitted this assignment.');
        }
        if ($request->hasFile('fileupload') && $request->file('fileupload')->isValid()) {
            $file = $request->file('fileupload');
            $fileExtension = $file->getClientOriginalExtension();
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'mp3', 'txt'];

            $fileMimeType = $file->getMimeType();
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

            if (!in_array($fileExtension, $allowedExtensions) || !in_array($fileMimeType, $allowedMimes)) {
                return redirect()->route('assignments.index')->with('error', 'Invalid file type or extension.');
            }

            $maxFileSize = 4 * 1024 * 1024;

            if ($file->getSize() > $maxFileSize) {
                return redirect()->route('assignments.index')->with('error', 'File size exceeds the limit.');
            }

            $fileName = time() . '_' . mt_rand(100000, 999999) . '.' . $fileExtension;

            $oldSubmissionsPath = public_path('uploads/old_submissions');

            if (file_exists($oldSubmissionsPath . '/' . $fileName)) {
                return redirect()->route('assignments.index')->with('error', 'File already exists.');
            }
            $file->move(public_path('uploads/submissions'), $fileName);
            \App\Models\Submission::create([
                'user_id' => $currentUserId,
                'assignment_id' => $originalAssignmentId,
                'file_path' => 'uploads/submissions/' . $fileName,
            ]);
            return redirect()->route('assignments.index')->with('success', 'Submission created successfully');
        } else {
            return redirect()->route('assignments.index')->with('error', 'Error uploading file');
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
        $assignment = Assignment::findOrFail($id);
        $all_submission = Submission::where('assignment_id', $id)->get();
        return view('submissions.detail', compact('assignment', 'all_submission'));
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
