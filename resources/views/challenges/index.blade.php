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
                @if (session('alert'))
                    <script>
                        alert("{!! session('alert') !!}");
                    </script>
                @endif
                <h2>Challenge List</h2>
                <form action="{{ route('challenges.create') }}" method="GET">
                    @csrf
                    @if (Auth::user()->role == 1)
                        <button type="submit" class="btn btn-success mb-3">Add Challenge</button>
                    @endif
                </form>
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Hint</th>
                            @if (Auth::user()->role == 1)
                                <th>Link Challenge</th>
                            @endif
                            <th colspan="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_challenge as $challenge)
                            <tr>
                                <td>{{ $challenge->id }}</td>
                                <td>{{ $challenge->name }}</td>
                                @if (Auth::user()->role == 1)
                                    <td>{{ $challenge->hint }}</td>
                                    <td> <a target="_blank" style="color: green" href="{{ $challenge->file_path }}">Link
                                            Challenge</a></td>
                                @else
                                    <td>*****************</td>
                                @endif
                                <td>
                                    @if (Auth::user()->role == 1)
                                        <a href="{{ route('challenges.edit', $challenge) }}"
                                            class="btn btn-primary">Edit</a>
                                    @else
                                        @if (\App\Models\Handle::where('challenge_id', $challenge->id)->where('user_id', Auth::user()->id)->first())
                                            <a href="#" class="btn btn-success">Solved</a>
                                        @else
                                            <a href="{{ route('challenges.show', $challenge) }}"
                                                class="btn btn-danger">Handle</a>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->role == 1)
                                        <a href="{{ route('handles.show', $challenge->id) }}"
                                            class="btn btn-info">Detail</a>
                                    @endif
                                </td>

                                <td>
                                    @if (Auth::user()->role === 1)
                                        <form action="{{ route('challenges.destroy', $challenge->id) }}" method="post">
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
