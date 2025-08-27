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

        #editPopup {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: 9999;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.popup-overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
}

.popup-content {
    position: relative;
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    width: 400px;
    max-width: 90%;
    z-index: 10;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    animation: fadeIn 0.2s ease;
}

.popup-close {
    position: absolute;
    top: 10px; right: 12px;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}

h3 {
    margin-top: 0;
    margin-bottom: 1rem;
    color: #2980b9;
    font-weight: 600;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 0.3rem;
    display: block;
}

.popup-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.btn {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    transition: 0.2s;
}

.btn-primary {
    background: #3498db;
    color: #fff;
}

.btn-primary:hover {
    background: #2980b9;
}

.btn-secondary {
    background: #7f8c8d;
    color: #fff;
}

.btn-secondary:hover {
    background: #616e70;
}

.btn-attendance {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    margin-left: 5px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
    </style>
</head>
<body>

    {{-- Program Header --}}
    <div class="card">
        <h1>{{ $OrgProgram->title }}</h1>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('storage/' . $OrgProgram->registrationRequirements->training_image) }}" alt="Training Image" width="200" height="200">

            <div style="margin-top: 10px;">
                <!-- Edit Button -->
                <form action="{{ route('orgImage.update', $OrgProgram->registrationRequirements->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="file" name="training_image" required>
                    <button type="submit" class="btn btn-primary">Update Image</button>
                </form>


                <!-- Delete Button -->
                <form action="{{ route('orgImage.delete', $OrgProgram->registrationRequirements->id)  }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this image?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>

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
                        <form action="{{ route('orgTrainingsManager.destroy', $program->id)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="trainer">👤 Trainer: {{ $program->Trainer->name }}</div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Attendance number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($program->trainingSchedules as $session)
                            <tr id="row-{{ $session->id }}">
                                <td class="session-date" data-raw-date="{{ $session->session_date }}">
                                    {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}
                                </td>

                                <td class="session-time">{{ $session->session_start_time }} - {{ $session->session_end_time }}</td>
                                <td>
                                    <span class="tr-status-badge
                                        @if ($sessionStatuses[$session->id] == 'مكتمل') tr-status-completed
                                        @elseif($sessionStatuses[$session->id] == 'قيد التقدم') tr-status-in-progress
                                        @else tr-status-not-started @endif">
                                        {{ $sessionStatuses[$session->id] ?? 'غير محدد' }}
                                    </span>
                                </td>
                                <td >{{ $sessionAttendanceCounts[$session->id] ?? 0 }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <!-- Edit button -->
                                        <button type="button" class="btn btn-edit" data-session-id="{{ $session->id }}">
                                            Edit
                                        </button>

                                        <!-- Delete button -->
                                        <form action="{{ route('orgSessions.destroy', $session->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">Delete</button>
                                        </form>

                                        <!-- Attendance button -->
                                        <a href="{{ route('orgSession.attendance', $session->id) }}" class="btn btn-attendance">
                                            تحديد الحضور
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            @endforeach
        </div>


<!-- Popup container -->
<div id="editPopup" style="display:none;">
    <div class="popup-overlay"></div>
    <div class="popup-content">
        <button id="closePopup" class="popup-close">&times;</button>
        <h3>Edit Session</h3>
        <form action="{{ route('orgSessions.update', $session->id) }}" id="popupForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="session_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Start Time</label>
                <input type="time" name="session_start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label>End Time</label>
                <input type="time" name="session_end_time" class="form-control" required>
            </div>
            <div class="popup-actions">
                <button type="button" id="cancelPopup" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>


<div class="card">
    <h3 class="card-header">الاحصائيات</h3>
    <p><strong>views:</strong> {{ $OrgProgram->views }}</p>
    <p><strong>participants count:</strong> {{ count($participants) }}</p>
    <p><strong>trainees count:</strong> {{ count($trainees)}}</p>
    <p><strong>Overall Attendance percentage:</strong> {{ $overallAttendancePercentage}}</p>

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




    <div class="card p-4">
        <h1 class="mb-4">ميسرو البرنامج</h1>

        <!-- Add Assistant Button -->
        <div class="mb-3 text-end">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#assistantsList" aria-expanded="false" aria-controls="assistantsList">
                إضافة ميسر
            </button>
        </div>
        <br>


       <!-- Hidden List -->
<div class="collapse" id="assistantsList">
    <div class="card card-body">
        <h5 class="mb-3">اختر ميسر:</h5>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assistants as $assistant)
                    <tr>
                        <td>{{ $assistant->name }} {{ $assistant->last_name }}</td>
                        <td>
                            <form action="{{ route('orgAssistant.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="assistant_id" value="{{ $assistant->id }}">
                                <input type="hidden" name="orgTraining_id" value="{{ $OrgProgram->id }}">
                                <button type="submit" class="btn btn-success btn-sm">اختيار</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

        @if($OrgProgram->assistantUsers->count())
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الهاتف</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($OrgProgram->assistantUsers as $assistant)
                        <tr>
                            <td>{{ $assistant->name }} {{ $assistant->assistant->last_name }}</td>
                            <td>{{ $assistant->email }}</td>
                            <td>{{ $assistant->phone_number }}</td>
                            <td>
                                <!-- Delete Button -->
                                <form action="{{ route('orgAssistant.destroy', ['assistant_id'=> $assistant->id, 'orgTraining_id'=>$OrgProgram->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm"
                                            style="background-color: #dc3545; color: white;"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا الميسر؟')">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لا توجد ميسرو.</p>
        @endif
    </div>

    <div class="card">
        <h3>المتقدمون</h3>
        @foreach($participants as $participant)
            <div class="border p-3 mb-3">
                <strong>{{ $participant->user->name }} {{ $participant->last_name }}</strong>


                    <form action="{{ route('participants.handleAction', [$OrgProgram->id, $participant->id]) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="action" value="accept">
                        <input type="hidden" name="is_org" value="true"> <!-- or "false" if it's a regular program -->
                        <button type="submit" class="btn btn-success btn-sm">قبول</button>
                    </form>

                    <form action="{{ route('participants.handleAction', [$OrgProgram->id, $participant->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="is_org" value="true"> <!-- أو "false" حسب نوع البرنامج -->
                        <input type="hidden" name="action" value="reject">
                        <button type="submit">رفض</button>
                    </form>

                    <form action="{{ route('participants.submitReason', [$OrgProgram->id, $participant->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="is_org" value="true">
                        <input type="text" name="rejection_reason" class="form-control" placeholder="سبب الرفض">
                        <button type="submit" class="btn btn-warning">حفظ السبب</button>
                    </form>

                    <form action="{{ route('participants.bulkAccept', $OrgProgram->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="is_org" value="true"> <!-- or "false" -->
                        <button type="submit" class="btn btn-success">قبول جميع المتدربين</button>
                    </form>
            </div>
        @endforeach
    </div>


    <div class="card">
        <h3 class="card-header">المتدربون</h3>
        <div class="card-body">
            @forelse($trainees as $trainee)
                <div class="border rounded p-3 mb-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>الاسم:</strong> {{ $trainee->user->name }} {{ $trainee->last_name }}<br>
                            <strong>البريد الإلكتروني:</strong> {{ $trainee->user->email }}<br>
                            <strong>رقم الهاتف:</strong> {{ $trainee->user->phone_number }}
                            <strong>نسبة الحضور</strong>{{ $attendanceStats[$trainee->id] ?? '0' }}%
                        </div>
                        <div>
                            <form action="{{ route('acceptedTrainee.delete', [$trainee->id, $OrgProgram->id]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المتدرب؟')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="is_org" value="true"> {{-- or "false" --}}
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>

                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">لا يوجد متدربون مسجلون حتى الآن.</p>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const popup = document.getElementById('editPopup');
            const form = document.getElementById('popupForm');
            const closeBtn = document.getElementById('closePopup');
            const cancelBtn = document.getElementById('cancelPopup');

            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function () {
                    const sessionId = this.dataset.sessionId;
                    const row = document.querySelector(`#row-${sessionId}`);

                    const dateStr = row.querySelector('.session-date').dataset.rawDate || row.querySelector('.session-date').innerText;
                    const timeRange = row.querySelector('.session-time').innerText.split(' - ');
                    const startTime = timeRange[0];
                    const endTime = timeRange[1];

                    form.querySelector('[name="session_date"]').value = dateStr; // YYYY-MM-DD
                    form.querySelector('[name="session_start_time"]').value = startTime;
                    form.querySelector('[name="session_end_time"]').value = endTime;
                    popup.style.display = 'flex';
                });
            });

            // Close popup
            closeBtn.addEventListener('click', () => popup.style.display = 'none');
            cancelBtn.addEventListener('click', () => popup.style.display = 'none');
            popup.addEventListener('click', e => { if(e.target === e.currentTarget) popup.style.display = 'none'; });
        });
        </script>




</body>
</html>
