@extends('layout.base')

@section('content')
    <div class="container">
        <h2>Received Messages</h2>

        <div class="received-messages-box">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Message Content</th>
                        <th>Received Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_message as $key => $message)
                        <tr>
                            <td> {{ optional($message->sender)->username ?? 'Unknown' }}
                            </td>
                            <td>{{ $message->content }}</td>
                            <td>{{ $message->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
