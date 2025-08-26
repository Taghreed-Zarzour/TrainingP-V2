<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Training Program Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 2rem;
            background-color: #f4f6f8;
            color: #333;
            line-height: 1.6;
        }

        h1, h2, h3 {
            color: #2c3e50;
            margin-bottom: 0.75rem;
        }

        p, li {
            font-size: 0.95rem;
            margin: 0.25rem 0;
        }

        ul {
            padding-left: 1.2rem;
            margin: 0.5rem 0 1rem;
        }

        .section {
            margin-bottom: 2rem;
        }

        .card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .highlight {
            color: #2980b9;
            font-weight: bold;
        }

        .list-box {
            background: #fafafa;
            border-left: 4px solid #3498db;
            padding: 0.8rem 1rem;
            border-radius: 6px;
            margin-bottom: 0.8rem;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-weight: 500;
        }
        a:hover {
            text-decoration: underline;
        }

        .program-link {
            display: block;
            background: #fdfdfd;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 0.8rem;
            margin-bottom: 1rem;
            transition: 0.2s ease;
        }

        .program-link:hover {
            background: #f7fbff;
            border-color: #3498db;
        }

        .meta {
            font-size: 0.9rem;
            color: #777;
        }

    </style>
</head>
<body>

    {{-- Program Header --}}
    <div class="card">
        <h1>{{ $OrgProgram->title }}</h1>
        <p><strong>Status:</strong> <span class="highlight">{{ ucfirst($OrgProgram->status) }}</span></p>
        <p><strong>Classification:</strong> {{ $OrgProgram->trainingClassification->name }}</p>
        <p><strong>Type:</strong> {{ $OrgProgram->programType->name }}</p>
        <p><strong>Language:</strong> {{ $OrgProgram->language->name }}</p>
        <p><strong>Description:</strong> {{ $OrgProgram->program_description }}</p>
        <p><strong>Created by:</strong> {{ $OrgProgram->organization->user->name }}</p>
        <p><strong>Join Now:</strong> <span class="highlight">${{ $OrgProgram->registrationRequirements->cost }}</span></p>
    </div>

    {{-- Program Info --}}
    <div class="card">
        <p><strong>Programs Count:</strong> {{ $OrgProgram->details->count() }}</p>
        <p><strong>Level:</strong> {{ $OrgProgram->trainingLevel->name }}</p>
        <p><strong>Application Method:</strong> {{ $OrgProgram->program_presentation_method }}</p>
        <p><strong>Registration Method:</strong> {{ $OrgProgram->registrationRequirements->application_submission_method }}</p>
        <p><strong>Location:</strong> {{ $OrgProgram->country->name }} , {{ $OrgProgram->city }}</p>
        @php
        $deadline = \Carbon\Carbon::parse($OrgProgram->registrationRequirements->application_deadline);
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
    </div>

    {{-- Goals --}}
    <div class="section">
        <h3>🎯 النتائج التعليمية من المسار التدريبي</h3>
        @if($OrgProgram->goals->count())
            <ul>
                @foreach($OrgProgram->goals as $goal)
                    @foreach ($goal->learning_outcomes as $learning_outcome)
                        <li class="list-box">{{ $learning_outcome }}</li>
                    @endforeach
                @endforeach
            </ul>
        @else
            <p>No goals listed.</p>
        @endif
    </div>

    {{-- Target Audience --}}
    <div class="section">
        <h3>👥 الفئة المستهدفة</h3>
        @if($OrgProgram->goals->count())
            <p><strong>📘 المستوى العلمي</strong></p>
            <ul>
                @foreach($education_levels as $education_level)
                    <li class="list-box">{{ $education_level }}</li>
                @endforeach
            </ul>

            <p><strong>💼 مجالات العمل</strong></p>
            <ul>
                @foreach($work_sectors as $work_sector)
                    <li class="list-box">{{ $work_sector }}</li>
                @endforeach
            </ul>

            <p><strong>🏢 المستوى الوظيفي</strong></p>
            <ul>
                @foreach($OrgProgram->goals as $goal)
                    @foreach ($goal->job_position as $job)
                        <li class="list-box">{{ $job }}</li>
                    @endforeach
                @endforeach
            </ul>
        @else
            <p>No target audience specified.</p>
        @endif
    </div>

    {{-- Requirements & Benefits --}}
    <div class="section">
        <h3>📝 المتطلبات</h3>
        @php
            $requirements = json_decode($OrgProgram->registrationRequirements->requirements, true);
        @endphp
        @if(is_array($requirements) && count($requirements))
            <ul>
                @foreach ($requirements as $requirement)
                    <li class="list-box">{{ $requirement }}</li>
                @endforeach
            </ul>
        @else
            <p>لا توجد متطلبات تسجيل.</p>
        @endif

        <h3>🌟 ميزات المسار</h3>
        @php
            $benefits = json_decode($OrgProgram->registrationRequirements->benefits, true);
        @endphp
        @if(is_array($benefits) && count($benefits))
            <ul>
                @foreach ($benefits as $benefit)
                    <li class="list-box">{{ $benefit }}</li>
                @endforeach
            </ul>
        @else
            <p>لا توجد ميزات.</p>
        @endif
    </div>

    {{-- Program Details --}}
    <div class="section">
        <h3>📋 ماذا يتضمن المسار</h3>
        @foreach ($OrgProgram->details as $program)
            @php $totalMinutes = 0; @endphp

            <div class="program-card" style="margin-bottom: 1.5rem;">

                {{-- Program Title Link --}}
                <a class="program-link" href="{{ route('org.training.show.program',  $program->id) }}" style="font-weight:bold; color:#3498db; text-decoration:none; display:block; margin-bottom:0.5rem;">
                    📌 {{ $program->program_title }}
                    <br>
                    👤 Trainer: {{ $program->Trainer->name }}
                </a>

                {{-- Sessions --}}
                @foreach ($program->trainingSchedules as $session)
                    @php
                        $sessionDuration = \Carbon\Carbon::parse($session->session_start_time)
                            ->diffInMinutes(\Carbon\Carbon::parse($session->session_end_time));
                        $totalMinutes += $sessionDuration;
                    @endphp

                    <div class="list-box" style="background:#f9f9f9; padding:0.5rem; margin-bottom:0.5rem; border-radius:6px;">
                        <strong>Day:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('l') }} |
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('d M') }} |
                        <strong>Time:</strong> {{ $session->session_start_time }} - {{ $session->session_end_time }} |
                        <strong>Duration:</strong> {{ $sessionDuration }} min
                    </div>
                @endforeach

                {{-- Program Duration --}}
                <p><strong>Program Duration:</strong> {{ round($totalMinutes / 60, 2) }} hours</p>
            </div>
        @endforeach
    </div>

    {{-- Organization Info --}}
    <div class="section">
        <h3>🏢 مقدم المسار</h3>
        <p><strong>{{ $OrgProgram->organization->user->name }}</strong></p>
        <p>{{ $OrgProgram->organization->user->bio }}</p>
        <p>Organization Type: {{ $OrgProgram->organization->type->name }}</p>

        <h3>👥 الميسّرون</h3>
        @if($OrgProgram->assistants->count())
            <ul>
                @foreach($OrgProgram->assistantUsers as $assistant)
                    <li class="list-box">{{ $assistant->name }} {{ $assistant->assistant->last_name }}</li>
                @endforeach
            </ul>
        @else
            <p>No assistants assigned.</p>
        @endif
    </div>


    

</body>
</html>
