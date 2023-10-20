@extends('layout.base')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
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
                <h2>{{ $user->role == 1 ? 'Teacher Details' : 'Student Details' }}</h2>
                <div class="user-details-box">
                    <p><strong>Username:</strong> {{ $user->username }}</p>
                    <p><strong>Name:</strong> {{ $user->fullname }}</p>
                    <p><strong>Role:</strong> {{ $user->role == 1 ? 'Teacher' : 'Student' }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Number Phone:</strong> {{ $user->phoneNumber }}</p>
                </div>
                <h2>Send Message</h2>
                <div class="send-message-box">
                    <form method="POST" action="{{ route('messages.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                        <div class="form-group">
                            <textarea name="message" name='content' class="form-control" rows="4" placeholder="Type your message here"></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <a href={{ route('users.index') }} class="btn btn-secondary" data-dismiss="modal">Close</a>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-6">
                <h2>Messages send to {{ $user->username }}</h2>
                <div class="received-messages-box">
                    @foreach ($all_message as $message)
                        <div class="list-group-item">
                            <p class="mb-1">{{ $message->content }}</p>
                            <small class="text-muted">Last updated:
                                {{ $message->updated_at->format('Y-m-d H:i:s') }}</small>
                            <div class="text-right">
                                <a href="{{ route('messages.edit', $message->id) }}"
                                    class="btn btn-warning btn-sm btn-equal">Edit</a>
                                <form action="{{ route('messages.destroy', $message->id) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-equal" type="submit"
                                        onclick="return confirm('Bạn có chắc muốn xóa tin nhắn này ?')">Delete</button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
