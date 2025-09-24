<!-- resources/views/orgTrainings/tabs/sessions.blade.php -->
<style>
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
</style>

<div class="tr-sessions-container">
    <div class="tr-sessions-card">
        <div class="tr-sessions-header">
            <h1 class="tr-sessions-title">الجلسات التدريبية</h1>
            <button class="custom-btn" data-bs-toggle="modal" data-bs-target="#addSessionModal">
                <img src="/images/cources/plus.svg">
                إضافة جلسة جديدة
            </button>
        </div>
        <div class="tr-sessions-table-container">
            <table class="tr-sessions-table">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>التوقيت</th>
                        <th>الحضور</th>
                        <th>الحالة</th>
                        <th>المتدربون</th>
                        <th>تفاعل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OrgProgramDetail->trainingSchedules as $index => $session)
                        <tr data-session-number="{{ $index + 1 }}">
                            <td data-label="التاريخ">{{ $session->session_date }}</td>
                            <td data-label="التوقيت">
                                {{ \Carbon\Carbon::parse($session->session_start_time)->format('g:i A') }} -
                                {{ \Carbon\Carbon::parse($session->session_end_time)->format('g:i A') }}
                            </td>
                            <td data-label="الحضور">{{ $sessionAttendanceCounts[$session->id] ?? 0 }}</td>
                            <td data-label="الحالة">
                                <span class="tr-status-badge 
                                    @if ($sessionStatuses[$session->id] == 'مكتمل') tr-status-completed
                                    @elseif($sessionStatuses[$session->id] == 'قيد التقدم') tr-status-in-progress
                                    @else tr-status-not-started @endif">
                                    {{ $sessionStatuses[$session->id] ?? 'غير محدد' }}
                                </span>
                            </td>
                            <td data-label="المتدربون">
                                <button class="tr-attendees-btn"
                                    onclick="window.location.href='{{ route('sessions.attendance', $session->id) }}?view={{ $sessionStatuses[$session->id] == 'مكتمل' ? 'show' : 'edit' }}'"
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
                                    <form class="p-0" action="{{ route('orgSessions.destroy', $session->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tr-action-btn tr-action-delete" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                            <img src="/images/cources/trash.svg">
                                        </button>
                                    </form>
                                    <button class="tr-action-btn tr-action-edit" data-bs-toggle="modal" data-bs-target="#editSessionModal{{ $session->id }}">
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
                                        <form action="{{ route('sessions.update', $session->id) }}" method="POST" class="p-0">
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
    </div>
</div>

