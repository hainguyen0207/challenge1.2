@extends('layout.base')
@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <h2 class="text-center">Slove Challenge</h2>
                    <form method="post" action="{{ route('handles.store') }}">
                        <b onclick="alert('Hint: {{ $challenge->hint }}')" class="btn btn-success mb-3">Show Hint</b>
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="challenge_id" value="{{ $challenge->id }}">
                        <div class="form-group">
                            <label for="challenge_id">Challenge:</label>
                            <input type="text" class="form-control" value="{{ $challenge->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer: </label>
                            <input type="text" class="form-control" name="answer" id="answer" required />
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('challenges.index') }}" class="btn btn-secondary">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
