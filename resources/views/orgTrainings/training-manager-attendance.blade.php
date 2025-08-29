@extends('frontend.layouts.master')

@section('title', 'تحديد الحضور')

@section('content')

    <!-- Blue Header Section -->
    <div class="blue-header full-width-header mt-4">
        <div class="container d-flex justify-content-center">
            <div class="col-12 col-lg-7 text-center">
                <div class="title-wrapper">
                    <h1 class="d-inline-block lh-base">
                        @if ($viewType === 'show')
                            عرض الحضور للجلسة
                        @else
                            تحديد الحضور للجلسة
                        @endif
                    </h1>
                </div>
                <div class="mb-4">
    المسار التدريبي / {{ $session->trainingProgram->trainingProgram->title }}
    / {{ $session->trainingProgram->program_title }}
  
</div>

            </div>
        </div>
    </div>

    <div class="tr-trainees-container">
        <div class="tr-trainees-card">
            @if ($viewType === 'show')
                <!-- عرض الحضور فقط -->
                <div class="tr-trainees-header">
                    <h4>عرض الحضور للجلسة</h4>
                </div>

                @if ($session_attendance->isEmpty())
                    <div class="alert alert-info text-center py-4">
                        <i class="fas fa-info-circle fa-2x mb-3"></i>
                        <h5>لا يوجد أي حضور مسجل لهذه الجلسة حتى الآن</h5>
                        <p class="mb-0">لم يتم تسجيل حضور أي متدرب لهذه الجلسة.</p>
                    </div>
                @else
                    <div class="tr-trainees-content tr-view-table">
                        <div class="tr-trainees-table-container tr-table-view">
                            <table class="tr-trainees-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم المتدرب</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>رقم الهاتف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($session_attendance as $index => $trainee)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="tr-trainee-name">
                                                    <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب"
                                                        class="tr-trainee-avatar">
                                                    <span>{{ $trainee->user->name }} {{ $trainee->last_name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $trainee->user->email }}</td>
                                            <td>{{ $trainee->user->phone_number }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="alert alert-success text-center mt-3">
                        <i class="fas fa-check-circle"></i>
                        إجمالي عدد الحضور: {{ $session_attendance->count() }} متدرب
                    </div>
                @endif
            @else
                <h4>تحديد الحضور للجلسة: {{ $session->session_title }}</h4>
                <!-- تحديد الحضور -->
                <div class="tr-trainees-header mt-4">
                    @if ($trainees->isNotEmpty())
                        <div class="tr-bulk-actions d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input me-2" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">تحديد الكل</label>
                            </div>
                            <button class="tr-select-all-btn" id="markPresentBtn">تأكيد الحضور</button>
                        </div>
                    @endif


                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($trainees->isEmpty())
                    @if ($session_attendance->isEmpty())
                        <div class="text-center">
                            <i class=" mb-3"></i>
                            <h5>لا يوجد متدربين متاحين لتسجيل الحضور</h5>
                            <p class="mb-0">جميع المسجلين في البرنامج قد تم تسجيل حضورهم بالفعل أو لا يوجد متدربين مسجلين.
                            </p>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="mb-3"></i>
                            <h5>جميع المتدربين قاموا بالحضور</h5>
                            <p class="mb-0">تم تسجيل حضور جميع المتدربين المسجلين في هذه الجلسة.</p>
                        </div>
                    @endif
                @endif

                @if ($trainees->isNotEmpty())
                    <form action="{{ route('orgSession.attendance.store', ['session' => $session->id]) }}" method="POST"
                        id="attendanceForm">
                        @csrf

                        <div class="tr-trainees-content tr-view-table">
                            <div class="tr-trainees-table-container tr-table-view">
                                <table class="tr-trainees-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="masterCheckbox">
                                                </div>
                                            </th>
                                            <th>اسم المتدرب</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>رقم الهاتف</th>
                                            <th>التفاصيل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trainees as $trainee)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input trainee-checkbox" type="checkbox"
                                                            name="attended[]" value="{{ $trainee->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="tr-trainee-name">
                                                        <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب"
                                                            class="tr-trainee-avatar">
                                                        <span>{{ $trainee->user->getTranslation('name', 'ar') }} {{ $trainee->getTranslation('last_name', 'ar')  }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $trainee->user->email }}</td>
                                                <td>{{ $trainee->user->phone_number }}</td>
                                                <td>
                                                    <button type="button"
                                                        onclick="window.location='{{ route('show_trainee_profile', $trainee->id) }}'"
                                                        class="tr-details-btn">
                                                        عرض التفاصيل
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="alert alert-info text-center mt-3">
                            <i class="fas fa-info-circle"></i>
                            متبقي لتسجيل حضورهم: {{ $trainees->count() }} متدرب
                        </div>
                    </form>
                @endif

                @if ($session_attendance->count() > 0)
                    <div class="mt-5">
                        <h4 class="mb-4">الطلاب المسجل حضورهم</h4>
                        <div class="tr-trainees-content tr-view-table">
                            <div class="tr-trainees-table-container tr-table-view">
                                <table class="tr-trainees-table">
                                    <thead>
                                        <tr>
                                            <th>اسم المتدرب</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>رقم الهاتف</th>
                                            <th>التفاصيل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($session_attendance as $trainee)
                                            <tr>
                                                <td>
                                                    <div class="tr-trainee-name">
                                                        <img src="{{ asset('images/icons/user.svg') }}" alt="متدرب"
                                                            class="tr-trainee-avatar">
                                                        <span>{{ $trainee->user->getTranslation('name', 'ar') }} {{ $trainee->getTranslation('last_name', 'ar')  }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $trainee->user->email }}</td>
                                                <td>{{ $trainee->user->phone_number }}</td>
                                                <td>                                  <button type="button"
                                                        onclick="window.location='{{ route('show_trainee_profile', $trainee->id) }}'"
                                                        class="tr-details-btn">
                                                        عرض التفاصيل
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="alert alert-success text-center mt-3">
                            <i class="fas fa-check-circle"></i>
                            عدد الحضور المسجلين: {{ $session_attendance->count() }} متدرب
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const masterCheckbox = document.getElementById('masterCheckbox');
        const markPresentBtn = document.getElementById('markPresentBtn');
        const attendanceForm = document.getElementById('attendanceForm');

        // تحديد الكل (من الهيدر)
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const traineeCheckboxes = document.querySelectorAll('.trainee-checkbox'); // 👈 حطها هون
                traineeCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                if (masterCheckbox) {
                    masterCheckbox.checked = this.checked;
                }
            });
        }

        // تحديد الكل (من الجدول)
        if (masterCheckbox) {
            masterCheckbox.addEventListener('change', function() {
                const traineeCheckboxes = document.querySelectorAll('.trainee-checkbox'); // 👈 وهون كمان
                traineeCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = this.checked;
                }
            });
        }

        // تأكيد الحضور
        if (markPresentBtn) {
            markPresentBtn.addEventListener('click', function(e) {
                e.preventDefault();
                attendanceForm.submit();
            });
        }
    });
</script>

@endsection
@endsection
