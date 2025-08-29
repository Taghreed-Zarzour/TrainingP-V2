<style>
    /* كلاسات معزولة ببادئة خاصة */
    .tr-sessions-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 10px;
        margin-bottom: 20px;
    }
    .tr-sessions-header {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }
    @media (min-width: 768px) {
        .tr-sessions-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
    .tr-sessions-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
    }
    .tr-sessions-add-btn {
        background-color: #3498db;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }
    /* تصميم الجدول للشاشات الكبيرة */
    .tr-sessions-table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .tr-sessions-table {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }
    .tr-sessions-table thead th {
        background-color: #DAE3FF;
        color: #003090;
        font-weight: 400;
        padding: 12px 15px;
        text-align: right;
    }
    .tr-sessions-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f1f1;
    }
    .tr-sessions-table tbody tr:last-child td {
        border-bottom: none;
    }
    .tr-session-title {
        font-weight: 500;
        color: #232323;
    }
    .tr-status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        text-align: center;
        min-width: 90px;
    }
    .tr-status-completed {
        background-color: #AFEDCC;
        color: #00AF6C;
    }
    .tr-status-in-progress {
        background-color: #FFC62A45;
        color: #FFC62A;
    }
    .tr-status-not-started {
        background-color: #D6D6D6;
        color: white;
    }
    .tr-attendees-btn {
        padding: 10px 20px;
        border-radius: 50px;
        text-align: center;
        cursor: pointer;
        border: 1px solid #003090;
        color: #003090;
        background-color: white;
        transition: background-color 0.3s ease;
    }
    .tr-attendees-btn:hover {
        background-color: #e4e4e4;
    }
    .tr-attendees-btn:disabled {
        color: #c0c0c0;
        border: 1px solid #D6D6D6;
        cursor: not-allowed;
    }
    .tr-action-buttons {
        display: flex;
        background-color: #f8f9fa;
        border-radius: 4px;
        overflow: hidden;
        border: 1px solid #B6BDD5;
    }
    .tr-action-btn {
        border: none;
        background: none;
        padding: 6px 10px;
        transition: all 0.2s;
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .tr-action-btn:not(:last-child) {
        border-left: 1px solid #B6BDD5;
    }
    .tr-action-edit {
        color: #2980b9;
    }
    .tr-action-edit:hover {
        background-color: rgba(41, 128, 185, 0.1);
    }
    .tr-action-delete {
        color: #e74c3c;
    }
    .tr-action-delete:hover {
        background-color: rgba(231, 76, 60, 0.1);
    }
    /* تصميم الجدول للجوال - تحويل إلى بطاقات */
    @media (max-width: 767px) {
        .tr-sessions-table {
            min-width: 100%;
            border: none;
        }
        .tr-sessions-table thead {
            display: none;
        }
        .tr-sessions-table tbody,
        .tr-sessions-table tr,
        .tr-sessions-table td {
            display: block;
            width: 100%;
            text-align: right;
        }
        .tr-sessions-table tr {
            position: relative;
            background: #fff;
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 12px 12px 40px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        /* رقم الجلسة على الجوال */
        .tr-sessions-table tr::before {
            content: attr(data-session-number);
            position: absolute;
            left: 10px;
            top: 15px;
            font-weight: 700;
            color: #2980b9;
            background-color: #f0f7ff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d0e3ff;
        }
        .tr-sessions-table td {
            padding: 5px 0px !important;
            position: relative;
            font-size: 0.95rem;
            border: none;
            border-bottom: 1px solid #f5f5f5;
        }
        .tr-sessions-table td:last-child {
            border-bottom: none;
        }
        .tr-sessions-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 4px;
            font-size: 0.85rem;
        }
        .tr-status-badge {
            min-width: 80px;
            padding: 5px 10px;
        }
        .tr-action-btn {
            padding: 6px 8px;
            border-radius: 4px;
            margin: 2px;
            background-color: #f8f9fa;
        }
    }
    
    /* تصميم الكروت */
    .program-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #eaeaea;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .program-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .program-card-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .program-details {
        flex: 1;
        display: flex;
        align-items: center;
    }
    .program-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }
    .arrow-icon {
        margin-left: 10px;
        transition: transform 0.3s ease;
    }
    .arrow-icon.rotated {
        transform: rotate(90deg);
    }
    .program-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .trainer-info {
        display: flex;
        align-items: center;
    }
    .trainer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: 10px;
    }
    .trainer-name {
        font-size: 0.9rem;
        color: #666;
    }
    .sessions-container {
        display: none;
        margin-top: 15px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    .sessions-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    .sessions-table th, .sessions-table td {
        border: 1px solid #e1e1e1;
        padding: 0.6rem;
        text-align: right;
        font-size: 0.9rem;
    }
    .sessions-table th {
        background: #f2f6fa;
        font-weight: 600;
    }
    .sessions-table tr:nth-child(even) {
        background: #fafafa;
    }
    .session-actions {
        display: flex;
        gap: 0.4rem;
    }
    .btn-attendance {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
    }
    .btn-attendance:hover {
        background-color: #218838;
    }
    .no-sessions-message {
        padding: 15px;
        text-align: center;
        color: #666;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .program-stats {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 0.9rem;
        color: #666;
    }
    .stat-item {
        display: flex;
        align-items: center;
    }
    .stat-icon {
        margin-left: 5px;
    }
    .add-program-btn {
        background-color: #3498db;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
    .empty-state img {
        width: 100px;
        opacity: 0.5;
        margin-bottom: 15px;
    }
    
    /* معلومات التدريب */
    .info-box {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
    }
    .info-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    .learning-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 8px;
    }
    .learning-item img {
        margin-left: 8px;
        margin-top: 3px;
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>تدريبات المسار</h2>
<button class="custom-btn" 
    onclick="window.location.href='{{ route('orgTraining.trainingDetail', $OrgProgram->id) }}'">
    <img src="/images/cources/plus.svg" alt="إضافة" class="me-2">
    إضافة تدريب جديد
</button>

    </div>

    @if ($OrgProgram->details->count() > 0)
        @foreach ($OrgProgram->details as $program)
            <div class="program-card" onclick="toggleSessions({{ $program->id }})">
                <div class="program-card-content">
                    <div class="program-details">
                        <div class="program-title">
                          

                                                                                    <div class="me-2">
                                                            <svg class="arrow-icon" id="arrow-{{ $program->id }}"
                                                                width="13" height="15" viewBox="0 0 13 15"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11.5001 5.88654C12.6655 6.68745 12.6543 8.41186 11.4787 9.19762L3.59254 14.4684C2.25871 15.3599 0.470856 14.3969 0.481237 12.7926L0.550107 2.14951C0.560488 0.545226 2.36065 -0.394492 3.68284 0.514171L11.5001 5.88654Z"
                                                                    fill="#666666" />
                                                            </svg>
                                                        </div>
                                                          {{ $program->program_title }}
                        </div>
                    </div>
                    <div class="program-actions">
                        <div class="trainer-info">
                            @if ($program->Trainer)
                                @if ($program->Trainer->photo)
                                    <img src="{{ asset('storage/' . $program->Trainer->photo) }}" class="trainer-avatar" alt="صورة المدرب">
                                @else
                                    <img src="{{ asset('images/icons/user.svg') }}" class="trainer-avatar" alt="صورة المدرب">
                                @endif
                                <div class="trainer-name m-0">
                                    {{ $program->Trainer->getTranslation('name', 'ar') }}
                                    {{ $program->Trainer->trainer?->getTranslation('last_name', 'ar') }}
                                </div>
                            @else
                                <div class="trainer-name m-0">لم يتم تحديد مدرب</div>
                            @endif
                        </div>
                        <div class="tr-action-buttons">
                            <a href="{{ route('orgTraining.trainingDetail', $OrgProgram->id) }}" class="tr-action-btn tr-action-edit" onclick="event.stopPropagation();">
                                <img src="/images/cources/edit-session.svg">
                            </a>
                            <form class="p-0" action="{{ route('orgTraining.destroy', $program->id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="tr-action-btn tr-action-delete">
                                    <img src="/images/cources/trash.svg">
                                </button>
                            </form>
                        </div>
<button type="button" class="custom-btn" 
    onclick="event.stopPropagation(); window.location.href='{{ route('org.training.show.program', $program->id) }}'">
    تفاصيل التدريب
</button>

                    </div>
                </div>
                
                <div id="sessions-{{ $program->id }}" class="sessions-container">
                    <div class="content-training">
                        @if (count($program->trainingSchedules) == 0)
                            <!-- عرض معلومات التدريب بدلاً من الجدول -->
                            <div class="info-box">
                                <h4 class="info-title">معلومات التدريب</h4>
                                <div class="learning-item">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                                    <span>عدد الجلسات: {{ $program->num_of_session ?? 'غير محدد' }}</span>
                                </div>
                                <div class="learning-item">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                                    <span>عدد الساعات: {{ $program->num_of_hours ?? 'غير محدد' }}</span>
                                </div>
                            </div>
                        @else
                            <!-- عرض جدول الجلسات -->
                            <div class="tr-sessions-table-container">
                                <table class="tr-sessions-table">
                                    <thead>
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>التوقيت</th>
                                            <th>الحالة</th>
                                            <th>عدد الحضور</th>
                                            <th>المتدربون</th>
                                            <th>تفاعل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($program->trainingSchedules as $session)
                                            <tr id="row-{{ $session->id }}">
                                                <td data-label="التاريخ">{{ $session->session_date }}</td>
                                                <td data-label="التوقيت">
                                                    {{ formatTimeArabic($session->session_start_time) }} -
                                                    {{ formatTimeArabic($session->session_end_time) }}
                                                </td>
                                                <td data-label="الحالة">
                                                    <span class="tr-status-badge 
                                                        @if ($sessionStatuses[$session->id] == 'مكتمل') tr-status-completed
                                                        @elseif($sessionStatuses[$session->id] == 'قيد التقدم') tr-status-in-progress
                                                        @else tr-status-not-started @endif">
                                                        {{ $sessionStatuses[$session->id] ?? 'غير محدد' }}
                                                    </span>
                                                </td>
                                                <td data-label="الحضور">{{ $sessionAttendanceCounts[$session->id] ?? 0 }}</td>
                                                <td data-label="المتدربون">
                                                    <button class="tr-attendees-btn"
                                                        onclick="window.location.href='{{ route('orgSession.attendance', $session->id) }}?view={{ $sessionStatuses[$session->id] == 'مكتمل' ? 'show' : 'edit' }}'"
                                                        @if ($sessionStatuses[$session->id] == 'لم تبدأ') disabled @endif>
                                                        @if ($sessionStatuses[$session->id] == 'مكتمل')
                                                            عرض الحضور
                                                        @else
                                                            تحديد الحضور
                                                        @endif
                                                    </button>
                                                </td>
                                                <td data-label="تفاعل">
                                                    <div class="tr-action-buttons">
                                                        <form class="p-0" action="{{ route('sessions.destroy', $session->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="tr-action-btn tr-action-delete"
                                                                onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                                <img src="/images/cources/trash.svg">
                                                            </button>
                                                        </form>
                                                        <button class="tr-action-btn tr-action-edit p-0" data-bs-toggle="modal"
                                                            data-bs-target="#editSessionModal{{ $session->id }}">
                                                            <img src="/images/cources/edit-session.svg">
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!-- مودال تعديل الجلسة -->
                                            <div class="modal fade" id="editSessionModal{{ $session->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content px-3 py-3">
                                                        <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('orgSessions.update', $session->id) }}" method="POST" class="p-0">
                                                                @csrf
                                                                @method('PUT')
                                                                
                                                                <div class="input-group mb-4">
                                                                    <div class="d-flex flex-column-reverse">
                                                                        <label class="w-100">تاريخ الجلسة ومدتها <span class="required">*</span></label>
                                                                    </div>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <input type="date" name="session_date" class="form-control" value="{{ $session->session_date }}" required>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="time-picker-container">
                                                                                <div class="time-picker" data-type="start">
                                                                                    {{ \Carbon\Carbon::parse($session->session_start_time)->format('g:i A') }}
                                                                                </div>
                                                                                <div class="time-picker-dropdown"></div>
                                                                                <input type="hidden" name="session_start_time" class="time-picker-input" 
                                                                                       value="{{ \Carbon\Carbon::parse($session->session_start_time)->format('H:i') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="time-picker-container">
                                                                                <div class="time-picker" data-type="end">
                                                                                    {{ \Carbon\Carbon::parse($session->session_end_time)->format('g:i A') }}
                                                                                </div>
                                                                                <div class="time-picker-dropdown"></div>
                                                                                <input type="hidden" name="session_end_time" class="time-picker-input" 
                                                                                       value="{{ \Carbon\Carbon::parse($session->session_end_time)->format('H:i') }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer border-0 px-0">
                                                                    <button type="submit" class="custom-btn w-100 py-2">
                                                                        حفظ التعديلات
                                                                        <img src="{{ asset('images/cources/arrow-left.svg') }}">
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
    
            <h4>لا توجد تدريبات في هذا المسار</h4>
            <p>يمكنك إضافة تدريبات جديدة من خلال الزر أعلاه</p>
        </div>
    @endif
</div>



<script>
    function toggleSessions(programId) {
        const sessionsContainer = document.getElementById(`sessions-${programId}`);
        const arrowIcon = document.getElementById(`arrow-${programId}`);
        
        if (sessionsContainer.style.display === 'none' || sessionsContainer.style.display === '') {
            sessionsContainer.style.display = 'block';
            if (arrowIcon) {
                arrowIcon.classList.add('rotated');
            }
        } else {
            sessionsContainer.style.display = 'none';
            if (arrowIcon) {
                arrowIcon.classList.remove('rotated');
            }
        }
    }
</script>