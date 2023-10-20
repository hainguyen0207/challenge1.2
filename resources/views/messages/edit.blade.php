@extends('layout.base')

@section('content')
    <div class="container">
        <h2>Edit Message</h2>
        <form method="POST" action="{{ route('messages.update', $message->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="message">Message Content:</label>
                <textarea name="message" class="form-control" rows="4">{{ $message->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Message</button>
        </form>
    </div>
@endsection
