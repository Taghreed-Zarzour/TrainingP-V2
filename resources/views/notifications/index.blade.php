<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Notifications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        .notification {
            background: #e9ecef;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .notification h4 {
            margin: 0;
        }
        .notification-time {
            font-size: 0.9em;
            color: gray;
        }
        .no-notifications {
            text-align: center;
            color: gray;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Your Notifications</h1>

    @if($notifications->isEmpty())
        <p class="no-notifications">No notifications available.</p>
    @else
        @foreach($notifications as $notification)
            <div class="notification">
                <h4>{{ $notification->data['message'] }}</h4>
                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
            </div>
        @endforeach
    @endif
</div>

</body>
</html>