<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إنشاء حساب متدرب</title>
    <!-- روابط CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logos/logo.svg') }}">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trainer_complete_profile.css') }}">

</head>
<style>
    .table-responsive {
        width: 100%;
    }

  table {
    width: 100%;
    background-color: #fff;
    border-collapse: separate; /* غيرناها */
    border-spacing: 0; /* إزالة الفراغ بين الخلايا */
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #ccc; /* حدود خارجية فقط */
}

thead {
    background-color: #dbeeff; /* أزرق فاتح لأول سطر */
    color: #003366;
}

th,
td {
    text-align: center;
    padding: 12px;
    font-weight: normal;
    white-space: nowrap;
    border: none; /* لا حدود داخلية */
}

/* لا تلوين خلفية أول عمود في tbody */
tbody td:first-child {
    background-color: unset;
    color: inherit;
}
    /* حذف تلوين أول عمود في الجسم */
    /* tbody td:first-child { background-color: unset; color: inherit; } */

    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        border-radius: 6px;
        border: 1px solid #A5A5A5;
        appearance: none;
        -webkit-appearance: none;
        background-color: #fff;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
        vertical-align: middle;
    }

    input[type="checkbox"]:checked {
        background-color: #003366;
        border-color: #003366;
    }

    input[type="checkbox"]:checked::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 6px;
        width: 4px;
        height: 8px;
        border: solid #fff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    /* تنسيق الجوال */
    @media (max-width: 768px) {
        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        thead {
            display: none;
        }

        table {
            border: none; /* إزالة حدود الجدول في الشاشات الصغيرة */
            border-radius: 0;
        }

        tbody tr {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 10px;
            background: #fff;
        }

        tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            border: none;
            font-weight: normal;
        }

        tbody td::before {
            content: attr(data-label);
            color: #003366;
            margin-left: 10px;
            font-weight: normal;
        }

        tbody td[data-label="اليوم"] {
            justify-content: center;
            background-color: #dbeeff; /* أزرق كاشف */
            color: #003366;
            border-bottom: 1px solid #ccc;
            border-radius: 10px 10px 0 0;
        }
    }
</style>

