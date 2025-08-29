@extends('frontend.layouts.master')
@section('title', $OrgProgram->title ?? 'مسار تدريبي')
@section('content')

    <style>
      h3{
            margin-bottom: 1.5rem;
      }
        .blue-light-header {
            background-color: #D9E6FF;
            background-size: cover;
            color: black;
            padding: 50px 0 0px;
            position: relative;
            margin-bottom: 30px;
        }

        .training-path-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .training-tag {
            background-color: #1a73e8;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-left: 30px;
        }

        .info-item img {
            margin-left: 10px;
        }

        .description {
            margin: 20px 0;
            line-height: 1.6;
        }

        .creator-info {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .creator-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-left: 15px;
            border: 1px solid #000;
        }

        .join-section {
            margin-bottom: 10px;
            width: 367px;
        }

        .time-left {
            color: #F55157;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .participants {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .avatar-stack {
            display: flex;
            position: relative;
            height: 40px;
            margin-top: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .user-avatar:not(:first-child) {
            margin-right: -20px;
        }

        .info-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.10);
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            margin-top: -50px;
            text-align-last: center;
        }

        .info-card-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .info-card-item {
            width: 16.66%;
            align-self: center;
            text-align: right;
            align-items: center;
            padding: 0 5px;
            justify-items: start;
        }

        .info-card-item-value {
            text-align-last: right;
            font-size: 20px;
            font-weight: 600;
            color: #0F1114;
        }

        .info-card-item-label {
            font-size: 14px;
            color: #5B6780;
        }

        .tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            flex-wrap: wrap;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #777;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
        }

        .tab.active {
            color: #003090;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #003090;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .learning-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .learning-item img {
            margin-left: 10px;
            margin-top: 3px;
        }

        .audience-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .audience-tag {
            background-color: #D9E6FF;
            color: #003090;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 14px;
            display: inline-block;
        }

        .training-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .training-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            cursor: pointer;
        }

        .training-item-info {
            display: flex;
            align-items: center;
        }

        .training-item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            margin-left: 15px;
        }

        .training-item-details {
            flex: 1;
        }

        .training-item-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .training-item-meta {
            display: flex;
            flex-wrap: wrap;
            font-size: 14px;
            color: #777;
        }

        .training-item-meta span {
            margin-left: 15px;
        }

        .training-item-content {
            display: none;
            padding: 15px;
            border-top: 1px solid #ddd;
        }

        .training-item.active .training-item-content {
            display: block;
        }

        .training-item.active .arrow-icon {
            transform: rotate(180deg);
        }

        .arrow-icon {
            transition: transform 0.3s;
        }

        .sessions-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sessions-table th,
        .sessions-table td {
            padding: 10px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }

        .sessions-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .facilitator {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .facilitator-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-left: 15px;
        }

        .organization-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .organization-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin-left: 20px;
        }

        .organization-details h3 {
            margin-bottom: 5px;
        }

        .organization-rating {
            color: #f5a623;
        }

        .organization-description {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .training-type {
            background-color: #005FDC;
            color: #ffffff;
        }

        .info-box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .info-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .trainer-card {
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .trainer-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .trainer-position {
            font-size: 14px;
            color: #777;
        }

        .trainer-rating {
            display: flex;
            align-items: center;
        }

        .trainer-bio {
            line-height: 1.6;
            color: #555;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .facilitators-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .facilitator-card {
            display: flex;
            align-items: center;
            padding: 10px;

        }

        .facilitator-name {
            font-size: 16px;
            font-weight: 500;
        }

        .session-schedule {
            margin-top: 30px;
        }

        .session-schedule .card {
            border-radius: 8px;
            overflow: hidden;
        }

        .session-schedule .table {
            margin-bottom: 0;
        }

        .session-schedule .table th,
        .session-schedule .table td {
            text-align: center;
            padding: 12px;
        }

        /* تعديلات للشاشات المتوسطة والصغيرة */
        @media (max-width: 992px) {
            .info-card-item {
                width: 33.33%;
                margin-bottom: 20px;
            }

            .img-orgtrainer {
                display: none;
            }

            .blue-light-header {
                padding: 30px 0 0px;
            }

            .join-section {
                width: 100%;
                max-width: 367px;
            }
        }

        @media (max-width: 768px) {
            .info-card-item {
                width: 50%;
            }

            .info-card-item-label {
                font-size: 12px;
            }

            .info-card-item-value {
                font-size: 18px;
            }

            .blue-light-header .row {
                flex-direction: column;
            }

            .blue-light-header .col-lg-7 {
                order: 2;
            }

            .blue-light-header .col-lg-5 {
                order: 1;
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .info-card-item {
                width: 100%;
            }

            .info-card-item-label {
                font-size: 12px;
            }

            .info-card-item-value {
                font-size: 18px;
            }

            .img-orgtrainer {
                max-width: 100%;
                height: auto;
            }

            .training-meta {
                flex-direction: column;
                gap: 10px;
            }

            .training-meta span {
                margin-left: 0 !important;
            }
        }

        /* تعديلات خاصة بشاشات اللابتوب */
        @media (min-width: 992px) and (max-width: 1200px) {
            .info-card-item-label {
                font-size: 12px;
            }

            .info-card-item-value {
                font-size: 20px;
            }

            .img-orgtrainer {
                max-width: 90%;
                height: auto;
            }
        }

        .img-orgtrainer {
            max-width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: contain;
        }

        @media (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 100%;
            }
        }
    </style>

    <!-- Blue Header Section -->
    <div class="blue-light-header full-width-header">
        <div class="container ">
            <div class="row px-5">
                <!-- العمود الأول للمعلومات -->
                <div class="col-12 col-lg-8 ps-5">
                    <div class="title-wrapper">
                        <h1 class="d-inline-block lh-base">
                            {{ $OrgProgram->title ?? 'مسار تدريبي' }}
                            <span class="training-type ms-2">{{ $OrgProgram->trainingClassification->name ?? '' }}</span>
                        </h1>
                    </div>
                    
                    <div
                        class="training-meta d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start text-center text-lg-start">
                        <span class="mb-2 mb-sm-0">
                            <img src="{{ asset('images/cources/language-black.svg') }}">
                            لغة المسار التدريبي - {{ $OrgProgram->language->name ?? 'غير محدد' }}
                        </span>
                        <span class="ms-sm-3">
                            <img src="{{ asset('images/cources/Training-type-black.svg') }}">
                            نوع المسار التدريبي - {{ $OrgProgram->programType->name ?? 'غير محدد' }}
                        </span>
                    </div>
                    <div class="description">
                        {{ $OrgProgram->program_description ?? 'لا يوجد وصف متاح' }}
                    </div>
                    <div class="creator-info">
                        <img src="{{ asset('images/icons/user.svg') }}" alt="Syrian Geeks" class="creator-image">
                        <span>تم الإنشاء بواسطة 
                        <span class="text-decoration-underline">
                            {{ $OrgProgram->organization->user->getTranslation('name', 'ar') ?? '' }}
                        </span></span>
                      </div>
                  <div class="join-section">
    @if (!auth()->check())
        <!-- الحالة 1: المستخدم غير مسجل دخول -->
        <div class="alert alert-info text-center mb-0">
            <i class="fas fa-info-circle me-2"></i>
            الرجاء تسجيل الدخول أولاً بحساب متدرب للانضمام إلى المسار التدريبي
            <div class="mt-2">
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm me-2">تسجيل الدخول</a>
                <span>ليس لديك حساب؟</span>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm ms-2">إنشاء حساب</a>
            </div>
        </div>
    @elseif (auth()->user()->userType?->type !== 'متدرب')
        <!-- الحالة 2: المستخدم مسجل ولكن ليس من نوع متدرب -->
        <div class="alert alert-warning text-center mb-0">
            <i class="fas fa-exclamation-triangle me-2"></i>
            الرجاء التسجيل بحساب متدرب للانضمام إلى المسار التدريبي
            <div class="mt-2">
                <span>الحساب الحالي: {{ auth()->user()->userType?->type }}</span>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm ms-2">تسجيل الخروج</a>
            </div>
        </div>
    @else
        <!-- المستخدم متدرب، نتحقق من الحالات الأخرى -->
        @if ($training_has_ended)
            <!-- الحالة 3: انتهى موعد التسجيل -->
            <div class="alert alert-danger text-center mb-0">
                <i class="fas fa-calendar-times me-2"></i>
                انتهى موعد التسجيل في هذا المسار التدريبي
                <div class="mt-2">
                    <small>آخر موعد للتسجيل كان: {{ \Carbon\Carbon::parse($OrgProgram->registrationRequirements->application_deadline)->format('d/m/Y') }}</small>
                </div>
            </div>
        @elseif ($has_enrolled)
            <!-- الحالة 4: المستخدم مسجل بالفعل، نتحقق من حالة تسجيله -->
            @switch($enrollment?->status)
                @case('pending')
                    <!-- الحالة 4.1: طلب قيد الانتظار -->
                    <div class="alert alert-warning text-center mb-0">
                        <i class="fas fa-clock me-2"></i>
                        تم إرسال طلبك مسبقًا، في انتظار الموافقة.
                        <div class="mt-2">
                            <small>تاريخ التقديم: {{ \Carbon\Carbon::parse($enrollment->created_at)->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    @break
                @case('accepted')
                    <!-- الحالة 4.2: تم قبول الطلب -->
                    <div class="alert alert-success text-center mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        تم قبولك في المسار التدريبي، بالتوفيق!
                        <div class="mt-2">
                            <small>رقم التسجيل: #{{ $enrollment->id }}</small>
                        </div>
                    </div>
                    @break
                @case('rejected')
                    <!-- الحالة 4.3: تم رفض الطلب -->
                    <div class="alert alert-danger text-center mb-0">
                        <i class="fas fa-times-circle me-2"></i>
                        تم رفض طلبك للانضمام.
                        @if (!empty($enrollment?->rejection_reason))
                            <div class="mt-2">
                                <strong>السبب:</strong> {{ $enrollment->rejection_reason }}
                            </div>
                        @endif

                    </div>
                    @break
                @default
                    <!-- الحالة 4.5: حالة غير معروفة -->
                    <div class="alert alert-info text-center mb-0">
                        <i class="fas fa-question-circle me-2"></i>
                        حالة طلبك: {{ $enrollment?->status ?? 'غير محدد' }}
                        <div class="mt-2">
                            <small>يرجى التواصل مع إدارة المسار التدريبي</small>
                        </div>
                    </div>
            @endswitch
        @else
            <!-- الحالة 5: المستخدم لم يسجل بعد -->
            @if ($OrgProgram->registrationRequirements->max_trainees > 0 && count($participants) >= $OrgProgram->registrationRequirements->max_trainees)
                <!-- الحالة 5.1: وصل العدد الأقصى للمتدربين -->
                <div class="alert alert-warning text-center mb-0">
                    <i class="fas fa-users me-2"></i>
                    وصل العدد الأقصى للمتدربين في هذا المسار التدريبي
                    <div class="mt-2">
                        <small>العدد الأقصى: {{ $OrgProgram->registrationRequirements->max_trainees }} متدرب</small>
                    </div>
                </div>
            @else
                <!-- الحالة 5.2: يمكن للمستخدم التسجيل -->
                <button class=" custom-btn w-100" data-bs-toggle="modal" data-bs-target="#confirmEnrollmentModal">
                    انضم الآن
                    <br>
                    <span dir="ltr">
                        @php
                            $cost = $OrgProgram->registrationRequirements->cost ?? 0;
                        @endphp
                        @if ($cost > 0)
                            ${{ number_format($cost, 2) }}
                        @else
                            المسار مجاني
                        @endif
                    </span>
                </button>
            @endif
        @endif
    @endif
</div>



                    @php
                        $deadline = null;
                        $remainingText = 'لا يوجد موعد نهائي للتسجيل';

                        if (
                            isset($OrgProgram->registrationRequirements) &&
                            $OrgProgram->registrationRequirements->application_deadline
                        ) {
                            $deadline = \Carbon\Carbon::parse(
                                $OrgProgram->registrationRequirements->application_deadline,
                            );
                            $now = \Carbon\Carbon::now();
                            $totalHours = $now->diffInHours($deadline, false);

                            if ($totalHours > 0) {
                                $diffInDays = intdiv($totalHours, 24);
                                $diffInHours = $totalHours % 24;
                                $remainingText = "متبق $diffInDays أيام و $diffInHours ساعات على انتهاء التسجيل";
                            } else {
                                $remainingText = 'انتهى موعد التسجيل';
                            }
                        }

                    @endphp
                    <div class="time-left">{{ $remainingText }}</div>
                    <!-- تعديل قسم المشاركين ليكون في سطرين -->
                    <div class="participants">
                        <div class="mb-2">
                            <span>انضم {{ $OrgProgram->organization->user->name ?? 'مستخدمين' }} و آخرون</span>
                        </div>
                        <div class="avatar-stack">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                        </div>
                    </div>
                </div>
                <!-- العمود الثاني للصورة -->
                <div class="col-12 col-lg-4 d-flex align-items-end px-5">
                    <img src="{{ asset('images/cources/orgtraining-bg.png') }}"
                        alt="{{ $OrgProgram->title ?? 'مسار تدريبي' }}" class="img-orgtrainer">
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <!-- بطاقة المعلومات -->
        <div class="info-card">
            <div class="info-card-row">
                <div class="info-card-item">
                  @php
    $count = $OrgProgram->details->count();
@endphp

<div class="info-card-item-value">
    {{ $count }}
    {{ $count == 1 ? 'تدريب' : 'تدريبات' }}
</div>

                  
                    <div class="info-card-item-label">محتويات المسار</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">
                        {{ $OrgProgram->trainingLevel->name ?? 'غير محدد' }}
                    </div>
                    <div class="info-card-item-label">مستوى المسار</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">
                        {{ round(($grandTotalMinutes ?? 0) / 60, 2) }} ساعة
                    </div>
                    <div class="info-card-item-label">عدد الساعات التدريبية</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">
                        {{ $OrgProgram->program_presentation_method ?? 'غير محدد' }}
                    </div>
                    <div class="info-card-item-label">طريقة تقديم المسار</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">
                        @if (isset($OrgProgram->registrationRequirements) &&
                                $OrgProgram->registrationRequirements->application_submission_method)
                            {{ $OrgProgram->registrationRequirements->application_submission_method == 'inside_platform' ? 'من خلال المنصة' : 'خارج المنصة' }}
                        @else
                            غير محدد
                        @endif
                    </div>
                    <div class="info-card-item-label">طريقة التسجيل</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">
                        @if (isset($OrgProgram->country) && $OrgProgram->city)
                            {{ $OrgProgram->country->name }}, {{ $OrgProgram->city }}
                        @else
                            غير محدد
                        @endif
                    </div>
                    <div class="info-card-item-label">مكان تقديم المسار</div>
                </div>
            </div>
        </div>
        <!-- التابات -->
        <div class="tabs">
            <div class="tab active" data-tab="learn">ماذا ستتعلم؟</div>
            <div class="tab" data-tab="info">معلومات المسار</div>
            <div class="tab" data-tab="content">محتوى المسار</div>
            <div class="tab" data-tab="facilitators">ميسرو المسار</div>
        </div>
        <!-- محتوى التابات -->
        <div class="tab-content active" id="learn">
            <h3>النتائج التعليمية من المسار التدريبي</h3>
            @if (isset($OrgProgram->goals) && $OrgProgram->goals->count() > 0)
                @foreach ($OrgProgram->goals as $goal)
                    @if (isset($goal->learning_outcomes) && is_array($goal->learning_outcomes))
                        @foreach ($goal->learning_outcomes as $learning_outcome)
                            <div class="learning-item">
                                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                                <span>{{ $learning_outcome }}</span>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @else
                <p>لا توجد أهداف محددة لهذا المسار.</p>
            @endif
        </div>
        <div class="tab-content" id="info">
            <h3>الفئة المستهدفة من المسار التدريبي</h3>
            @if (isset($OrgProgram->goals) && $OrgProgram->goals->count() > 0)
                <div class="info-block-content-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                    <span>المستوى العلمي</span>
                </div>
                <div class="audience-tags">
                    @if (isset($education_levels))
                        @foreach ($education_levels as $education_level)
                            <span class="audience-tag">{{ $education_level }}</span>
                        @endforeach
                    @else
                        <span class="audience-tag">غير محدد</span>
                    @endif
                </div>



                <div class="info-block-content-item mt-4">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                    <span>الحالة الوظيفية</span>
                </div>
                <div class="audience-tags">
                    @if (isset($OrgProgram->goals))
                        @foreach ($OrgProgram->goals as $goal)
                            @if (isset($goal->work_status) && is_array($goal->work_status))
                                @foreach ($goal->work_status as $work_status)
                                    @if ($work_status)
                                        <span class="audience-tag">
                                            @if ($work_status === 'working')
                                                يعمل
                                            @elseif ($work_status === 'not_working')
                                                لا يعمل
                                            @endif
                                        </span>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <span class="audience-tag">غير محدد</span>
                    @endif
                </div>





                <div class="info-block-content-item mt-4">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                    <span>مجالات العمل</span>
                </div>
                <div class="audience-tags">
                    @if (isset($work_sectors))
                        @foreach ($work_sectors as $work_sector)
                            <span class="audience-tag">{{ $work_sector }}</span>
                        @endforeach
                    @else
                        <span class="audience-tag">غير محدد</span>
                    @endif
                </div>

                <div class="info-block-content-item mt-4">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                    <span>المستوى الوظيفي</span>
                </div>
                <div class="audience-tags">
                    @if (isset($OrgProgram->goals))
                        @foreach ($OrgProgram->goals as $goal)
                            @if (isset($goal->job_position) && is_array($goal->job_position))
                                @foreach ($goal->job_position as $job)
                                    <span class="audience-tag">{{ $job }}</span>
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <span class="audience-tag">غير محدد</span>
                    @endif
                </div>


                <div class="info-block-content-item mt-4">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                    <span>المنطقة / الجنسية</span>
                </div>
                <div class="audience-tags">
                    @if (isset($OrgProgram->goals))
                        @foreach ($OrgProgram->goals as $goal)
                            @if (isset($goal->country_id) && is_array($goal->country_id))
                                @foreach ($goal->country_id as $countryId)
                                    @php
                                        $country = \App\Models\Country::find($countryId);
                                    @endphp
                                    @if ($country)
                                        <span class="audience-tag">{{ $country->name }}</span>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <span class="audience-tag">غير محدد</span>
                    @endif
                </div>
            @else
                <p>لا توجد فئة مستهدفة محددة لهذا المسار.</p>
            @endif

            <h3 class="mt-4">المتطلبات أو الشروط اللازمة للالتحاق بالمسار</h3>
            @php
                $requirements = [];
                if (isset($OrgProgram->registrationRequirements)) {
                    $req = json_decode($OrgProgram->registrationRequirements->requirements, true);
                    if (is_array($req)) {
                        $requirements = $req;
                    }
                }
            @endphp
            @if (count($requirements) > 0)
                @foreach ($requirements as $requirement)
                    <div class="learning-item">
                        <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                        <span>{{ $requirement }}</span>
                    </div>
                @endforeach
            @else
                <p>لا توجد متطلبات تسجيل.</p>
            @endif
            @if (isset($OrgProgram->registrationRequirements) )
              @php
                    $benefits = [];
                    if (isset($OrgProgram->registrationRequirements)) {
                        $ben = json_decode($OrgProgram->registrationRequirements->benefits, true);
                        if (is_array($ben)) {
                            $benefits = $ben;
                        }
                    }
                @endphp
                @if (count($benefits) > 0)
                <h3 class="mt-4">ميزات المسار</h3>
              
            
                    @foreach ($benefits as $benefit)
                        <div class="learning-item">
                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                            <span>{{ $benefit }}</span>
                        </div>
                    @endforeach

                @endif
            @endif
        </div>

        <div class="tab-content" id="content">

            <h3>ماذا يتضمن المسار</h3>
            @if (isset($OrgProgram->details) && $OrgProgram->details->count() > 0)
                @foreach ($OrgProgram->details as $program)
                    @php
                        $totalMinutes = 0;
                        $hasSessions = isset($program->trainingSchedules) && $program->trainingSchedules->count() > 0;
                    @endphp
                    <div class="training-item">
                        <div class="training-item-header" onclick="toggleTraining(this)">
                            <div class="training-item-info">
                                {{-- <img src="{{ asset('images/icons/training1.svg') }}"
                                    alt="{{ $program->program_title ?? '' }}" class="training-item-image"> --}}
                                <div class="training-item-details">
                                    <div class="training-item-title">{{ $program->program_title ?? '' }}</div>
                                    <div class="training-item-meta">
                                        <span>التدريب {{ $loop->index + 1 }}</span>

                                        @if ($hasSessions)
                                            @foreach ($program->trainingSchedules as $session)
                                                @php
                                                    $sessionDuration = \Carbon\Carbon::parse(
                                                        $session->session_start_time,
                                                    )->diffInMinutes(\Carbon\Carbon::parse($session->session_end_time));
                                                    $totalMinutes += $sessionDuration;
                                                @endphp
                                            @endforeach
                                            <span>{{ round($totalMinutes / 60, 2) }} ساعة</span>
                                        @else
                                            @if (isset($program->num_of_hours))
                                                <span>{{ $program->num_of_hours }} ساعة</span>
                                            @else
                                                <span>غير محدد</span>
                                            @endif
                                        @endif

                                        <span>المدرب: {{ $program->Trainer->getTranslation('name', 'ar') ?? 'غير محدد' }}
                                            {{ $program->Trainer->Trainer->getTranslation('last_name', 'ar') ?? '' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">

                              <a href="{{ route('org.training.show.program', $program->id) }}" class="me-2 text-decoration-underline training-details-btn">تفاصيل التدريب</a>

                                <svg class="arrow-icon" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 10L12 15L17 10" stroke="#333" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>


                        </div>
                        <div class="training-item-content">
                            @if ($hasSessions)
                                <div class="session-schedule">
                                    <h4 class="info-title">جدولة الجلسات</h4>
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="table-responsive w-100">
                                                <table class="table table-borderless m-0">
                                                    <thead>
                                                        <tr style="border-bottom: 1px solid #dee2e6;">
                                                            <th class="p-3 text-center">اليوم</th>
                                                            <th class="p-3 text-center">التاريخ</th>
                                                            <th class="p-3 text-center">وقت الجلسة</th>
                                                            <th class="p-3 text-center">مدة الجلسة</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($program->trainingSchedules as $session)
                                                            @php
                                                                $sessionDuration = \Carbon\Carbon::parse(
                                                                    $session->session_start_time,
                                                                )->diffInMinutes(
                                                                    \Carbon\Carbon::parse($session->session_end_time),
                                                                );
                                                            @endphp
                                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                                <td class="p-3 text-center">
                                                                    {{ \Carbon\Carbon::parse($session->session_date)->locale('ar')->dayName }}
                                                                </td>
                                                                <td class="p-3 text-center">
                                                                    {{ \Carbon\Carbon::parse($session->session_date)->locale('ar')->translatedFormat('d F') }}
                                                                </td>
                                                                <td class="p-3 text-center">
                                                                    {{ $session->session_start_time }} -
                                                                    {{ $session->session_end_time }}
                                                                </td>
                                                                <td class="p-3 text-center">
                                                                    {{ round($sessionDuration / 60, 2) }} ساعة
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
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
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="info-box">
                    <p>لا توجد تدريبات محددة لهذا المسار.</p>
                </div>
            @endif
        </div>
        <div class="tab-content" id="facilitators">
            <div class="trainer-card mt-5">
                <h4 class="info-title">مقدم المسار</h4>
                <div class=" d-flex flex-column flex-md-row align-items-start gap-4">
                    <a href="#"
                        style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                        <div class="trainer-image text-center">
                            <img src="{{ asset('images/icons/user.svg') }}"
                                alt="{{ $OrgProgram->organization->user->name ?? '' }}" class="custom-rounded"
                                width="120" height="120">
                        </div>
                        <div class="text-start align-self-center">
                            <h5 class="trainer-name mb-1">
                                {{ $OrgProgram->organization->user->getTranslation('name', 'ar') ?? '' }}

                            </h5>
                            <p class="trainer-position mb-2">
                                {{ $OrgProgram->organization->type->name ?? 'غير محدد' }}
                            </p>
                        </div>
                    </a>
                </div>
                <p class="trainer-bio mt-3">
                    {{ $OrgProgram->organization->user->bio ?? 'لا يوجد نبذة متاحة' }}
                </p>

                @if (isset($OrgProgram->assistants) && $OrgProgram->assistants->count() > 0)
                    <h5 class="section-title mt-5">ميسرو المسار</h5>
                    <div class="facilitators-container d-flex flex-column flex-md-row gap-4">
                        @foreach ($OrgProgram->assistantUsers as $assistant)
                            <div class="facilitator-card d-flex align-items-center gap-3">
                                <img src="{{ asset('images/icons/user.svg') }}" alt="{{ $assistant->name ?? '' }}"
                                    class="rounded-circle" width="60" height="60">
                                <span class="facilitator-name">
                                    {{ $assistant->getTranslation('name', 'ar') ?? '' }}
                                    {{ $assistant->assistant->getTranslation('last_name', 'ar') ?? '' }}


                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>لا يوجد ميسرون لهذا المسار.</p>
                @endif
            </div>
        </div>
    </div>

        <!-- Modal تأكيد الاشتراك -->
    <div class="modal fade" id="confirmEnrollmentModal" tabindex="-1" aria-labelledby="confirmEnrollmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0 position-relative justify-content-end pb-3">
                    <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>
                <div class="modal-body text-center pt-0">
                    <img src="{{ asset('/images/cources/join.svg') }}" />
                    <h5 class="modal-title fw-bold mb-3" id="confirmEnrollmentModalLabel">هل أنت متأكد من الاشتراك في هذا
                        المسار التدريبي</h5>
                    <p class="text-muted mb-4">
                        عند تأكيد الاشتراك، سيتم إضافتك إلى قائمة المشاركين في المسار التدريبي "{{ $OrgProgram->title ?? '' }}".<br>
                        قد يتطلب الأمر موافقة من المدرب أو خطوات إضافية.
                    </p>
                </div>
                
                <div class="modal-footer border-0 d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <form class="flex-fill" style="padding: 0px"
                        action="{{ route('orgEnrollment.enroll', ['OrgProgram_id' => $OrgProgram->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="custom-btn flex-fill">نعم، أؤكد انضمامي</button>
                    </form>
                    <button type="button" class="btn-cancel flex-fill" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // تبديل التابات
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // إزالة النشط من جميع التابات والمحتويات
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                // إضافة النشط للتاب المحدد ومحتواه
                tab.classList.add('active');
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
        // تبديل عرض محتوى التدريب
        function toggleTraining(header) {
            const trainingItem = header.parentElement;
            trainingItem.classList.toggle('active');
        }
        // منع انتشار الحدث عند النقر على زر "تفاصيل التدريب"
document.querySelectorAll('.training-details-btn').forEach(btn => {
    btn.addEventListener('click', function(event) {
        event.stopPropagation(); // منع انتشار الحدث للعناصر الأب
        // السماح للرابط بالعمل كالمعتاد (الانتقال للصفحة الأخرى)
    });
});
    </script>
@endsection
@section('scripts')
@endsection
