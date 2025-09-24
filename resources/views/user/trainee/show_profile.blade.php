@extends('frontend.layouts.master')
@section('title', 'حساب المتدرب')

@section('content')
    @php
        // تعريف المتغيرات العامة للاستخدام في جميع أجزاء الصفحة
        $days = [
            'sat' => 'السبت',
            'sun' => 'الأحد',
            'mon' => 'الإثنين',
            'tue' => 'الثلاثاء',
            'wed' => 'الأربعاء',
            'thu' => 'الخميس',
            'fri' => 'الجمعة',
        ];
        $times = [
            '6_9_am' => '6-9 صباحًا',
            '9_12_am' => '9-12 صباحًا',
            '12_3_pm' => '12-3 ظهرًا',
            '3_6_pm' => '3-6 عصرًا',
            '6_9_pm' => '6-9 مساءً',
            '9_12_pm' => '9-12 ليلًا',
        ];
    @endphp
    <style>
        /* الألوان الأساسية */
        :root {
            --primary-color: #004aad;
            --primary-hover: #003090;
            --secondary-color: #6c757d;
            --light-color: #f8f9fa;
            --border-color: #D9D9D9;
            --success-color: #28a745;
        }
        /* العناصر العامة */
        .card-header h5 {
            font-size: 1.2rem;
            color: #1a1a1a;
        }
        .title {
            line-height: 40px;
        }
        .card-body .text-muted {
            font-size: 1rem;
            color: var(--secondary-color);
        }
        .card-body .fw-semibold {
            font-size: 1.1rem;
            color: #212529;
            line-height: 1.6;
        }
        /* الكروت المخصصة */
        .custom-card {
            border: 1px solid var(--border-color);
            border-radius: 32px;
            overflow: hidden;
        }
        .custom-card .card {
            overflow: hidden;
            background-color: transparent;
            border: none;
        }
        .card-header {
            background-color: transparent !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: none !important;
        }
        .card-body {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            background-color: transparent;
            justify-content: center;
            align-items: center;
            align-content: space-around;
        }
        /* جدول الأوقات المفضلة - النسخة المعدلة */
        .preferred-times-table-container {
            border-radius: 14.47px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .preferred-times-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }
        .preferred-times-table th {
            font-weight: normal;
            font-size: 1.2rem;
            background-color: #DAE3FF;
            color: #003090;
            letter-spacing: 0;
            vertical-align: middle;
            padding: 15px 10px;
            text-align: center;
            border: none;
            border-bottom: 1px solid #e0e0e0;
        }
        .preferred-times-table td {
            font-size: 1.2rem;
            padding: 15px 10px;
            text-align: center;
            border: none;
            background-color: white;
            vertical-align: middle;
        }
        .preferred-times-table tr {
            background-color: transparent;
        }
        .preferred-times-table tr:hover {
            background-color: transparent;
        }

        .check-mark {
            color: #003090;
            font-weight: bold;
            font-size: 1.5em;
        }
        .dash-mark {}
        /* تعديلات للشاشات الكبيرة */
        @media (min-width: 992px) {
            .preferred-times-table th,
            .preferred-times-table td {
                padding: 18px 12px;
            }
        }
        /* تعديلات للهاتف */
        @media (max-width: 767.98px) {
            .preferred-times-table-container {
                border-radius: 10px;
            }
            .preferred-times-table th {
                font-size: 18px;
                padding: 12px 8px;
            }
            .preferred-times-table td {
                padding: 12px 8px;
                font-size: 14px;
            }
            .check-mark {
                font-size: 1.1em;
            }
        }
        /* الأزرار */
        .btn {
            transition: all 0.3s ease;
        }
        .btn-light {
            background-color: #f8f9fa;
            border-color: #ddd;
        }
        .btn-light:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }
        .btn-primary {
            background-color: #003090;
            border-color: #003090;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        .download-btn {
            border: 2px solid #003090;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            padding: 10px;
            color: #003090;
            transition: background 0.3s, color 0.3s;
        }
        .download-btn:hover {
            background-color: #003090;
            color: #fff;
        }
        .download-btn:hover svg path {
            fill: #fff;
            /* تغيير لون الأيقونة عند الهوفر */
        }
        /* العناصر الأخرى */
        .phone-container {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            height: 48px;
            background-color: #fff;
            overflow: hidden;
        }
        .flag-img {
            width: 34px;
            height: 24px;
            border-radius: 4px;
            object-fit: cover;
        }
        .img-profile {
            width: 200px;
            height: 200px;
            border-radius: 18px;
            object-fit: cover;
            flex-shrink: 0;
        }
        .user-info-block {
            flex: 1;
            min-width: 240px;
            word-break: break-word;
            white-space: normal;
        }
        .upload-cv {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background-color: var(--light-color);
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }

        /* التعديلات للشاشات المتوسطة */
        @media (max-width: 768px) {

            .card-body {
                flex-direction: column;
                align-items: center;
                padding: 15px !important;
            }
            .contact-style {
                flex-direction: column;
                align-items: flex-start;
            }
            .custom-modal {
                width: 95%;
                padding: 15px;
            }
        }
        /* التعديلات للشاشات الصغيرة */
        @media (max-width: 576px) {
            .card-header h5 {
                font-size: 1rem;
                text-align: center;
            }
            .preferred-times-table {
                font-size: 14px;
            }
            .preferred-times-table th,
            .preferred-times-table td {
                padding: 8px 4px;
            }
            .check-mark {
                font-size: 1.1em;
            }
            .personal-info-flex {
                flex-direction: column;
                align-items: center;
            }
            .small-padding {
                padding: 0px
            }
        }
        .flag-img {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
            border: 1px solid #fff;
        }
        .flag-img:hover {
            transform: scale(1.1);
        }
