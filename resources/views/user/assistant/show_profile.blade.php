@extends('frontend.layouts.master')

@section('title', 'حساب المساعد')
@section('content')
    <style>

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
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .custom-btn {
            border: 2px solid var(--primary-color);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            padding: 10px;
            color: var(--primary-color);
            transition: background 0.3s, color 0.3s;
        }

        .custom-btn:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .custom-btn:hover svg path {
            fill: #fff;
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
        }

        .phone-country-selector {
            display: flex;
            align-items: center;
            padding: 0 10px;
            background-color: #fff;
            border-left: 1px solid #ccc;
            height: 100%;
            gap: 6px;
            cursor: pointer;
            white-space: nowrap;
        }

        .phone-country-selector .divider {
            width: 1px;
            height: 20px;
            background-color: #ccc;
        }

        .phone-country-selector .arrow-down {
            font-size: 10px;
            color: #333;
            margin-right: 4px;
        }

        .phone-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0 12px;
            font-size: 16px;
            background: transparent;
            direction: ltr;
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

        .is-owner .edit-button-container {
            display: block;
        }

        /* قسم ملخص الخبرات */
        .summary-section {
            background-color: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .summary-section h4 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .experience-item {
            margin-bottom: 15px;
        }

        .experience-item h5 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .experience-item p {
            margin-bottom: 0;
        }

        /* تعديلات للشاشات الصغيرة */
        @media (max-width: 768px) {
            .summary-section {
                padding: 15px;
            }
        }
    </style>

    <main class="assistant-account-page {{ auth()->check() && auth()->id() == $assistant->id ? 'is-owner' : '' }}">
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
                                    style="width: 200px; height: 200px;">
                                    @if ($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="صورة المساعد"
                                            class="img-profile w-100 h-100 object-fit-cover rounded-4">
                                    @else
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية"
                                            class="img-profile w-100 h-100 object-fit-cover rounded-4">
                                    @endif

                                    <!-- الأعلام فوق الصورة في الزاوية السفلية اليسرى -->
                                    @if (!empty($assistant->nationality) && count($assistant->nationality))
                                        <div class="position-absolute d-flex gap-1 flex-wrap align-items-center"
                                            style="bottom: 8px; left: 8px;">
                                            @foreach (collect($countries)->whereIn('id', $assistant->nationality)->take(5) as $country)
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
                                            {{ $assistant->getTranslation('last_name', 'ar') }}
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
                                            <strong>{{ $user->phone_number }}</strong>
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
                                        class="download-btn flex-grow-1">
                                        <svg style="margin-left: 8px;" width="24" height="20" viewBox="0 0 24 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.975 5.14152C17.643 5.07552 17.372 4.86852 17.233 4.57252C15.681 1.30152 12.09 -0.527481 8.498 0.134519C5.226 0.734519 2.661 3.34652 2.114 6.63552C1.952 7.60652 1.964 8.57852 2.147 9.52552C2.207 9.83452 2.074 10.1785 1.801 10.4265C0.656 11.4675 0 12.9505 0 14.4965C0 17.5285 2.467 19.9965 5.5 19.9965H16.5C20.636 19.9965 24 16.6325 24 12.4965C24 8.93152 21.466 5.83852 17.974 5.14252L17.975 5.14152ZM16.501 17.9955H5.501C3.571 17.9955 2.001 16.4255 2.001 14.4955C2.001 13.5125 2.419 12.5675 3.147 11.9055C3.933 11.1905 4.302 10.1325 4.11 9.14252C3.972 8.43052 3.964 7.69752 4.086 6.96152C4.489 4.53952 6.451 2.54052 8.857 2.09952C9.242 2.02952 9.625 1.99552 10.002 1.99552C12.314 1.99552 14.408 3.28452 15.424 5.42952C15.838 6.30152 16.624 6.91052 17.582 7.10252C20.141 7.61352 21.999 9.88052 21.999 12.4965C21.999 15.5285 19.532 17.9965 16.499 17.9965L16.501 17.9955ZM15.122 11.2885C15.513 11.6795 15.513 12.3115 15.122 12.7025L12.415 15.4095C12.028 15.7965 11.519 15.9915 11.01 15.9935L11.001 15.9955L10.992 15.9935C10.483 15.9915 9.974 15.7965 9.587 15.4095L6.88 12.7025C6.489 12.3115 6.489 11.6795 6.88 11.2885C7.271 10.8975 7.903 10.8975 8.294 11.2885L10.001 12.9955V7.99552C10.001 7.44252 10.449 6.99552 11.001 6.99552C11.553 6.99552 12.001 7.44252 12.001 7.99552V12.9955L13.708 11.2885C14.099 10.8975 14.731 10.8975 15.122 11.2885Z"
                                                fill="#003090" />
                                        </svg>
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

                <!-- العمود الثاني: ملخص الخبرات والتعليم -->
                <div class="col-lg-6 col-md-12 d-flex justify">
                    <div class="custom-card h-100 w-100 p-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center border-0">

                                <h4 class="title fw-bold mb-0">ملخص الخبرات والتعليم</h4>

                                <button class="btn btn-sm edit-button-container" onclick="openModal('professional-summary')">
                                    <img src="{{ asset('images/pencil-simple.svg') }}" />
                                </button>
                            </div>
                            <div class="text-muted small fw-semibold">{{ $user->bio ?? 'غير محدد' }}</div>

                            <div class="card-body px-2 justify-content-start gap-3">
                                <!-- مجالات الخبرة -->
                                <div class="w-100">
                                    <div class="text-muted small">مجالات الخبرة</div>
                                    <div class="fw-semibold">
                                        @if ($assistant_experience_areas->count() > 0)
                                            {{ implode('، ', $assistant_experience_areas->pluck('name')->toArray()) }}
                                        @else
                                            غير محدد
                                        @endif
                                    </div>
                                </div>

                                <div class="w-100">
                                    <div class="text-muted small">سنوات الخبرة</div>
                                    <div class="fw-semibold">
                                        @php
                                            $years = $assistant->years_of_experience;
                                        @endphp

                                        @if ($years === null)
                                            غير محدد
                                        @elseif ($years == 0)
                                            بدون خبرة
                                        @elseif ($years >= 3 && $years <= 10)
                                            {{ $years }} سنوات
                                        @else
                                            {{ $years }} سنة
                                        @endif
                                    </div>
                                </div>

                                <!-- الخدمات -->
                                <div class="w-100">
                                    <div class="text-muted small">الخدمات</div>
                                    <div class="fw-semibold">
                                        @if ($assistant_providedServices->count() > 0)
                                            {{ implode('، ', $assistant_providedServices->pluck('name')->toArray()) }}
                                        @else
                                            غير محدد
                                        @endif
                                    </div>
                                </div>


                                <div class="row w-100">
                                    <!-- التخرج -->
                                    <div class="col-md-6 col-12">
                                        <div class="text-muted small">التخرج</div>
                                        <div class="fw-semibold">
                                            @if ($assistant->university && $assistant->graduation_year)
                                                {{ $assistant->university }} -
                                                {{ $assistant->graduation_year ? date('Y', strtotime($assistant->graduation_year)) : 'غير محدد' }}
                                            @else
                                                غير محدد
                                            @endif
                                        </div>
                                    </div>

                                    <!-- التعليم -->
                                    <div class="col-md-6 col-12">
                                        <div class="text-muted small">التعليم</div>
                                        <div class="fw-semibold">
                                            @php
                                                $educationLevelName = null;
                                                if ($assistant->education_levels_id) {
                                                    $educationLevelName = \App\Models\EducationLevel::find(
                                                        $assistant->education_levels_id,
                                                    )?->name;
                                                }
                                            @endphp

                                            @if ($assistant->specialization || $educationLevelName)
                                                {{ $assistant->specialization ?? '' }} - {{ $educationLevelName ?? '' }}
                                            @else
                                                غير محدد
                                            @endif
                                        </div>
                                    </div>
                                </div>





                            </div>
                        </div>
                    </div>
                </div>
            </div>
  @if (!$user->userCv && auth()->check() && auth()->id() == $user->id)

                <div class="card-header d-flex justify-content-between align-items-center mt-5">
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
                            <div class="desc w-100">
                                <span class="text-muted mb-3">حمّل سيرتك الذاتية بشكل سهل وسريع</span>
                            </div>

                              <div class="edit-button-container">
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
                    </div>
                </div>
            @endif
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

        <form class="modal-form" action="{{ route('update_assistant_personal_information') }}" method="POST"
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
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="صورة المساعد" />
                            @else
                                <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية" />
                            @endif
                        </div>
                        </div>
                        <div class="profile-upload-desc">
                            أرفق صورة شخصية مربعة وواضحة (JPG أو PNG، حد أقصى 5MB).
                        </div>
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
                        value="{{ old('last_name_ar', $assistant->getTranslation('last_name', 'ar')) }}"
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
                        value="{{ old('last_name_en', $assistant->getTranslation('last_name', 'en')) }}"
                        placeholder="اكتب هنا" />
                </div>
            </div>

            <div class="input-group-2col">
                <div class="input-group">
                    <label>رقم الهاتف <span class="required">*</span></label>
                    <div class="phone-container">
                        @php
                            $code = isset($user->phone_code) ? ltrim($user->phone_code, '+') : '90';
                            $defaultFlag = 'tr';

                            foreach ($countries as $country) {
                                if ((string) $country->phonecode === $code) {
                                    $defaultFlag = strtolower($country->iso2);
                                    break;
                                }
                            }
                        @endphp

                        <div class="phone-country-selector" id="flagBtn">
                            <span id="countryCode" dir="ltr">{{ $user->phone_code ?? '+90' }}</span>
                            <span class="divider"></span>
                            <span class="arrow-down">🞃</span>
                            <img class="flag-img" id="selectedFlag"
                                src="{{ asset('flags/' . ($defaultFlag ?? 'tr') . '.svg') }}">
                        </div>

                        <input type="tel" name="phone_number" class="phone-input" value="{{ $user->phone_number }}"
                            placeholder="ادخل رقم الهاتف" required>

                        <input type="hidden" name="phone_code" id="phoneCodeHidden"
                            value="{{ $user->phone_code ?? '+90' }}">
                    </div>
                    <div class="country-dropdown" id="countryDropdown">
                        <input type="text" class="search-box" placeholder="ابحث عن دولة...">
                        <div class="country-list">
                            @foreach ($countries as $country)
                                <div class="country-option" data-code="{{ $country->phonecode }}"
                                    data-flag="{{ strtolower($country->iso2) }}">
                                    <img src="{{ asset('flags/' . strtolower($country->iso2) . '.svg') }}" width="34"
                                        height="24">
                                    <span>+{{ $country->phonecode }}</span>
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
                        <option value="{{ $country->id }}" @if (in_array((string) $country->id, old('nationality', $user->assistant->nationality ?? []))) selected @endif>
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

    <!-- Modal ملخص الخبرات والتعليم -->
    <div id="professional-summary" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">تعديل ملخص الخبرات والتعليم</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="professional-summary">&times;</span>
        </div>
        <div class="modal-desc">قم بتحديث معلومات الخبرات والتعليم الخاصة بك</div>

        <form class="modal-form" action="{{ route('update_experience_and_education') }}" method="POST"
            id="professionalSummaryForm">
            @csrf
            @method('PUT')

            <!-- العنوان المهني -->
            <div class="input-group">
                <label>العنوان المهني <span class="required">*</span></label>
                <input name="headline" type="text" value="{{ old('headline', $assistant->headline) }}"
                    placeholder="مثال: مدرب في المهارات الرقمية UX/UI" required />
            </div>
            <div class="input-group">
                <label>نبذه عنك <span class="required">*</span></label>
                <input name="bio" type="text" value="{{ old('bio', $user->bio) }}"
                    placeholder="شارك نبذة مختصرة تبرز خبرتك وهويتك المهنية" required />
            </div>
            <!-- مجالات الخبرة -->
            <div class="input-group">
                <label>مجالات الخبرة <span class="required">*</span></label>
<select name="experience_areas[]" class="custom-multiselect" multiple required
    data-placeholder="اختر مجالات خبرتك">
    @foreach ($experience_areas as $area)
        <option value="{{ $area->id }}"
            @if (in_array((string) $area->id, old('experience_areas', $assistant->experience_areas ?? []))) selected @endif>
            {{ $area->name }}
        </option>
    @endforeach
</select>

            </div>

            <!-- سنوات الخبرة -->
            <div class="input-group">
                <label>سنوات الخبرة <span class="required">*</span></label>
                <input name="years_of_experience" type="number" min="0" max="50"
                    value="{{ old('years_of_experience', $assistant->years_of_experience) }}" placeholder="عدد السنوات"
                    required />
            </div>

            <!-- الخدمات -->
          <div class="input-group">
    <label>الخدمات المقدمة <span class="required">*</span></label>
    <select name="provided_services[]" class="custom-multiselect" multiple required
        data-placeholder="اختر الخدمات التي تقدمها">
        @foreach ($provided_services as $service)
            <option value="{{ $service->id }}"
                @if (in_array((string) $service->id, old('provided_services', $assistant->provided_services ?? []))) selected @endif>
                {{ $service->name }}
            </option>
        @endforeach
    </select>
</div>

            <!-- التعليم -->
            <div class="input-group-2col">
                <div class="input-group">
                    <label>الجامعة <span class="required">*</span></label>
                    <input name="university" type="text" value="{{ old('university', $assistant->university) }}"
                        placeholder="اسم الجامعة" required />
                </div>
                <div class="input-group">
                    <label>سنة التخرج <span class="required">*</span></label>
                    <input name="graduation_year" type="date"
                        value="{{ old('graduation_year', $assistant->graduation_year ? $assistant->graduation_year : '') }}"
                        required />
                </div>
            </div>

            <!-- التخصص -->
            <div class="input-group">
                <label>التخصص <span class="required">*</span></label>
                <input name="specialization" type="text"
                    value="{{ old('specialization', $assistant->specialization) }}" placeholder="التخصص الأكاديمي"
                    required />
            </div>

<!-- مستوى التعليم -->
<div class="input-group">
    <label>مستوى التعليم <span class="required">*</span></label>
    <select name="education_levels_id" class="custom-singleselect" required>
        @foreach ($education_levels as $level)
            <option value="{{ $level->id }}"
                @if (old('education_level', $assistant->education_levels_id ?? '') == $level->id) selected @endif>
                {{ $level->name }}
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
        document.addEventListener("DOMContentLoaded", function() {
            /** ✅ دالة عرض الخطأ */
            function showError(input, message) {
                clearError(input);
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
                personalInfoForm.addEventListener("submit", function(e) {
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

                    // ✅ الاسم بالإنجليزية
                    if (nameEn.value.trim() && !validateEnglish(nameEn.value)) {
                        showError(nameEn, "يرجى إدخال الاسم بالإنجليزية بشكل صحيح");
                        valid = false;
                    }

                    // ✅ الكنية بالإنجليزية
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

            /** ✅ نموذج ملخص الخبرات والتعليم */
            const professionalSummaryForm = document.getElementById("professionalSummaryForm");
            if (professionalSummaryForm) {
                professionalSummaryForm.addEventListener("submit", function(e) {
                    let valid = true;

                    const headline = this.elements["headline"];
                    const experienceAreas = this.elements["experience_areas[]"];
                    const yearsOfExperience = this.elements["years_of_experience"];
                    const providedServices = this.elements["provided_services[]"];
                    const university = this.elements["university"];
                    const graduationYear = this.elements["graduation_year"];
                    const specialization = this.elements["specialization"];
                    const educationLevel = this.elements["education_level"];
                    const sex = this.elements["sex"];

                    clearError(headline);
                    clearError(experienceAreas);
                    clearError(yearsOfExperience);
                    clearError(providedServices);
                    clearError(university);
                    clearError(graduationYear);
                    clearError(specialization);
                    clearError(educationLevel);
                    clearError(sex);

                    // ✅ العنوان المهني
                    if (!headline.value.trim()) {
                        showError(headline, "يرجى إدخال العنوان المهني");
                        valid = false;
                    }

                    // ✅ مجالات الخبرة
                    if (!experienceAreas.selectedOptions || experienceAreas.selectedOptions.length === 0) {
                        showError(experienceAreas, "يرجى اختيار مجالات الخبرة");
                        valid = false;
                    }

                    // ✅ سنوات الخبرة
                    if (!yearsOfExperience.value.trim() || isNaN(yearsOfExperience.value) ||
                        yearsOfExperience.value <
                        0) {
                        showError(yearsOfExperience, "يرجى إدخال عدد سنوات الخبرة صحيح");
                        valid = false;
                    }

                    // ✅ الخدمات المقدمة
                    if (!providedServices.selectedOptions || providedServices.selectedOptions.length ===
                        0) {
                        showError(providedServices, "يرجى اختيار الخدمات المقدمة");
                        valid = false;
                    }

                    // ✅ الجامعة
                    if (!university.value.trim()) {
                        showError(university, "يرجى إدخال اسم الجامعة");
                        valid = false;
                    }

                    // ✅ سنة التخرج
                    if (!graduationYear.value.trim()) {
                        showError(graduationYear, "يرجى إدخال سنة التخرج");
                        valid = false;
                    }

                    // ✅ التخصص
                    if (!specialization.value.trim()) {
                        showError(specialization, "يرجى إدخال التخصص");
                        valid = false;
                    }

                    if (!valid) e.preventDefault();
                });
            }
        });










        document.addEventListener('DOMContentLoaded', function() {
            const flagBtn = document.getElementById('flagBtn');

            const countryDropdown = document.getElementById('countryDropdown');
            const selectedFlag = document.getElementById('selectedFlag');
            const countryCode = document.getElementById('countryCode');
            const phoneCodeHidden = document.getElementById('phoneCodeHidden');
            const countryFlagHidden = document.getElementById('countryFlagHidden');

            flagBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                countryDropdown.style.display = countryDropdown.style.display === 'block' ? 'none' :
                    'block';
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
                    const code = '+' + this.getAttribute('data-code');
                    const flag = this.getAttribute('data-flag');

                    selectedFlag.src = `/flags/${flag}.svg`;
                    countryCode.textContent = code;
                    phoneCodeHidden.value = code;
                    countryFlagHidden.value = flag;

                    countryDropdown.style.display = 'none';
                });
            });

            countryDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

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

        $(document).ready(function() {
            const citySelect = $('#city');
            const countrySelect = $('#country_id');
            const previouslySelectedCity = "{{ $user->city ?? '' }}";

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
    </script>
@endsection
