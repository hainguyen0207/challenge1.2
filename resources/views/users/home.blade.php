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
                <h2>Users List</h2>
                <form action="{{ route('users.create') }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-success mb-3">Add Student</button>
                </form>
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>FullName</th>
                            <th>Email</th>
                            <th>PhoneNumber</th>
                            <th>Role</th>
                            <th colspan="3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phoneNumber }}</td>
                                @if ($user->role === 1)
                                    <td style="color:red">Teacher</td>
                                @else
                                    <td>Student</td>
                                @endif
                                <td>
                                    @if (Auth::user()->role === 1 || Auth::user()->id === $user->id)
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                    @else
                                        <button class="btn btn-primary" disabled>Edit</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">Detail</a>
                                </td>
                                <td>
                                    @if (Auth::user()->id == 1)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit"
                                                onclick="return confirm('Bạn có chắc muốn xóa ?')">Delete</button>
                                        </form>
                                    @else
                                        <form action="#" method="post">
                                            <button class="btn btn-danger" type="submit" disabled>Delete</button>
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
