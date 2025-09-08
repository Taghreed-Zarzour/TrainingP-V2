{{-- resources/views/notifications/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .notification {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            background: #f1f1f1;
        }
        .notification-time {
            font-size: 0.8em;
            color: gray;
        }
        .notification a {
            color: blue;
            text-decoration: underline;
        }
        .no-notifications {
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Your Notifications</h1>
    <ul id="notifications-list">
        @if($notifications->isEmpty())
            <li class="no-notifications">No notifications available.</li>
        @else
            @foreach($notifications as $notification)
                <li class="notification">
                    <strong>{{ $notification->data['message'] }}</strong>
                    <span class="notification-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                    <div>
                        @if(isset($notification->data['rejection_reason']))
                            <p>Reason: {{ $notification->data['rejection_reason'] }}</p>
                        @endif
                        <div>
                        @if(isset($notification->data['type']))
                            @if($notification->data['type'] === 'enrollmentRequest')
                                <p>Trainer ID: {{ $notification->data['trainee_id'] }}</p>
                                <div class="button-container">
                                    <form action="{{ route('participants.handleAction', ['program' => $notification->data['program_id'], 'participant' => $notification->data['trainee_id']]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="action" value="accept">
                                        <input type="hidden" name="is_org" value="{{ $notification->data['is_org'] }}">
                                        <button type="submit" class="btn">Accept</button>
                                    </form>
                                    <form action="{{ route('participants.handleAction', ['program' => $notification->data['program_id'], 'participant' => $notification->data['trainee_id']]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <input type="hidden" name="is_org" value="{{ $notification->data['is_org'] }}">
                                        <button type="submit" class="btn reject">Reject</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
 
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $(document).ready(function() {
        function fetchNotifications() {
            $.ajax({
                url: '{{ route("notifications.index") }}', // Adjust this route as necessary
                method: 'GET',
                success: function(data) {
                    $('#notifications-list').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching notifications:", error);
                }
            });
        }

        // Fetch notifications every 8 seconds
        setInterval(fetchNotifications, 8000);
    });
</script> 
</body>
</html>