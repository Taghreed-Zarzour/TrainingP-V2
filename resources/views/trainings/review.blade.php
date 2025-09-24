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
            cursor: pointer;
        }
    </style>
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        <!-- خطوات التقدم -->
                        @include('trainings.partials.stepper', [
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

                    <form method="POST" action="{{ route('training.publish', $training->id) }}"
                        class="training-form-review">
                        @csrf
                        <div class="grid">
                            <div class="training-info">
                                <h4 class="clickable-title"
                                    onclick="window.location.href='{{ route('training.basic', $training->id) }}'">
                                    معلومات التدريب الأساسية
                                </h4>

                                @if (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->profile_image))
                                    @php
                                        $imagePath = str_contains(
                                            $training->AdditionalSetting->profile_image,
                                            'storage/',
                                        )
                                            ? $training->AdditionalSetting->profile_image
                                            : 'storage/' . $training->AdditionalSetting->profile_image;
                                    @endphp
                                    <img src="{{ asset($imagePath) }}" alt="صورة التدريب">
                                @else
                                    <img src="{{ asset('images/cources/training-default-img.svg') }}" alt="صورة افتراضية">
                                @endif

                                @if (!(auth()->user()->userType?->type === 'مؤسسة'))
                                    <div>
                                        <h5>المدرب: {{ auth()->user()->getTranslation('name', 'ar') }}
                                            {{ auth()->user()->trainer?->getTranslation('last_name', 'ar') }}</h5>
                                    </div>
                                @endif
                                @if (!empty($training) && method_exists($training, 'assistants') && $training->assistants()->exists())
                                    <h5 class="clickable-title"
                                        onclick="window.location.href='{{ route('training.team', $training->id) }}'">

                                        @if (!(auth()->user()->userType?->type === 'مؤسسة'))
                                            المدرب المشارك:
                                        @else
                                            المدربون المشاركون:
                                            <br>
                                        @endif
                                        @php
                                            $allTrainerIds = [];
                                            $assistants = $training->assistants()->get(); // الحصول على المجموعة بشكل صريح

                                            foreach ($assistants as $assistant) {
                                                if (method_exists($assistant, 'getAllTrainers')) {
                                                    $trainerIds = $assistant->getAllTrainers();
                                                    if (is_array($trainerIds)) {
                                                        $allTrainerIds = array_merge($allTrainerIds, $trainerIds);
                                                    }
                                                }
                                            }

                                            $allTrainerIds = array_unique($allTrainerIds);
                                            $trainers = collect();

                                            if (!empty($allTrainerIds)) {
                                                $trainers = \App\Models\User::whereIn('id', $allTrainerIds)->get();
                                            }
                                        @endphp

                                        @foreach ($trainers as $trainer)
                                            {{ $trainer->getTranslation('name', 'ar') }}
                                            {{ $trainer->trainer?->getTranslation('last_name', 'ar') }} <br>
                                        @endforeach
                                    </h5>
                                @endif
                            </div>
                            <div class="training-details">
                                @if (!empty($training->language))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.basic', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/global.svg') }}" alt="">
                                        <p>لغة التدريب: {{ $training->language->name }}</p>
                                    </div>
                                @endif

                                @if (!empty($training->programType))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.basic', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/type.svg') }}" alt="">
                                        <p>نوع البرنامج: {{ $training->programType->name }}</p>
                                    </div>
                                @endif

                                @if (!empty($training->trainingClassification))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.basic', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/category.svg') }}" alt="">
                                        <p>تصنيف التدريب: {{ $training->trainingClassification->name }}</p>
                                    </div>
                                @endif

                                @if (!empty($training->trainingLevel))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.basic', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/level.svg') }}" alt="">
                                        <p>مستوى التدريب: {{ $training->trainingLevel->name }}</p>
                                    </div>
                                @endif

                                @if (!empty($training->program_presentation_method_id))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.basic', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/method.svg') }}" alt="">
                                        <p>طريقة تقديم التدريب: {{ $training->program_presentation_method_id }}</p>
                                    </div>
                                @endif

                                @if ($training->schedules_later)
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.schedule', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/session.svg') }}" alt="">
                                        <p>الجلسات: سيتم تحديدها لاحقاً</p>
                                    </div>
                                @elseif (!empty($training->sessions) && $training->sessions->count() > 0)
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.schedule', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/session.svg') }}" alt="">
                                        <p>عدد الجلسات: {{ $training->sessions->count() }} جلسات</p>
                                    </div>
                                @endif

                                @if (!empty($application_submission_method_label))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.settings', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/register-type.svg') }}" alt="">
                                        <p>طريقة التسجيل: {{ $application_submission_method_label }}</p>
                                    </div>
                                @endif

                                @if (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->max_trainees))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.settings', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/participants.svg') }}" alt="">
                                        <p>العدد الأقصى للمشاركين: {{ $training->AdditionalSetting->max_trainees == 0 ? 'لا يوجد عدد محدد' : $training->AdditionalSetting->max_trainees . 'مشارك' }}

                                        </p>
                                    </div>
                                @endif

                                @if (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->country))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.settings', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/location.svg') }}" alt="">
                                        <p>مكان التدريب:
                                            {{ $training->AdditionalSetting->country->name }}{{ !empty($training->AdditionalSetting->city) ? ', ' . $training->AdditionalSetting->city : '' }}
                                        </p>
                                    </div>
                                @endif

                                @if (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->application_deadline))
                                    <div class="training-details-item clickable-title"
                                        onclick="window.location.href='{{ route('training.settings', $training->id) }}'">
                                        <img src="{{ asset('images/training-details/calendar.svg') }}" alt="">
                                        <p>تاريخ انتهاء التقديم:
                                            {{ $training?->AdditionalSetting?->application_deadline
                                                ? \Carbon\Carbon::parse($training->AdditionalSetting->application_deadline)->locale('ar')->translatedFormat('d F Y')
                                                : 'غير معروف' }}
                                        </p>
                                    </div>
                                @endif

                                <div class="training-price clickable-title"
                                    onclick="window.location.href='{{ route('training.settings', $training->id) }}'">
                                    <p class="training-price-label">سعر الاشتراك</p>
                                    <p class="training-price-value">
                                        @if (
                                            !empty($training->AdditionalSetting) &&
                                                !empty($training->AdditionalSetting->is_free) &&
                                                $training->AdditionalSetting->is_free)
                                            مجاني
                                        @elseif (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->cost))
                                            @php
                                                $cost = $training->AdditionalSetting->cost ?? 0;
                                            @endphp
                                            @if ($cost > 0)
                                                @if (floor($cost) == $cost)
                                                    {{ number_format($cost, 0, '', ',') }}
                                                @else
                                                    {{ number_format($cost, 2, '.', ',') }}
                                                @endif
                                                {{ $training->AdditionalSetting->currency ?? '' }}
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
                                    onclick="window.location.href='{{ route('training.basic', $training->id) }}'">
                                    <span>وصف التدريب</span>
                                </div>
                                <div class="info-block-content">
                                    {{ $training->description ?? 'لم يتم إدخال وصف للتدريب' }}
                                </div>
                            </div>

                            @php
                                // الحصول على بيانات الفئة المستهدفة من جدول التفاصيل
                                $trainingDetail = $training->detail ?? null;
                                $targetAudienceData = [];

                                if ($trainingDetail) {
                                    $targetAudienceData = [
                                        'education_level_id' => is_array($trainingDetail->education_level_id)
                                            ? $trainingDetail->education_level_id
                                            : json_decode($trainingDetail->education_level_id ?? '[]', true),
                                        'work_status' => is_array($trainingDetail->work_status)
                                            ? $trainingDetail->work_status
                                            : json_decode($trainingDetail->work_status ?? '[]', true),
                                        'work_sector_id' => is_array($trainingDetail->work_sector_id)
                                            ? $trainingDetail->work_sector_id
                                            : json_decode($trainingDetail->work_sector_id ?? '[]', true),
                                        'job_position' => is_array($trainingDetail->job_position)
                                            ? $trainingDetail->job_position
                                            : json_decode($trainingDetail->job_position ?? '[]', true),
                                        'country_id' => is_array($trainingDetail->country_id)
                                            ? $trainingDetail->country_id
                                            : json_decode($trainingDetail->country_id ?? '[]', true),
                                    ];
                                }
                            @endphp

                            @if (
                                !empty($targetAudienceData) &&
                                    (count($targetAudienceData['education_level_id'] ?? []) > 0 ||
                                        count($targetAudienceData['work_status'] ?? []) > 0 ||
                                        count($targetAudienceData['work_sector_id'] ?? []) > 0 ||
                                        count($targetAudienceData['job_position'] ?? []) > 0 ||
                                        count($targetAudienceData['country_id'] ?? []) > 0))
                                <div class="info-block">
                                    <div class="info-block-title clickable-title"
                                        onclick="window.location.href='{{ route('training.goals', $training->id) }}'">
                                        <span>الفئة المستهدفة من التدريب</span>
                                    </div>
                                    <div class="info-block-content">
                                        @if (
                                            !empty($targetAudienceData['education_level_id']) &&
                                                is_array($targetAudienceData['education_level_id']) &&
                                                count($targetAudienceData['education_level_id']) > 0)
                                            <div class="audience-question">
                                                <div class="audience-question-title">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                                    المستوى العلمي
                                                </div>
                                                <div class="audience-tags">
                                                    @foreach ($targetAudienceData['education_level_id'] as $levelId)
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

                                        @if (
                                            !empty($targetAudienceData['work_status']) &&
                                                is_array($targetAudienceData['work_status']) &&
                                                count($targetAudienceData['work_status']) > 0)
                                            <div class="audience-question">
                                                <div class="audience-question-title">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                                    الحالة الوظيفية
                                                </div>
                                                <div class="audience-tags">
                                                    @foreach ($targetAudienceData['work_status'] as $work_status)
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

                                        @if (
                                            !empty($targetAudienceData['work_sector_id']) &&
                                                is_array($targetAudienceData['work_sector_id']) &&
                                                count($targetAudienceData['work_sector_id']) > 0)
                                            <div class="audience-question">
                                                <div class="audience-question-title">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                                    قطاع العمل
                                                </div>
                                                <div class="audience-tags">
                                                    @foreach ($targetAudienceData['work_sector_id'] as $sectorId)
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

                                        @if (
                                            !empty($targetAudienceData['job_position']) &&
                                                is_array($targetAudienceData['job_position']) &&
                                                count($targetAudienceData['job_position']) > 0)
                                            <div class="audience-question">
                                                <div class="audience-question-title">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}"
                                                        class="me-2">
                                                    المستوى الوظيفي
                                                </div>
                                                <div class="audience-tags">
                                                    @foreach ($targetAudienceData['job_position'] as $position)
                                                        <span class="audience-tag">{{ $position }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if (
                                            !empty($targetAudienceData['country_id']) &&
                                                is_array($targetAudienceData['country_id']) &&
                                                count($targetAudienceData['country_id']) > 0)
                                            <div class="audience-question">
                                                <div class="audience-question-title">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}"
                                                        class="me-2">
                                                    الجنسية/ المنطقة
                                                </div>
                                                <div class="audience-tags">
                                                    @foreach ($targetAudienceData['country_id'] as $countryId)
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

                            @if (!empty($learning_outcomes))
                                <div class="info-block">
                                    <div class="info-block-title clickable-title"
                                        onclick="window.location.href='{{ route('training.goals', $training->id) }}'">
                                        <span>ما الذي سيتعلمه المشاركون في هذا التدريب</span>
                                    </div>
                                    <div class="info-block-content">
                                        @foreach ($learning_outcomes as $item)
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
                                        onclick="window.location.href='{{ route('training.goals', $training->id) }}'">
                                        <span>المتطلبات أو الشروط اللازمة للالتحاق بالتدريب</span>
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

                            @php
                                $filteredBenefits = array_filter($benefits, function ($item) {
                                    return trim($item) !== '';
                                });
                            @endphp

                            @if (!empty($filteredBenefits))
                                <div class="info-block">
                                    <div class="info-block-title clickable-title"
                                        onclick="window.location.href='{{ route('training.goals', $training->id) }}'">
                                        <span>ميزات التدريب</span>
                                    </div>
                                    <div class="info-block-content">
                                        @foreach ($filteredBenefits as $item)
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
                            <div class="info-block">
                                <div class="info-block-title clickable-title"
                                    onclick="window.location.href='{{ route('training.schedule', $training->id) }}'">
                                    <span>جدولة الجلسات</span>
                                </div>
                                <div class="info-block-content">
                                    @if ($training->schedules_later)
                                        <div class="info-block-content-item">
                                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                                            <div class="info-block-content-item-title">
                                                عدد الجلسات {{ $training->num_of_session }} جلسة
                                            </div>
                                        </div>

                                        <div class="info-block-content-item">
                                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                                            <div class="info-block-content-item-title">
                                                عدد الساعات
                                                {{ rtrim(rtrim(number_format($training->num_of_hours, 1), '0'), '.') }}
                                                ساعة
                                            </div>
                                        </div>
                                    @elseif (empty($training->sessions) || $training->sessions->count() == 0)
                                        <div class="no-sessions-message">
                                            لم يتم إضافة جلسات بعد. يمكنك إضافتها لاحقاً من خلال صفحة تعديل التدريب.
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>اليوم</th>
                                                        <th>التاريخ</th>
                                                        <th>وقت الجلسة</th>
                                                        <th>مدة الجلسة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($training->sessions as $s)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($s->session_date)->locale('ar')->dayName }}
                                                            </td>
                                                            <td>{{ $s->session_date }}</td>
                                                            <td> {{ formatTimeArabic($s->session_start_time) }} -
                                                                {{ formatTimeArabic($s->session_end_time) }}</td>
                                                            <td>
                                                                {{ calculateDurationArabic($s->session_start_time, $s->session_end_time) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if (!empty($training) && $training->assistants)
                                @php
                                    $assistant = $training->assistants;
                                    $allAssistantIds = method_exists($assistant, 'getAllAssistants')
                                        ? $assistant->getAllAssistants()
                                        : [];
                                    $assistantsList = !empty($allAssistantIds)
                                        ? \App\Models\User::whereIn('id', $allAssistantIds)->get()
                                        : collect();
                                @endphp

                                @if ($assistantsList->count() > 0)
                                    <div class="info-block">
                                        <div class="info-block-title clickable-title"
                                            onclick="window.location.href='{{ route('training.team', $training->id) }}'">
                                            <span>مساعدو المدرب (الميسرون)</span>
                                        </div>
                                        <div class="info-block-content">
                                            @foreach ($assistantsList as $assistant)
                                                <div class="trainer-profile">
                                                    @if (!empty($assistant->photo))
                                                        <img src="{{ asset('storage/' . $assistant->photo) }}"
                                                            alt="صورة المساعد" class="tr-trainee-avatar">
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
                            @endif

                            @if (!empty($training_files))
                                <div class="info-block">
                                    <div class="info-block-title clickable-title"
                                        onclick="window.location.href='{{ route('training.settings', $training->id) }}'">
                                        <span>مرفقات التدريب</span>
                                    </div>
                                    <div class="info-block-content">
                                        @foreach ($training_files as $file)
                                            <div class="info-block-content-item">
                                                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                                                <div class="info-block-content-item-title" dir="ltr">
                                                    <a href="{{ asset('storage/' . $file) }}"
                                                        target="_blank">{{ basename($file) }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->payment_method))
                                <div class="info-block">
                                    <div class="info-block-title clickable-title"
                                        onclick="window.location.href='{{ route('training.settings', $training->id) }}'">
                                        <span>آلية الدفع</span>
                                    </div>
                                    <div class="info-block-content bordered">
                                        {{ $training->AdditionalSetting->payment_method }}
                                    </div>
                                </div>
                            @endif

                            <!-- الرسالة الترحيبية -->
                            <div class="welcome-box">
                                <div class="section-title clickable-title"
                                    onclick="window.location.href='{{ route('training.settings', $training->id) }}'">

                                    <h3 class="section-title">رسالة ترحيبية</h3>
                                </div>
                                <p>{{ $welcome_message }}</p>
                            </div>
                        </div>

                        <div class="input-group-2col mt-4 training-form-review-actions">
                            <div class="input-group">
                                <a href="{{ route('training.settings', $training->id) }}"
                                    class="pbtn pbtn-outlined-main">
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
        </div>
    </main>
@endsection
@section('scripts')
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <script>
        // يمكنك إضافة أي سكريبتات إضافية هنا إذا لزم الأمر
    </script>
@endsection
