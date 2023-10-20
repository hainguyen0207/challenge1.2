@extends('layout.base')
@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Edit Challenge</h2>
                    <form method="post" action="{{ route('challenges.update', $challenge->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="name" class="form-control" name="name" id="name"
                                value="{{ $challenge->name }}" />
                        </div>
                        <div class="form-group">
                            <label for="hint">Hint:</label>
                            <textarea name="hint" id="hint" class="form-control" rows="4">{{ $challenge->hint }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="fileupload">Select File:</label>
                            <input type="file" class="form-control" name="fileupload" id="fileupload"
                                value=" {{ $challenge->file_path }}" />
                        </div>


                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Challenge</button>
                            <a href="{{ route('challenges.index') }}" class="btn btn-secondary">Close</a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
