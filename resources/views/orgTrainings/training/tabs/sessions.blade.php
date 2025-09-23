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
                                {{ formatTimeArabic($session->session_start_time) }} -
                                {{ formatTimeArabic($session->session_end_time) }}
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
                                    <form class="p-0" action="{{ route('orgSessions.destroy', $session->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tr-action-btn tr-action-delete" onclick="return confirm('هل أنت متأكد من حذف الجلسة؟')">
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