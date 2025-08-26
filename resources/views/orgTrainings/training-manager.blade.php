<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Training Program Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 2rem;
            background-color: #f9fbfd;
            color: #333;
        }

        h1, h2 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        p {
            margin: 0.4rem 0;
        }

        .card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .program-card {
            margin-bottom: 2rem;
        }

        .program-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.6rem;
        }

        .program-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2980b9;
        }

        .trainer {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.8rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        table th, table td {
            border: 1px solid #e1e1e1;
            padding: 0.6rem;
            text-align: left;
            font-size: 0.9rem;
        }

        table th {
            background: #f2f6fa;
            font-weight: 600;
        }

        table tr:nth-child(even) {
            background: #fafafa;
        }

        /* Buttons */
        .btn {
            padding: 0.3rem 0.7rem;
            font-size: 0.85rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
            color: #fff;
        }

        .btn-edit {
            background: #3498db;
        }
        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: #e74c3c;
        }
        .btn-delete:hover {
            background: #c0392b;
        }

        .action-buttons {
            display: flex;
            gap: 0.4rem;
        }
    </style>
</head>
<body>

    {{-- Program Header --}}
    <div class="card">
        <h1>{{ $OrgProgram->title }}</h1>
        <p><strong>Description:</strong> {{ $OrgProgram->program_description }}</p>
        <p><strong>Level:</strong> {{ $OrgProgram->trainingLevel->name }}</p>
        <p><strong>Max trainees:</strong> {{ $OrgProgram->registrationRequirements->max_trainees }}</p>
        <p><strong>Classification:</strong>
            @foreach ($orgTrainingClassification as $Classification)
            {{ $Classification }} ,
            @endforeach </p>
        <p><strong>Application Method:</strong> {{ $OrgProgram->program_presentation_method }}</p>
        <p><strong>Registration Method:</strong> {{ $OrgProgram->registrationRequirements->application_submission_method }}</p>
        <p><strong>Language:</strong> {{ $OrgProgram->language->name }}</p>
        <p><strong>Location:</strong> {{ $OrgProgram->country->name }} , {{ $OrgProgram->city }}</p>
        {{-- <p><strong>Total Sessions:</strong> {{ $OrgProgram->details->sum('num_of_session') }}</p> --}}
    </div>

    {{-- Training Programs --}}
    <div class="card">
        <h1>تدريبات المسار</h1>

        @foreach ($OrgProgram->details as $program)
            <div class="program-card">
                <div class="program-header">
                    <div class="program-title">{{ $program->program_title }}</div>
                    <div class="action-buttons">
                        <a href="" class="btn btn-edit">Edit</a>
                        <form action="{{ route('org.training.manager.destroy', $program->id)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="trainer">👤 Trainer: {{ $program->Trainer->name }}</div>

                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($program->trainingSchedules as $session)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}</td>
                                <td>{{ $session->session_start_time }} - {{ $session->session_end_time }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="" class="btn btn-edit">Edit</a>
                                        <form action="" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>


    <div class="card">
        <h1>معلومات المسار</h1>
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

        <h3>الوصف</h3>
        <p>{{ $OrgProgram->program_description }}</p>

        <h3>📅 ما الذي سيتعلمه اشلماركون </h3>
        @if($OrgProgram->goals->count())
            <ul>
                @foreach($OrgProgram->goals as $goal)
                    @foreach ($goal->learning_outcomes as $learning_outcome)
                        <li>{{ $learning_outcome }}</li>
                    @endforeach
                @endforeach
            </ul>
        @else
            <p>No goals listed.</p>
        @endif

        <h3>الية الدفع</h3>
        <p>{{ $OrgProgram->registrationRequirements->payment_method }}</p>


     <h3>الرسالة الترحيبية</h3>
        <p>{{ $OrgProgram->registrationRequirements->welcome_message }}</p>

    </div>




</body>
</html>
