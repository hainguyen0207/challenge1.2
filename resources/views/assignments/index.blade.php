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
                <h2>Assignments List</h2>
                <form action="{{ route('assignments.create') }}" method="GET">
                    @csrf
                    @if (Auth::user()->role == 1)
                        <button type="submit" class="btn btn-success mb-3">Add Assignment</button>
                    @endif
                </form>
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Link Assignment</th>
                            <th>Expired Date</th>
                            <th colspan="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_assignment as $assignment)
                            <tr>
                                <td>{{ $assignment->id }}</td>
                                <td>{{ $assignment->title }}</td>
                                <td>{{ $assignment->description }}</td>
                                <td><a style="color: green" target="_blank" href="{{ $assignment->file_path }}">Link
                                        Assignment</a></td>
                                <td style="color: red">{{ $assignment->expired_at }}</td>
                                <td>
                                    @if (Auth::user()->role == 1)
                                        <a href="{{ route('assignments.edit', $assignment) }}"
                                            class="btn btn-primary">Edit</a>
                                    @else
                                        @if (\App\Models\Submission::where('assignment_id', $assignment->id)->where('user_id', Auth::user()->id)->first())
                                            <a href="#" class="btn btn-success">Submitted</a>
                                        @else
                                            <a href="{{ route('assignments.show', $assignment) }}"
                                                class="btn btn-danger">Submission</a>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->role == 1)
                                        <a href="{{ route('submissions.show', $assignment->id) }}"
                                            class="btn btn-info">Detail</a>
                                    @endif
                                </td>

                                <td>
                                    @if (Auth::user()->role === 1)
                                        <form action="{{ route('assignments.destroy', $assignment->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit"
                                                onclick="return confirm('Bạn có chắc muốn xóa ?')">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
