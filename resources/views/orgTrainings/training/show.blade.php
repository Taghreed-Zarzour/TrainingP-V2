<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Training Sessions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h3, h4 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .alert {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Training Details</h1>

    <form action="{{ route('organizationTraining.update', $training->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="program_title">Program Title:</label>
            <input type="text" id="program_title" name="program_title" value="{{ old('program_title', $training->program_title) }}" required>
            @error('program_title')
                <div class="alert">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="trainer_id">Trainer:</label>
            <select id="trainer_id" name="trainer_id" required>
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}" {{ $trainer->id == $training->trainer_id ? 'selected' : '' }}>
                        {{ $trainer->name }}
                    </option>
                @endforeach
            </select>
            @error('trainer_id')
                <div class="alert">{{ $message }}</div>
            @enderror
        </div>

        <h3>Training Sessions</h3>
        @if($training->trainingSchedules->isEmpty())
            <p>No training sessions available.</p>
        @else
            @foreach($training->trainingSchedules as $schedule)
                <div class="session-details">
                    <input type="hidden" name="session_ids[]" value="{{ $schedule->id }}">
                    <div class="form-group">
                        <label for="session_date_{{ $schedule->id }}">Date:</label>
                        <input type="date" id="session_date_{{ $schedule->id }}" name="session_dates[{{ $schedule->id }}]" value="{{ old('session_dates.'.$schedule->id, $schedule->session_date) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="session_start_time_{{ $schedule->id }}">Session Start Time:</label>
                        <input type="time" id="session_start_time_{{ $schedule->id }}" name="session_start_times[{{ $schedule->id }}]" value="{{ old('session_start_times.'.$schedule->id, $schedule->session_start_time) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="session_end_time_{{ $schedule->id }}">Session End Time:</label>
                        <input type="time" id="session_end_time_{{ $schedule->id }}" name="session_end_times[{{ $schedule->id }}]" value="{{ old('session_end_times.'.$schedule->id, $schedule->session_end_time) }}" required>
                    </div>
                    <div class="form-group">
                        <form action="{{ route('orgSessions.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this session?');">Delete</button>
                        </form>
                    </div>
                    <hr>
                </div>
            @endforeach
        @endif

        <!-- Button to Add New Session -->
        <button id="add-session-btn" class="btn">Add New Session</button>

        <!-- New Session Fields -->
        <div id="new-session-fields" style="display: none; margin-top: 20px;">
            <h4>New Session</h4>
            <div class="form-group">
                <label for="new_session_date">Date:</label>
                <input type="date" id="new_session_date" name="new_session_date" required>
            </div>
            <div class="form-group">
                <label for="new_session_start_time">Start Time:</label>
                <input type="time" id="new_session_start_time" name="new_session_start_time" required>
            </div>
            <div class="form-group">
                <label for="new_session_end_time">End Time:</label>
                <input type="time" id="new_session_end_time" name="new_session_end_time" required>
            </div>
            <button id="save-new-session" class="btn btn-success">Save Session</button>
        </div>

        <button type="submit" class="btn">Update Training</button>
    </form>

    <a href="{{ route('organization.showSpecificTraining', $training->id) }}" class="btn" style="margin-top: 10px; background-color: #6c757d;">Cancel</a>
</div>

<script>
    document.getElementById('add-session-btn').onclick = function() {
        const newSessionFields = document.getElementById('new-session-fields');
        newSessionFields.style.display = newSessionFields.style.display === 'none' ? 'block' : 'none';
    };

    document.getElementById('save-new-session').onclick = function() {
        const date = document.getElementById('new_session_date').value;
        const startTime = document.getElementById('new_session_start_time').value;
        const endTime = document.getElementById('new_session_end_time').value;

        fetch('{{ route("organizationSessions.store",  $training->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                session_date: date,
                session_start_time: startTime,
                session_end_time: endTime
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Session added successfully!');
                location.reload(); // Reload the page to see the updated session list
            } else {
                alert('Failed to add session!');
            }
        })
        .catch(error => console.error('Error:', error));
    };
</script>

</body>
</html>