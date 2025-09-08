@extends('frontend.layouts.master')
@section('title', 'التدريبات')
@section('css')
@endsection
@section('content')
    <!-- Blue Header Section -->
    <div class="blue-header full-width-header">
        <div class="container d-flex justify-content-start">
            <div class="col-12 col-lg-7 text-center text-lg-force-right">
                <div class="title-wrapper">
                    <h1 class="d-inline-block lh-base">
                        {{ $program->program_title ?? 'التدريب' }}
                            <span class="training-type ms-2">{{ $orgProgram->trainingClassification->name ?? '' }}</span>
                    </h1>
                </div>
                    <div class="trainer-name">
هذا التدريب جزء من المسار التدريبي
                      {{ $orgProgram->title ?? 'التدريب' }}
                </div>
                <div class="trainer-name">تم الإنشاء بواسطة:
                    @if ($orgProgram->organization->user)
                        <a href="{{ route('show_organization_profile', ['id' => $orgProgram->organization->user->id]) }}"
                            style="display: contents; text-decoration: none; color: inherit;">
                            <span class="text-decoration-underline">{{ $orgProgram->organization->user->getTranslation('name', 'ar') ?? 'غير محدد' }}</span></a>
                            

                            @else
                        <span>غير محدد</span>
                    @endif
                </div>
                <div class="training-meta d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start text-center text-lg-start">
                    <span class="mb-2 mb-sm-0">
                        <img src="{{ asset('images/cources/language.svg') }}" alt="لغة التدريب">
                        لغة التدريب: {{ $orgProgram->language?->name ?? 'غير محدد' }}
                    </span>
                    <span class="ms-sm-3">
                        <img src="{{ asset('images/cources/Training-type.svg') }}" alt="نوع البرنامج">
                        نوع البرنامج: {{ $orgProgram->programType?->name ?? 'غير محدد' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cards Container -->
    <div class="container">
        <div class="row flex-row-reverse flex-col-reverse">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            
            <!-- Small Card -->
            <div class="col-lg-4 order-lg-1">
                <div class="small-card">
                    @if ($orgProgram->AdditionalSetting?->profile_image)
                        <img src="{{ asset('storage/' . $orgProgram->AdditionalSetting->profile_image) }}"
                            class="square-image" alt="صورة التدريب">
                    @else
                        <img src="{{ asset('images/cources/training-default-img.svg') }}" class="square-image" alt="صورة التدريب">
                    @endif
                    
                    <div class="price-section mt-3">
                        <div class="price mb-3">
                            سعر التسجيل:
                            @php
                                $cost = $orgProgram->registrationRequirements?->cost ?? 0;
                            @endphp
                            @if ($cost > 0)
                                @if (floor($cost) == $cost)
                                    {{ number_format($cost, 0, '', ',') }}
                                @else
                                    {{ number_format($cost, 2, '.', ',') }}
                                @endif
                                {{ $orgProgram->registrationRequirements?->currency ?? '' }}
                            @else
                                مجاني
                            @endif
                        </div>
                        <div class="time-left">
                            <img class="pe-2" src="{{ asset('images/cources/calender-red.svg') }}" alt="سعر التسجيل">
                            @php
                                $deadline = \Carbon\Carbon::parse($orgProgram->registrationRequirements->application_deadline);
                                $now = \Carbon\Carbon::now();
                                $totalHours = $now->diffInHours($deadline, false);
                                $diffInDays = intdiv($totalHours, 24);
                                $diffInHours = $totalHours % 24;
                            @endphp
                            @if($totalHours > 0)
                                متبقي {{ $diffInDays }} يوم و {{ $diffInHours }} ساعة
                            @else
                                انتهى موعد التقديم
                            @endif
                        </div>
                    </div>
                    
                    <h5>تفاصيل التدريب</h5>
                    <div class="training-details">
                        <div>
                            <div class="mb-3">
                                <img src="{{ asset('images/training-details/calendar.svg') }}" alt="">
                                تاريخ انتهاء التقديم: 
                                {{ $orgProgram->registrationRequirements?->application_deadline 
                                    ? \Carbon\Carbon::parse($orgProgram->registrationRequirements->application_deadline)
                                        ->locale('ar')
                                        ->translatedFormat('d F Y')
                                    : 'غير معروف' }}
                            </div>

                            @if ($orgProgram->trainingLevel)
                                <div class="mb-3">
                                    <img class="pe-2" src="{{ asset('images/cources/level.svg') }}" alt="مستوى التدريب">
                                    مستوى التدريب: {{ $orgProgram->trainingLevel->name }}
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/type.svg') }}" alt="طريقة تقديم التدريب">
                                طريقة تقديم التدريب: {{ $orgProgram->program_presentation_method_id ?? 'غير محدد' }}
                            </div>
                            
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/clock2.svg') }}" alt="عدد الساعات">

                                عدد الساعات: {{ $program->duration_text }}
                            </div>
                            
                            @if ($orgProgram->registrationRequirements?->application_submission_method)
                                <div class="mb-3">
                                    <img class="pe-2" src="{{ asset('images/cources/Register.svg') }}" alt="طريقة التسجيل">
                                    طريقة التسجيل:
                                  
                                    {{ $orgProgram->registrationRequirements->application_submission_method == 'inside_platform' ? 'داخل المنصة' : 'خارج المنصة' }}
                                </div>
                            @endif
                            
                            @if ($orgProgram->registrationRequirements?->max_trainees)
                                <div class="mb-3">
                                    <img class="pe-2" src="{{ asset('images/cources/members.svg') }}" alt="العدد الأقصى للمشاركين">
                                    العدد الأقصى للمشاركين: {{ $orgProgram->registrationRequirements->max_trainees  == 0 ? 'لا يوجد عدد محدد' :$orgProgram->registrationRequirements->max_trainees . 'مشارك'}}

        
                                </div>
                            @endif
                            
                            @if ($orgProgram->country)
                                <div class="mb-3">
                                    <img class="pe-2" src="{{ asset('images/cources/location2.svg') }}" alt="مكان التدريب">
                                    مكان التدريب: {{ $orgProgram->country?->name ?? '' }} -
                                    {{ $orgProgram->city ?? '' }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row g-2">
<div class="col-12">
    <button type="button" class="custom-btn w-100"
        onclick="window.location='{{ route('org.training.show', $orgProgram->id) }}'">
        عرض البرنامج التدريبي ←
    </button>
</div>

                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-8 order-lg-2">
                <div class="large-card">
                    @php
                        $learningOutcomes = [];
                        if ($orgProgram->goals->count()) {
                            foreach ($orgProgram->goals as $goal) {
                                if (is_array($goal->learning_outcomes)) {
                                    $learningOutcomes = array_merge($learningOutcomes, $goal->learning_outcomes);
                                } else {
                                    $decoded = json_decode($goal->learning_outcomes, true);
                                    if (is_array($decoded)) {
                                        $learningOutcomes = array_merge($learningOutcomes, $decoded);
                                    }
                                }
                            }
                        }
                        
                        $details = [
                            'ما الذي سيتعلمه المشاركون في هذا التدريب' => $learningOutcomes,
                        ];
                    @endphp
                    
                    @foreach ($details as $title => $items)
                        <div class="info-box">
                            <h4 class="info-title">{{ $title }}</h4>
                            @if (!empty($items))
                                <ul class="list-unstyled">
                                    @foreach ($items as $item)
                                        <li class="d-flex align-items-start mb-2">
                                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check"
                                                class="me-2" width="20" height="20">
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">لا توجد بيانات متاحة لهذا القسم.</p>
                            @endif
                        </div>
                    @endforeach
                    
                    @php
                        $requirements = is_array($orgProgram->registrationRequirements->requirements) 
                            ? $orgProgram->registrationRequirements->requirements 
                            : json_decode($orgProgram->registrationRequirements->requirements, true) ?? [];
                        
                        $benefits = is_array($orgProgram->registrationRequirements->benefits) 
                            ? $orgProgram->registrationRequirements->benefits 
                            : json_decode($orgProgram->registrationRequirements->benefits, true) ?? [];
                            
                        $details = [
                            'المتطلبات او الشروط اللازمة للالتحاق بالتدريب' => $requirements,
                            'ميزات التدريب' => $benefits,
                        ];
                        
                        $hasAnyData = collect($details)->some(function ($items) {
                            $items = is_array($items) ? $items : json_decode($items, true);
                            $items = array_filter($items, fn($value) => !empty($value));
                            return !empty($items);
                        });
                    @endphp
                    
                    @if ($hasAnyData)
                        <div class="info-box">
                            <h4 class="info-title mt-1">وصف التدريب</h4>
                            <p>{{ $orgProgram->program_description ?? 'لا يوجد وصف متاح' }}</p>
                            
                            <!-- عرض الفئة المستهدفة من التدريب -->
                            @if (!empty($orgProgram->goals) && $orgProgram->goals->count() > 0)
                                @php
                                    $goals = $orgProgram->goals->first();
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
                                    $workStatus = is_array($goals->work_status)
                                        ? $goals->work_status
                                        : json_decode($goals->work_status, true) ?? [];
                                @endphp
                                <div class="info-block">
                                    <div class="info-block-title clickable-title"
                                        onclick="window.location.href='{{ route('orgTraining.goals', $orgProgram->id) }}'">
                                        <span>الفئة المستهدفة من المسار التدريبي</span>
                                    </div>
                                    <div class="info-block-content">
                                        @if (!empty($educationLevels) && is_array($educationLevels) && count($educationLevels) > 0)
                                            <div class="audience-question">
                                                <div class="audience-question-title">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
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
                                        
                                        @if (!empty($workStatus) && is_array($workStatus) && count($workStatus) > 0)
                                            <div class="audience-question">
                                                <div class="audience-question-title">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                                    الحالة الوظيفية
                                                </div>
                                                <div class="audience-tags">
                                                    @foreach ($workStatus as $status)
                                                        @if ($status)
                                                            <span class="audience-tag">
                                                                @if ($status === 'working')
                                                                    يعمل
                                                                @elseif ($status === 'not_working')
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
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
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
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
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
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
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
                            
                            @foreach ($details as $title => $items)
                                @php
                                    $items = is_array($items) ? $items : json_decode($items, true);
                                    $items = array_filter($items, fn($value) => !empty($value));
                                @endphp
                                @if (!empty($items))
                                    <div class="">
                                        <h4 class="info-title mt-5">{{ $title }}</h4>
                                        <ul class="list-unstyled">
                                            @foreach ($items as $item)
                                                <li class="d-flex align-items-start mb-2">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" class="me-2" width="20" height="20">
                                                    <span>{{ $item }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <!-- الجلسات التدريبية -->
                    <div class="container mt-5">
                        <div class="mt-4 session-schedule">
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
                                                @if (!$program->trainingSchedules || $program->trainingSchedules->isEmpty())
                                                    <tr>
                                                        <td colspan="4" class="text-center">لا توجد جلسات لهذا البرنامج.</td>
                                                    </tr>
                                                @else
                                                    @foreach ($program->trainingSchedules as $session)
                                                        @php
                                                            $sessionDate = \Carbon\Carbon::parse($session->session_date);
                                                            $sessionDuration = \Carbon\Carbon::parse($session->session_start_time)
                                                                ->diffInMinutes(\Carbon\Carbon::parse($session->session_end_time));
                                                            $durationHours = floor($sessionDuration / 60);
                                                            $durationMinutes = $sessionDuration % 60;
                                                            $durationText = $durationHours > 0 ? $durationHours . ' ساعة ' : '';
                                                            $durationText .= $durationMinutes > 0 ? $durationMinutes . ' دقيقة' : '';
                                                        @endphp
                                                        <tr style="border-bottom: 1px solid #dee2e6;">
                                                            <td class="p-3 text-center">
                                                                {{ $sessionDate->locale('ar')->dayName }}
                                                            </td>
                                                            <td class="p-3 text-center">
                                                                {{ $sessionDate->locale('ar')->translatedFormat('d F') }}
                                                            </td>
                                                            <td class="p-3 text-center">
                                                                {{ \Carbon\Carbon::parse($session->session_start_time)->format('g:i A') }} -
                                                                {{ \Carbon\Carbon::parse($session->session_end_time)->format('g:i A') }}
                                                            </td>
                                                            <td class="p-3 text-center">
                                                                {{ $durationText }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- مقدم التدريب -->
                    <div class="info-box mt-5">
                        <h4 class="info-title">المدرب</h4>
                        @if ($program->Trainer)
                            <div class="trainer-card d-flex flex-column flex-md-row align-items-start gap-4">
                                <a href="{{ route('show_trainer_profile', ['id' => $program->Trainer->id]) }}"
                                    style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                                    <div class="trainer-image text-center">
                                        @if ($program->Trainer->photo)
                                            <img src="{{ asset('storage/' . $program->Trainer->photo) }}"
                                                alt="{{ $program->Trainer->name }}" class="custom-rounded" width="120"
                                                height="120">
                                        @else
                                            <img src="{{ asset('images/icons/user.svg') }}" alt=""
                                                class="custom-rounded" width="120" height="120">
                                        @endif
                                    </div>
                                    <div class="text-start align-self-center">
                                        <h5 class="trainer-name mb-1">{{ $program->Trainer->getTranslation('name', 'ar') }}
                                            {{ $program->Trainer->trainer?->getTranslation('last_name', 'ar') ?? '' }}</h5>
                                        <p class="trainer-position mb-2">{{ $program->Trainer->trainer?->headline ?? '' }}</p>
                                        <div class="trainer-rating mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($averageTrainerRating))
                                                    <img src="{{ asset('images/cources/Star.svg') }}" alt="نجمة">
                                                @elseif ($i - $averageTrainerRating < 1)
                                                    <img src="{{ asset('images/cources/Star-half.svg') }}" alt="نصف نجمة">
                                                @else
                                                    <img src="{{ asset('images/cources/Star-gray.svg') }}" alt="نجمة رمادية">
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <p class="trainer-bio mt-3">{{ $program->Trainer->bio ?? 'لا يوجد نبذة متاحة' }}</p>
                            
                            @if (count($orgProgram->assistantUsers) > 0)
                                <h5 class="section-title mt-5">ميسرو التدريب</h5>
                                <div class="facilitators-container d-flex flex-column flex-md-row gap-4">
                                    @foreach ($orgProgram->assistantUsers as $assistant)
                                        <div class="facilitator-card d-flex align-items-center gap-3">
                                            @if ($assistant->photo)
                                                <img src="{{ asset('storage/' . $assistant->photo) }}"
                                                    alt=""
                                                    class="rounded-circle" width="60" height="60">
                                            @else
                                                <img src="{{ asset('images/icons/user.svg') }}"
                                                    alt=""
                                                    class="rounded-circle" width="60" height="60">
                                            @endif
                                            <span class="facilitator-name">{{ $assistant->getTranslation('name', 'ar') }}
                                                {{ $assistant->assistant?->getTranslation('last_name', 'ar') ?? '' }} </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <p>لا يوجد مدرب محدد لهذا التدريب.</p>
                        @endif
                    </div>
                    
                    <!-- معلومات المنظمة -->
                    <div class="info-box mt-5">
                        <h4 class="info-title">نبذة عن المؤسسة المُعلنة</h4>
                        <div class="trainer-card d-flex flex-column flex-md-row align-items-start gap-4">
                            <div class="trainer-image text-center">
                                @if ($orgProgram->organization->user->photo)
                                    <img src="{{ asset('storage/' . $orgProgram->organization->user->photo) }}"
                                        alt="{{ $orgProgram->organization->user->name }}" class="custom-rounded" width="120"
                                        height="120">
                                @else
                                    <img src="{{ asset('images/icons/user.svg') }}" alt="{{ $orgProgram->organization->user->name }}"
                                        class="custom-rounded" width="120" height="120">
                                @endif
                            </div>
                            <div class="text-start align-self-center">
                                <h5 class="trainer-name mb-1">{{ $orgProgram->organization->user->getTranslation('name', 'ar') }}</h5>
                                <p class="trainer-position mb-2">{{ $orgProgram->organization->type->name }}</p>
                            </div>
                        </div>
                        <p class="trainer-bio mt-3">{{ $orgProgram->organization->user->bio ?? 'لا يوجد نبذة متاحة' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal دعوة صديق -->
    <div class="modal fade" id="inviteFriendModal" tabindex="-1" aria-labelledby="inviteFriendModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 justify-content-end">
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-header border-0 pb-0 position-relative">
                    <h5 class="modal-title fw-bold w-100 text-start mb-4" id="inviteFriendModalLabel">ادعُ أصدقاءك
                        للتدريب!</h5>
                </div>
                <div class="modal-body pt-0">
                    <p class="text-muted text-start mb-4">
                        شارك هذا التدريب مع أصدقائك المهتمين وكونوا جزءًا من التجربة معًا. التدريب متاح للجميع، ونعتقد أنك
                        قد تكون أفضل من يوصي به.
                    </p>
                    <div class="social-share">
                        <div class="d-flex justify-content-start flex-wrap gap-3 mb-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                target="_blank" 
                                class="btn btn-social btn-facebook p-2" 
                                title="شارك على فيسبوك">
                                <img src="{{ asset('images/cources/facebook.svg') }}" alt="فيسبوك">
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode('تعالوا شاركوا هذا التدريب الرائع!') }}&url={{ urlencode(url()->current()) }}" 
                                target="_blank" 
                                class="btn btn-social btn-twitter p-2" 
                                title="شارك على تويتر">
                                <img src="{{ asset('images/cources/twitter.svg') }}" alt="تويتر">
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                                target="_blank" 
                                class="btn btn-social btn-linkedin p-2" 
                                title="شارك على لينكدإن">
                                <img src="{{ asset('images/cources/linkedin.svg') }}" alt="لينكدإن">
                            </a>
                            <a href="mailto:?subject={{ urlencode('دعوة للمشاركة في تدريب') }}&body={{ urlencode('شاركونا هذا التدريب الرائع: ' . url()->current()) }}" 
                                class="btn btn-social btn-email p-2" 
                                title="شارك عبر الإيميل">
                                <img src="{{ asset('images/cources/email.svg') }}" alt="إيميل">
                            </a>
                            <a href="https://wa.me/?text={{ urlencode('تعالوا شاركوا هذا التدريب الرائع: ' . url()->current()) }}" 
                                target="_blank" 
                                class="btn btn-social btn-whatsapp p-2" 
                                title="شارك على واتساب">
                                <img src="{{ asset('images/cources/SMS.svg') }}" alt="واتساب">
                            </a>
                        </div>
                    </div>
                    <div class="share-section mb-4">
                        <div class="row align-items-center g-2">
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="shareLinkInput" readonly
                                    value="{{ url()->current() }}">
                            </div>
                            <div class="col-md-3">
                                <button class="custom-btn w-100" type="button" id="copyLinkBtn">
                                    <i class="far fa-copy me-1"></i> نسخ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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
                        التدريب؟</h5>
                    <p class="text-muted mb-4">
                        عند تأكيد الاشتراك، سيتم إضافتك إلى قائمة المشاركين في تدريب "{{ $program->program_title ?? '' }}".<br>
                        قد يتطلب الأمر موافقة من المدرب أو خطوات إضافية.
                    </p>
                </div>
                <div class="modal-footer border-0 d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <form class="flex-fill" style="padding: 0px"
                        action="{{ route('enrolle', ['program_id' => $program->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="custom-btn flex-fill">نعم، أؤكد انضمامي</button>
                    </form>
                    <button type="button" class="btn-cancel flex-fill" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // الحصول على الحقل وزر النسخ
            const shareLinkInput = document.getElementById("shareLinkInput");
            const copyLinkBtn = document.getElementById("copyLinkBtn");
            // وضع رابط الصفحة الحالية في الحقل
            shareLinkInput.value = window.location.href;
            // نسخ الرابط عند الضغط على الزر
            copyLinkBtn.addEventListener("click", function() {
                shareLinkInput.select();
                document.execCommand("copy");
                // تغيير نص الزر لفترة قصيرة للتأكيد
                copyLinkBtn.innerHTML = '<i class="far fa-check me-1"></i> تم النسخ!';
                setTimeout(() => {
                    copyLinkBtn.innerHTML = '<i class="far fa-copy me-1"></i> نسخ';
                }, 1500);
            });
        });
    </script>
@endsection