<!-- مودال إضافة جلسة جديدة -->
<div class="modal fade" id="addSessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content px-3 py-3">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="addSessionForm" action="{{ route('session.store', ['program_id' => $OrgProgramDetail->trainingProgram->id]) }}" class="p-0" method="POST">
                    @csrf
                    <div class="session-fields-container">
                        <div class="session-group" style="position: relative; margin-top: 20px;">
                            <div class="input-group">
                                <div class="d-flex flex-column-reverse">
                                    <label class="w-100">تاريخ الجلسة و مدتها<span class="required">*</span></label>
                                </div>
                                <div class="sub-label">
                                    اختر التاريخ الذي ستُعقد فيه الجلسة ووقتي بدء وانتهاء الجلسة.
                                </div>
                                <div class="input-group-2col inner mb-3" style="align-items: flex-start;">
                                    <div style="width: 100%;">
                                        <input type="date" name="schedules[0][session_date]" placeholder="مثال: 15 يونيو 2025" required>
                                    </div>
                                    <div style="width: 100%;">
                                        <div class="time-picker-container">
                                            <div class="time-picker" data-type="start">وقت بدء الجلسة</div>
                                            <div class="time-picker-dropdown"></div>
                                            <input type="hidden" name="schedules[0][session_start_time]" class="time-picker-input" value="">
                                        </div>
                                    </div>
                                    <div style="width: 100%;">
                                        <div class="time-picker-container">
                                            <div class="time-picker" data-type="end">وقت انتهاء الجلسة</div>
                                            <div class="time-picker-dropdown"></div>
                                            <input type="hidden" name="schedules[0][session_end_time]" class="time-picker-input" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mt-3">
                        <button type="button" class="add-more-btn" id="add-session-btn">
                            <img src="{{ asset('images/icons/plus-main.svg') }}" />
                            <span>أضف جلسة جديدة</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 justify-content-center flex-row-reverse w-100 d-flex">
                <button type="button" class="btn-cancel mx-2 flex-fill" data-bs-dismiss="modal">
                    إلغاء
                </button>
                <button type="submit" form="addSessionForm" class="custom-btn mx-2 flex-fill">
                    حفظ و متابعة
                    <img src="{{ asset('images/cources/arrow-left.svg') }}">
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sessionIndex = 1;
        
        function generateTimeOptions() {
            const options = [];
            for (let hour = 0; hour < 24; hour++) {
                for (let minute = 0; minute < 60; minute += 15) {
                    const time24 = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                    let hour12 = hour % 12 || 12;
                    const ampm = hour < 12 ? 'صباحاً' : 'مساءً';
                    const time12 = `${hour12}:${minute.toString().padStart(2, '0')} ${ampm}`;
                    options.push({ value: time24, label: time12 });
                }
            }
            return options;
        }
        
        const timeOptions = generateTimeOptions();
        
        function formatTimeTo12Hour(time24) {
            if (!time24) return '';
            const [hours, minutes] = time24.split(':');
            const hour12 = hours % 12 || 12;
            const ampm = hours < 12 ? 'صباحاً' : 'مساءً';
            return `${hour12}:${minutes} ${ampm}`;
        }
        
        function formatTimeTo24Hour(time12) {
            if (!time12) return '';
            const match = time12.match(/(\d{1,2}):(\d{2})\s*(صباحاً|مساءً)/);
            if (!match) return '';
            
            let hours = parseInt(match[1]);
            const minutes = match[2];
            const period = match[3];
            
            if (period === 'مساءً' && hours < 12) hours += 12;
            else if (period === 'صباحاً' && hours === 12) hours = 0;
            
            return `${hours.toString().padStart(2, '0')}:${minutes}`;
        }
        
        function initializeTimePickers(container = document) {
            const timePickers = container.querySelectorAll('.time-picker');
            
            timePickers.forEach(picker => {
                const dropdown = picker.nextElementSibling;
                const hiddenInput = dropdown.nextElementSibling;
                const currentValue = hiddenInput.value;
                
                if (currentValue && currentValue !== 'وقت بدء الجلسة' && currentValue !== 'وقت انتهاء الجلسة') {
                    picker.textContent = formatTimeTo12Hour(currentValue);
                    hiddenInput.value = currentValue;
                } else {
                    const defaultText = picker.dataset.type === 'start' ? 'وقت بدء الجلسة' : 'وقت انتهاء الجلسة';
                    picker.textContent = defaultText;
                    if (!currentValue || currentValue === 'وقت بدء الجلسة' || currentValue === 'وقت انتهاء الجلسة') {
                        hiddenInput.value = '';
                    }
                }
                
                dropdown.innerHTML = '';
                timeOptions.forEach(option => {
                    const optionElement = document.createElement('div');
                    optionElement.className = 'time-picker-option';
                    optionElement.textContent = option.label;
                    optionElement.dataset.value = option.value;
                    
                    if (option.value === currentValue) {
                        optionElement.classList.add('selected');
                    }
                    
                    optionElement.addEventListener('click', function() {
                        picker.textContent = option.label;
                        hiddenInput.value = option.value;
                        
                        dropdown.querySelectorAll('.time-picker-option').forEach(opt => {
                            opt.classList.remove('selected');
                        });
                        optionElement.classList.add('selected');
                        
                        dropdown.style.display = 'none';
                        validateTimeInputs(picker);
                    });
                    
                    dropdown.appendChild(optionElement);
                });
                
                picker.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });
                
                document.addEventListener('click', function() {
                    dropdown.style.display = 'none';
                });
            });
        }
        
        function validateTimeInputs(timePicker) {
            const sessionGroup = timePicker.closest('.session-group') || timePicker.closest('.row');
            const startTimeInput = sessionGroup.querySelector('input[name$="[session_start_time]"], input[name="session_start_time"]');
            const endTimeInput = sessionGroup.querySelector('input[name$="[session_end_time]"], input[name="session_end_time"]');
            
            if (startTimeInput && endTimeInput && startTimeInput.value && endTimeInput.value) {
                const startTime = startTimeInput.value;
                const endTime = endTimeInput.value;
                
                if (startTime >= endTime) {
                    if (!endTimeInput.nextElementSibling || !endTimeInput.nextElementSibling.classList.contains('error-message')) {
                        const errorElement = document.createElement('span');
                        errorElement.className = 'error-message';
                        errorElement.textContent = 'وقت النهاية يجب أن يكون بعد وقت البداية';
                        errorElement.style.color = 'red';
                        errorElement.style.fontSize = '0.8rem';
                        endTimeInput.parentNode.insertBefore(errorElement, endTimeInput.nextSibling);
                    }
                    endTimeInput.style.borderColor = 'red';
                } else {
                    if (endTimeInput.nextElementSibling && endTimeInput.nextElementSibling.classList.contains('error-message')) {
                        endTimeInput.nextElementSibling.remove();
                    }
                    endTimeInput.style.borderColor = '';
                }
            }
        }
        
        function updateHiddenInputsBeforeSubmit() {
            document.querySelectorAll('.time-picker').forEach(picker => {
                const dropdown = picker.nextElementSibling;
                const hiddenInput = dropdown.nextElementSibling;
                
                if (picker && hiddenInput) {
                    const pickerText = picker.textContent.trim();
                    if (pickerText === 'وقت بدء الجلسة' || pickerText === 'وقت انتهاء الجلسة' || pickerText === '') {
                        hiddenInput.value = '';
                    } else {
                        const time24 = formatTimeTo24Hour(pickerText);
                        hiddenInput.value = time24;
                    }
                }
            });
        }
        
        initializeTimePickers();
        
        document.getElementById('add-session-btn').addEventListener('click', function() {
            const container = document.querySelector('.session-fields-container');
            const newSession = document.createElement('div');
            
            newSession.className = 'session-group';
            newSession.style.position = 'relative';
            newSession.style.marginTop = '20px';
            
            newSession.innerHTML = `
                <div class="input-group">
                    <div class="d-flex flex-column-reverse">
                        <label class="w-100">تاريخ الجلسة و مدتها<span class="required">*</span></label>
                    </div>
                    <div class="sub-label">
                        اختر التاريخ الذي ستُعقد فيه الجلسة ووقتي بدء وانتهاء الجلسة.
                    </div>
                    <div class="input-group-2col inner mb-3" style="align-items: flex-start;">
                        <div style="width: 100%;">
                            <input type="date" name="schedules[${sessionIndex}][session_date]" placeholder="مثال: 15 يونيو 2025" required>
                        </div>
                        <div style="width: 100%;">
                            <div class="time-picker-container">
                                <div class="time-picker" data-type="start">وقت بدء الجلسة</div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden" name="schedules[${sessionIndex}][session_start_time]" class="time-picker-input" value="">
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <div class="time-picker-container">
                                <div class="time-picker" data-type="end">وقت انتهاء الجلسة</div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden" name="schedules[${sessionIndex}][session_end_time]" class="time-picker-input" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="remove-session-btn" 
                        style="position: absolute; left: -6px; top: -3px; background: none; border: none; cursor: pointer;"
                        onclick="this.closest('.session-group').remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                        <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                    </svg>
                </button>
            `;
            
            container.appendChild(newSession);
            sessionIndex++;
            
            initializeTimePickers(newSession);
        });
        
        document.getElementById('addSessionForm').addEventListener('submit', function(e) {
            updateHiddenInputsBeforeSubmit();
        });
        
        document.querySelectorAll('form[action*="sessions/update"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                updateHiddenInputsBeforeSubmit();
            });
        });
    });
