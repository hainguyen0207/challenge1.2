@extends('layout.base')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                <h2>Submission List {{ $assignment->title }}</h2>
                <form action="" method="GET">
                    @csrf
                    <a href="{{ route('assignments.edit', $assignment) }}" class="btn btn-success mb-3">Change File</a>

                    <table class="table table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Time Submit</th>
                                <th>File</th>
                                <th>Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_submission as $submission)
                                <tr>
                                    <td>{{ $submission->updated_at }}</td>
                                    <td><a style="color: forestgreen" href="../{{ $submission->file_path }}"
                                            target="_blank">Link Submit</a></td>
                                    <td>{{ $submission->user->fullname }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection
