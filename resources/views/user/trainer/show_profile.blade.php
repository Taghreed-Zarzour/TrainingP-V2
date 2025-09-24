@extends('frontend.layouts.master')

@section('title', 'حساب المدرب')

@section('content')
    <style>
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

        /* Dropdown Styles */
        .country-dropdown {
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 250px;
            max-height: 300px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
            margin-top: 5px;
        }

        .search-box {
            width: 100%;
            padding: 6px;
            margin-bottom: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .country-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 5px;
            cursor: pointer;
            transition: background 0.2s;
            direction: ltr;
        }

        .country-option:hover {
            background-color: #f5f5f5;
        }

        .country-option img {
            border-radius: 4px;
            margin-left: 10px;
        }

        .vedio_profile {
            border-radius: 16px;
            overflow: hidden;
            width: 100%;
            height: 409px;
            object-fit: contain;
            object-position: center;
        }

        @media only screen and (max-width: 600px) {
            .vedio_profile {
                height: auto;
            }
        }

        /* Hide edit buttons for non-owners */
        .edit-button-container {
            display: none;
        }

        .is-owner .edit-button-container {
            display: block;
        }


        .star-rating {
            direction: rtl;
            font-size: 1.5rem;
            unicode-bidi: bidi-override;
            display: flex;
            gap: 5px;
            cursor: pointer;
        }

        .star {
            color: #ccc;
            transition: color 0.3s;
        }

        .star.selected {
            color: #ffc107;
            /* لون النجوم المحددة */
        }

        .carousel-card {
            width: calc(100% / 3 - 1rem);
            min-width: 300px;
            transition: transform 0.3s ease;
        }


        .custom-carousel {
            scroll-behavior: smooth;
            overflow-x: auto;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE/Edge */
        }

        .custom-carousel::-webkit-scrollbar {
            display: none;
            /* Chrome */
        }

        .rating-line {
            height: 8px;
            background-color: #e0e0e0;
            /* رمادي فاتح كخلفية */
            border-radius: 4px;
            overflow: hidden;
            width: 200px;
            /* عرض ثابت */
            flex-shrink: 0;
        }

        .rating-line-inner {
            height: 100%;
            background-color: #003090;
            /* أزرق فقط */
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        /* زر الحذف بلون الأحمر، بحجم مناسب مع زر التحميل */
        .delete-btn {
            border: 1.5px solid #dc3545;
            color: #dc3545;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            background: transparent;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.3s, color 0.3s;
            width: fit-content;
        }

        .delete-btn:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>

    <main>
        <div class="trainer-account-page {{ auth()->check() && auth()->id() == $user->id ? 'is-owner' : '' }}">

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

            <div class="grid">
                <div class="right-col">
                    <div class="card-block base-info">
                        <div class="card-header">
                            <div class="card-header-title"></div>
                            <div class="edit-button-container">
                                <button onclick="openModal('personal-info')">
                                    <img src="{{ asset('images/pencil-simple.svg') }}" />
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="bi-image-wrap">
                                @if ($user->photo)
                                    <div class="image-container">
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="صورة المدرب"
                                            class="square-img" />
                                    </div>
                                @else
                                    <div class="image-container">
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية"
                                            class="square-img" />
                                    </div>
                                @endif

                                <div class="bi-flags">
                                    @if ($user->nationalities && $user->nationalities->count())
                                        @foreach ($user->nationalities->take(5) as $country)
                                            <img src="{{ asset('flags/' . strtolower($country->iso2) . '.svg') }}"
                                                alt="{{ $country->name }}" class="flag-img" title="{{ $country->name }}" />
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="bi-title-wrap">
                                <div class="bi-name-wrap">
                                    <div class="bi-name">{{ $user->getTranslation('name', 'ar') }}
                                        {{ $user->trainer->getTranslation('last_name', 'ar') }}</div>
                                    @if ($user->email_verified_at)
                                        <div class="bi-badge">
                                            <img src="{{ asset('images/seal-check-fill.svg') }}" alt="حساب موثوق" />
                                        </div>
                                    @endif
                                </div>
                                <div class="bi-social-links">
                                    @if ($trainer->linkedin_url)
                                        <a href="{{ $trainer->linkedin_url }}" target="_blank">
                                            <img src="{{ asset('images/linkedin.svg') }}" alt="لينكد إن" />
                                        </a>
                                    @endif
                                    <a href="#" onclick="copyLink(event)">
                                        <img src="{{ asset('images/share.svg') }}" alt="مشاركة" />
                                    </a>
                                    <script>
                                        function copyLink(event) {
                                            event.preventDefault();

                                            // قراءة الاسم والكنية بالإنجليزي من الـ HTML
                                            const nameEn = "{{ trim($user->getTranslation('name', 'en')) }}";
                                            const lastNameEn = "{{ trim($user->trainer->getTranslation('last_name', 'en')) }}";
                                            const userId = "{{ $user->id }}";

                                            let slugPart;

                                            if (nameEn && lastNameEn) {
                                                // تكوين الـ slug (صيغة URL آمنة)
                                                slugPart = (nameEn + '-' + lastNameEn).toLowerCase().replace(/\s+/g, '-');
                                                slugPart = slugPart.replace(/[^a-z0-9\-]/g, ''); // إزالة أي رموز غريبة
                                                slugPart += '-' + userId;
                                            } else {
                                                slugPart = userId;
                                            }

                                            const fullUrl = `${window.location.origin}/show-trainer-profile/${slugPart}`;

                                            navigator.clipboard.writeText(fullUrl).then(function() {
                                                alert('تم نسخ الرابط بنجاح ✅');
                                            }, function(err) {
                                                alert('حدث خطأ أثناء نسخ الرابط ❌');
                                                console.error('Clipboard error:', err);
                                            });
                                        }
                                    </script>

                                </div>
                            </div>

                            <div class="bi-title-wrap" style="justify-content: end;">
                                <div class="bi-name-wrap">
                                    <div class="bi-name" style="text-transform: capitalize;">
                                        {{ $user->getTranslation('name', 'en') }}
                                        {{ $user->trainer->getTranslation('last_name', 'en') }}</div>

                                </div>

                            </div>

                            <div class="bi-branch">{{ $trainer->headline ?? '' }}</div>
                            <div class="bi-desc">
                                {{ $user->bio }}
                            </div>
                            @if (empty($trainer->hourly_wage) || $trainer->hourly_wage == 0)
                                <div class="edit-button-container">
                                    <a onclick="openModal('personal-info')" class="bi-price text-pointer">
                                        أدخل الأجر في الساعة
                                    </a>
                                </div>
                            @else
                                @php
                                    $wage = $trainer->hourly_wage;
                                    $formattedWage =
                                        is_numeric($wage) && floor($wage) == $wage
                                            ? number_format($wage, 0, '.', '')
                                            : $wage;
                                @endphp

                                <div class="bi-price">
                                    الأجر في الساعة {{ $formattedWage }}
                                    {{ \App\Enums\Currency::tryFrom($trainer->currency)?->symbol() ?? '' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-block experiences">
                        <div class="card-header">
                            <div class="card-header-title">
                                ملخص الخبرات
                            </div>
                            <div class="edit-button-container">
                                <button onclick="openModal('experience')">
                                    <img src="{{ asset('images/pencil-simple.svg') }}" />
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="ex-wrap">
                                <div class="ex-title">قطاع العمل:</div>
                                <div class="ex-desc">
                                    @foreach ($trainer_workSectors as $workSector)
                                        {{ $workSector->name }}@if (!$loop->last)
                                            ،
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="ex-wrap">
                                <div class="ex-title">الخدمات:</div>
                                <div class="ex-desc">
                                    @foreach ($trainer_providedServices as $service)
                                        {{ $service->name }}@if (!$loop->last)
                                            ،
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="ex-wrap">
                                <div class="ex-title">الخبرات الدولية:</div>
                                <div class="ex-desc">
                                    @if ($trainer_internationalExperiences && count($trainer_internationalExperiences) > 0)
                                        @foreach ($trainer_internationalExperiences as $experience)
                                            {{ $experience->name }}@if (!$loop->last)
                                                ،
                                            @endif
                                        @endforeach
                                    @else
                                        لا يوجد
                                    @endif
                                </div>
                            </div>

                            <div class="ex-wrap">
                                <div class="ex-title">
                                    أهم مجالات العمل:
                                </div>
                                <div class="ex-desc">
                                    @foreach ($trainer_workFields as $workField)
                                        {{ $workField->name }}@if (!$loop->last)
                                            ،
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="ex-wrap">
                                <div class="ex-title">
                                    أهم مواضيع التدريب:
                                </div>
                                <div class="ex-desc">
                                    @if (is_array($trainer->important_topics) && count($trainer->important_topics) > 0)
                                        {{ implode('، ', $trainer->important_topics) }}
                                    @else
                                        لا يوجد
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-block contact">
                        <div class="card-header">
                            <div class="card-header-title">
                                معلومات التواصل
                            </div>
                            <div class="edit-button-container">
                                <button onclick="openModal('contact')">
                                    <img src="{{ asset('images/pencil-simple.svg') }}" />
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="c-title">{{ $user->country->name ?? '' }}، {{ $user->city ?? '' }}</div>
                            <div class="c-wrap">
                                <div class="c-name">رقم الهاتف:</div>
                                <div class="c-link" style="direction: ltr;">
                                    <a href="tel:{{ $user->phone_code }}{{ $user->phone_number }}">
                                        {{ $user->phone_code }}{{ $user->phone_number }}
                                    </a>
                                </div>
                            </div>
                            <div class="c-wrap">
                                <div class="c-name">البريد الإلكتروني:</div>
                                <div class="c-link">
                                    <a href="mailto:{{ $user->email }}">
                                        {{ $user->email }}
                                    </a>
                                </div>
                            </div>
                            @if ($trainer->website)
                                <div class="c-wrap">
                                    <div class="c-name">الموقع الإلكتروني:</div>
                                    <div class="c-link">
                                        <a href="{{ $trainer->website }}" target="_blank">
                                            {{ $trainer->website }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($user->userCv)
                        <div
                            style="display: flex; flex-direction: row; align-items: flex-start; gap: 12px; align-items: center;">
                            <!-- زر تحميل السيرة كما هو -->
                            <a class="upload-cv" href="{{ route('download.cv', $user->id) }}">
                                <img src="{{ asset('images/cloud.svg') }}" alt="" />
                                تحميل السيرة الذاتية
                            </a>

                            <!-- زر حذف -->
                            <form method="POST" class="p-0" action="{{ route('delete_cv') }}"
                                onsubmit="return confirm('هل أنت متأكد من حذف السيرة الذاتية؟');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" title="حذف السيرة الذاتية">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5v6a.5.5 0 0 0 1 0v-6a.5.5 0 0 0-1 0zm4 0v6a.5.5 0 0 0 1 0v-6a.5.5 0 0 0-1 0z" />
                                        <path fill-rule="evenodd"
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H13.5a.5.5 0 0 0 0-1H10.5a.5.5 0 0 1-.5-.5h-3a.5.5 0 0 1-.5.5H2.5z" />
                                    </svg>
                                    حذف
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="left-col">
                    <div class="edit-button-container">
                        @if ($profileCompletion == 100 && !$user->profile_message_shown)
                            <div class="success-message">
                                <div class="sm-badge">
                                    <img src="{{ asset('images/icons/seal-check-fill-green.svg') }}" alt="نجاح" />
                                </div>
                                <div class="sm-message">
                                    رائع! لقد أكملت حسابك كمدرب بنجاح – الآن سيرى
                                    العالم خبرتك، وستكون فرصتك لصناعة الأثر أكبر بين
                                    المؤسسات والمتدربين
                                </div>
                            </div>
                            @php

                                $user->update(['profile_message_shown' => true]);
                            @endphp
                        @endif
                        @if ($profileCompletion < 100)
                            <div class="warning-message">
                                <div class="sm-badge">
                                    <img src="{{ asset('images/icons/warning.svg') }}" alt="تحذير" />
                                </div>
                                <div class="wm-message">
                                    عند اكتمال حسابك كمدرب، سيصبح ظاهرًا للمؤسسات
                                    والمتدربين ضمن المنصة
                                </div>
                                <div>
                                    <div class="circular-progress">
                                        <svg viewBox="0 0 36 36" class="circular-chart">
                                            <path class="circle-bg" d="M18 2.0845
                                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                                        a 15.9155 15.9155 0 0 1 0 -31.831" />
                                            <path class="circle_percentage"
                                                stroke-dasharray="{{ $profileCompletion ?? 30 }}, 100" d="M18 2.0845
                                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                                        a 15.9155 15.9155 0 0 1 0 -31.831" />
                                            <text x="18" y="20.35" class="percentage">
                                                {{ $profileCompletion ?? 30 }}%
                                            </text>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- تحقق أولًا إذا كان المستخدم مسجل دخول وإذا كان صاحب الحساب --}}
                    {{-- تحقق إذا كان صاحب الحساب أو إذا هناك فيديو --}}
                    @if ($trainer->previousTraining || (auth()->check() && auth()->id() == $trainer->id))
                        <div class="add-item-block prev-training">
                            <div class="title-wrap pt-title-wrap">
                                <div class="title">مقطع من تدريب سابق</div>

                                {{-- أزرار التعديل تظهر فقط لصاحب الحساب --}}
                                @if (auth()->check() && auth()->id() == $trainer->id)
                                    @if ($trainer->previousTraining)
                                        <div class="edit-button-container">
                                            <a href="#" onclick="openModal('prev-training')">
                                                <img src="../images/pencil-simple.svg" />
                                            </a>
                                        </div>
                                    @else
                                        <div class="edit-button-container">
                                            <button onclick="openModal('prev-training')"
                                                class="pbtn pbtn-main pbtn-small piconed">
                                                <img src="{{ asset('images/icons/plus.svg') }}" />
                                            </button>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <div class="card-block">
                                <div class="card-body align-content-center">
                                    @if ($trainer->previousTraining)
                                        <div class="prev-training-item w-100">
                                            <div class="card-body">
                                                @php
                                                    $videoLink = $trainer->previousTraining->video_link;
                                                @endphp

                                                {{-- عرض الفيديو بناءً على المصدر --}}
                                                @if (Str::contains($videoLink, ['youtube.com', 'youtu.be']))
                                                    <iframe class="vedio_profile"
                                                        src="{{ Str::contains($videoLink, 'watch?v=') ? str_replace('watch?v=', 'embed/', $videoLink) : str_replace('youtu.be/', 'www.youtube.com/embed/', $videoLink) }}"
                                                        frameborder="0" allowfullscreen>
                                                    </iframe>
                                                @elseif (Str::contains($videoLink, 'vimeo.com'))
                                                    <iframe class="vedio_profile"
                                                        src="https://player.vimeo.com/video/{{ basename($videoLink) }}"
                                                        frameborder="0" allowfullscreen>
                                                    </iframe>
                                                @elseif (Str::contains($videoLink, 'drive.google.com'))
                                                    <iframe class="vedio_profile"
                                                        src="https://drive.google.com/file/d/{{ getGoogleDriveId($videoLink) }}/preview"
                                                        frameborder="0" allowfullscreen>
                                                    </iframe>
                                                @elseif (Str::contains($videoLink, ['dropbox.com']))
                                                    <iframe class="vedio_profile"
                                                        src="{{ str_replace('?dl=0', '?raw=1', $videoLink) }}"
                                                        frameborder="0" allowfullscreen>
                                                    </iframe>
                                                @else
                                                    <video width="100%" height="auto" controls>
                                                        <source src="{{ $videoLink }}" type="video/mp4">
                                                        المتصفح لا يدعم تشغيل الفيديو.
                                                    </video>
                                                @endif

                                                <div class="pti-title">
                                                    {{ $trainer->previousTraining->training_title }}
                                                </div>
                                                <div class="pti-desc">
                                                    {{ $trainer->previousTraining->description }}
                                                </div>
                                            </div>
                                        </div>
                                    @elseif(auth()->check() && auth()->id() == $trainer->id)
                                        {{-- لا يوجد فيديو، يظهر فقط لصاحب الحساب --}}
                                        <div class="content">
                                            <img src="{{ asset('images/trainer-account/prev-training.svg') }}"
                                                alt="تدريب سابق" />
                                            <div class="desc">
                                                ارفع مقطع فيديو يبرز مهاراتك التدريبية ويُظهر تميزك في تقديم المحتوى.
                                                هذا يساعد المؤسسات والمتدربين على التعرف عليك بشكل أفضل وزيادة فرص اختيارك.
                                            </div>
                                            <div class="edit-button-container">
                                                <button onclick="openModal('prev-training')">
                                                    <img src="{{ asset('images/icons/plus-dark.svg') }}" />
                                                    رفع مقطعًا من تدريب سابق
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif



                    @if (!$user->userCv && auth()->check() && auth()->id() == $user->id)
                        <div class="add-item-block">
                            <div class="title-wrap">
                                <div class="title">السيرة الذاتية CV</div>
                                <div class="edit-button-container">
                                    <button class="pbtn pbtn-main pbtn-small piconed"
                                        onclick="document.getElementById('cv-upload').click()">
                                        <img src="{{ asset('images/icons/plus.svg') }}" />
                                    </button>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="card-body align-content-center">
                                    <div class="content">
                                        <img src="{{ asset('images/trainer-account/cv.svg') }}" alt="سيرة ذاتية" />
                                        <div class="desc">
                                            حمّل سيرتك الذاتية بشكل سهل وسريع
                                        </div>
                                        <div class="edit-button-container">
                                            <button onclick="document.getElementById('cv-upload').click()">
                                                <img src="{{ asset('images/icons/plus-dark.svg') }}" />
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
                        </div>
                    @endif

                    @php
                        // تحقق من وجود تقييم للمستخدم الحالي في مصفوفة التقييمات
                        $userRating = null;
                        if (auth()->check()) {
                            foreach ($ratings as $rating) {
                                if ($rating->trainee_id == auth()->id()) {
                                    $userRating = $rating;
                                    break;
                                }
                            }
                        }
                    @endphp
                    @if (count($ratings) > 0)
                        <div class="reviews">
                            <div class="reviews-title-wrap d-flex flex-column flex-sm-row gap-2">
                                <div class="reviews-title">
                                    تقييمات المتدربين والمؤسسات
                                </div>
                                @if (auth()->user() && auth()->user()->userType?->type === 'متدرب')
                                    <!-- زر إضافة أو تحديث التقييم -->
                                    <div class="text-end mt-3">
                                        <button type="button" class="custom-btn" data-bs-toggle="modal"
                                            data-bs-target="#ratingModal">
                                            {{ $userRating ? 'تحديث التقييم' : 'إضافة تقييم' }}
                                            <img src="{{ asset('images/cources/arrow-left.svg') }}">
                                        </button>
                                    </div>
                                @endif
                                <div class="reviews-slider-buttons">
                                    <button class="prev pbtn pbtn-outlined">
                                        <img src="{{ asset('images/reviews/prev.svg') }}" />
                                    </button>
                                    <button class="next pbtn pbtn-main">
                                        <img src="{{ asset('images/reviews/next.svg') }}" />
                                    </button>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="card-body align-content-center">
                                    <div class="general-rating">
                                        <div class="ratings-details">



                                            @php
                                                $criteria = ['clarity', 'interaction', 'organization'];
                                                $starCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                                $totalRatings = 0;
                                                $totalSum = 0;

                                                foreach ($ratings as $rating) {
                                                    foreach ($criteria as $criterion) {
                                                        if (isset($rating->$criterion)) {
                                                            $score = $rating->$criterion;
                                                            $rounded = round($score);
                                                            $starCounts[$rounded]++;
                                                            $totalSum += $score;
                                                            $totalRatings++;
                                                        }
                                                    }
                                                }

                                                $averageTrainerRating =
                                                    $totalRatings > 0 ? $totalSum / $totalRatings : 0;
                                            @endphp


                                            @foreach ([5, 4, 3, 2, 1] as $stars)
                                                @php
                                                    $percentage =
                                                        $totalRatings > 0
                                                            ? ($starCounts[$stars] / $totalRatings) * 100
                                                            : 0;
                                                @endphp
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <div class="rating-star d-flex align-items-center gap-1">
                                                        {{ $stars }}
                                                        <img src="{{ asset('images/icons/star-fill.svg') }}" />
                                                    </div>
                                                    <div class="rating-line" style="width: 200px;">
                                                        <div class="rating-line-inner"
                                                            style="width: {{ $percentage }}%;"></div>
                                                    </div>
                                                </div>
                                            @endforeach



                                        </div>
                                        <div class="average-rating">
                                            <div class="average-rating-value">
                                                {{ number_format($averageTrainerRating, 1) }}
                                            </div>
                                            <div class="stars-wrapper">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($averageTrainerRating))
                                                        <img src="{{ asset('images/icons/star-fill.svg') }}"
                                                            alt="">
                                                    @elseif($i == ceil($averageTrainerRating) && $averageTrainerRating - floor($averageTrainerRating) >= 0.5)
                                                        <img src="{{ asset('images/icons/star-half.svg') }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('images/icons/star.svg') }}" alt="">
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="average-rating-count">
                                                <span>{{ $totalRatings }}</span> مراجعة
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper">
                                <div class="swiper-content">
                                    @foreach ($ratings as $rating)
                                        <div class="swiper-slide">
                                            <div class="review-item">
                                                <div class="review-item-header">
                                                    <div class="review-item-user">
                                                        @if ($rating->trainee->user->photo)
                                                            <img src="{{ asset('storage/' . $rating->trainee->user->photo) }}"
                                                                alt="{{ $rating->trainee->user->name }}">
                                                        @else
                                                            <img src="{{ asset('images/icons/user.svg') }}"
                                                                alt="صورة افتراضية">
                                                        @endif
                                                        <div>
                                                            <div class="review-item-user-name">



                                                                {{ $rating->trainee->user->getTranslation('name', 'ar') }}
                                                                {{ $rating->trainee->getTranslation('last_name', 'ar') }}
                                                            </div>
                                                            <div class="review-item-user-position">
                                                                متدرب
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="review-item-date">
                                                        {{ $rating->created_at->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                                <div class="review-item-comment">
                                                    {{ $rating->comment }}
                                                </div>
                                                <div class="review-item-ratings">
                                                    <div class="review-item-ratings-header">
                                                        <div>إجمالي التقييم</div>
                                                        <div>
                                                            {{ number_format(($rating->clarity + $rating->interaction + $rating->organization) / 3, 1) }}
                                                            نجوم</div>
                                                    </div>
                                                    <div class="review-item-ratings-item">
                                                        <div>
                                                            التمكن من تبسيط المعلومات
                                                            <span class="tooltip">
                                                                <img src="{{ asset('images/icons/tooltip.svg') }}"
                                                                    alt="" />
                                                                <div class="tooltip-desc">
                                                                    مدى قدرة المدرب على تبسيط المفاهيم المعقدة
                                                                </div>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="stars-wrapper">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $rating->clarity)
                                                                        <img src="{{ asset('images/icons/star-fill.svg') }}"
                                                                            alt="">
                                                                    @else
                                                                        <img src="{{ asset('images/icons/star.svg') }}"
                                                                            alt="">
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="review-item-ratings-item">
                                                        <div>
                                                            أسلوب التدريب والتفاعل
                                                            <span class="tooltip">
                                                                <img src="{{ asset('images/icons/tooltip.svg') }}"
                                                                    alt="" />
                                                                <div class="tooltip-desc">
                                                                    جودة التفاعل مع المتدربين وأسلوب الشرح
                                                                </div>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="stars-wrapper">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $rating->interaction)
                                                                        <img src="{{ asset('images/icons/star-fill.svg') }}"
                                                                            alt="">
                                                                    @else
                                                                        <img src="{{ asset('images/icons/star.svg') }}"
                                                                            alt="">
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="review-item-ratings-item">
                                                        <div>
                                                            تنظيم وإدارة التدريب
                                                            <span class="tooltip">
                                                                <img src="{{ asset('images/icons/tooltip.svg') }}"
                                                                    alt="" />
                                                                <div class="tooltip-desc">
                                                                    جودة التنظيم وإدارة الوقت خلال التدريب
                                                                </div>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="stars-wrapper">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $rating->organization)
                                                                        <img src="{{ asset('images/icons/star-fill.svg') }}"
                                                                            alt="">
                                                                    @else
                                                                        <img src="{{ asset('images/icons/star.svg') }}"
                                                                            alt="">
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="add-item-block">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="reviews-title mb-0">
                                    تقييمات المتدربين والمؤسسات
                                </div>
                                @if (auth()->user() && auth()->user()->userType?->type === 'متدرب')
                                    <!-- زر إضافة أو تحديث التقييم -->
                                    <div class="text-end mt-3">
                                        <button type="button" class="custom-btn" data-bs-toggle="modal"
                                            data-bs-target="#ratingModal">
                                            {{ $userRating ? 'تحديث التقييم' : 'إضافة تقييم' }}
                                            <img src="{{ asset('images/cources/arrow-left.svg') }}">
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="card-block">
                                <div class="card-body align-content-center">
                                    <div class="content d-flex align-items-center gap-3">
                                        <img src="{{ asset('images/trainer-account/reviews.svg') }}" alt="تقييمات" />
                                        @if (auth()->check() && auth()->id() == $user->id)
                                            <div class="desc">
                                                لم تتلقَ أية تقييمات أو مراجعات بعد، عندما ستحصل على تقييم فسيظهر هنا
                                            </div>
                                        @else
                                            <div class="desc">
                                                لم يتلق أية تقييمات أو مراجعات بعد
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif



                    @if (!(auth()->check() && auth()->id() == $user->id) && $tariningPrograms->count() > 0)
                        <div class="reviews mt-4">
                            <div class="reviews-title-wrap d-flex flex-column flex-sm-row gap-2">
                                <div class="reviews-title">
                                    تدريبات قام بها المدرب
                                </div>
                                <div class="reviews-slider-buttons">
                                    <button class="prev pbtn pbtn-outlined" id="carouselPrev" type="button">
                                        <!-- Prev SVG -->
                                        <img src="{{ asset('images/reviews/prev.svg') }}" />
                                    </button>
                                    <button class="next pbtn pbtn-main" id="carouselNext" type="button">
                                        <!-- Next SVG -->
                                        <img src="{{ asset('images/reviews/next.svg') }}" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-wrapper position-relative">
                            <div class="overflow-hidden w-100">
                                <div class="d-flex flex-nowrap gap-3 custom-carousel" id="cardCarousel">
                                    @foreach ($tariningPrograms as $tariningProgram)
                                        <div class="carousel-card flex-shrink-0">
                                            <a href="{{ route('show_trainings_announcements', $tariningProgram->id) }}"
                                                class="text-decoration-none text-dark">
                                                <div class="h-100 border rounded-4 position-relative">
                                                    <div class="d-flex flex-column justify-content-between image-custom">
                                                        @if ($tariningProgram->AdditionalSetting && $tariningProgram->AdditionalSetting->profile_image)
                                                            <img src="{{ asset('storage/' . $tariningProgram->AdditionalSetting->profile_image) }}"
                                                                class="card-img-top" alt="صورة التدريب">
                                                        @else
                                                            <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                                alt="صورة افتراضية" class="card-img-top">
                                                        @endif
                                                    </div>
                                                    @php
                                                        $trainer = $tariningProgram->trainer;
                                                        $trainerPhoto =
                                                            $trainer && $trainer->photo
                                                                ? asset('storage/' . $trainer->photo)
                                                                : asset('images/icons/user.svg');
                                                    @endphp
                                                    <div
                                                        class="card-body d-flex flex-column justify-content-between gap-1 p-3">
                                                        <h6 class="fw-bold">{{ $tariningProgram->title }}</h6>
                                                        <div class="trainer-info mt-2 mb-2">
                                                            <a href="{{ route('show_trainer_profile', ['id' => $trainer->id]) }}"
                                                                style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                                                                <img class="trainer-img" src="{{ $trainerPhoto }}"
                                                                    alt="صورة المدرب" />
                                                                <span>{{ $trainer->getTranslation('name', 'ar') }}
                                                                    {{ $trainer->trainer->getTranslation('last_name', 'ar') }}</span>
                                                            </a>
                                                        </div>
                                                        <ul
                                                            class="list-unstyled d-flex flex-wrap gap-3 text-muted small mb-2">
                                                            <li class="d-flex align-items-center gap-2">
                                                                <img src="{{ asset('images/cources/clock.svg') }}"
                                                                    alt="المدة">
                                                                @php
                                                                    $hours = floor(
                                                                        $tariningProgram->total_duration_hours,
                                                                    );
                                                                    $minutes = round(
                                                                        ($tariningProgram->total_duration_hours -
                                                                            $hours) *
                                                                            60,
                                                                    );
                                                                @endphp
                                                                @if ($hours > 0 && $minutes > 0)
                                                                    {{ $hours }} ساعة و {{ $minutes }} دقيقة
                                                                @elseif($hours > 0)
                                                                    {{ $hours }} ساعة
                                                                @else
                                                                    {{ $minutes }} دقيقة
                                                                @endif
                                                            </li>
                                                            @if (
                                                                $tariningProgram->program_presentation_method_id === \App\Enums\TrainingAttendanceType::HYBRID->value ||
                                                                    $tariningProgram->program_presentation_method_id === \App\Enums\TrainingAttendanceType::REMOTE->value)
                                                                <li class="d-flex align-items-center gap-2">
                                                                    <img src="{{ asset('images/cources/online.svg') }}"
                                                                        alt="نوع الدورة">
                                                                    أونلاين
                                                                </li>
                                                            @else
                                                                <li class="d-flex align-items-center gap-2">
                                                                    <img src="{{ asset('images/cources/location.svg') }}"
                                                                        alt="الموقع">
                                                                    @if ($tariningProgram->AdditionalSetting)
                                                                        {{ $tariningProgram->AdditionalSetting->city }},
                                                                        {{ $tariningProgram->AdditionalSetting->country->name ?? '---' }}
                                                                    @else
                                                                        ---
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const carousel = document.getElementById('cardCarousel');
                                const card = document.querySelector('.carousel-card');
                                // التحقق من وجود البطاقات قبل تنفيذ الكود
                                if (carousel && card) {
                                    const cardWidth = card.offsetWidth + 16; // 16px = gap-3
                                    document.getElementById('carouselNext').addEventListener('click', () => {
                                        if (carousel.scrollLeft + cardWidth * 3 >= carousel.scrollWidth) {
                                            carousel.scrollLeft = 0;
                                        } else {
                                            carousel.scrollLeft += cardWidth;
                                        }
                                    });
                                    document.getElementById('carouselPrev').addEventListener('click', () => {
                                        if (carousel.scrollLeft <= 0) {
                                            carousel.scrollLeft = carousel.scrollWidth;
                                        } else {
                                            carousel.scrollLeft -= cardWidth;
                                        }
                                    });
                                }
                            });
                        </script>
                    @endif




                </div>



            </div>
        </div>
    </main>



    {{-- training programs --}}
    {{-- <div>
        @foreach ($tariningPrograms as $tariningProgram)
            <div class="mb-3">
                <strong>الاسم:</strong> {{ $tariningProgram->title }} <br>
                <strong>المدرب:</strong> {{ $tariningProgram->trainer->name }}  {{ $tariningProgram->trainer->trainer->last_name }} <br>
                <strong>المدة:</strong> {{ $tariningProgram->total_duration_hours }}
                ساعة <br>
                <hr>
            </div>
        @endforeach
    </div> --}}

    <!-- Modals -->
    <div id="customModalOverlay" class="modal-overlay" style="display: none"></div>

    <!-- Previous Training Modal -->
    <div id="prev-training" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">إضافة مقطع من تدريب سابق</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="prev-training">&times;</span>
        </div>
        <div class="modal-desc">أضف رابطًا لفيديو تدريب قدمته سابقًا لتعزيز ملفك الشخصي</div>
        <form class="modal-form" action="{{ route('upload_pre_training') }}" method="POST" id="prevTrainingForm">
            @csrf
            <div class="input-group">
                <label>فيديو لتدريب سابق<span class="required">*</span></label>
                <div class="sub-label">
                    أضف رابطًا لفيديو تدريب قدمته (YouTube، Drive، Dropbox...). تأكد أن الرابط قابل للمشاهدة.
                </div>
                <input name="video_link" type="url" placeholder="اكتب هنا" required />
            </div>
            <div class="input-group">
                <label for="training-title">عنوان التدريب <span class="required">*</span></label>
                <input name="training_title" id="training-title" type="text" placeholder="اكتب هنا" required />
            </div>
            <div class="input-group">
                <label for="training-desc">وصف التدريب <span class="required">*</span></label>
                <textarea name="description" id="training-desc" placeholder="اكتب هنا" rows="5" required></textarea>
            </div>
            <div class="input-group">
                <button type="submit" class="pbtn pbtn-main piconed">
                    حفظ و متابعة
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </form>
    </div>

    <!-- Personal Info Modal -->
    <div id="personal-info" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">تعديل المعلومات الشخصية</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="personal-info">&times;</span>
        </div>
        <div class="modal-desc">قم بتحديث معلوماتك الشخصية لتعزيز ملفك الشخصي</div>

        <form class="modal-form" action="{{ route('update_personal_info') }}" method="POST"
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
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="صورة المدرب" />
                                @else
                                    <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية" />
                                @endif
                            </div>
                        </div>
                    </label>
                    <div class="profile-upload-desc">
                        أرفق صورة شخصية مربعة وواضحة (JPG أو PNG، حد أقصى 5MB).
                    </div>
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
                        value="{{ old('last_name_ar', $user->trainer->getTranslation('last_name', 'ar')) }}"
                        placeholder="اكتب هنا" required />
                </div>
            </div>
            <div class="input-group-2col">
                <div class="input-group">
                    <label>الاسم (بالإنجليزية)</label>
                    <input name="name_en" type="text"
                        value="{{ old('name_en', $user->getTranslation('name', 'en')) }}" placeholder="اكتب هنا" />
                </div>
                <div class="input-group">
                    <label>الكنية (بالإنجليزية)</label>
                    <input name="last_name_en" type="text"
                        value="{{ old('last_name_en', $user->trainer->getTranslation('last_name', 'en')) }}"
                        placeholder="اكتب هنا" />
                </div>
            </div>
            <div class="input-group-2col">
                <div class="input-group">
                    <label>العنوان Headline (بالعربية) <span class="required">*</span></label>
                    <input name="headline" type="text" value="{{ $trainer->headline ?? '' }}"
                        placeholder="اكتب هنا" required />
                </div>
                <div class="input-group">
                    <label>الجنسية <span class="required">*</span></label>
                    <select name="nationality[]" class="custom-multiselect" multiple>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @if (in_array((string) $country->id, old('nationality', $user->trainer->nationality ?? []))) selected @endif>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="input-group">
                <label>رابط حسابك على منصة لينكدان</label>
                <input name="linkedin_url" type="text" value="{{ $trainer->linkedin_url ?? '' }}"
                    placeholder="اكتب هنا" />
            </div>
            <div class="input-group">
                <label>نبذة عنك <span class="required">*</span></label>
                <textarea name="bio" placeholder="شارك نبذة مختصرة تبرز خبرتك وهويتك المهنية" rows="5" required>{{ old('bio', $user->bio) }}</textarea>
            </div>
            <div class="input-group-2col">
                @php
                    $wage = $trainer->hourly_wage ?? 0;
                    $formattedWage =
                        is_numeric($wage) && floor($wage) == $wage ? number_format($wage, 0, '.', '') : $wage;
                @endphp

                <div class="input-group">
                    <label>الأجر في الساعة</label>
                    <input name="hourly_wage" type="number" value="{{ $formattedWage }}" placeholder="مثال: 20" />
                </div>

                <div class="input-group">
                    <label>العملة</label>
                    <select name="currency" class="custom-singleselect">
                        @foreach (\App\Enums\Currency::cases() as $currency)
                            <option value="{{ $currency->value }}"
                                {{ ($trainer->currency ?? '') === $currency->value ? 'selected' : '' }}>
                                {{ $currency->label() }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="input-group">
                <button type="submit" class="pbtn pbtn-main piconed">
                    حفظ التعديل
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </form>
    </div>

    <!-- Experience Modal -->
    <div id="experience" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">تعديل الخبرات</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="experience">&times;</span>
        </div>
        <div class="modal-desc">قم بتحديث خبراتك العملية والتدريبية</div>
        <form class="modal-form" action="{{ route('update_experiance', $user->id) }}" method="POST"
            id="experienceForm">
            @csrf
            @method('PUT')
            <div class="input-group-2col">
                <div class="input-group">
                    <label>قطاع العمل</label>
                    <select name="work_sectors[]" class="custom-multiselect" multiple>
                        @foreach ($work_sectors as $sector)
                            <option value="{{ $sector->id }}"
                                {{ in_array($sector->id, old('work_sectors', $trainer_workSectors->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label>الخدمات المقدمة</label>
                    <select name="provided_services[]" class="custom-multiselect" multiple>
                        @foreach ($provided_services as $service)
                            <option value="{{ $service->id }}"
                                {{ in_array($service->id, old('provided_services', $trainer_providedServices->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="input-group-2col">
                <div class="input-group">
                    <label>مجالات العمل</label>
                    <select name="work_fields[]" class="custom-multiselect" multiple>
                        @foreach ($work_fields as $field)
                            <option value="{{ $field->id }}"
                                {{ in_array($field->id, old('work_fields', $trainer_workFields->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                {{ $field->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group">
                    <label>
                        أهم المواضيع التدريبية
                        <span class="tooltip">
                            <img src="{{ asset('images/icons/tooltip.svg') }}" alt="" />
                            <div class="tooltip-desc">اختر أهم المواضيع التي تقدمها في تدريباتك</div>
                        </span>
                    </label>
                    <select name="important_topics[]" class="custom-multiselect" multiple>
                        @foreach (\App\Enums\ImportantTopicsType::cases() as $topic)
                            <option value="{{ $topic->value }}"
                                {{ in_array($topic->value, $trainer->important_topics ?? []) ? 'selected' : '' }}>
                                {{ $topic->value }}
                            </option>
                        @endforeach
                    </select>
                </div>


            </div>

            <div class="input-group">
                <label>الخبرات الدولية</label>
                <select name="international_exp[]" class="custom-multiselect" multiple>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ in_array($country->id, old('international_exp', $trainer_internationalExperiences->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group">
                <button type="submit" class="pbtn pbtn-main piconed">
                    حفظ التعديل
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </form>
    </div>

    <!-- Contact Modal -->
    <div id="contact" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">تعديل معلومات التواصل</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="contact">&times;</span>
        </div>
        <div class="modal-desc">قم بتحديث معلومات التواصل الخاصة بك</div>
        <form class="modal-form" action="{{ route('update_contact_info', $user->id) }}" method="POST"
            id="contactForm">
            @csrf
            @method('PUT')

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

                        <input type="tel" name="phone_number" class="phone-input"
                            value="{{ $user->phone_number }}" placeholder="ادخل رقم الهاتف" required>

                        <input type="hidden" name="phone_code" id="phoneCodeHidden"
                            value="{{ $user->phone_code ?? '+90' }}">
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
                    <input name="email" type="email" placeholder="اكتب هنا" value="{{ $user->email }}"
                        disabled />
                </div>
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
                <label>الموقع الالكتروني</label>
                <input name="website" type="text" value="{{ $trainer->website ?? '' }}" placeholder="اكتب هنا" />
            </div>

            <div class="input-group">
                <button type="submit" class="pbtn pbtn-main piconed">
                    حفظ التعديل
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </form>
    </div>



    @php
        // تحقق من وجود تقييم للمستخدم الحالي في مصفوفة التقييمات
        $userRating = null;
        if (auth()->check()) {
            foreach ($ratings as $rating) {
                if ($rating->trainee_id == auth()->id()) {
                    $userRating = $rating;
                    break;
                }
            }
        }
    @endphp

    <!-- مودال تقييم المدرب -->
    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-5">
                <form action="{{ route('trainer.rating.store', ['trainer_id' => $user->id]) }}" method="POST">
                    @csrf
                    @if ($userRating)
                        @method('POST')
                    @endif

                    <div class="modal-header border-0 justify-content-end">
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"
                            aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-4 w-100">
                            <label>تقييم المدرب:</label>
                            <textarea class="form-control w-100 rounded-4" name="comment" rows="5"
                                placeholder="اكتب تعليقك عن المدرب هنا...">
@if ($userRating)
{{ $userRating->comment }}
@endif
</textarea>
                        </div>

                        @php
                            $criteria = [
                                'clarity' => 'التمكن من تبسيط المعلومات',
                                'interaction' => 'أسلوب التدريب والتفاعل',
                                'organization' => 'تنظيم وإدارة التدريب',
                            ];
                        @endphp

                        <div class="rating-criteria">
                            @foreach ($criteria as $key => $label)
                                <div
                                    class="rating-item mb-4 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                    <span class="rating-label d-flex align-items-center gap-2">
                                        {{ $label }}
                                        <img src="{{ asset('images/icons/question-mark.svg') }}" class="tooltip-icon"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="هذا المعيار يقيس {{ $label }}">
                                    </span>
                                    <div class="star-rating" data-name="{{ $key }}">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="{{ $key }}-{{ $i }}"
                                                name="{{ $key }}" value="{{ $i }}"
                                                @if ($userRating && $userRating->$key == $i) checked @endif>
                                            <label for="{{ $key }}-{{ $i }}">★</label>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer border-0 w-100">
                        <button type="submit" class="pbtn pbtn-main w-100">
                            @if ($userRating)
                                تحديث التقييم
                            @else
                                إرسال المراجعة
                            @endif
                            <img src="{{ asset('images/cources/arrow-left.svg') }}">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .rating-criteria {


            padding: 20px;
        }

        .rating-item {
            padding: 10px 15px;

        }

        .rating-label {
            font-weight: 500;
            color: #333;
        }

        .tooltip-icon {
            width: 16px;
            height: 16px;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        .tooltip-icon:hover {
            opacity: 1;
        }

        .star-rating {
            direction: ltr;
            display: inline-flex;
            flex-direction: row-reverse;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            font-size: 24px;
            padding: 0 5px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ffc107;
        }

        .star-rating input:checked+label {
            color: #ffc107;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تفعيل التلميحات
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // جعل النجوم تفاعلية
            const stars = document.querySelectorAll('.star-rating label');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const radioId = this.getAttribute('for');
                    document.getElementById(radioId).checked = true;
                });
            });
        });
    </script>




@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/validator@13.9.0/validator.min.js"></script>
    <script src="{{ asset('js/forms-validation/Trainer-Profile/prev-training.js') }}"></script>
    <script src="{{ asset('js/forms-validation/Trainer-Profile/personal-info.js') }}"></script>
    <script src="{{ asset('js/forms-validation/Trainer-Profile/experience.js') }}"></script>
    <script src="{{ asset('js/forms-validation/Trainer-Profile/contact.js') }}"></script>

    <script src="{{ asset('js/profile-image.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
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
                    const code = this.getAttribute('data-code');
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
