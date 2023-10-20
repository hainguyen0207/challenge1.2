@extends('layout.base')
@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Edit Assignment</h2>
                    <form method="post" action="{{ route('assignments.update', $assignment->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Để sử dụng HTTP method PUT cho việc cập nhật -->

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" id="title"
                                value="{{ $assignment->title }}" />
                        </div>
                        <div class="form-group">
                            <label for="Description">Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ $assignment->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="fileupload">Select File:</label>
                            <input type="file" class="form-control" name="fileupload" id="fileupload"
                                value=" {{ $assignment->file_path }}" />
                        </div>
                        <div class="form-group">
                            <label for="expired_at">Expired Date:</label>
                            <input type="date" class="form-control" name="expired_at" id="expired_at"
                                value="{{ $assignment->expired_at }}" />

                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Assignment</button>
                            <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Close</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
