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
                <h2>Sloved Student List: {{ $challenge->name }}</h2>
                <form action="" method="GET">
                    @csrf

                    <table class="table table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Time Sloved</th>
                                <th>Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_handle as $handle)
                                <tr>
                                    <td>{{ $handle->updated_at }}</td>
                                    <td>{{ $handle->user->fullname }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection
