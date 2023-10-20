@extends('layout.base')
@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Add New Assignment</h2>
                    <form method="post" action="{{ route('assignments.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" id="title" required />
                        </div>
                        <div class="form-group">
                            <label for="Description">Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="4"
                                placeholder="Type your description here"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fileupload">Select File:</label>
                            <input type="file" class="form-control" name="fileupload" id="fileupload" required />
                        </div>
                        <div class="form-group">
                            <label for="expired_at">Expired Date:</label>
                            <input type="date" class="form-control" name="expired_at" id="expired_at" required />

                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Add Assignment</button>
                            <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
