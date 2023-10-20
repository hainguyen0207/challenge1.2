@extends('layout.base')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center"> {{ Auth::user()->id == 1 ? 'Profile Teacher' : 'Profile Student' }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username"
                                value="{{ Auth::user()->username }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" class="form-control" name="fullname" id="fullname"
                                value="{{ Auth::user()->fullname }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ Auth::user()->email }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" name="phoneNumber" id="phoneNumber"
                                value="{{ Auth::user()->phoneNumber }}" disabled>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-primary">Edit Profile</a>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
