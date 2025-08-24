@extends('frontend.layouts.master')
@section('title', 'مراجعة البرنامج التدريبي')
@section('content')
    <style>
        .clickable-title {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .clickable-title:hover {
            color: #3498db;
        }
        .training-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
          
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .training-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        .training-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 5px;
              padding: 15px;
        }
        .training-title-2 {
            font-weight: 500;
            font-size: 18px;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }
        .trainer-name {
            color: #7f8c8d;
            font-size: 14px;
        }
        .sessions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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
            font-size: 12px;
            display: inline-block;
        }
        .no-sessions-message {
            text-align: center;
            color: #7f8c8d;
            padding: 20px;
            font-style: italic;
        }
        .training-price-value {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .info-block-content-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .info-block-content-item img {
            margin-left: 10px;
        }
      
        .trainer-profile {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .trainer-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 15px;
        }
        .training-details-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .training-details-item img {
            margin-left: 10px;
        }
        
        /* تعديلات جديدة */
        .training-info {
            position: relative;
        }
        .training-info img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 8px;
            height: auto;
        }
        
        @media (min-width: 768px) {
            .grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
            .training-info img {
                height: 100%;
            }
        }
        
        @media (max-width: 767px) {
            .grid {
                display: flex;
                flex-direction: column;
            }
            .training-info img {
                width: 100%;
                height: auto;
            }
        }
        
        .sessions-container {
          
            display: none;
        }
        
        .sessions-container.show {
            display: block;
            border-top: 1px solid #e0e0e0;
        }
        
        .session-content {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .content-training{
            padding: 15px;
        }
        
        /* أنماط السهم الجديدة */
        .arrow-icon {
            transition: transform 0.3s ease;
            margin-right: 8px;
            width: 16px;
            height: 16px;
        }
        
        .arrow-icon.rotated {
            transform: rotate(90deg);
        }
    </style>
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        @include('orgTrainings.partials.stepper', [
                            'currentStep' => 6,
                            'trainingId' => $training->id ?? null,
                            'isEditMode' => true,
                        ])
                    </div>
                </div>
                <div class="left-col">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="info-message">
                        <div class="info-badge">
                            <img src="{{ asset('images/icons/hint.svg') }}" alt="" />
                        </div>
                        <div class="info-message-content">
                            قبل نشر التدريب، يُرجى مراجعة جميع البيانات المدخلة والتأكد من صحتها ودقتها. يمكنك تعديل أي قسم
                            من خلال الضغط عليه حيث سيتم نقلك للصفحة الخاصة و سيتم حفظ التعديل تلقائيًا
                        </div>
                    </div>
                    <form method="POST" action="{{ route('orgTraining.publish', $training->id) }}"
                        class="training-form-review">
                        @csrf
                        <div class="grid">
                            <div class="training-info">
                                <h4 class="clickable-title"
                                    onclick="window.location.href='{{ route('orgTraining.basicInformation', $training->id) }}'">
                                    {{ $training->title }}
                                </h4>
                                @if (!empty($settings->training_image))
                                    @php
                                        $imagePath = str_contains($settings->training_image, 'storage/')
                                            ? $settings->training_image
                                            : 'storage/' . $settings->training_image;
                                    @endphp
                                    <img src="{{ asset($imagePath) }}" alt="صورة التدريب">
                                @else
                                    <img src="{{ asset('images/cources/training-default-img.svg') }}" alt="صورة افتراضية">
                                @endif
                            </div>
                            <div class="training-details gap-1">
                                @if (!empty($training->language))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.basicInformation', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/global.svg') }}" alt="">
                                        <p>لغة المسار: {{ $training->language->name }}</p>
                                    </div>
                                @endif
                                @if (!empty($training->program_type))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.basicInformation', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/type.svg') }}" alt="">
                                        <p>نوع المسار التدريبي: {{ $training->programType->name }}</p>
                                    </div>
                                @endif
                                @if (!empty($training->trainingClassification))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.basicInformation', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/category.svg') }}" alt="">
                                        <p>تصنيفات المسار: {{ $training->trainingClassification->name }}</p>
                                    </div>
                                @endif
                                @if (!empty($training->trainingLevel))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.basicInformation', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/level.svg') }}" alt="">
                                        <p>مستوى المسار: {{ $training->trainingLevel->name }}</p>
                                    </div>
                                @endif
                                @if (!empty($training->program_presentation_method))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.basicInformation', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/method.svg') }}" alt="">
                                        <p>طريقة تقديم المسار: {{ $training->program_presentation_method }}</p>
                                    </div>
                                @endif
                                @if (!empty($training->details))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.trainingDetail', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/session.svg') }}" alt="">
                                        <p>عدد التدريبات: {{ $training->details->count() }} تدريب</p>
                                    </div>
                                @endif
                                @if (!empty($submissionMethod))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/register-type.svg') }}" alt="">
                                        <p>طريقة التسجيل:
                                            {{ $submissionMethod == 'inside_platform' ? 'داخل المنصة' : 'خارج المنصة' }}
                                        </p>
                                    </div>
                                @endif
                                @if (!empty($settings))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/participants.svg') }}" alt="">
                                        <p>العدد الأقصى للمشاركين:
                                            {{ $settings->max_trainees == 0 ? 'لا يوجد عدد محدد' : $settings->max_trainees . 'مشارك' }}
                                        </p>
                                    </div>
                                @endif
                                @if (!empty($settings) && !empty($settings->country))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/location.svg') }}" alt="">
                                        <p>مكان التقديم:
                                            {{ $settings->country->name }}{{ !empty($settings->city) ? ', ' . $settings->city : '' }}
                                        </p>
                                    </div>
                                @endif
                                @if (!empty($settings) && !empty($settings->application_deadline))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/calendar.svg') }}" alt="">
                                        <p>تاريخ انتهاء التقديم:
                                            {{ \Carbon\Carbon::parse($settings->application_deadline)->locale('ar')->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                @endif
                                <div class="training-price clickable-title"
                                    onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                                    <p class="training-price-label">سعر الاشتراك</p>
                                    <p class="training-price-value">
                                        @if (!empty($settings) && !empty($settings->is_free) && $settings->is_free)
                                            مجاني
                                        @elseif (!empty($settings) && !empty($settings->cost))
                                            @php
                                                $cost = $settings->cost ?? 0;
                                            @endphp
                                            @if ($cost > 0)
                                                @if (floor($cost) == $cost)
                                                    {{ number_format($cost, 0, '', ',') }}
                                                @else
                                                    {{ number_format($cost, 2, '.', ',') }}
                                                @endif
                                                {{ $settings->currency ?? '' }}
                                            @endif
                                        @else
                                            ---
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="info-blocks">
                            <div class="info-block">
                                <div class="info-block-title clickable-title"
                                    onclick="window.location.href='{{ route('orgTraining.basicInformation', $training->id) }}'">
                                    <span>وصف المسار التدريبي</span>
                                </div>
                                <div class="info-block-content">
                                    {{ $training->program_description ?? 'لم يتم إدخال وصف للتدريب' }}
                                </div>
                            </div>
                            <!-- عرض الفئة المستهدفة من التدريب -->
                            @if (!empty($training->goals) && $training->goals->count() > 0)
                                @php
                                    $goals = $training->goals->first();
                                    // فك تشفير حقول JSON إذا كانت نصوصاً، أو استخدامها كما هي إذا كانت مصفوفات بالفعل
                                    $educationLevels = is_array($goals->education_level_id)
                                        ? $goals->education_level_id
                                        : json_decode($goals->education_level_id, true) ?? [];
                                    $workSectors = is_array($goals->work_sector_id)
                                        ? $goals->work_sector_id
                                        : json_decode($goals->work_sector_id, true) ?? [];
                                    $jobPositions = is_array($goals->job_position)
                                        ? $goals->job_position
                                        : json_decode($goals->job_position, true) ?? [];
                                    $countries = is_array($goals->country_id)
                                        ? $goals->country_id
                                        : json_decode($goals->country_id, true) ?? [];
                                    $learningOutcomes = is_array($goals->learning_outcomes)
                                        ? $goals->learning_outcomes
                                        : json_decode($goals->learning_outcomes, true) ?? [];
                                @endphp
                                <div class="info-block">
                                    <div class="info-block-title clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.goals', $training->id) }}'">
                                        <span>الفئة المستهدفة من المسار التدريبي</span>
                                    </div>
                                    <div class="info-block-content">
                                        @if (!empty($educationLevels) && is_array($educationLevels) && count($educationLevels) > 0)
                                            <div class="audience-question">
                                                <div class="audience-question-title">
                                                    <img src="{{ asset(path: 'images/icons/check-circle.svg') }}"
                                                        class="me-2">
                                                    المستوى العلمي
                                                </div>
                                                <div class="audience-tags">
                                                    @foreach ($educationLevels as $levelId)
                                                        @php
                                                            $level = \App\Models\EducationLevel::find($levelId);
                                                            @endphp
                                                        @if ($level)
                                                        <span class="audience-tag">{{ $level->name }}</span>
                                                    @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if (!empty($goals->work_status))
                                <div class="audience-question">
                                    <div class="audience-question-title">
                                        <img src="{{ asset(path: 'images/icons/check-circle.svg') }}" class="me-2">
                                        الحالة الوظيفية
                                    </div>
                                    <div class="audience-tags">
@foreach ($goals->work_status as $work_status)
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

                                    </div>
                                </div>
                            @endif
                            @if (!empty($workSectors) && is_array($workSectors) && count($workSectors) > 0)
                                <div class="audience-question">
                                    <div class="audience-question-title">
                                        <img src="{{ asset(path: 'images/icons/check-circle.svg') }}" class="me-2">
                                        قطاع العمل
                                    </div>
                                    <div class="audience-tags">
                                        @foreach ($workSectors as $sectorId)
                                            @php
                                                $sector = \App\Models\WorkSector::find($sectorId);
                                            @endphp
                                            @if ($sector)
                                            <span class="audience-tag">{{ $sector->name }}</span>
                                        @endif
                            @endforeach
                        </div>
                </div>
                @endif
                @if (!empty($jobPositions) && is_array($jobPositions) && count($jobPositions) > 0)
                    <div class="audience-question">
                        <div class="audience-question-title">
                            <img src="{{ asset(path: 'images/icons/check-circle.svg') }}" class="me-2">
                            المستوى الوظيفي
                        </div>
                        <div class="audience-tags">
                            @foreach ($jobPositions as $position)
                                <span class="audience-tag">{{ $position }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (!empty($countries) && is_array($countries) && count($countries) > 0)
                    <div class="audience-question">
                        <div class="audience-question-title">
                            <img src="{{ asset(path: 'images/icons/check-circle.svg') }}" class="me-2">
                            الجنسية/ المنطقة
                        </div>
                        <div class="audience-tags">
                            @foreach ($countries as $countryId)
                                @php
                                    $country = \App\Models\Country::find($countryId);
                                @endphp
                                @if ($country)
                                <span class="audience-tag">{{ $country->name }}</span>
                            @endif
                @endforeach
            </div>
        </div>
        @endif
        </div>
        </div>
        @endif
        @if (!empty($learningOutcomes) && is_array($learningOutcomes) && count($learningOutcomes) > 0)
            <div class="info-block">
                <div class="info-block-title clickable-title"
                    onclick="window.location.href='{{ route('orgTraining.goals', $training->id) }}'">
                    <span>النتائج التعليمية من المسار التدريبي</span>
                </div>
                <div class="info-block-content">
                    @foreach ($learningOutcomes as $item)
                        <div class="info-block-content-item">
                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                            <div class="info-block-content-item-title">
                                {{ $item }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if (!empty($requirements))
            <div class="info-block">
                <div class="info-block-title clickable-title"
                    onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                    <span>المتطلبات أو الشروط اللازمة للالتحاق بالمسار</span>
                </div>
                <div class="info-block-content">
                    @foreach ($requirements as $item)
                        <div class="info-block-content-item">
                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                            <div class="info-block-content-item-title">
                                {{ $item }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if (!empty($benefits))
            <div class="info-block">
                <div class="info-block-title clickable-title"
                    onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                    <span>ميزات هذا المسار التدريبي</span>
                </div>
                <div class="info-block-content">
                    @foreach ($benefits as $item)
                        <div class="info-block-content-item">
                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                            <div class="info-block-content-item-title">
                                {{ $item }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <!-- عرض التدريبات والجلسات -->
                        <div class="info-block">
                            <div class="info-block-title clickable-title"
                                onclick="window.location.href='{{ route('orgTraining.trainingDetail', $training->id) }}'">
                                <span>تدريبات المسار</span>
                            </div>
                            <div class="info-block-content">
                                @if (empty($training->details) || $training->details->count() == 0)
                                    <div class="no-sessions-message">
                                        لم يتم إضافة تدريبات بعد. يمكنك إضافتها لاحقاً من خلال صفحة تعديل التدريب.
                                    </div>
                                @else
                                    @foreach ($training->details as $detail)
                                        <div class="training-item">
                                            <div class="training-item-header" id="header-{{ $detail->id }}">
                                                <div class="training-title-2 clickable-title"
                                                    onclick="toggleSessions({{ $detail->id }})">
<div class="me-2">
<svg class="arrow-icon" id="arrow-{{ $detail->id }}" width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.5001 5.88654C12.6655 6.68745 12.6543 8.41186 11.4787 9.19762L3.59254 14.4684C2.25871 15.3599 0.470856 14.3969 0.481237 12.7926L0.550107 2.14951C0.560488 0.545226 2.36065 -0.394492 3.68284 0.514171L11.5001 5.88654Z" fill="#666666"/>
</svg>
</div>
                                                    

                                                    {{ $detail->program_title }}
                                                </div>
                                                <div class="trainer-name m-0">
                                                    @if ($detail->trainer)
                                                        @if ($detail->trainer->photo)
                                                            <img src="{{ asset('storage/' . $detail->trainer->photo) }}"
                                                                class="tr-trainee-avatar me-2">
                                                        @else
                                                            <img src="{{ asset('images/icons/user.svg') }}"
                                                                class="tr-trainee-avatar me-2">
                                                        @endif
                                                        المدرب: {{ $detail->trainer->getTranslation('name', 'ar') }}
                                                        {{ $detail->trainer->trainer?->getTranslation('last_name', 'ar') }}
                                                    @else
                                                        لم يتم تحديد مدرب
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="sessions-{{ $detail->id }}" class="sessions-container">
                                                <div class="content-training">
                                                @if ($detail->schedule_later)
                                                    <div class="no-sessions-message">
                                                        سيتم تحديد الجلسات لاحقاً بعد اكتمال عدد المشاركين.
                                                    </div>
                                                @elseif (empty($detail->trainingSchedules) || $detail->trainingSchedules->count() == 0)
                                                    <div class="no-sessions-message">
                                                        لم يتم إضافة جلسات بعد.
                                                    </div>
                                                @else
                                                    <div class="info-block-content-item-title">
                                                        الجدول الزمني للتدريب
                                                    </div>
                                                    <div class="session-content">
                                                        <table class="sessions-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>عنوان الجلسة</th>
                                                                    <th>اليوم</th>
                                                                    <th>التاريخ</th>
                                                                    <th>وقت الجلسة</th>
                                                                    <th>مدة الجلسة</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($detail->trainingSchedules as $schedule)
                                                                    <tr>
                                                                        <td>جلسة {{ $loop->index + 1 }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($schedule->session_date)->locale('ar')->dayName }}
                                                                        </td>
                                                                        <td>{{ $schedule->session_date }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($schedule->session_start_time)->format('H:i') }}
                                                                            -
                                                                            {{ \Carbon\Carbon::parse($schedule->session_end_time)->format('H:i') }}
                                                                        </td>
                                                                        <td>
                                                                            {{ \Carbon\Carbon::parse($schedule->session_start_time)->diffInMinutes(\Carbon\Carbon::parse($schedule->session_end_time)) }}
                                                                            دقيقة
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                              </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @if (!empty($training->assistantUsers) && $training->assistantUsers->count() > 0)
                            <div class="info-block">
                                <div class="info-block-title clickable-title"
                                    onclick="window.location.href='{{ route('orgTraining.assistants', $training->id) }}'">
                                    <span>مساعدو المدرب (الميسرون)</span>
                                </div>
                                <div class="info-block-content">
                                    @foreach ($training->assistantUsers as $assistant)
                                        <div class="trainer-profile">
                                            @if (!empty($assistant->photo))
                                                <img src="{{ asset('storage/' . $assistant->photo) }}" alt="صورة المساعد"
                                                    class="tr-trainee-avatar">
                                            @else
                                                <img src="{{ asset('images/icons/user.svg') }}" alt="مساعد"
                                                    class="tr-trainee-avatar">
                                            @endif
                                            <p>{{ $assistant->getTranslation('name', 'ar') }}
                                                {{ $assistant->assistant?->getTranslation('last_name', 'ar') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if (!empty($training_files))
                            <div class="info-block">
                                <div class="info-block-title clickable-title"
                                    onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                                    <span>مرفقات التدريب</span>
                                </div>
                                <div class="info-block-content">
                                    @foreach ($training_files as $file)
                                        <div class="info-block-content-item">
                                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                                            <div class="info-block-content-item-title" dir="ltr">
                                                <a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if (!empty($settings) && !empty($settings->payment_method))
                            <div class="info-block">
                                <div class="info-block-title clickable-title"
                                    onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                                    <span>آلية الدفع</span>
                                </div>
                                <div class="info-block-content bordered">
                                    {{ $settings->payment_method }}
                                </div>
                            </div>
                        @endif
                        <!-- الرسالة الترحيبية -->
                        <div class="welcome-box">
                            <div class="section-title clickable-title"
                                onclick="window.location.href='{{ route('orgTraining.settings', $training->id) }}'">
                                <h3 class="section-title">رسالة ترحيبية</h3>
                            </div>
                            <p>{{ $settings->welcome_message ?? 'لم يتم إدخال رسالة ترحيبية' }}</p>
                        </div>
                    </div>
                    <div class="input-group-2col mt-4 training-form-review-actions">
                        <div class="input-group">
                            <a href="{{ route('orgTraining.settings', $training->id) }}" class="pbtn pbtn-outlined-main">
                                السابق
                            </a>
                        </div>
                        <div class="input-group">
                            <button type="submit" class="pbtn pbtn-main piconed">
                                <span>تأكيد نشر التدريب</span>
                                <img src="{{ asset('images/arrow-left.svg') }}" alt="">
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        function toggleSessions(trainingId) {
            const sessionsDiv = document.getElementById(`sessions-${trainingId}`);
            const headerDiv = document.getElementById(`header-${trainingId}`);
            const arrowIcon = document.getElementById(`arrow-${trainingId}`);
            
            if (sessionsDiv.classList.contains('show')) {
                sessionsDiv.classList.remove('show');
                headerDiv.classList.remove('has-content');
                arrowIcon.classList.remove('rotated');
            } else {
                sessionsDiv.classList.add('show');
                headerDiv.classList.add('has-content');
                arrowIcon.classList.add('rotated');
                
                // إضافة تأثير حركي عند الفتح
                const content = sessionsDiv.querySelector('.session-content');
                if (content) {
                    content.style.animation = 'fadeIn 0.3s ease-in-out';
                }
            }
        }
    </script>
@endsection