.edit-button-container {
    display: none;
}
        .is-owner .edit-button-container {
            display: block;
        }



        /* ✅ التأثير خاص فقط بجدول الأوقات المفضلة */
        .custom-preferred-times {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            background: #fff;
            font-size: 14px;
        }
        .custom-preferred-times th,
        .custom-preferred-times td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .custom-preferred-times th {
            background: #f8f9fa;
            font-weight: bold;
        }
        /* ✅ تحسين المظهر على الشاشات الصغيرة */
        @media (max-width: 768px) {
            .custom-preferred-times {
                font-size: 11px;
            }
            .custom-preferred-times th,
            .custom-preferred-times td {
                padding: 4px;
                border: 1px solid #ccc;
            }
            .custom-preferred-times th {
                font-size: 12px;
            }
            .custom-preferred-times input[type="checkbox"] {
                transform: scale(0.9);
            }
        }
    </style>
    <main class="trainee-account-page {{ auth()->check() && auth()->id() == $trainee->id ? 'is-owner' : '' }}">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
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
            <div class="row gx-4 gy-4 mb-4 mt-2">
                <!-- العمود الأول: المعلومات الشخصية -->
                <div class="col-lg-6 col-md-12 d-flex">
                    <div class="custom-card h-100 w-100 p-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <!-- الصورة -->
                                <div class="text-center flex-shrink-0 position-relative"
                                    style="width: 250px; height: 250px; border-radius: 23px;">
                                    @if ($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="صورة المتدرب"
                                            class="img-profile w-100 h-100 object-fit-cover rounded-4">
                                    @else
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية"
                                            class="img-profile w-100 h-100 object-fit-cover rounded-4">
                                    @endif
                                    <!-- الأعلام فوق الصورة في الزاوية السفلية اليسرى -->
                                    @if ($user->nationalities && $user->nationalities->count())
                                        <div class="position-absolute d-flex gap-1 flex-wrap align-items-center"
                                            style="bottom: 8px; left: 8px;">
                                            @foreach ($user->nationalities->take(5) as $country)
                                                <img src="{{ asset('flags/' . strtolower($country->iso2) . '.svg') }}"
                                                    alt="{{ $country->name }}" title="{{ $country->name }}"
                                                    class="flag-img shadow-sm"
                                                    style="width: 24px; height: 16px; border-radius: 3px;">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <!-- المعلومات -->
                                <div class="user-info-block">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h4 class="title fw-bold m-0">
                                            {{ $user->getTranslation('name', 'ar') }}
                                            {{ $user->trainee->getTranslation('last_name', 'ar') }}
                                        </h4>
                                        <button class="btn btn-sm edit-button-container"
                                            onclick="openModal('personal-info')">
                                            <img src="{{ asset('images/pencil-simple.svg') }}" />
                                        </button>
                                    </div>
                                    <p class="fw-semibold text-dark mb-3">معلومات التواصل</p>
                                    <p class="mb-3 fw-semibold"> {{ $user->country->name ?? '' }}،
                                        {{ $user->city ?? '' }}</p>
<div class="contact-style mb-3">
    <div class="label">رقم الهاتف:</div>
    <div class="value text-dark" style="text-align: left;" dir="ltr">
        <strong>{{ $user->phone_code }} {{ $user->phone_number }}</strong>
    </div>
</div>
                                    <div class="contact-style mb-3">
                                        <div class="label">البريد الإلكتروني:</div>
                                        <div class="value text-dark" style="text-align: left;" dir="rtl">
                                            <strong>{{ $user->email }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($user->userCv)
                                <div class="edit-button-container d-flex align-items-center mt-3" style="gap: 8px;">
                                    <!-- زر التحميل (كبير) -->
                                    <a download href="{{ asset('storage/' . $user->userCv->cv_file) }}"
                                        class="btn btn-outline-primary flex-grow-1">
                                        تحميل السيرة الذاتية
                                    </a>
                                    <!-- زر الحذف (صغير - أيقونة فقط) -->
                                    <form method="POST" action="{{ route('delete_cv') }}" class="pt-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-danger p-2 d-flex align-items-center justify-content-center"
                                            title="حذف السيرة الذاتية"
                                            onclick="return confirm('هل أنت متأكد من حذف السيرة الذاتية؟')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5v6a.5.5 0 0 0 1 0v-6a.5.5 0 0 0-1 0zm4 0v6a.5.5 0 0 0 1 0v-6a.5.5 0 0 0-1 0z" />
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H13.5a.5.5 0 0 0 0-1H10.5a.5.5 0 0 1-.5-.5h-3a.5.5 0 0 1-.5.5H2.5z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- العمود الثاني: البيانات المهنية -->
                <div class="col-lg-6 col-md-12 d-flex">
                    <div class="custom-card h-100 w-100 p-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center border-0">
                                <h4 class="title fw-bold mb-0">بياناتك المهنية واهتماماتك التدريبية</h4>
                                <button class="btn btn-sm edit-button-container" onclick="openModal('professional-data')">
                                    <img src="{{ asset('images/pencil-simple.svg') }}" />
                                </button>
                            </div>
                            <div class="card-body px-2">
                                <!-- اسم الجهة -->
                                <div class="w-100">
                                    <div class="text-muted small ">اسم الجهة التي تعمل لديها</div>
                                    <div class="fw-semibold">{{ $trainee->work_institution ?? 'غير محدد' }}</div>
                                </div>
                                <!-- المواضيع التي تهمك -->
                                <div class="w-100">
                                    <div class="text-muted small">المواضيع التدريبية التي تهمك</div>
                                    <div class="fw-semibold">
                                        @if (is_array($trainee->fields_of_interest) && count($trainee->fields_of_interest) > 0)
                                            {{ implode('، ', $trainee->fields_of_interest) }}
                                        @else
                                            غير محدد
                                        @endif
                                    </div>
                                </div>
                                <!-- المنصب الوظيفي -->
                                <div class="w-100">
                                    <div class="text-muted small">المنصب الوظيفي الحالي</div>
                                    <div class="fw-semibold">{{ $trainee->job_position ?? 'غير محدد' }}</div>
                                </div>
                                <!-- طريقة التدريب المفضلة -->
                                <div class="w-100">
                                    <div class="text-muted small">طريقة التدريب المفضلة</div>
                                    <div class="fw-semibold">{{ $trainee->training_attendance ?? 'غير محدد' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          @if (!$user->userCv && auth()->check() && auth()->id() == $user->id)
                <div class="card-header d-flex justify-content-between align-items-center  mt-5">
                    <h4 class="title fw-bold">السيرة الذاتية CV</h4>
                    <div class="edit-button-container">
                        <button class="pbtn pbtn-main pbtn-small piconed btn-sm"
                            onclick="document.getElementById('cv-upload').click()">
                            <img src="{{ asset('images/icons/plus.svg') }}" />
                        </button>
                    </div>
                </div>
                <!-- معلومات التواصل والسيرة الذاتية -->
                <div class="custom-card col-12 mb-4">
                    <!-- السيرة الذاتية -->
                    <div class="card">
                        <div class="card-body text-center align-content-center">
                            <img src="{{ asset('images/trainer-account/cv.svg') }}" alt="سيرة ذاتية"
                                style="max-width: 100px;" />
                            <div class="w-100">
                                <span class="text-muted mb-3">حمّل سيرتك الذاتية بشكل سهل وسريع</span>
                            </div>
                            <button class="btn download-btn px-5"
                                onclick="document.getElementById('cv-upload').click()">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.3359 12.75H6.33594C6.13743 12.7487 5.94742 12.6693 5.80706 12.5289C5.66669 12.3885 5.58725 12.1985 5.58594 12C5.58725 11.8015 5.66669 11.6115 5.80706 11.4711C5.94742 11.3307 6.13743 11.2513 6.33594 11.25H18.3359C18.5344 11.2513 18.7245 11.3307 18.8648 11.4711C19.0052 11.6115 19.0846 11.8015 19.0859 12C19.0846 12.1985 19.0052 12.3885 18.8648 12.5289C18.7245 12.6693 18.5344 12.7487 18.3359 12.75Z"
                                        fill="#003090" />
                                    <path
                                        d="M12.3359 18.75C12.1374 18.7487 11.9474 18.6693 11.8071 18.5289C11.6667 18.3885 11.5872 18.1985 11.5859 18V6C11.5872 5.80149 11.6667 5.61149 11.8071 5.47112C11.9474 5.33075 12.1374 5.25131 12.3359 5.25C12.5344 5.25131 12.7245 5.33075 12.8648 5.47112C13.0052 5.61149 13.0846 5.80149 13.0859 6V18C13.0846 18.1985 13.0052 18.3885 12.8648 18.5289C12.7245 18.6693 12.5344 18.7487 12.3359 18.75Z"
                                        fill="#003090" />
                                </svg>
                                إضافة السيرة الذاتية
                            </button>
                            <form id="cvUploadForm" action="{{ route('upload_cv') }}" method="POST"
                                enctype="multipart/form-data" style="display: none;">
                                @csrf
                                <input type="file" name="uploadPdf" id="cv-upload"
                                    onchange="document.getElementById('cvUploadForm').submit();">
                            </form>
                        </div>
                    </div>
            @endif
        </div>
        <!-- الأوقات المفضلة وطريقة الحضور -->
        <div class="col-12  mb-3 mt-5 p-0">
            <div class="card border-0" style="border-radius: 14.47px; overflow: hidden;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="title fw-bold title">الأوقات التي تناسبك لحضور التدريبات</h4>
                    <div class="edit-button-container">
                        <button class="btn btn-sm" onclick="openModal('preferred-times')">
                            <img src="{{ asset('images/pencil-simple.svg') }}" />
                        </button>
                    </div>
                </div>
                @if (is_array($preferred_times) && count($preferred_times) > 0)
                    {{-- ✅ الجدول للشاشات الكبيرة --}}
                    <div class="preferred-times-table-container d-none d-md-block">
                        <table class="preferred-times-table w-100">
                            <thead>
                                <tr>
                                    <th>اليوم</th>
                                    <th>6-9 صباحًا</th>
                                    <th>9-12 صباحًا</th>
                                    <th>12-3 ظهرًا</th>
                                    <th>3-6 عصرًا</th>
                                    <th>6-9 مساءًا</th>
                                    <th>9-12 ليلًا</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($days as $dayKey => $dayName)
                                    <tr>
                                        <td class="">{{ $dayName }}</td>
                                        @foreach ($times as $timeKey => $timeLabel)
                                            <td>
                                                @if (in_array("{$dayKey}_{$timeKey}", $preferred_times))
                                                    <span class="check-mark">
                                                        <svg width="22" height="22" viewBox="0 0 28 28"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M26.7805 0.435547C26.3661 0.435547 25.6032 0.514846 24.4898 0.67026C23.3765 0.826542 22.6567 0.977326 22.3323 1.1203C22.0067 1.26326 21.4183 1.75932 20.5689 2.60295C19.7186 3.44948 18.4851 5.01201 16.8722 7.28911C15.2573 9.56851 13.7506 11.9747 12.3502 14.5099C10.9297 17.0849 9.62109 19.72 8.42807 22.408C7.30545 20.4857 6.29106 19.1825 5.3797 18.4972C4.47066 17.8089 3.70372 17.4657 3.08003 17.4657C2.59324 17.4657 1.98316 17.7253 1.24719 18.2422C0.512084 18.7608 0.144531 19.2681 0.144531 19.7685C0.144531 20.1309 0.481696 20.6677 1.15631 21.3777C2.49224 22.7891 3.67478 24.286 4.69843 25.8705C5.32355 26.818 5.73915 27.3998 5.94637 27.6116C6.15243 27.8217 6.78045 27.9297 7.83044 27.9297C9.29168 27.9297 10.1593 27.7424 10.4351 27.3653C10.7089 27.0027 11.2151 25.9211 11.9534 24.1181C13.7776 19.6039 16.0457 15.2931 18.7563 11.1886C21.4695 7.08565 23.9547 3.982 26.2171 1.87942C26.6677 1.48003 26.9386 1.22101 27.0338 1.10148C27.1264 0.981377 27.1739 0.860693 27.1739 0.735088C27.1739 0.536552 27.0422 0.435547 26.7805 0.435547Z"
                                                                fill="#003090" />
                                                        </svg>

                                                    </span>
                                                @else
                                                    <span class="dash-mark"><svg width="10" height="3"
                                                            viewBox="0 0 10 4" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0.948472 3.51336V0.63204H9.69293V3.51336H0.948472Z"
                                                                fill="#A5A5A5" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- ✅ بطاقات للشاشات الصغيرة --}}
                    <div class="d-block d-md-none">
                        @foreach ($days as $dayKey => $dayName)
                            @php
                                $availableTimes = [];
                                foreach ($times as $timeKey => $timeLabel) {
                                    if (in_array("{$dayKey}_{$timeKey}", $preferred_times)) {
                                        $availableTimes[] = $timeLabel;
                                    }
                                }
                            @endphp
                            @if (count($availableTimes) > 0)
                                <div class="border-bottom p-3">
                                    <div class="fw-semibold mb-2">{{ $dayName }}</div>
                                    <div>
                                        @foreach ($availableTimes as $time)
                                            <span class="d-inline-block me-2 mb-2 check-mark w-100">✓
                                                {{ $time }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="p-3 text-muted">لم يتم تحديد أوقات مناسبة للتدريب بعد</div>
                @endif
            </div>
        </div>
        </div>
    </main>
    <!-- Modals -->
    <div id="customModalOverlay" class="modal-overlay" style="display: none"></div>
    <!-- Modal المعلومات الشخصية -->
    <div id="personal-info" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">تعديل المعلومات الشخصية</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="personal-info">&times;</span>
        </div>
        <div class="modal-desc">قم بتحديث معلوماتك الشخصية</div>
        <form class="modal-form" action="{{ route('update_personal_information') }}" method="POST"
            enctype="multipart/form-data" id="personalInfoForm">
            @csrf
            @method('PUT')
            <div class="input-group">
                <div class="profile-upload-container">
                    <label class="profile-image-label">
                        <input type="file" accept="image/png, image/jpeg" id="profileImageInput" name="photo"
                            hidden />
<div class="profile-image-preview-container">
    <div class="profile-image-preview" id="profileImagePreview">
        @if ($user->photo)
            <div class="image-container">
                <img src="{{ asset('storage/' . $user->photo) }}" alt="صورة المتدرب" />
            </div>
        @else
            <div class="image-container">
                <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية" />
            </div>
        @endif
    </div>

</div>
  <div class="profile-upload-desc">
        أرفق صورة شخصية مربعة وواضحة (JPG أو PNG، حد أقصى 5MB).
    </div>
<style>
    

</style>
                    </label>
                </div>
            </div>
            <div class="input-group-2col">
                <div class="input-group">
                    <label>الاسم (بالعربية) <span class="required">*</span></label>
                    <input name="name_ar" type="text"
                        value="{{ old('name_ar', $user->getTranslation('name', 'ar')) }}" placeholder="اكتب هنا"
                        required />
                </div>
                <div class="input-group">
                    <label>الكنية (بالعربية) <span class="required">*</span></label>
                    <input name="last_name_ar" type="text"
                        value="{{ old('last_name_ar', $user->trainee->getTranslation('last_name', 'ar')) }}"
                        placeholder="اكتب هنا" required />
                </div>
            </div>
            <div class="input-group-2col">
                <div class="input-group">
                    <label>الاسم (بالإنجليزية) </label>
                    <input name="name_en" type="text"
                        value="{{ old('name_en', $user->getTranslation('name', 'en')) }}" placeholder="اكتب هنا" />
                </div>
                <div class="input-group">
                    <label>الكنية (بالإنجليزية) </label>
                    <input name="last_name_en" type="text"
                        value="{{ old('last_name_en', $user->trainee->getTranslation('last_name', 'en')) }}"
                        placeholder="اكتب هنا" />
                </div>
            </div>

          <div class="input-group-2col">
    <div class="input-group">
        <label>رقم الهاتف<span class="required">*</span></label>
        <div class="phone-container">
            <div class="phone-country-selector" id="flagBtn">
                <span id="countryCode" dir="ltr">{{ $user->phone_code ?? '+966' }}</span>
                <span class="divider"></span>
                <span class="arrow-down">🞃</span>
                <img class="flag-img" id="selectedFlag" 
                    src="{{ asset('flags/' . strtolower($user->country->iso2 ?? 'sa') . '.svg') }}">
            </div>
            <input type="tel" name="phone_number" class="phone-input"
                value="{{ $user->phone_number }}" placeholder="ادخل رقم الهاتف" required>
            <input type="hidden" name="phone_code" id="phoneCodeHidden"
                value="{{ $user->phone_code ?? '+966' }}">
        </div>
        <div class="country-dropdown" id="countryDropdown">
            <input type="text" class="search-box" placeholder="ابحث عن دولة...">
            <div class="country-list">
                @foreach ($countries as $country)
                    <div class="country-option" data-code="{{ $country->phonecode }}"
                        data-flag="{{ strtolower($country->iso2) }}">
                        <img src="{{ asset('flags/' . strtolower($country->iso2) . '.svg') }}"
                            width="34" height="24">
                        <span>{{ $country->phonecode }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
                <div class="input-group disable">
                    <label>البريد الإلكتروني<span class="required">*</span></label>
                    <input name="email" type="email" placeholder="اكتب هنا" value="{{ $user->email }}" disabled />
                </div>
            </div>


            <div class="input-group">
                <label>الجنسية <span class="required">*</span></label>
                <select name="nationality[]" class="custom-multiselect" multiple required>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @if (in_array((string) $country->id, old('nationality', $user->nationalities->pluck('id')->toArray() ?? []))) selected @endif>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-group-2col">
                <div class="input-group">
                    <label>الدولة<span class="required">*</span></label>
                    <select name="country_id" id="country_id" class="custom-singleselect" required>
                        <option value="" disabled>اختر الدولة</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ $user->country_id == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label>المدينة<span class="required">*</span></label>
                    <select name="city" id="city" class="custom-singleselect" required>
                        <option value="" disabled selected>اختر المدينة</option>
                    </select>
                </div>
            </div>
            <div class="input-group">
                <button type="submit" class="btn btn-primary">
                    حفظ التعديل
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </form>
    </div>
    <!-- Modal البيانات المهنية -->
    <div id="professional-data" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">تعديل البيانات المهنية</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="professional-data">&times;</span>
        </div>
        <div class="modal-desc">قم بتحديث بياناتك المهنية واهتماماتك التدريبية</div>
        <form class="modal-form" action="{{ route('update_pro-data') }}" method="POST" id="professionalDataForm">
            @csrf
            @method('PUT')
            <!-- اسم الجهة -->
            <div class="input-group">
                <label>اسم الجهة التي تعمل لديها</label>
                <input name="work_institution" type="text"
                    value="{{ old('work_institution', $trainee->work_institution) }}"
                    placeholder="اكتب اسم المؤسسة أو الجهة" />
            </div>

            <!-- المواضيع التي تهمك -->
            <div class="input-group">
                <label>المجالات التي تهمك <span class="required">*</span></label>
                <select name="fields_of_interest[]" class="custom-multiselect" multiple required
                    data-placeholder="اختر مجالات اهتمامك">
                    <option value="مقدمة البرمجة"
                        {{ is_array(old('fields_of_interest', $trainee->fields_of_interest)) && in_array('مقدمة البرمجة', old('fields_of_interest', $trainee->fields_of_interest)) ? 'selected' : '' }}>
                        مقدمة البرمجة</option>
                    <option value="تطوير الويب"
                        {{ is_array(old('fields_of_interest', $trainee->fields_of_interest)) && in_array('تطوير الويب', old('fields_of_interest', $trainee->fields_of_interest)) ? 'selected' : '' }}>
                        تطوير الويب</option>
                    <option value="تحليل البيانات"
                        {{ is_array(old('fields_of_interest', $trainee->fields_of_interest)) && in_array('تحليل البيانات', old('fields_of_interest', $trainee->fields_of_interest)) ? 'selected' : '' }}>
                        تحليل البيانات</option>
                    <option value="ذكاء صناعي"
                        {{ is_array(old('fields_of_interest', $trainee->fields_of_interest)) && in_array('ذكاء صناعي', old('fields_of_interest', $trainee->fields_of_interest)) ? 'selected' : '' }}>
                        ذكاء صناعي</option>
                </select>
            </div>

            <!-- المنصب الوظيفي -->
            <div class="input-group">
                <label>المنصب الوظيفي الحالي</label>
                <input name="job_position" type="text" value="{{ old('job_position', $trainee->job_position) }}"
                    placeholder="اكتب المنصب الوظيفي" />
            </div>
            <!-- طريقة التدريب المفضلة -->
            <div class="input-group">
                <label>كيف تفضل حضور التدريب؟ <span class="required">*</span></label>
                <select name="training_attendance" class="custom-singleselect" required>
                    @foreach (\App\Enums\TrainingAttendanceType::cases() as $attendanceType)
                        <option value="{{ $attendanceType->value }}"
                            {{ $trainee->training_attendance->value === $attendanceType->value ? 'selected' : '' }}>
                            {{ $attendanceType->value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-group">
                <button type="submit" class="btn btn-primary">
                    حفظ التعديل
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </form>
    </div>
    <!-- Modal الأوقات المفضلة -->
    <div id="preferred-times" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">تعديل الأوقات المناسبة للتدريب</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="preferred-times">&times;</span>
        </div>
        <div class="modal-desc">حدد الأوقات التي تناسبك لحضور التدريبات</div>
        <form class="modal-form small-padding" action="{{ route('update_preferred_times') }}" method="POST"
            id="preferredTimesForm">
            @csrf
            @method('PUT')
            <div class="table-responsive preferred-times-wrapper">
                <table class="preferred-times-table custom-preferred-times">
                    <thead>
                        <tr>
                            <th>اليوم</th>
                            <th>6-9 صباحًا</th>
                            <th>9-12 صباحًا</th>
                            <th>12-3 ظهرًا</th>
                            <th>3-6 عصرًا</th>
                            <th>6-9 مساءًا</th>
                            <th>9-12 ليلًا</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $dayKey => $dayName)
                            <tr>
                                <td>{{ $dayName }}</td>
                                @foreach ($times as $timeKey => $timeLabel)
                                    <td>
                                        <input type="checkbox" name="preferred_times[]"
                                            value="{{ $dayKey }}_{{ $timeKey }}" class="time-checkbox"
                                            @if (in_array("{$dayKey}_{$timeKey}", old('preferred_times', $preferred_times ?? []))) checked @endif>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="input-group">
                <button type="submit" class="btn btn-primary">
                    حفظ التعديل
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/validator@13.9.0/validator.min.js"></script>
    <script src="{{ asset('js/profile-image.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // التحقق من صحة النماذج
  document.addEventListener("DOMContentLoaded", function () {
    /** ✅ دالة عرض الخطأ */
    function showError(input, message) {
        clearError(input); // إزالة الأخطاء السابقة أولاً
        input.classList.add("is-invalid");
        input.style.borderColor = "#e00";
        const errorMsg = document.createElement("div");
        errorMsg.className = "error-msg text-danger";
        errorMsg.style.fontSize = "0.9em";
        errorMsg.style.marginTop = "4px";
        errorMsg.textContent = message;
        input.parentNode.appendChild(errorMsg);
    }
    /** ✅ دالة إزالة الخطأ */
    function clearError(input) {
        input.classList.remove("is-invalid");
        input.style.borderColor = "";
        const oldError = input.parentNode.querySelector(".error-msg");
        if (oldError) oldError.remove();
    }
    /** ✅ دالة تحقق عامة */
    function validateArabic(value) {
        return /^[\u0600-\u06FF\s]+$/.test(value.trim());
    }
    function validateEnglish(value) {
        return /^[A-Za-z\s]+$/.test(value.trim());
    }
    function validatePhone(value) {
        return /^[0-9]{6,15}$/.test(value.trim());
    }
    /** ✅ نموذج المعلومات الشخصية */
    const personalInfoForm = document.getElementById("personalInfoForm");
    if (personalInfoForm) {
        personalInfoForm.addEventListener("submit", function (e) {
            let valid = true;
            const nameAr = this.elements["name_ar"];
            const lastNameAr = this.elements["last_name_ar"];
            const nameEn = this.elements["name_en"];
            const lastNameEn = this.elements["last_name_en"];
            const phone = this.elements["phone_number"];
            const nationality = this.elements["nationality[]"];
            const country = this.elements["country_id"];
            const city = this.elements["city"];
            clearError(nameAr);
            clearError(lastNameAr);
            clearError(nameEn);
            clearError(lastNameEn);
            clearError(phone);
            clearError(nationality);
            clearError(country);
            clearError(city);
            // ✅ الاسم بالعربية
            if (!nameAr.value.trim() || !validateArabic(nameAr.value)) {
                showError(nameAr, "يرجى إدخال الاسم بالعربية بشكل صحيح");
                valid = false;
            }
            // ✅ الكنية بالعربية
            if (!lastNameAr.value.trim() || !validateArabic(lastNameAr.value)) {
                showError(lastNameAr, "يرجى إدخال الكنية بالعربية بشكل صحيح");
                valid = false;
            }
            // ✅ الاسم بالإنجليزية (اختياري لكن لو كتب لازم يكون إنجليزي)
            if (nameEn.value.trim() && !validateEnglish(nameEn.value)) {
                showError(nameEn, "يرجى إدخال الاسم بالإنجليزية بشكل صحيح");
                valid = false;
            }
            // ✅ الكنية بالإنجليزية (اختياري لكن لو كتب لازم يكون إنجليزي)
            if (lastNameEn.value.trim() && !validateEnglish(lastNameEn.value)) {
                showError(lastNameEn, "يرجى إدخال الكنية بالإنجليزية بشكل صحيح");
                valid = false;
            }
            // ✅ الهاتف
            if (!phone.value.trim() || !validatePhone(phone.value)) {
                showError(phone, "يرجى إدخال رقم هاتف صحيح (6-15 رقم)");
                valid = false;
            }
            // ✅ الجنسية
            if (!nationality.selectedOptions || nationality.selectedOptions.length === 0) {
                showError(nationality, "يرجى اختيار الجنسية");
                valid = false;
            }
            // ✅ الدولة
            if (!country.value) {
                showError(country, "يرجى اختيار الدولة");
                valid = false;
            }
            // ✅ المدينة
            if (!city.value) {
                showError(city, "يرجى اختيار المدينة");
                valid = false;
            }
            if (!valid) e.preventDefault();
        });
    }
    /** ✅ نموذج البيانات المهنية */
    const professionalDataForm = document.getElementById("professionalDataForm");
    if (professionalDataForm) {
        professionalDataForm.addEventListener("submit", function (e) {
            let valid = true;
            const fieldsOfInterest = this.elements["fields_of_interest[]"];
            const attendanceType = this.elements["training_attendance"];
            clearError(fieldsOfInterest);
            clearError(attendanceType);
            // ✅ مجالات الاهتمام
            if (!fieldsOfInterest.selectedOptions || fieldsOfInterest.selectedOptions.length === 0) {
                showError(fieldsOfInterest, "يرجى اختيار مجالات الاهتمام");
                valid = false;
            }
            // ✅ طريقة الحضور
            if (!attendanceType.value) {
                showError(attendanceType, "يرجى اختيار طريقة الحضور");
                valid = false;
            }
            if (!valid) e.preventDefault();
        });
    }
    /** ✅ نموذج الأوقات المفضلة */
    const preferredTimesForm = document.getElementById("preferredTimesForm");
    if (preferredTimesForm) {
        preferredTimesForm.addEventListener("submit", function (e) {
            const checkedTimes = this.querySelectorAll('input[name="preferred_times[]"]:checked').length;
            if (checkedTimes < 2) {
                alert("يرجى اختيار أوقات مناسبة في يومين على الأقل");
                e.preventDefault();
            }
        });
    }
});


        // جلب بيانات المدن عند تغيير الدولة
        $(document).ready(function() {
            const citySelect = $('#city');
            const countrySelect = $('#country_id');
            const previouslySelectedCity = "{{ $user->city ?? '' }}";
            function initCustomSingleSelectForCity() {
                const select = document.querySelector("#city");
                const existingWrapper = select.nextElementSibling;
                if (existingWrapper && existingWrapper.classList.contains("custom-singleselect-wrapper")) {
                    existingWrapper.remove();
                }
                const wrapper = document.createElement("div");
                wrapper.className = "custom-singleselect-wrapper";
                wrapper.tabIndex = 0;
                const input = document.createElement("input");
                input.type = "text";
                input.className = "custom-singleselect-input";
                input.placeholder = "اختر المدينة";
                input.autocomplete = "off";
                const optionsList = document.createElement("div");
                optionsList.className = "options-list";
                const arrow = document.createElement("span");
                arrow.className = "dropdown-arrow";
                arrow.innerHTML = "&#9662;";
                const options = Array.from(select.options).map((opt) => ({
                    value: opt.value,
                    name: opt.text,
                    selected: opt.selected,
                }));
                let selected = select.value;
                function renderOptions(filter = "") {
                    optionsList.innerHTML = "";
                    const filtered = options.filter((opt) =>
                        opt.name.toLowerCase().includes(filter.toLowerCase())
                    );
                    if (filtered.length === 0) {
                        optionsList.innerHTML = `<div class="option-item" style="color:#aaa;">لا توجد نتائج</div>`;
                        return;
                    }
                    filtered.forEach((opt) => {
                        const div = document.createElement("div");
                        div.className = "option-item";
                        div.textContent = opt.name;
                        if (opt.value === selected) div.classList.add("active");
                        div.onclick = () => {
                            selected = opt.value;
                            select.value = selected;
                            input.value = opt.name;
                            optionsList.style.display = "none";
                            wrapper.classList.remove("open");
                        };
                        optionsList.appendChild(div);
                    });
                }
                function renderSelected() {
                    const opt = options.find((o) => o.value === selected);
                    input.value = opt ? opt.name : "";
                }
                input.addEventListener("focus", () => {
                    input.value = "";
                    renderOptions("");
                    optionsList.style.display = "block";
                    wrapper.classList.add("open");
                });
                input.addEventListener("input", () => {
                    renderOptions(input.value);
                    optionsList.style.display = "block";
                });
                input.addEventListener("click", () => {
                    input.value = "";
                    renderOptions("");
                    optionsList.style.display = "block";
                    wrapper.classList.add("open");
                });
                document.addEventListener("click", (e) => {
                    if (!wrapper.contains(e.target)) {
                        optionsList.style.display = "none";
                        wrapper.classList.remove("open");
                        renderSelected();
                    }
                });
                renderSelected();
                wrapper.appendChild(input);
                wrapper.appendChild(optionsList);
                wrapper.appendChild(arrow);
                select.after(wrapper);
                select.style.display = "none";
            }
            function loadCities(countryId, setSelected = false) {
                citySelect.empty().append('<option value="" disabled selected>اختر المدينة</option>');
                fetch('/cities')
                    .then(response => response.json())
                    .then(data => {
                        const filtered = data.filter(city =>
                            String(city.country_id) === String(countryId)
                        );
                        if (filtered.length === 0) {
                            citySelect.append('<option disabled>لا توجد مدن متاحة</option>');
                            return;
                        }
                        filtered.forEach(city => {
                            citySelect.append(new Option(city.name, city.name));
                        });
                        if (setSelected && previouslySelectedCity) {
                            citySelect.val(previouslySelectedCity);
                        }
                        initCustomSingleSelectForCity();
                    })
                    .catch(error => {
                        console.error("خطأ أثناء جلب المدن:", error);
                        citySelect.append('<option disabled>فشل تحميل المدن</option>');
                    });
            }
            countrySelect.on('change', function() {
                const selectedCountryId = $(this).val();
                if (selectedCountryId) {
                    loadCities(selectedCountryId, false);
                }
            });
            const initialCountryId = countrySelect.val();
            if (initialCountryId) {
                loadCities(initialCountryId, true);
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
    const flagBtn = document.getElementById('flagBtn');
    const countryDropdown = document.getElementById('countryDropdown');
    const selectedFlag = document.getElementById('selectedFlag');
    const countryCode = document.getElementById('countryCode');
    const phoneCodeHidden = document.getElementById('phoneCodeHidden');

    flagBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        countryDropdown.style.display = countryDropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function() {
        countryDropdown.style.display = 'none';
    });

    document.querySelector('.search-box').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.country-option').forEach(option => {
            const text = option.textContent.toLowerCase();
            option.style.display = text.includes(searchTerm) ? 'flex' : 'none';
        });
    });

    document.querySelectorAll('.country-option').forEach(option => {
        option.addEventListener('click', function() {
            const code = this.getAttribute('data-code');
            const flag = this.getAttribute('data-flag');

            selectedFlag.src = `/flags/${flag}.svg`;
            countryCode.textContent = code;
            phoneCodeHidden.value = code;

            countryDropdown.style.display = 'none';
        });
    });

    countryDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
    </script>
@endsection