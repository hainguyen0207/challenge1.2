@extends('layout.base')
@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Submission Assignment</h2>
                    <form method="post" action="{{ route('submissions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                        <div class="form-group">
                            <label for="assignment_id">Assignment:</label>
                            <input type="text" class="form-control" value="{{ $assignment->title }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="fileupload">Select File:</label>
                            <input type="file" class="form-control" name="fileupload" id="fileupload" required />
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