<body>
    <div class="verify-bg mb-5">
        <!-- العنوان الرئيسي -->
        <div class="header">
            <h1 class="page-title">المعلومات
                <span class="intro-highlighted-text">
                    الرئيسية
                    <img src="../images/cots-style.svg" class="cots-style-img" alt="" />
                </span>
            </h1>
        </div>

        <!-- Stepper للتنقل بين الخطوات -->
        <div class="stepper-container">
            <div class="stepper">
                <div class="progress-line" style="width: 0%;"></div>
                <!-- الخطوة 1 -->
                <div class="step" data-step="1" onclick="goToStep(1)">
                    <div class="step-title">المعلومات الرئيسية</div>
                    <div class="step-circle">1</div>
                </div>
                <!-- الخطوة 2 -->
                <div class="step" data-step="2" onclick="goToStep(2)">
                    <div class="step-title">البيانات المهنية والاهتمامات التدريبية</div>
                    <div class="step-circle">2</div>
                </div>
            </div>
        </div>

        <div class="container-lg">
            <!-- نموذج متعدد الخطوات -->
            <div class="form-container">
                <form id="multiStepForm" method="POST"
                    action="{{ route('trainee.complete-register', ['id' => $user->id]) }}"
                    onsubmit="return validateForm(event)">
                    @csrf

                    <!-- الخطوة 1: المعلومات الأساسية -->
                    <div class="step-form active" id="step1">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">الاسم (بالعربية)</label>
                                <input type="text" id="name_ar" name="name_ar" class="form-control" required
                                    placeholder="مثال: أحمد" pattern="[\u0600-\u06FF\s]+"
                                    title="يجب أن يحتوي على حروف عربية فقط">
                                <div class="error-message" id="name_ar_error">يجب إدخال الاسم بالعربية بشكل صحيح</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الكنية (بالعربية)</label>
                                <input type="text" id="last_name_ar" name="last_name_ar" class="form-control"
                                    required placeholder="مثال: العلي" pattern="[\u0600-\u06FF\s]+"
                                    title="يجب أن يحتوي على حروف عربية فقط">
                                <div class="error-message" id="last_name_ar_error">يجب إدخال الكنية بالعربية بشكل صحيح
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <label class="form-label">الاسم (بالإنجليزية)</label>
                                <input type="text" id="name_en" name="name_en" required style="direction: ltr"
                                    class="form-control" placeholder="Example: Ali" pattern="[A-Za-z\s]+"
                                    title="يجب أن يحتوي على حروف إنجليزية فقط">
                                <div class="error-message" id="name_en_error">يجب إدخال الاسم بالإنجليزية بشكل صحيح</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الكنية (بالإنجليزية)</label>
                                <input type="text" id="last_name_en" name="last_name_en" required style="direction: ltr"
                                    class="form-control" placeholder="Example: Alali" pattern="[A-Za-z\s]+"
                                    title="يجب أن يحتوي على حروف إنجليزية فقط">
                                <div class="error-message" id="last_name_en_error">يجب إدخال الكنية بالإنجليزية بشكل صحيح
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <label class="form-label">مستوى التعليم</label>
                                <select id="education_levels" name="education_levels_id" class="form-select" required>
                                    <option value="" selected disabled>اختر آخر مؤهل دراسي حصلت عليه</option>
                                    @foreach ($educatuin_levels as $education_level)
                                        <option value="{{ $education_level->id }}">{{ $education_level->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="education_levels_error">يجب اختيار مستوى التعليم</div>

                            </div>

                            <div class="col-md-6">
                                <label class="form-label">مجالات العمل</label>
                                <select class="form-select select2" id="work_fields" name="work_fields[]" multiple
                                    data-placeholder="اختر من القائمة أو أضف مجالًا جديدًا" required>

                                    @foreach ($work_fields as $work_field)
                                        <option value="{{ $work_field->id }}">{{ $work_field->name }}</option>
                                    @endforeach
                                    <option value="other">أخرى (حدد في الأسفل)</option>
                                </select>
            
    </div>
                                <div class="col-md-12" id="extra_work_field_container" style="display: none;">
                                <label class="form-label">مجال عمل إضافي</label>
                                <input type="text" id="extra_work_field" name="extra_work_field"
                                    class="form-control" placeholder="أدخل مجال العمل الإضافي">
                                <div class="error-message" id="extra_work_field_error">يجب إدخال مجال العمل الإضافي
                                </div>
                            </div>

                                <div class="col-md-6">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="text" id="phone_number" name="phone_number" required
                                        class="form-control phone-ltr" pattern="\+?[0-9]{6,20}"
                                        title="يجب أن يحتوي على أرقام فقط (6-20 رقم)"
                                        placeholder="مثال: 00963xxxxxxxxx">
                                    <div class="error-message" id="phone_number_error">يجب إدخال رقم هاتف صحيح</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">الجنسية</label>
                                    <select id="nationality" class="form-select select2" name="nationality[]"
                                        multiple data-placeholder="اختر من القائمة الدولة التي تحمل جنسيتها" required>
                                        @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" id="nationality_error">يجب اختيار الجنسية</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">الدولة</label>
                                    <select id="country_id" name="country_id" class="form-select" required>
                                        <option value="" selected disabled>اختر دولتك</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" id="country_id_error">يجب اختيار الدولة</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">المدينة</label>
                                    <select id="city" name="city" class="form-select" required>
                                        <option value="" selected disabled>اختر المدينة</option>
                                    </select>
                                    <div class="error-message" id="city_error">يجب اختيار المدينة</div>
                                </div>
                                <div class="col-md-12 d-flex gap-3 align-items-center mt-4">
                                    @foreach ($sexs as $sex)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sex"
                                                id="sex_{{ $sex->value }}" value="{{ $sex->value }}"
                                                {{ old('sex') == $sex->value ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="gender_{{ $sex->value }}">
                                                {{ $sex->value }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="error-message" id="gender_error">يجب اختيار الجنس</div>
                            </div>

                            <button type="button" class="btn btn-primary w-100 mt-4" onclick="validateStep1()">
                                احفظ وتابع
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.0706 18.819C9.97208 18.8194 9.87448 18.8001 9.78348 18.7623C9.69248 18.7246 9.60992 18.669 9.54061 18.599L3.47161 12.529C3.33213 12.3879 3.25391 12.1975 3.25391 11.999C3.25391 11.8006 3.33213 11.6102 3.47161 11.469L9.54061 5.40002C9.68278 5.26754 9.87083 5.19542 10.0651 5.19885C10.2594 5.20228 10.4448 5.28099 10.5822 5.4184C10.7196 5.55581 10.7984 5.7412 10.8018 5.9355C10.8052 6.1298 10.7331 6.31785 10.6006 6.46002L5.06061 12L10.6006 17.54C10.7401 17.6812 10.8183 17.8716 10.8183 18.07C10.8183 18.2685 10.7401 18.4589 10.6006 18.6C10.5318 18.6706 10.4493 18.7265 10.3582 18.7642C10.2671 18.8018 10.1692 18.8205 10.0706 18.819Z"
                                        fill="white" />
                                    <path
                                        d="M20.9999 12.75H4.16992C3.97141 12.7487 3.78141 12.6693 3.64104 12.5289C3.50067 12.3885 3.42123 12.1985 3.41992 12C3.42123 11.8015 3.50067 11.6115 3.64104 11.4711C3.78141 11.3307 3.97141 11.2513 4.16992 11.25H20.9999C21.1984 11.2513 21.3884 11.3307 21.5288 11.4711C21.6692 11.6115 21.7486 11.8015 21.7499 12C21.7486 12.1985 21.6692 12.3885 21.5288 12.5289C21.3884 12.6693 21.1984 12.7487 20.9999 12.75Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </div>






                        <!-- الخطوة 2: البيانات المهنية -->
                        <div class="step-form" id="step2">
                            <div class="row g-3">

                                <div class="col-md-12">
                                    <label class="form-label">المجالات التي تهمك</label>
                                    <select class="form-select select2" id="fields_of_interest"
                                        name="fields_of_interest[]" data-placeholder="اختر مجالات اهتمامك" multiple
                                        required>
                                    <option value="مقدمة البرمجة">مقدمة البرمجة</option>
                                    <option value="تطوير الويب">تطوير الويب</option>
                                    <option value="تحليل البيانات">تحليل البيانات</option>
                                    <option value="ذكاء صناعي">ذكاء صناعي</option>
                                    </select>
                                    <div class="error-message" id="fields_of_interest_error">يجب اختيار مجالات
                                        الاهتمام
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">هل تعمل حالياً؟</label>
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_working"
                                                id="is_working_yes" value="1" required>
                                            <label class="form-check-label" for="is_working_yes">نعم</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_working"
                                                id="is_working_no" value="0" required checked>
                                            <label class="form-check-label" for="is_working_no">لا</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" style="display: none;">
                                    <label class="form-label">القطاع الذي تعمل به</label>
                                    <select class="form-select" id="work_sectors" name="work_sectors">
                                        <option value="" selected disabled>اختر القطاع</option>
                                        @foreach ($work_sectors as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                        @endforeach
                                    </select>
                                        <div class="error-message" id="work_sectors_error">يجب اختيار القطاع</div>

                                </div>


                                <div class="col-md-12" style="display: none;">
                                    <label class="form-label">المنصب الوظيفي</label>
                                    <input type="text" id="job_position" name="job_position" class="form-control"
                                        placeholder="مثال: مطور ويب">
                                            <div class="error-message" id="job_position_error">يجب إدخال المنصب الوظيفي</div>

                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">الأوقات التي تناسبك لحضور التدريبات</label>


<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>اليوم</th>
                <th>6 - 9 صباحًا</th>
                <th>9 - 12 صباحًا</th>
                <th>12 - 3 ظهرًا</th>
                <th>3 - 6 عصرًا</th>
                <th>6 - 9 مساءً</th>
                <th>9 - 12 ليلًا</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="اليوم">السبت</td>
                <td data-label="6 - 9 صباحًا"><input type="checkbox" name="preferred_times[]" value="sat_6_9_am"></td>
                <td data-label="9 - 12 صباحًا"><input type="checkbox" name="preferred_times[]" value="sat_9_12_am"></td>
                <td data-label="12 - 3 ظهرًا"><input type="checkbox" name="preferred_times[]" value="sat_12_3_pm"></td>
                <td data-label="3 - 6 عصرًا"><input type="checkbox" name="preferred_times[]" value="sat_3_6_pm"></td>
                <td data-label="6 - 9 مساءً"><input type="checkbox" name="preferred_times[]" value="sat_6_9_pm"></td>
                <td data-label="9 - 12 ليلًا"><input type="checkbox" name="preferred_times[]" value="sat_9_12_pm"></td>
            </tr>
            <tr>
                <td data-label="اليوم">الأحد</td>
                <td data-label="6 - 9 صباحًا"><input type="checkbox" name="preferred_times[]" value="sun_6_9_am"></td>
                <td data-label="9 - 12 صباحًا"><input type="checkbox" name="preferred_times[]" value="sun_9_12_am"></td>
                <td data-label="12 - 3 ظهرًا"><input type="checkbox" name="preferred_times[]" value="sun_12_3_pm"></td>
                <td data-label="3 - 6 عصرًا"><input type="checkbox" name="preferred_times[]" value="sun_3_6_pm"></td>
                <td data-label="6 - 9 مساءً"><input type="checkbox" name="preferred_times[]" value="sun_6_9_pm"></td>
                <td data-label="9 - 12 ليلًا"><input type="checkbox" name="preferred_times[]" value="sun_9_12_pm"></td>
            </tr>
            <tr>
                <td data-label="اليوم">الإثنين</td>
                <td data-label="6 - 9 صباحًا"><input type="checkbox" name="preferred_times[]" value="mon_6_9_am"></td>
                <td data-label="9 - 12 صباحًا"><input type="checkbox" name="preferred_times[]" value="mon_9_12_am"></td>
                <td data-label="12 - 3 ظهرًا"><input type="checkbox" name="preferred_times[]" value="mon_12_3_pm"></td>
                <td data-label="3 - 6 عصرًا"><input type="checkbox" name="preferred_times[]" value="mon_3_6_pm"></td>
                <td data-label="6 - 9 مساءً"><input type="checkbox" name="preferred_times[]" value="mon_6_9_pm"></td>
                <td data-label="9 - 12 ليلًا"><input type="checkbox" name="preferred_times[]" value="mon_9_12_pm"></td>
            </tr>
            <tr>
                <td data-label="اليوم">الثلاثاء</td>
                <td data-label="6 - 9 صباحًا"><input type="checkbox" name="preferred_times[]" value="tue_6_9_am"></td>
                <td data-label="9 - 12 صباحًا"><input type="checkbox" name="preferred_times[]" value="tue_9_12_am"></td>
                <td data-label="12 - 3 ظهرًا"><input type="checkbox" name="preferred_times[]" value="tue_12_3_pm"></td>
                <td data-label="3 - 6 عصرًا"><input type="checkbox" name="preferred_times[]" value="tue_3_6_pm"></td>
                <td data-label="6 - 9 مساءً"><input type="checkbox" name="preferred_times[]" value="tue_6_9_pm"></td>
                <td data-label="9 - 12 ليلًا"><input type="checkbox" name="preferred_times[]" value="tue_9_12_pm"></td>
            </tr>
            <tr>
                <td data-label="اليوم">الأربعاء</td>
                <td data-label="6 - 9 صباحًا"><input type="checkbox" name="preferred_times[]" value="wed_6_9_am"></td>
                <td data-label="9 - 12 صباحًا"><input type="checkbox" name="preferred_times[]" value="wed_9_12_am"></td>
                <td data-label="12 - 3 ظهرًا"><input type="checkbox" name="preferred_times[]" value="wed_12_3_pm"></td>
                <td data-label="3 - 6 عصرًا"><input type="checkbox" name="preferred_times[]" value="wed_3_6_pm"></td>
                <td data-label="6 - 9 مساءً"><input type="checkbox" name="preferred_times[]" value="wed_6_9_pm"></td>
                <td data-label="9 - 12 ليلًا"><input type="checkbox" name="preferred_times[]" value="wed_9_12_pm"></td>
            </tr>
            <tr>
                <td data-label="اليوم">الخميس</td>
                <td data-label="6 - 9 صباحًا"><input type="checkbox" name="preferred_times[]" value="thu_6_9_am"></td>
                <td data-label="9 - 12 صباحًا"><input type="checkbox" name="preferred_times[]" value="thu_9_12_am"></td>
                <td data-label="12 - 3 ظهرًا"><input type="checkbox" name="preferred_times[]" value="thu_12_3_pm"></td>
                <td data-label="3 - 6 عصرًا"><input type="checkbox" name="preferred_times[]" value="thu_3_6_pm"></td>
                <td data-label="6 - 9 مساءً"><input type="checkbox" name="preferred_times[]" value="thu_6_9_pm"></td>
                <td data-label="9 - 12 ليلًا"><input type="checkbox" name="preferred_times[]" value="thu_9_12_pm"></td>
            </tr>
            <tr>
                <td data-label="اليوم">الجمعة</td>
                <td data-label="6 - 9 صباحًا"><input type="checkbox" name="preferred_times[]" value="fri_6_9_am"></td>
                <td data-label="9 - 12 صباحًا"><input type="checkbox" name="preferred_times[]" value="fri_9_12_am"></td>
                <td data-label="12 - 3 ظهرًا"><input type="checkbox" name="preferred_times[]" value="fri_12_3_pm"></td>
                <td data-label="3 - 6 عصرًا"><input type="checkbox" name="preferred_times[]" value="fri_3_6_pm"></td>
                <td data-label="6 - 9 مساءً"><input type="checkbox" name="preferred_times[]" value="fri_6_9_pm"></td>
                <td data-label="9 - 12 ليلًا"><input type="checkbox" name="preferred_times[]" value="fri_9_12_pm"></td>
            </tr>
        </tbody>
    </table>
</div>

                                    <div class="error-message" id="preferred_times_error">يجب اختيار الأوقات المناسبة
                                        على
                                        الأقل في يومين</div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">كيف تفضل حضور التدريب؟</label>
                                    <select class="form-select" id="training_attendance" name="training_attendance"
                                        required>
                                        <option value="" selected disabled>اختر طريقة التدريب المفضلة</option>
                                        @foreach (\App\Enums\TrainingAttendanceType::cases() as $attendanceType)
                                            <option value="{{ $attendanceType->value }}">{{ $attendanceType->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" id="training_attendance_error">يجب اختيار طريقة الحضور
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 ">
                                <button type="submit" onclick="return validateForm(event)" class="btn btn-primary w-100 mt-4">إنهاء التسجيل وإنشاء
                                    الحساب
                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.0706 18.819C9.97208 18.8194 9.87448 18.8001 9.78348 18.7623C9.69248 18.7246 9.60992 18.669 9.54061 18.599L3.47161 12.529C3.33213 12.3879 3.25391 12.1975 3.25391 11.999C3.25391 11.8006 3.33213 11.6102 3.47161 11.469L9.54061 5.40002C9.68278 5.26754 9.87083 5.19542 10.0651 5.19885C10.2594 5.20228 10.4448 5.28099 10.5822 5.4184C10.7196 5.55581 10.7984 5.7412 10.8018 5.9355C10.8052 6.1298 10.7331 6.31785 10.6006 6.46002L5.06061 12L10.6006 17.54C10.7401 17.6812 10.8183 17.8716 10.8183 18.07C10.8183 18.2685 10.7401 18.4589 10.6006 18.6C10.5318 18.6706 10.4493 18.7265 10.3582 18.7642C10.2671 18.8018 10.1692 18.8205 10.0706 18.819Z"
                                            fill="white" />
                                        <path
                                            d="M20.9999 12.75H4.16992C3.97141 12.7487 3.78141 12.6693 3.64104 12.5289C3.50067 12.3885 3.42123 12.1985 3.41992 12C3.42123 11.8015 3.50067 11.6115 3.64104 11.4711C3.78141 11.3307 3.97141 11.2513 4.16992 11.25H20.9999C21.1984 11.2513 21.3884 11.3307 21.5288 11.4711C21.6692 11.6115 21.7486 11.8015 21.7499 12C21.7486 12.1985 21.6692 12.3885 21.5288 12.5289C21.3884 12.6693 21.1984 12.7487 20.9999 12.75Z"
                                            fill="white" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                </form>



                <!-- عرض الأخطاء والرسائل -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- روابط JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // دالة للتنقل بين الخطوات
        function goToStep(stepNumber) {
            document.querySelectorAll('.step-form').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(`step${stepNumber}`).classList.add('active');

            const steps = document.querySelectorAll('.stepper .step');
            steps.forEach((step, index) => {
                const stepCircle = step.querySelector('.step-circle');
                const stepTitle = step.querySelector('.step-title');
                const stepNum = index + 1;

                if (stepNum < stepNumber) {
                    step.classList.add('completed');
                    step.classList.remove('active');
                    stepCircle.innerHTML = '';
                    stepCircle.classList.add('completed');
                    stepTitle.classList.add('completed');
                } else if (stepNum === stepNumber) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                    stepCircle.innerHTML = stepNum;
                    stepCircle.classList.add('active');
                    stepCircle.classList.remove('completed');
                    stepTitle.classList.add('active');
                } else {
                    step.classList.remove('active', 'completed');
                    stepCircle.innerHTML = stepNum;
                    stepCircle.classList.remove('active', 'completed');
                    stepTitle.classList.remove('active', 'completed');
                }
            });

            const progressLine = document.querySelector('.progress-line');
            let percent = 0;
            if (stepNumber === 1) percent = 0;
            else if (stepNumber === 2) percent = 100;
            progressLine.style.width = percent + '%';
        }

      function showError(elementId, errorId, message) {
    const element = document.getElementById(elementId);
    const errorElement = document.getElementById(errorId);
    
    if (element) element.classList.add('is-invalid');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
}

function hideError(elementId, errorId) {
    const element = document.getElementById(elementId);
    const errorElement = document.getElementById(errorId);
    
    if (element) element.classList.remove('is-invalid');
    if (errorElement) errorElement.style.display = 'none';
}

        function handleSelect2Validation(id, isValid) {
            const container = $('#' + id).next('.select2-container');
            if (!isValid) {
                container.addClass('is-invalid');
            } else {
                container.removeClass('is-invalid');
            }
        }

        // تحقق من صحة الحقول المحددة
        function validateFields(fields) {
            let isValid = true;

            fields.forEach(field => {
                const element = document.getElementById(field.id);
                const value = field.isSelect2 ? $(element).val() : element.value;

                if (!field.validation(value)) {
                    showError(field.id, field.errorId, field.errorMessage);

                    if (field.isSelect2) {
                        handleSelect2Validation(field.id, false);
                    }

                    isValid = false;
                } else {
                    hideError(field.id, field.errorId);

                    if (field.isSelect2) {
                        handleSelect2Validation(field.id, true);
                    }
                }
            });

            return isValid;
        }

        // تحقق من صحة الخطوة 1
        function validateStep1() {
            const fields = [{
                    id: 'name_ar',
                    errorId: 'name_ar_error',
                    validation: (value) => value && /^[\u0600-\u06FF\s]+$/.test(value),
                    errorMessage: 'يجب إدخال الاسم بالعربية بشكل صحيح',
                    isSelect2: false
                },
                {
                    id: 'last_name_ar',
                    errorId: 'last_name_ar_error',
                    validation: (value) => value && /^[\u0600-\u06FF\s]+$/.test(value),
                    errorMessage: 'يجب إدخال الكنية بالعربية بشكل صحيح',
                    isSelect2: false
                },
                {
                    id: 'education_levels',
                    errorId: 'education_levels_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار مستوى التعليم',
                    isSelect2: false
                },
                {
                    id: 'work_fields',
                    errorId: 'work_fields_error',
                    validation: (value) => value && value.length > 0,
                    errorMessage: 'يجب اختيار مجالات العمل',
                    isSelect2: true
                },
                {
                    id: 'phone_number',
                    errorId: 'phone_number_error',
                    validation: (value) => value && /^\+?[0-9]{6,20}$/.test(value),
                    errorMessage: 'يجب إدخال رقم هاتف صحيح',
                    isSelect2: false
                },
                {
                    id: 'nationality',
                    errorId: 'nationality_error',
                    validation: (value) => value && value.length > 0,
                    errorMessage: 'يجب اختيار الجنسية',
                    isSelect2: true
                },
                {
                    id: 'country_id',
                    errorId: 'country_id_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار الدولة',
                    isSelect2: false
                },
                {
                    id: 'city',
                    errorId: 'city_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار المدينة',
                    isSelect2: false
                }
            ];
            let isValid = validateFields(fields);

            // التحقق اليدوي من اختيار الجنس
            const genderSelected = document.querySelector('input[name="sex"]:checked');
            const genderError = document.getElementById('gender_error');
            if (!genderSelected) {
                genderError.style.display = 'block';
                isValid = false;
            } else {
                genderError.style.display = 'none';
            }

            if (isValid) {
                // الانتقال إلى الخطوة الثانية بدون التحقق منها هنا
                goToStep(2);
            }
            return isValid; // إرجاع قيمة صواب/خطأ
        }

function validateStep2() {
    const fields = [
        {
            id: 'fields_of_interest',
            errorId: 'fields_of_interest_error',
            validation: (value) => value && value.length > 0,
            errorMessage: 'يجب اختيار مجالات الاهتمام',
            isSelect2: true
        },
        {
            id: 'training_attendance',
            errorId: 'training_attendance_error',
            validation: (value) => value && value !== '',
            errorMessage: 'يجب اختيار طريقة الحضور',
            isSelect2: false
        }
    ];

    let isValid = validateFields(fields);

    // التحقق من الأوقات المفضلة
    const preferredTimes = $('input[name="preferred_times[]"]:checked').length;
    if (preferredTimes < 2) {
        document.getElementById('preferred_times_error').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('preferred_times_error').style.display = 'none';
    }

    // التحقق من حقول العمل إذا كان يعمل
    if ($('#is_working_yes').is(':checked')) {
        const workFields = [
            {
                id: 'work_sectors',
                errorId: 'work_sectors_error',
                validation: (value) => value && value !== '',
                errorMessage: 'يجب اختيار القطاع',
                isSelect2: false
            },
            {
                id: 'job_position',
                errorId: 'job_position_error',
                validation: (value) => value && value.trim() !== '',
                errorMessage: 'يجب إدخال المنصب الوظيفي',
                isSelect2: false
            }
        ];
        isValid = validateFields(workFields) && isValid;
    }

    return isValid;
}

// تحقق نهائي قبل الإرسال
function validateForm(event) {
    
    
    // تحقق من الخطوة 1
    const isStep1Valid = validateStep1();
    
    // تحقق من الخطوة 2
    const isStep2Valid = validateStep2();
    
    // إذا كانت أي خطوة غير صالحة، امنع الإرسال
    if (!isStep1Valid || !isStep2Valid) {
        return false;
    }
    
    // إذا كانت كل الخطوات صالحة، أرسل النموذج
    this.submit(); // ⚠ أرسل النموذج يدويًا
}
        // تهيئة الصفحة عند التحميل
        window.addEventListener('load', () => {
            document.querySelector('.step[data-step="1"] .step-circle').classList.add('active');

            // تهيئة select2
            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%'
                });
            });

            // جلب بيانات المدن عند تغيير الدولة
            $('#country_id').on('change', function() {
                var selected_country_id = $(this).val();
                $('#city').empty().append('<option value="" selected disabled>اختر المدينة</option>');

                fetch('/cities')
                    .then(response => response.json())
                    .then(data => {
                        let filteredCities = data.filter(city => city.country_id ==
                            selected_country_id);
                        filteredCities.forEach(city => {
                            let option = new Option(city.name, city.name);
                            $('#city').append(option);
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching cities:", error);
                    });
            });

            // إظهار/إخفاء حقول العمل بناءً على اختيار "هل تعمل حالياً"
            $('input[name="is_working"]').change(function() {
                const isWorking = $(this).val() === '1';
                const $workSectorsField = $('#work_sectors').closest('.col-md-12');
                const $jobPositionField = $('#job_position').closest('.col-md-12');

                // إظهار/إخفاء الحقول
                $workSectorsField.toggle(isWorking);
                $jobPositionField.toggle(isWorking);

                // إضافة/إزالة السمة required
                $('#work_sectors').prop('required', isWorking);
                $('#job_position').prop('required', isWorking);

                // إعادة تعيين القيم إذا تم اختيار "لا يعمل"
                if (!isWorking) {
                    $('#work_sectors').val('').trigger('change');
                    $('#job_position').val('');
                }
            }).trigger('change');


        });
        $(document).ready(function() {
            $('#work_fields').on('change', function() {
                const values = $(this).val() || [];
                const hasOther = values.includes('other');

                $('#extra_work_field_container').toggle(hasOther);
                $('#extra_work_field').prop('required', hasOther);

                if (!hasOther) {
                    $('#extra_work_field').val('');
                }
            }).trigger('change');
        });
    </script>
</body>

</html>
