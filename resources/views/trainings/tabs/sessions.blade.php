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

    /* إخفاء عمود الأرقام على الشاشات الكبيرة */
    .tr-session-number-col {
        display: none;
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
        /* لون الخط فضي */
        border: 1px solid #D6D6D6;
        /* لون البوردر فضي */
        /* لون الخلفية يبقى كما هو أو يمكن تغييره */
        cursor: not-allowed;
        /* تغيير شكل المؤشر إلى علامة عدم السماح */
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

        /* إخفاء عمود الأرقام على الجوال (تم استبداله بالرقم في الزاوية) */
        .tr-session-number-col {
            display: none;
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
                    @foreach ($program->sessions as $index => $session)
                        <tr data-session-number="{{ $index + 1 }}">
                          
                            <td data-label="التاريخ">{{ $session->session_date }}</td>
                            <td data-label="التوقيت">
                          
                                {{ formatTimeArabic($session->session_start_time) }} -
                                {{ formatTimeArabic($session->session_end_time) }}</td>
                            
                            <td data-label="الحضور">{{ $sessionAttendanceCounts[$session->id] ?? 0 }}</td>
                            <td data-label="الحالة">
                                <span
                                    class="tr-status-badge 
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
                                    <form class="p-0" action="{{ route('sessions.destroy', $session->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tr-action-btn tr-action-delete"
                                            onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                            <img src="/images/cources/trash.svg">
                                        </button>
                                    </form>
                                    <button class="tr-action-btn tr-action-edit" data-bs-toggle="modal"
                                        data-bs-target="#editSessionModal{{ $session->id }}">
                                        <img src="/images/cources/edit-session.svg">
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- مودال تعديل الجلسة -->
                        <div class="modal fade" id="editSessionModal{{ $session->id }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content px-3 py-3">
                                    <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="إغلاق"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('sessions.update', $session->id) }}" method="POST"
                                            class="p-0">
                                            @csrf
                                            @method('PUT')
                                            

                                            <div class="input-group mb-4">
                                                <div class="d-flex flex-column-reverse">
                                                    <label class="w-100">تاريخ الجلسة ومدتها <span
                                                            class="required">*</span></label>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <input type="date" name="session_date" class="form-control"
                                                            value="{{ $session->session_date }}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="time" name="session_start_time"
                                                            class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($session->session_start_time)->format('H:i') }}"
                                                            required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="time" name="session_end_time"
                                                            class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($session->session_end_time)->format('H:i') }}"
                                                            required>
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
    <div class="modal-dialog modal-dialog-centered  modal-lg ">
        <div class="modal-content px-3 py-3">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="addSessionForm" action="{{ route('session.store', ['program_id' => $program->id]) }}"
                    class="p-0" method="POST">
                    @csrf
                    <div class="session-fields-container">
                        <!-- الجلسة الأولى -->
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
                                        <input type="date" name="schedules[0][session_date]"
                                            placeholder="مثال: 15 يونيو 2025" required>
                                    </div>

                                    <div style="width: 100%;">
                                        <input type="time" name="schedules[0][session_start_time]" required>
                                    </div>

                                    <div style="width: 100%;">
                                        <input type="time" name="schedules[0][session_end_time]" required>
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
    //تكرار التاريخ والوقت
    document.addEventListener('DOMContentLoaded', function() {
        let sessionIndex = 1;

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
                        <input type="time" name="schedules[${sessionIndex}][session_start_time]" required>
                    </div>

                    <div style="width: 100%;">
                        <input type="time" name="schedules[${sessionIndex}][session_end_time]" required>
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
        });
    });
</script>
