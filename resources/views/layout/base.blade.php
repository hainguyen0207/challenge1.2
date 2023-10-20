<!DOCTYPE html>
<html>

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_create_student.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_detail.css') }}">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Class Room</h3>
            </div>

            <!-- User Info -->
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="{{ route('users.index') }}"><b>Users</b></a>
                </li>
                <li>
                    <a href="{{ route('messages.index') }}"><b>Messages</b></a>
                </li>
                <li>
                    <a href="{{ route('assignments.index') }}"><b>Assignment</b></a>
                </li>
                <li>
                    <a href="{{ route('challenges.index') }}"><b>Challenge</b></a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="{{ route('users.index') }}">Students Management</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        @if (Auth::check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile') }}">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('signout') }}">Sign Out</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
