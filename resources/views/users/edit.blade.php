@extends('layout.base')
@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center"> {{ $user->id == 1 ? 'Edit Teacher' : 'Edit Student' }}</h2>
                    <form method="post" action="{{ route('users.update', $user->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" name="username" id="username"
                                value="{{ Auth::user()->id == 1 ? $user->username : $user->username }}"
                                @if (Auth::user()->id != 1) disabled @endif />
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" id="password"
                                value="{{ Auth::user()->id == 1 ? $user->password : '11111111' }}" />
                        </div>
                        <div class="form-group">
                            <label for="fullname">Họ Tên:</label>
                            <input type="text" class="form-control" name="fullname" id="fullname"
                                value="{{ Auth::user()->id == 1 ? $user->fullname : $user->fullname }}"
                                @if (Auth::user()->id != 1) disabled @endif />
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ $user->email }}" />
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Số điện thoại:</label>
                            <input type="text" class="form-control" name="phoneNumber" id="phoneNumber"
                                value="{{ $user->phoneNumber }}" />
                        </div>
                        <div class="d-flex justify-content-between">
                            @if (Auth::user()->id === 1 || Auth::user()->id === $user->id)
                                <button type="submit" class="btn btn-primary">Edit Student</button>
                            @endif
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