</script>

<style>
    .time-picker-container {
        position: relative;
        width: 100%;
        border: 1px solid #a5a5a5;
        border-radius: 6px;
        padding: 14px 24px;
        font-size: 1rem;
        background: #ffffff;
        outline: none;
        transition: border 0.2s;
        box-sizing: border-box;
        width: 100%;
    }
    .time-picker {
        width: 100%;
        padding: 10px 40px 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        cursor: pointer;
        position: relative;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        height: 42px;
    }
    .time-picker::after {
        content: '';
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 22px;
        height: 24px;
        background-image: url("data:image/svg+xml,%3Csvg width='22' height='24' viewBox='0 0 22 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M10.974 16.803C10.6462 16.8032 10.3217 16.7326 10.0189 16.5953C9.71614 16.458 9.4411 16.2567 9.20953 16.003L3.24878 9.48004C3.13015 9.33739 3.0663 9.15024 3.07051 8.95746C3.07471 8.76467 3.14665 8.58106 3.27137 8.44477C3.39609 8.30847 3.56402 8.22997 3.74027 8.22555C3.91652 8.22113 4.08756 8.29114 4.21786 8.42104L10.1804 14.94C10.3915 15.1706 10.6775 15.3001 10.9758 15.3001C11.2741 15.3001 11.5602 15.1706 11.7712 14.94L17.7319 8.42004C17.8619 8.28756 18.0338 8.21544 18.2115 8.21887C18.3891 8.2223 18.5586 8.30101 18.6842 8.43842C18.8098 8.57583 18.8818 8.76122 18.8849 8.95552C18.8881 9.14982 18.8221 9.33787 18.701 9.48004L12.7403 16.003C12.5085 16.257 12.2331 16.4584 11.93 16.5957C11.6269 16.7329 11.302 16.8034 10.974 16.803Z' fill='%23444444'/%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        transition: transform 0.3s ease;
    }
    .time-picker-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 100;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }
    .time-picker-option {
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .time-picker-option:hover {
        background-color: #f5f5f5;
    }
    .time-picker-option.selected {
        background-color: #e9f5ff;
        font-weight: bold;
    }
    .time-picker-input {
        display: none;
    }
    @media (max-width: 768px) {
        .time-picker-dropdown {
            max-height: 150px;
        }
    }
</style>