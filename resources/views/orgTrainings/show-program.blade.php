<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $program->program_title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.5;
        }

        h2, h3 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        p {
            margin: 0.2rem 0;
        }

        .card {
            background: #fff;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        ul {
            padding-left: 1rem;
        }

        li {
            margin-bottom: 0.3rem;
        }

        .highlight {
            color: #007bff;
            font-weight: bold;
        }

        .session-box {
            background-color: #f1f3f5;
            padding: 0.8rem;
            border-radius: 6px;
            margin-bottom: 0.8rem;
        }
    </style>
</head>
<body>
    {{-- Program Header --}}
    <div class="card">
        <h2>📘 Program Details</h2>
        <p><strong>Title:</strong> {{ $program->program_title }}</p>
        <p><strong>Main Program:</strong> {{ $orgProgram->title }}</p>
        <p><strong>Created By:</strong> {{ $orgProgram->organization->user->name }}</p>
        <p><strong>Language:</strong> {{ $orgProgram->language->name }}</p>
        <p><strong>Type:</strong> {{ $orgProgram->programType->name }}</p>
        <p><strong>Trainer:</strong> {{ $program->Trainer->name }}</p>
        <p><strong>Description:</strong> {{ $orgProgram->program_description }}</p>

        @php
        $deadline = \Carbon\Carbon::parse($orgProgram->registrationRequirements->application_deadline);
        $now = \Carbon\Carbon::now();
        $totalHours = $now->diffInHours($deadline, false);
        $diffInDays = intdiv($totalHours, 24);
        $diffInHours = $totalHours % 24;
        @endphp

        @if($totalHours > 0)
            <p><strong>⏳ Time left to apply:</strong> {{ $diffInDays }} days and {{ $diffInHours }} hours</p>
        @else
            <p><strong>⚠️ Application deadline has passed.</strong></p>
        @endif

        <p><strong>Total Duration:</strong> <span class="highlight">{{ round($grandTotalMinutes / 60, 2) }} hours</span></p>
        <p><strong>Join Now:</strong> <span class="highlight">${{ $orgProgram->registrationRequirements->cost }}</span></p>
        <p><strong>Level:</strong> {{ $orgProgram->trainingLevel->name }}</p>
        <p><strong>Location:</strong> {{ $orgProgram->country->name }}, {{ $orgProgram->city }}</p>
    </div>

    {{-- Learning Outcomes --}}
    <div class="card">
        <h3>📅 Learning Outcomes</h3>
        @if($orgProgram->goals->count())
            <ul>
                @foreach($orgProgram->goals as $goal)
                    @foreach ($goal->learning_outcomes as $learning_outcome)
                        <li>{{ $learning_outcome }}</li>
                    @endforeach
                @endforeach
            </ul>
        @else
            <p>No goals listed.</p>
        @endif
    </div>

    {{-- Requirements & Benefits --}}
    <div class="card">
        <h3>📝 Requirements</h3>
        @php $requirements = json_decode($orgProgram->registrationRequirements->requirements, true); @endphp
        @if(is_array($requirements) && count($requirements))
            <ul>
                @foreach ($requirements as $requirement)
                    <li>{{ $requirement }}</li>
                @endforeach
            </ul>
        @else
            <p>None</p>
        @endif

        <h3>🌟 Benefits</h3>
        @php $benefits = json_decode($orgProgram->registrationRequirements->benefits, true); @endphp
        @if(is_array($benefits) && count($benefits))
            <ul>
                @foreach ($benefits as $benefit)
                    <li>{{ $benefit }}</li>
                @endforeach
            </ul>
        @else
            <p>None</p>
        @endif
    </div>

    {{-- Sessions --}}
    <div class="card">
        <h3>📅 Training Sessions</h3>
        @foreach ($program->trainingSchedules as $session)
        {{-- @dd($session); --}}
            @php
                $sessionDuration = \Carbon\Carbon::parse($session->session_start_time)
                    ->diffInMinutes(\Carbon\Carbon::parse($session->session_end_time));
            @endphp
            <div class="session-box">
                <p><strong>Day:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('l') }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}</p>
                <p><strong>Time:</strong> {{ $session->session_start_time }} - {{ $session->session_end_time }}</p>
                <p><strong>Duration:</strong> {{ $sessionDuration }} min</p>
            </div>
        @endforeach
    </div>

    {{-- Organization Info --}}
    <div class="card">
        <h3>🏢 Organization Info</h3>
        <p><strong>{{ $orgProgram->organization->user->name }}</strong></p>
        <p>{{ $orgProgram->organization->user->bio }}</p>
        <p>Type: {{ $orgProgram->organization->type->name }}</p>
    </div>

    {{-- Trainer & Assistants --}}
    <div class="card">
        <h3>🏫 Trainer</h3>
        <p><strong>{{ $program->Trainer->name }}</strong></p>
        <p>{{ $program->Trainer->bio ?? '' }}</p>

        <h3>👥 Assistants</h3>
        @if($orgProgram->assistants->count())
            <ul>
                @foreach($orgProgram->assistantUsers as $assistant)
                    <li>{{ $assistant->name }} {{ $assistant->assistant->last_name }}</li>
                @endforeach
            </ul>
        @else
            <p>None</p>
        @endif
    </div>

</body>
</html>
