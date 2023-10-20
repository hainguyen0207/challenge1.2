@extends('layout.base')
@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Add New Challenge</h2>
                    <form method="post" action="{{ route('challenges.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Challenge Name:</label>
                            <input type="text" class="form-control" name="name" id="name" required />
                        </div>
                        <div class="form-group">
                            <label for="hint">Hint:</label>
                            <textarea name="hint" id="hint" class="form-control" rows="4" placeholder="Type your hint here"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fileupload">Select File:</label>
                            <input type="file" class="form-control" name="fileupload" id="fileupload" required />
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Add Challenge</button>
                            <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
