@extends('frontend.layouts.master')
@section('title', 'تدريباتي')
@section('content')
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --info-color: #0dcaf0;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        /* أنماط أساسية */
        .card-img-wrapper {
            width: 100%;
            padding-top: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }

        .card-img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            padding: 11px;
        }

        .program-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--primary-color);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-body-trainee {
            padding: 20px;
        }

        .trainer-name {
            font-weight: 400;
            font-size: 1rem;
            margin-bottom: 0.7rem;
            margin-top: 0.7rem;
        }

        .location-hours {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            color: var(--secondary-color);
        }

        .status-message {
            display: flex;
            padding: 0.5rem;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #313131;
            text-align: center;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .status-pending {
            background-color: #FFAD2A61;
            border: 1px solid #FE9C24;
        }

        .status-accepted {
            background-color: #00AF6C42;
            border: 1px solid #00AF6C;
        }

        .status-rejected {
            background-color: #FFC6C8;
            border: 1px solid #F55157;
        }

        .status-suspended {
              background-color: #DFEDFF;
            border: 1px solid #2462FE;
        }

        .link-details {
            font-size: 14px;
            text-align: center;
            font-weight: 400;
            transition: all 0.2s ease;
            color: #003090;
        }



        .progress-container {
            margin-bottom: 0.5rem;
        }

        .progress {
            height: 13px;
            border-radius: 4px;
            background-color: #D9E6FF;
        }

        .progress-bar {
            background-color: #00AF6C;
            border-radius: 4px;
        }

        .progress-label-trainee {
            font-size: 0.85rem;
            color: var(--secondary-color);
            margin-top: 0.25rem;
            text-align: right;
        }

        .next-session {
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .next-session-date {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .session-time {
            font-size: 0.85rem;
            color: var(--secondary-color);
            font-weight: 500;
            margin-top: 0.25rem;
        }

        .btn-start {
            display: block;
            width: 100%;
            padding: 0.75rem;
            text-align: center;
            background-color: #003090;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-start:hover {
            background-color: #012366;
            color: white;
            text-decoration: none;
        }

        .btn-start:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .countdown-container {
            text-align: center;
            padding: 0.5rem;
        }

        .countdown {
            font-size: 1.1rem;
            font-weight: 600;
            color: #003090;
            background-color: #D9E6FF;
            border-radius: 6px;
            padding: 0.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .countdown-days {
            font-size: 1.1rem;
            font-weight: 600;
            color: #003090;
            background-color: #D9E6FF;
            border-radius: 6px;
            padding: 0.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .countdown-prefix {
            font-size: 0.9rem;
            color: #003090;
            font-weight: 500;
        }

        .days {
            font-weight: 700;
            color: #003090;
        }

        .hours {
            font-size: 1rem;
            color: #003090;
        }

        .completion-badge {
            color: var(--success-color);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-state h4 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .btn-reveal {
            display: block;
            width: 100%;
            padding: 0.75rem;
            text-align: center;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-reveal:hover {
            background-color: #0b5ed7;
            color: white;
            text-decoration: none;
        }

        .section-subtitle {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 1.5rem 0 1rem;
            color: var(--dark-color);
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: var(--secondary-color);
        }

        .info-item img {
            width: 16px;
            height: 16px;
        }

        /* أنماط التدريبات الحالية */
        .current-training .card {
            height: 100%;
        }

        .session-info-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
        }

        .trainer-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        .square-image-container {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            overflow: hidden;
            border-radius: 8px;
        }

        .square-image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            padding: 11px;
            border-radius: 24px;
        }

        .session-info-card .row {
            margin: 0;
        }

        /* أنماط التدريبات المكتملة */
        .trainer-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trainer-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        .trainer-info span {
            font-size: 1rem;
            font-weight: 400;
        }

        .link-details i {
            margin-right: 5px;
        }

        /* أنماط العناوين */
        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title span:first-child {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }



        /* استعلامات الوسائط للشاشات المختلفة */
        @media (max-width: 1199px) {
            .card-body-trainee {
                padding: 15px;
            }
        }

        @media (max-width: 991px) {
            .current-training .square-image-container {
                margin: 0 auto;

            }

            .session-info-card {
                margin-top: 1rem;
            }

            .session-info-card .col-6 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 1rem;
            }

            .session-info-card .col-6:last-child {
                margin-bottom: 0;
            }

            .countdown-container {
                padding: 0;
            }
        }

        @media (max-width: 767px) {
            .section-title span:first-child {
                font-size: 1.3rem;
            }

            .section-subtitle {
                font-size: 1.1rem;
            }

            .card-img-wrapper {
                padding-top: 75%;
            }
        }

        @media (max-width: 576px) {
            .card-body-trainee {
                padding: 12px;
            }

            .trainer-info {
                margin-bottom: 0.5rem;
            }

            .link-details {
                font-size: 0.9rem;
            }

            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
            }

            .nav-tabs .nav-link {
                font-size: 0.85rem;
                padding: 0.5rem 0.75rem;
            }

            .section-title span:first-child {
                font-size: 1.2rem;
            }



            .card-img-wrapper {
                padding-top: 70%;
            }
        }

        @media (min-width: 1400px) {
            .container {
                max-width: 1320px;
            }


        }

        /* أنماط جديدة لقسم التدريبات المكتملة */
        .trainer-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.5rem;
        }

        .trainer-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        .trainer-info span {
            font-size: 1rem;
            font-weight: 400;
        }

        .link-details {
            font-size: 14px;
            text-align: center;
            font-weight: 400;
            transition: all 0.2s ease;
            color: #003090;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
        }

        .link-details:hover {
            color: #4071d2;
        }

        .link-details i {
            margin-right: 5px;
        }

        .completion-badge {
            color: var(--success-color);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.3rem 0.6rem;

            border-radius: 4px;
        }

        /* تعديل بطاقة التدريب المكتملة */
        .card-trainee.completed-card {
            height: 100%;
            /* استخدام الارتفاع الكامل */
            display: flex;
            flex-direction: column;
        }

        .card-trainee.completed-card .card-body-trainee {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            /* توزيع العناصر بالتساوي */
            flex-grow: 1;
            /* السماح بالنمو لملء المساحة */
            height: 100%;
        }

        .card-trainee.completed-card .card-title-trainee {
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        /* تعديل الصورة في بطاقة التدريب المكتملة */
        .card-trainee.completed-card .square-image-container {
            padding-bottom: 75%;
            height: 100%;

        }

        /* تعديل للشاشات الصغيرة */
        @media (max-width: 768px) {
            .card-trainee.completed-card .card-title-trainee {
                font-size: 1rem;
            }

            .trainer-info {
                margin-bottom: 0.3rem;
            }

            .link-details {
                font-size: 0.85rem;
                padding: 0.3rem 0.6rem;
            }
        }
    </style>

    <!-- Blue Header Section -->
    <div class="blue-header full-width-header mt-4">
        <div class="container d-flex justify-content-center">
            <div class="col-12 col-lg-7 text-center">
                <div class="title-wrapper">
                    <h1 class="d-inline-block lh-base">
                        تدريباتي
                    </h1>
                </div>
                <div class="mb-4">
                    الرئيسية / إدارة التدريبات
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- تبويبات  -->
        <div class="text-center mb-3">
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
                            type="button" role="tab">التدريبات المرتقبة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="current-tab" data-bs-toggle="tab" data-bs-target="#current"
                            type="button" role="tab">التدريبات الحالية</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed"
                            type="button" role="tab">التدريبات المكتملة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="suspended-tab" data-bs-toggle="tab" data-bs-target="#suspended"
                            type="button" role="tab">التدريبات المعلقة</button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- محتوى التبويبات -->
        <div class="tab-content" id="myTabContent">
            <!-- تبويب التدريبات المرتقبة -->
            <div class="tab-pane fade show active mb-4" id="upcoming" role="tabpanel">
                <div class="section-title">
                    <span>التدريبات المرتقبة ({{ count($scheduledTrainings) + count($scheduledOrgTrainings) }})</span>
                </div>

                @if (count($scheduledTrainings))
                    <div class="section-subtitle">التدريبات ({{ count($scheduledTrainings) }})</div>
                    <div class="row g-4">
                        @foreach ($scheduledTrainings as $item)
                            @if (isset($item['program']) && $item['program'])
                                @php
                                    $training = $item['program'];
                                    $status = $item['status'];
                                    $start_date = $item['start_date'] ?? null;
                                @endphp
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card card-trainee">
                                        <div class="card-img-wrapper">
                                            @if ($training->AdditionalSetting && $training->AdditionalSetting->profile_image)
                                                <img src="{{ asset('storage/' . $training->AdditionalSetting->profile_image) }}"
                                                    alt="صورة التدريب">
                                            @else
                                                <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                    alt="صورة التدريب">
                                            @endif
                                            <span
                                                class="badge-position">{{ $training->TrainingClassification->name ?? 'تدريب' }}</span>
                                        </div>
                                        <div class="card-body-trainee pt-1">
                                            <h5 class="card-title-trainee">{{ $training->title }}</h5>
                                            <div class="trainer-info mt-3 mb-3">
                                                @php
                                                    $trainer = $training->trainer;
                                                    $trainerPhoto =
                                                        $trainer && $trainer->photo
                                                            ? asset('storage/' . $trainer->photo)
                                                            : asset('images/icons/user.svg');
                                                @endphp
                                                @if ($trainer)
                                                    <a href="{{ route('show_trainer_profile', ['id' => $trainer->id]) }}"
                                                        style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                                                        <img class="trainer-img" src="{{ $trainerPhoto }}"
                                                            alt="صورة المدرب" />
                                                        <span>
                                                            {{ $trainer->getTranslation('name', 'ar') }}
                                                            {{ optional($trainer->trainer)->getTranslation('last_name', 'ar') }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <span>لم يتم تحديد مدرب</span>
                                                @endif
                                            </div>
                                            <ul class="list-unstyled d-flex flex-wrap gap-3 text-muted small mb-3">
                                                {{-- المدة --}}
                                                <li class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/cources/clock.svg') }}" alt="المدة">
                                                    @php
                                                        $durationText = '';
                                                        // إذا كان schedules_later = 1 → استخدم num_of_hours
                                                        if (
                                                            !empty($training->schedules_later) &&
                                                            $training->schedules_later == 1
                                                        ) {
                                                            if (
                                                                !empty($training->num_of_hours) &&
                                                                $training->num_of_hours > 0
                                                            ) {
                                                                $hours = floor($training->num_of_hours);
                                                                $minutes = round(
                                                                    ($training->num_of_hours - $hours) * 60,
                                                                );
                                                                if ($hours > 0 && $minutes > 0) {
                                                                    $durationText =
                                                                        $hours . ' ساعة و ' . $minutes . ' دقيقة';
                                                                } elseif ($hours > 0) {
                                                                    $durationText = $hours . ' ساعة';
                                                                } else {
                                                                    $durationText = $minutes . ' دقيقة';
                                                                }
                                                            }
                                                        }
                                                        // إذا كان schedules_later = 0 → احسب المدة من الجلسات
                                                        elseif (
                                                            isset($training->sessions) &&
                                                            $training->sessions->count() > 0
                                                        ) {
                                                            $totalMinutes = 0;
                                                            foreach ($training->sessions as $session) {
                                                                if (
                                                                    isset($session->session_start_time) &&
                                                                    isset($session->session_end_time)
                                                                ) {
                                                                    $startTime = \Carbon\Carbon::parse(
                                                                        $session->session_start_time,
                                                                    );
                                                                    $endTime = \Carbon\Carbon::parse(
                                                                        $session->session_end_time,
                                                                    );
                                                                    $totalMinutes += $startTime->diffInMinutes(
                                                                        $endTime,
                                                                    );
                                                                }
                                                            }
                                                            if ($totalMinutes > 0) {
                                                                $hours = floor($totalMinutes / 60);
                                                                $minutes = $totalMinutes % 60;
                                                                if ($hours > 0 && $minutes > 0) {
                                                                    $durationText =
                                                                        $hours . ' ساعة و ' . $minutes . ' دقيقة';
                                                                } elseif ($hours > 0) {
                                                                    $durationText = $hours . ' ساعة';
                                                                } else {
                                                                    $durationText = $minutes . ' دقيقة';
                                                                }
                                                            }
                                                        }
                                                        // fallback إذا لم يتم تحديد المدة
                                                        if (empty($durationText)) {
                                                            $durationText = 'قيد الإعداد';
                                                        }
                                                        echo $durationText;
                                                    @endphp
                                                </li>
                                                {{-- الموقع أو أونلاين --}}
                                                @if (
                                                    $training->program_presentation_method_id === \App\Enums\TrainingAttendanceType::HYBRID->value ||
                                                        $training->program_presentation_method_id === \App\Enums\TrainingAttendanceType::REMOTE->value)
                                                    <li class="d-flex align-items-center gap-2">
                                                        <img src="{{ asset('images/cources/online.svg') }}"
                                                            alt="نوع الدورة">
                                                        أونلاين
                                                    </li>
                                                @else
                                                    <li class="d-flex align-items-center gap-2">
                                                        <img src="{{ asset('images/cources/location.svg') }}"
                                                            alt="الموقع">
                                                        {{ $training->AdditionalSetting && $training->AdditionalSetting->city ? $training->AdditionalSetting->city : '---' }}
                                                        {{ $training->AdditionalSetting && $training->AdditionalSetting->country
                                                            ? ' - ' . $training->AdditionalSetting->country->name
                                                            : '' }}
                                                    </li>
                                                @endif
                                            </ul>
                                            @if ($status === 'pending')
                                                <div class="status-message status-pending">
                                                    <img src="{{ asset('images/cources/wait.svg') }}">
                                                    بانتظار موافقة المدرب
                                                </div>
                                            @elseif($status === 'rejected')
                                                <div class="status-message status-rejected">
                                                    <img src="{{ asset('images/cources/rejected.svg') }}">
                                                    تم رفض طلبك
                                                </div>
                                            @elseif($status === 'accepted')
                                                <div class="status-message status-accepted">
                                                    <img src="{{ asset('images/cources/accepted.svg') }}">
                                                    تم قبولك سيبدأ التدريب بتاريخ {{ $start_date ?? 'لاحق' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if (count($scheduledOrgTrainings))
                    <div class="section-subtitle">المسارات التدريبية ({{ count($scheduledOrgTrainings) }})</div>
                    <div class="row g-4">
                        @foreach ($scheduledOrgTrainings as $item)
                            @if (isset($item['program']) && $item['program'])
                                @php
                                    $orgTraining = $item['program'];
                                    $status = $item['status'];
                                    $start_date = $item['start_date'] ?? null;
                                @endphp
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card card-trainee">
                                        <div class="card-img-wrapper">
                                            @if ($orgTraining->profile_image)
                                                <img src="{{ asset('storage/' . $orgTraining->profile_image) }}"
                                                    alt="صورة التدريب">
                                            @else
                                                <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                    alt="صورة التدريب">
                                            @endif
                                            <span class="badge-position">
                                                {{ $orgTraining->trainingClassification->name ?? 'مسار تدريبي' }}
                                            </span>
                                        </div>
                                        <div class="card-body-trainee pt-1">
                                            <h5 class="card-title-trainee">{{ $orgTraining->title }}</h5>
                                            <div class="trainer-info mt-3 mb-3">
                                                @php
                                                    $trainer = $orgTraining->organization->user ?? null;
                                                    $trainerPhoto =
                                                        $trainer && $trainer->photo
                                                            ? asset('storage/' . $trainer->photo)
                                                            : asset('images/icons/user.svg');
                                                @endphp
                                                @if ($trainer)
                                                    <a href="{{ route('show_trainer_profile', ['id' => $trainer->id]) }}"
                                                        style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                                                        <img class="trainer-img" src="{{ $trainerPhoto }}"
                                                            alt="صورة المدرب" />
                                                        <span>
                                                            {{ $trainer->getTranslation('name', 'ar') }}
                                                            {{ optional($trainer->trainer)->getTranslation('last_name', 'ar') }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <span>لم يتم تحديد مدرب</span>
                                                @endif
                                            </div>
                                            <ul class="list-unstyled d-flex flex-wrap gap-3 text-muted small mb-3">
                                                {{-- عدد التدريبات في المسار --}}
                                                <li class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/cources/clock.svg') }}"
                                                        alt="عدد التدريبات">
                                                    @php
                                                        $trainingCount = $orgTraining->details
                                                            ? $orgTraining->details->count()
                                                            : 0;
                                                        echo $trainingCount . ' تدريب';
                                                    @endphp
                                                </li>
                                                {{-- الموقع --}}
                                                <li class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/cources/location.svg') }}" alt="الموقع">
                                                    {{ $orgTraining->country->name ?? '---' }}
                                                    {{ $orgTraining->city ? ' - ' . $orgTraining->city : '' }}
                                                </li>
                                            </ul>
                                            {{-- حالة الطلب --}}
                                            @if ($status === 'pending')
                                                <div class="status-message status-pending">
                                                    <img src="{{ asset('images/cources/wait.svg') }}">
                                                    طلب التسجيل قيد المراجعة من قبل المؤسسة.
                                                </div>
                                            @elseif($status === 'rejected')
                                                <div class="status-message status-rejected">
                                                    <img src="{{ asset('images/cources/rejected.svg') }}">
                                                    تم رفض طلب التسجيل .
                                                </div>
                                            @elseif($status === 'accepted')
                                                <div class="status-message status-accepted">
                                                    <img src="{{ asset('images/cources/accepted.svg') }}">
                                                    تم قبولك سيبدأ التدريب بتاريخ {{ $start_date ?? 'لاحق' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if (!count($scheduledTrainings) && !count($scheduledOrgTrainings))
                    <div
                        class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                        <h4>لا توجد تدريبات مرتقبة حالياً</h4>
                        <p>يمكنك استعراض التدريبات المتاحة والتسجيل فيها</p>
                        <a href="{{ route('trainings_announcements') }}" class="custom-btn">استعراض التدريبات</a>
                    </div>
                @endif
            </div>

            <!-- تبويب التدريبات الحالية -->
            <div class="tab-pane fade mb-4" id="current" role="tabpanel">
                <div class="section-title">
                    <span>التدريبات الحالية ({{ count($ongoingTrainings) + count($ongoingOrgTrainings) }})</span>
                </div>

                <!-- التدريبات العادية -->
                @if (count($ongoingTrainings))
                    <div class="section-subtitle">التدريبات ({{ count($ongoingTrainings)}})</div>
                    <div class="row">
                        @foreach ($ongoingTrainings as $item)
                            @php
                                $training = $item['program'];
                                $rate = $item['completionRate'];
                                $nextSession = $item['nextSession'];
                                // حساب الوقت المتبقي للجلسة التالية
                                $timeRemaining = null;
                                $canStartSession = false;
                                $hasDays = false;
                                if ($nextSession) {
                                    $now = \Carbon\Carbon::now();
                                    $sessionDateTime = \Carbon\Carbon::parse(
                                        $nextSession->session_date . ' ' . $nextSession->session_start_time,
                                    );
                                    if ($sessionDateTime->gt($now)) {
                                        $diff = $now->diff($sessionDateTime);
                                        if ($diff->days > 0) {
                                            // إذا كان هناك أيام، عرض عدد الأيام
                                            $timeRemaining = [
                                                'days' => $diff->days,
                                                'hours' => $diff->h,
                                                'minutes' => $diff->i,
                                                'seconds' => $diff->s,
                                            ];
                                            $hasDays = true;
                                        } else {
                                            // إذا لم يكن هناك أيام، عرض بالساعات والدقائق والثواني
                                            $timeRemaining = [
                                                'days' => 0,
                                                'hours' => $diff->h,
                                                'minutes' => $diff->i,
                                                'seconds' => $diff->s,
                                            ];
                                            $hasDays = false;
                                        }
                                    } else {
                                        $canStartSession = true;
                                    }
                                }
                            @endphp
                            <div class="col-12 current-training mb-4">
                                <div class="card card-trainee rounded-3 m-0">
                                    <div class="row g-0">
                                        <!-- النصف الأول: صورة، عنوان، مدرب، شريط التقدم -->
                                        <div class="col-lg-6 col-md-12 px-3 align-content-center">
                                            <div class="row h-100">
                                                <div class="col-md-4 d-flex align-items-start justify-content-start ps-0">
                                                    <div class="square-image-container">
                                                        @if ($training->AdditionalSetting && $training->AdditionalSetting->profile_image)
                                                            <img src="{{ asset('storage/' . $training->AdditionalSetting->profile_image) }}"
                                                                alt="صورة التدريب">
                                                        @else
                                                            <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                                alt="صورة التدريب">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-8 d-flex flex-column justify-content-center py-3">
                                                    <h5 class="card-title-trainee">{{ $training->title }}</h5>
                                                    <div class="trainer-name d-flex align-items-center">
                                                        @if ($training->trainer->photo)
                                                            <img src="{{ asset('storage/' . $training->trainer->photo) }}"
                                                                class="trainer-img me-2">
                                                        @else
                                                            <img src="{{ asset('images/icons/user.svg') }}"
                                                                class="trainer-img me-2">
                                                        @endif
                                                        {{ $training->trainer->getTranslation('name', 'ar') ?? '' }}
                                                        {{ optional($training->trainer->trainer)->getTranslation('last_name', 'ar') ?? '' }}
                                                    </div>
                                                    <div class="progress-container mt-3">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $rate }}%"></div>
                                                        </div>
                                                    </div>
                                                    <div class="progress-label-trainee">{{ 100 - $rate }}% متبقي لاكمال
                                                        التدريب</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- النصف الثاني: معلومات الجلسة وزر البدء -->
                                        <div class="col-lg-6 col-md-12 px-3 align-content-center">
                                            <div class="session-info-card">
                                                <div class="row h-100">
                                                    <!-- العمود الأول: معلومات الجلسة -->
                                                    <div class="col-6 d-flex flex-column justify-content-center">
                                                        <div class="next-session">
                                                            الجلسة التالية:
                                                            <div class="next-session-date">
                                                                @if ($nextSession)
                                                                    @php
                                                                        $sessionDate = \Carbon\Carbon::parse(
                                                                            $nextSession->session_date,
                                                                        )->locale('ar');
                                                                        $formattedDate = $sessionDate->translatedFormat(
                                                                            'd F Y',
                                                                        );
                                                                        $startTime = \Carbon\Carbon::parse(
                                                                            $nextSession->session_start_time,
                                                                        )->format('H:i');
                                                                        $endTime = \Carbon\Carbon::parse(
                                                                            $nextSession->session_end_time,
                                                                        )->format('H:i');
                                                                    @endphp
                                                                    {{ $formattedDate }}
                                                                    <div class="session-time mt-1">
                                                                        {{ $startTime }} - {{ $endTime }}
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">لا توجد جلسات قادمة</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- العمود الثاني: زر البدء أو العد التنازلي -->
                                                    <div class="col-6 d-flex flex-column justify-content-center">
                                                        @if ($nextSession)
                                                            @if ($canStartSession)
                                                                <button class="btn-start">ابدأ الجلسة</button>
                                                            @else
                                                                <div class="countdown-container">
                                                                    @if ($hasDays)
                                                                        <div class="countdown-days"
                                                                            id="countdown-{{ $nextSession->id }}"
                                                                            data-type="days"
                                                                            data-days="{{ $timeRemaining['days'] }}"
                                                                            data-hours="{{ $timeRemaining['hours'] }}"
                                                                            data-minutes="{{ $timeRemaining['minutes'] }}"
                                                                            data-seconds="{{ $timeRemaining['seconds'] }}">
                                                                            <span class="countdown-prefix">تبدأ بعد</span>
                                                                            <span
                                                                                class="days">{{ $timeRemaining['days'] }}</span>
                                                                            <span>يوم</span>
                                                                            @if ($timeRemaining['hours'] > 0)
                                                                                <span>و</span>
                                                                                <span
                                                                                    class="hours">{{ $timeRemaining['hours'] }}</span>
                                                                                <span>ساعة</span>
                                                                            @endif
                                                                        </div>
                                                                    @else
                                                                        <div class="countdown"
                                                                            id="countdown-{{ $nextSession->id }}"
                                                                            data-type="time"
                                                                            data-hours="{{ $timeRemaining['hours'] }}"
                                                                            data-minutes="{{ $timeRemaining['minutes'] }}"
                                                                            data-seconds="{{ $timeRemaining['seconds'] }}">
                                                                            <span class="countdown-prefix">تبدأ بعد</span>
                                                                            <span>{{ str_pad($timeRemaining['hours'], 2, '0', STR_PAD_LEFT) }}:{{ str_pad($timeRemaining['minutes'], 2, '0', STR_PAD_LEFT) }}:{{ str_pad($timeRemaining['seconds'], 2, '0', STR_PAD_LEFT) }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @else
                                                            <button class="btn-start" disabled>لا توجد جلسات متاحة</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- المسارات التدريبية -->
                @if (count($ongoingOrgTrainings))
                    <div class="section-subtitle">المسارات التدريبية ({{ count($ongoingOrgTrainings)}})</div>
                    <div class="row">
                        @foreach ($ongoingOrgTrainings as $item)
                            @php
                                $orgTraining = $item['program'];
                                $rate = $item['completionRate'];
                                $nextSession = $item['nextSession'];
                                // حساب الوقت المتبقي للجلسة التالية
                                $timeRemaining = null;
                                $canStartSession = false;
                                $hasDays = false;
                                if ($nextSession) {
                                    $now = \Carbon\Carbon::now();
                                    $sessionDateTime = \Carbon\Carbon::parse(
                                        $nextSession->session_date . ' ' . $nextSession->session_start_time,
                                    );
                                    if ($sessionDateTime->gt($now)) {
                                        $diff = $now->diff($sessionDateTime);
                                        if ($diff->days > 0) {
                                            // إذا كان هناك أيام، عرض عدد الأيام
                                            $timeRemaining = [
                                                'days' => $diff->days,
                                                'hours' => $diff->h,
                                                'minutes' => $diff->i,
                                                'seconds' => $diff->s,
                                            ];
                                            $hasDays = true;
                                        } else {
                                            // إذا لم يكن هناك أيام، عرض بالساعات والدقائق والثواني
                                            $timeRemaining = [
                                                'days' => 0,
                                                'hours' => $diff->h,
                                                'minutes' => $diff->i,
                                                'seconds' => $diff->s,
                                            ];
                                            $hasDays = false;
                                        }
                                    } else {
                                        $canStartSession = true;
                                    }
                                }
                            @endphp
                            <div class="col-12 current-training mb-4">
                                <div class="card card-trainee rounded-3 m-0">
                                    <div class="row g-0">
                                        <!-- النصف الأول: صورة، عنوان، مدرب، شريط التقدم -->
                                        <div class="col-lg-6 col-md-12 px-3 align-content-center">
                                            <div class="row h-100">
                                                <div class="col-md-4 d-flex align-items-start justify-content-start ps-0">
                                                    <div class="square-image-container">
                                                        @if ($orgTraining->profile_image)
                                                            <img src="{{ asset('storage/' . $orgTraining->profile_image) }}"
                                                                alt="صورة التدريب">
                                                        @else
                                                            <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                                alt="صورة التدريب">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-8 d-flex flex-column justify-content-center py-3">
                                                    <h5 class="card-title-trainee">{{ $orgTraining->title }}</h5>
                                                    <div class="trainer-name d-flex align-items-center">
                                                        @if ($orgTraining->organization->user->photo)
                                                            <img src="{{ asset('storage/' . $orgTraining->organization->user->photo) }}"
                                                                class="trainer-img me-2">
                                                        @else
                                                            <img src="{{ asset('images/icons/user.svg') }}"
                                                                class="trainer-img me-2">
                                                        @endif
                                                        {{ $orgTraining->organization->user->getTranslation('name', 'ar') ?? '' }}
                                                    </div>
                                                    <div class="progress-container mt-3">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $rate }}%"></div>
                                                        </div>
                                                    </div>
                                                    <div class="progress-label-trainee">{{ 100 - $rate }}% متبقي لاكمال
                                                        المسار</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- النصف الثاني: معلومات الجلسة وزر البدء -->
                                        <div class="col-lg-6 col-md-12 px-3 align-content-center">
                                            <div class="session-info-card">
                                                <div class="row h-100">
                                                    <!-- العمود الأول: معلومات الجلسة -->
                                                    <div class="col-6 d-flex flex-column justify-content-center">
                                                        <div class="next-session">
                                                            الجلسة التالية:
                                                            <div class="next-session-date">
                                                                @if ($nextSession)
                                                                    @php
                                                                        $sessionDate = \Carbon\Carbon::parse(
                                                                            $nextSession->session_date,
                                                                        )->locale('ar');
                                                                        $formattedDate = $sessionDate->translatedFormat(
                                                                            'd F Y',
                                                                        );
                                                                        $startTime = \Carbon\Carbon::parse(
                                                                            $nextSession->session_start_time,
                                                                        )->format('H:i');
                                                                        $endTime = \Carbon\Carbon::parse(
                                                                            $nextSession->session_end_time,
                                                                        )->format('H:i');
                                                                    @endphp
                                                                    {{ $formattedDate }}
                                                                    <div class="session-time mt-1">
                                                                        {{ $startTime }} - {{ $endTime }}
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">لا توجد جلسات قادمة</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- العمود الثاني: زر البدء أو العد التنازلي -->
                                                    <div class="col-6 d-flex flex-column justify-content-center">
                                                        @if ($nextSession)
                                                            @if ($canStartSession)
                                                                <button class="btn-start">ابدأ الجلسة</button>
                                                            @else
                                                                <div class="countdown-container">
                                                                    @if ($hasDays)
                                                                        <div class="countdown-days"
                                                                            id="countdown-{{ $nextSession->id }}"
                                                                            data-type="days"
                                                                            data-days="{{ $timeRemaining['days'] }}"
                                                                            data-hours="{{ $timeRemaining['hours'] }}"
                                                                            data-minutes="{{ $timeRemaining['minutes'] }}"
                                                                            data-seconds="{{ $timeRemaining['seconds'] }}">
                                                                            <span class="countdown-prefix">تبدأ بعد</span>
                                                                            <span
                                                                                class="days">{{ $timeRemaining['days'] }}</span>
                                                                            <span>يوم</span>
                                                                            @if ($timeRemaining['hours'] > 0)
                                                                                <span>و</span>
                                                                                <span
                                                                                    class="hours">{{ $timeRemaining['hours'] }}</span>
                                                                                <span>ساعة</span>
                                                                            @endif
                                                                        </div>
                                                                    @else
                                                                        <div class="countdown"
                                                                            id="countdown-{{ $nextSession->id }}"
                                                                            data-type="time"
                                                                            data-hours="{{ $timeRemaining['hours'] }}"
                                                                            data-minutes="{{ $timeRemaining['minutes'] }}"
                                                                            data-seconds="{{ $timeRemaining['seconds'] }}">
                                                                            <span class="countdown-prefix">تبدأ بعد</span>
                                                                            <span>{{ str_pad($timeRemaining['hours'], 2, '0', STR_PAD_LEFT) }}:{{ str_pad($timeRemaining['minutes'], 2, '0', STR_PAD_LEFT) }}:{{ str_pad($timeRemaining['seconds'], 2, '0', STR_PAD_LEFT) }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @else
                                                            <button class="btn-start" disabled>لا توجد جلسات متاحة</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!count($ongoingTrainings) && !count($ongoingOrgTrainings))
                    <div
                        class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                        <h4>لا توجد تدريبات حالية</h4>
                        <p>سيتم عرض التدريبات الجارية هنا بعد قبول طلباتك</p>
                    </div>
                @endif
            </div>

            <!-- تبويب التدريبات المكتملة -->
            <div class="tab-pane fade mb-4" id="completed" role="tabpanel">
                <div class="section-title">
                    <span>التدريبات المكتملة ({{ count($completedTrainings) + count($completedOrgTrainings) }})</span>
                </div>

                @if (count($completedTrainings))
                    <div class="section-subtitle">التدريبات ({{count($completedTrainings) }})</div>
                    <div class="row g-3">
                        @foreach ($completedTrainings as $item)
                            @php
                                $training = $item['program'];
                                $rate = $item['completionRate'];
                            @endphp
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="card card-trainee completed-card h-100">
                                    <div class="row g-0 h-100">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <div class="square-image-container w-100">
                                                @if ($training->AdditionalSetting && $training->AdditionalSetting->profile_image)
                                                    <img src="{{ asset('storage/' . $training->AdditionalSetting->profile_image) }}"
                                                        alt="صورة التدريب">
                                                @else
                                                    <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                        alt="صورة التدريب">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8 align-content-center">
                                            <div class="card-body-trainee">
                                                <!-- العنوان -->
                                                <h5 class="card-title-trainee">{{ $training->title }}</h5>

                                                <!-- صورة المدرب واسمه -->
                                                <div class="trainer-info">
                                                    @if ($training->trainer->photo)
                                                        <img src="{{ asset('storage/' . $training->trainer->photo) }}"
                                                            class="trainer-img me-2">
                                                    @else
                                                        <img src="{{ asset('images/icons/user.svg') }}"
                                                            class="trainer-img me-2">
                                                    @endif
                                                    <span>{{ $training->trainer->getTranslation('name', 'ar') }}
                                                        {{ optional($training->trainer->trainer)->getTranslation('last_name', 'ar') }}</span>
                                                </div>

                                                <!-- نسبة الإكمال ورابط التفاصيل -->
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="completion-badge">{{ $rate }}% مكتمل</div>
                                                    <a href="{{ route('show_trainings_announcements', $training->id) }}"
                                                        class="link-details">
                                                        <span dir="rtl"
                                                            style="display:inline-flex; align-items:center; gap:.5rem;">
                                                            عرض تفاصيل التدريب
                                                            <span>🡨</span>
                                                        </span>

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (count($completedOrgTrainings))
                    <div class="section-subtitle">المسارات التدريبية ({{count($completedOrgTrainings) }})</div>
                    <div class="row g-3">
                        @foreach ($completedOrgTrainings as $item)
                            @php
                                $orgTraining = $item['program'];
                                $rate = $item['completionRate'];
                            @endphp
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="card card-trainee completed-card h-100">
                                    <div class="row g-0 h-100">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <div class="square-image-container w-100">
                                                @if ($orgTraining->profile_image)
                                                    <img src="{{ asset('storage/' . $orgTraining->profile_image) }}"
                                                        alt="صورة التدريب">
                                                @else
                                                    <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                        alt="صورة التدريب">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8 align-content-center">
                                            <div class="card-body-trainee">
                                                <!-- العنوان -->
                                                <h5 class="card-title-trainee">{{ $orgTraining->title }}</h5>

                                                <!-- صورة المدرب واسمه -->
                                                <div class="trainer-info">
                                                    @if ($orgTraining->organization->user->photo)
                                                        <img src="{{ asset('storage/' . $orgTraining->organization->user->photo) }}"
                                                            class="trainer-img me-2">
                                                    @else
                                                        <img src="{{ asset('images/icons/user.svg') }}"
                                                            class="trainer-img me-2">
                                                    @endif
                                                    <span>{{ $orgTraining->organization->user->getTranslation('name', 'ar') ?? '' }}</span>
                                                </div>

                                                <!-- نسبة الإكمال ورابط التفاصيل -->
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="completion-badge">{{ $rate }}% مكتمل</div>
                                                    <a href="{{ route('org.training.show', $orgTraining->id) }}"
                                                        class="link-details">

                                                        <span dir="rtl"
                                                            style="display:inline-flex; align-items:center; gap:.5rem;">
                                                            عرض تفاصيل التدريب
                                                            <span>🡨</span>
                                                        </span>

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!count($completedTrainings) && !count($completedOrgTrainings))
                    <div
                        class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                        <h4>لا توجد تدريبات مكتملة</h4>
                        <p>سيتم عرض التدريبات المكتملة هنا بعد إنهائك لها</p>
                    </div>
                @endif
            </div>

            <!-- تبويب التدريبات المعلقة -->
            <div class="tab-pane fade mb-4" id="suspended" role="tabpanel">
                <div class="section-title">
                    <span>التدريبات المعلقة
                ({{ count($pausedTrainings) + count($pausedOrgTrainings) }})</span>
                </div>
                @if (count($pausedTrainings))
                    <div class="section-subtitle">التدريبات ({{ count($pausedTrainings) }})</div>
                    <div class="row g-4">
                        @foreach ($pausedTrainings as $training)
                            @if ($training)
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card card-trainee">
                                        <div class="card-img-wrapper">
                                            @if ($training->AdditionalSetting && $training->AdditionalSetting->profile_image)
                                                <img src="{{ asset('storage/' . $training->AdditionalSetting->profile_image) }}"
                                                    alt="صورة التدريب">
                                            @else
                                                <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                    alt="صورة التدريب">
                                            @endif
                                            <span class="badge-position">{{ $training->TrainingClassification->name ?? 'تدريب' }}</span>
                                        </div>
                                        <div class="card-body-trainee pt-1">
                                            <h5 class="card-title-trainee">{{ $training->title }}</h5>
                                            <div class="trainer-info mt-3 mb-3">
                                                @php
                                                    $trainer = $training->trainer;
                                                    $trainerPhoto = $trainer && $trainer->photo
                                                        ? asset('storage/' . $trainer->photo)
                                                        : asset('images/icons/user.svg');
                                                @endphp
                                                @if ($trainer)
                                                    <a href="{{ route('show_trainer_profile', ['id' => $trainer->id]) }}"
                                                        style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                                                        <img class="trainer-img" src="{{ $trainerPhoto }}"
                                                            alt="صورة المدرب" />
                                                        <span>
                                                            {{ $trainer->getTranslation('name', 'ar') }}
                                                            {{ optional($trainer->trainer)->getTranslation('last_name', 'ar') }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <span>لم يتم تحديد مدرب</span>
                                                @endif
                                            </div>
                                            <ul class="list-unstyled d-flex flex-wrap gap-3 text-muted small mb-3">
                                                {{-- المدة --}}
                                                <li class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/cources/clock.svg') }}" alt="المدة">
                                                    @php
                                                        $durationText = '';
                                                        if (!empty($training->schedules_later) && $training->schedules_later == 1) {
                                                            if (!empty($training->num_of_hours) && $training->num_of_hours > 0) {
                                                                $hours = floor($training->num_of_hours);
                                                                $minutes = round(($training->num_of_hours - $hours) * 60);
                                                                if ($hours > 0 && $minutes > 0) {
                                                                    $durationText = $hours . ' ساعة و ' . $minutes . ' دقيقة';
                                                                } elseif ($hours > 0) {
                                                                    $durationText = $hours . ' ساعة';
                                                                } else {
                                                                    $durationText = $minutes . ' دقيقة';
                                                                }
                                                            }
                                                        } elseif (isset($training->sessions) && $training->sessions->count() > 0) {
                                                            $totalMinutes = 0;
                                                            foreach ($training->sessions as $session) {
                                                                if (isset($session->session_start_time) && isset($session->session_end_time)) {
                                                                    $startTime = \Carbon\Carbon::parse($session->session_start_time);
                                                                    $endTime = \Carbon\Carbon::parse($session->session_end_time);
                                                                    $totalMinutes += $startTime->diffInMinutes($endTime);
                                                                }
                                                            }
                                                            if ($totalMinutes > 0) {
                                                                $hours = floor($totalMinutes / 60);
                                                                $minutes = $totalMinutes % 60;
                                                                if ($hours > 0 && $minutes > 0) {
                                                                    $durationText = $hours . ' ساعة و ' . $minutes . ' دقيقة';
                                                                } elseif ($hours > 0) {
                                                                    $durationText = $hours . ' ساعة';
                                                                } else {
                                                                    $durationText = $minutes . ' دقيقة';
                                                                }
                                                            }
                                                        }
                                                        if (empty($durationText)) {
                                                            $durationText = 'قيد الإعداد';
                                                        }
                                                        echo $durationText;
                                                    @endphp
                                                </li>
                                                {{-- الموقع أو أونلاين --}}
                                                @if ($training->program_presentation_method_id === \App\Enums\TrainingAttendanceType::HYBRID->value || $training->program_presentation_method_id === \App\Enums\TrainingAttendanceType::REMOTE->value)
                                                    <li class="d-flex align-items-center gap-2">
                                                        <img src="{{ asset('images/cources/online.svg') }}" alt="نوع الدورة">
                                                        أونلاين
                                                    </li>
                                                @else
                                                    <li class="d-flex align-items-center gap-2">
                                                        <img src="{{ asset('images/cources/location.svg') }}" alt="الموقع">
                                                        {{ $training->AdditionalSetting && $training->AdditionalSetting->city ? $training->AdditionalSetting->city : '---' }}
                                                        {{ $training->AdditionalSetting && $training->AdditionalSetting->country ? ' - ' . $training->AdditionalSetting->country->name : '' }}
                                                    </li>
                                                @endif
                                            </ul>
                                            <div class="status-message status-suspended">
                                                <img src="{{ asset('images/cources/wait.svg') }}">
                                                تم تعليق التدريب من قبل المدرب
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                @if (count($pausedOrgTrainings))
                    <div class="section-subtitle">المسارات التدريبية ({{ count($pausedOrgTrainings) }})</div>
                    <div class="row g-4">
                        @foreach ($pausedOrgTrainings as $orgTraining)
                            @if ($orgTraining)
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card card-trainee">
                                        <div class="card-img-wrapper">
                                            @if ($orgTraining->profile_image)
                                                <img src="{{ asset('storage/' . $orgTraining->profile_image) }}"
                                                    alt="صورة التدريب">
                                            @else
                                                <img src="{{ asset('images/cources/training-default-img.svg') }}"
                                                    alt="صورة التدريب">
                                            @endif
                                            <span class="badge-position">
                                                {{ $orgTraining->trainingClassification->name ?? 'مسار تدريبي' }}
                                            </span>
                                        </div>
                                        <div class="card-body-trainee pt-1">
                                            <h5 class="card-title-trainee">{{ $orgTraining->title }}</h5>
                                            <div class="trainer-info mt-3 mb-3">
                                                @php
                                                    $trainer = $orgTraining->organization->user ?? null;
                                                    $trainerPhoto = $trainer && $trainer->photo
                                                        ? asset('storage/' . $trainer->photo)
                                                        : asset('images/icons/user.svg');
                                                @endphp
                                                @if ($trainer)
                                                    <a href="{{ route('show_trainer_profile', ['id' => $trainer->id]) }}"
                                                        style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                                                        <img class="trainer-img" src="{{ $trainerPhoto }}"
                                                            alt="صورة المدرب" />
                                                        <span>
                                                            {{ $trainer->getTranslation('name', 'ar') }}
                                                            {{ optional($trainer->trainer)->getTranslation('last_name', 'ar') }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <span>لم يتم تحديد مدرب</span>
                                                @endif
                                            </div>
                                            <ul class="list-unstyled d-flex flex-wrap gap-3 text-muted small mb-3">
                                                {{-- عدد التدريبات في المسار --}}
                                                <li class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/cources/clock.svg') }}" alt="عدد التدريبات">
                                                    @php
                                                        $trainingCount = $orgTraining->details ? $orgTraining->details->count() : 0;
                                                        echo $trainingCount . ' تدريب';
                                                    @endphp
                                                </li>
                                                {{-- الموقع --}}
                                                <li class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/cources/location.svg') }}" alt="الموقع">
                                                    {{ $orgTraining->country->name ?? '---' }}
                                                    {{ $orgTraining->city ? ' - ' . $orgTraining->city : '' }}
                                                </li>
                                            </ul>
                                            <div class="status-message status-suspended">
                                                <img src="{{ asset('images/cources/stopped.svg') }}">
                                                تم تعليق التدريب من قبل المؤسسة
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                @if (!count($pausedTrainings) && !count($pausedOrgTrainings))
                    <div class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                        <h4>لا توجد تدريبات معلقة</h4>
                        <p>جميع تدريباتك نشطة وليست معلقة</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // حفظ واستعادة التبويب النشط
            const activeTabKey = 'traineeTrainingsActiveTab';
            // استعادة التبويب النشط من localStorage
            const savedTab = localStorage.getItem(activeTabKey);
            if (savedTab) {
                const tab = new bootstrap.Tab(document.querySelector(savedTab));
                tab.show();
            }
            // حفظ التبويب النشط عند التغيير
            document.querySelectorAll('#myTab .nav-link').forEach(tabEl => {
                tabEl.addEventListener('click', function() {
                    localStorage.setItem(activeTabKey, `#${this.id}`);
                });
            });

            // تحديث العد التنازلي للجلسات
            function updateSessionCountdowns() {
                // تحديث العد التنازلي بالأيام
                const countdownDaysElements = document.querySelectorAll('.countdown-days[data-type="days"]');
                countdownDaysElements.forEach(element => {
                    // الحصول على القيم من خصائص data
                    let days = parseInt(element.dataset.days);
                    let hours = parseInt(element.dataset.hours);
                    let minutes = parseInt(element.dataset.minutes);
                    let seconds = parseInt(element.dataset.seconds);

                    // تحديث الثواني
                    if (seconds > 0) {
                        seconds--;
                    } else if (minutes > 0) {
                        minutes--;
                        seconds = 59;
                    } else if (hours > 0) {
                        hours--;
                        minutes = 59;
                        seconds = 59;
                    } else if (days > 0) {
                        days--;
                        hours = 23;
                        minutes = 59;
                        seconds = 59;
                    }

                    // تحديث خصائص data
                    element.dataset.days = days;
                    element.dataset.hours = hours;
                    element.dataset.minutes = minutes;
                    element.dataset.seconds = seconds;

                    // تحديث العرض
                    if (days > 0) {
                        element.querySelector('.days').textContent = days;
                        if (hours > 0) {
                            element.querySelector('.hours').textContent = hours;
                        }
                    } else {
                        // عندما يصبح الوقت أقل من يوم، تحويل إلى صيغة الساعات والدقائق والثواني
                        const countdownContainer = element.closest('.countdown-container');
                        if (countdownContainer) {
                            countdownContainer.innerHTML = `
                                <div class="countdown" id="${element.id}" data-type="time" data-hours="${hours}" data-minutes="${minutes}" data-seconds="${seconds}">
                                    <span class="countdown-prefix">تبدأ بعد</span>
                                    <span>${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}</span>
                                </div>
                            `;
                        }
                    }
                });

                // تحديث العد التنازلي بالوقت (HH:MM:SS)
                const countdownTimeElements = document.querySelectorAll('.countdown[data-type="time"]');
                countdownTimeElements.forEach(element => {
                    // الحصول على القيم من خصائص data
                    let hours = parseInt(element.dataset.hours);
                    let minutes = parseInt(element.dataset.minutes);
                    let seconds = parseInt(element.dataset.seconds);

                    if (seconds > 0) {
                        seconds--;
                    } else if (minutes > 0) {
                        minutes--;
                        seconds = 59;
                    } else if (hours > 0) {
                        hours--;
                        minutes = 59;
                        seconds = 59;
                    }

                    // تحديث خصائص data
                    element.dataset.hours = hours;
                    element.dataset.minutes = minutes;
                    element.dataset.seconds = seconds;

                    // تحديث العرض
                    const timeSpan = element.querySelector('span:last-child');
                    if (timeSpan) {
                        timeSpan.textContent =
                            `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    }

                    // عندما ينتهي العد التنازلي
                    if (hours === 0 && minutes === 0 && seconds === 0) {
                        const countdownContainer = element.closest('.countdown-container');
                        if (countdownContainer) {
                            countdownContainer.innerHTML = '<button class="btn-start">ابدأ الجلسة</button>';
                        }
                    }
                });
            }

            // تحديث العد التنازلي كل ثانية
            setInterval(updateSessionCountdowns, 1000);
        });
    </script>
@endsection
