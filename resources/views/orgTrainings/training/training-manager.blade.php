@extends('frontend.layouts.master')
@section('title', $OrgProgramDetail->trainingProgram->title ?? 'تفاصيل التدريب')

@section('content')
    <!-- Blue Header Section -->
    <div class="blue-header full-width-header mt-4">
        <div class="container d-flex justify-content-center">
            <div class="col-12 col-lg-7 text-center">
                <div class="title-wrapper">
                    <h1 class="d-inline-block lh-base">إدارة التدريب</h1>
                </div>
                <div class="mb-4">
                    <div class="mb-4" id="breadcrumb-tab-title">
                        المسارات التدريبية/{{ $OrgProgramDetail->trainingProgram->title }}/<span id="current-tab-name">إحصائيات</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-xxl">
        <div class="training-card">
            <div class="training-header">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-4 image-column">
                        <div class="image-wrapper">
                            <div class="training-image-container">
                                @if ($OrgProgramDetail->trainingProgram->registrationRequirements && $OrgProgramDetail->trainingProgram->registrationRequirements->profile_image)
                                    <img src="{{ asset('storage/' . $OrgProgramDetail->trainingProgram->registrationRequirements->profile_image) }}"
                                        class="training-image" alt="صورة التدريب">
                                @else
                                    <img src="{{ asset('images/cources/training-default-img.svg') }}" class="training-image"
                                        alt="صورة التدريب">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- المعلومات -->
                    <div class="col-lg-8 content-column">
                        <div class="info-container h-100">
                            <div class="row h-100">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <img src="/images/cources/type-program.svg" class="info-icon" alt="نوع البرنامج">
                                        <span>نوع البرنامج: {{ $OrgProgramDetail->trainingProgram->programType->name ?? 'غير محدد' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/level.svg" class="info-icon" alt="مستوى التدريب">
                                        <span>مستوى التدريب: {{ $OrgProgramDetail->trainingProgram->programLevel ?? 'غير محدد' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/clock2.svg" class="info-icon" alt="عدد الجلسات">
                                        <span>عدد الجلسات: {{ count($OrgProgramDetail->trainingSchedules) }} جلسات</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/members.svg" class="info-icon" alt="العدد الأقصى">
                                        <span>العدد الأقصى للمشاركين:
                                            {{ $OrgProgramDetail->trainingProgram->registrationRequirements->max_trainees == 0 ? 'لا يوجد عدد محدد' : $OrgProgramDetail->trainingProgram->registrationRequirements->max_trainees . 'مشارك' }}
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/location2.svg" class="info-icon" alt="مكان التدريب">
                                        <span>مكان التدريب: {{ $OrgProgramDetail->trainingProgram->country->name ?? 'غير محدد' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/calender-primary.svg" class="info-icon" alt="تاريخ الانتهاء">
                                        <span>تاريخ انتهاء التقديم:
                                            {{ \Carbon\Carbon::parse($OrgProgramDetail->trainingProgram->registrationRequirements->application_deadline)->locale('ar')->translatedFormat('j/F/Y') ?? 'غير محدد' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <img src="/images/cources/language-primary.svg" class="info-icon" alt="لغة التدريب">
                                        <span>لغة التدريب: {{ $OrgProgramDetail->trainingProgram->language->name ?? 'غير محدد' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/calssification.svg" class="info-icon" alt="تصنيف التدريب">
                                        <span>تصنيف التدريب: {{ $orgTrainingClassification->first() ?? 'غير محدد' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/type.svg" class="info-icon" alt="طريقة التقديم">
                                        <span>طريقة تقديم التدريب: {{ $OrgProgramDetail->trainingProgram->program_presentation_method_id ?? 'غير محدد' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/Register.svg" class="info-icon" alt="طريقة التسجيل">
                                        <span>طريقة التسجيل:
                                            {{ $OrgProgramDetail->trainingProgram->registrationRequirements->application_submission_method ?? 'غير محدد' }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- سعر الاشتراك -->
                            <div class="price-divider"></div>
                            <div class="price-section flex-row">
                                <strong>سعر الاشتراك</strong>
                                <strong class="price">
                                    @php
                                        $cost = $OrgProgramDetail->trainingProgram->registrationRequirements->cost ?? 0;
                                    @endphp
                                    @if ($cost > 0)
                                        @if (floor($cost) == $cost)
                                            {{ number_format($cost, 0, '', ',') }}
                                        @else
                                            {{ number_format($cost, 2, '.', ',') }}
                                        @endif
                                        {{ $OrgProgramDetail->trainingProgram->registrationRequirements->currency ?? '' }}
                                    @else
                                        مجاني
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- عنوان التدريب واسم المدرب -->
            <div class="info-section">
                <h1 class="training-title m-0">{{ $OrgProgramDetail->trainingProgram->title }}</h1>
                <p class="trainer-name">المدرب: {{ $OrgProgramDetail->trainer->getTranslation('name', 'ar') }}</p>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            
            <!-- التبويبات -->
            <div class="container-fluid py-3">
                <ul class="nav simple-tabs justify-content-around mb-4" id="mainTabs" role="tablist"
                    data-bs-target="#mainTabsContent">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="stats-tab" data-bs-toggle="tab" href="#stats" role="tab"
                            aria-controls="stats" aria-selected="true">
                            إحصائيات
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="sessions-tab" data-bs-toggle="tab" href="#sessions" role="tab"
                            aria-controls="sessions" aria-selected="false">
                            الجلسات التدريبية
                        </a>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link" id="registrants-tab" data-bs-toggle="tab" href="#registrants"
                            role="tab" aria-controls="registrants" aria-selected="false">
                            المسجلون
                        </a>
                    </li> --}}
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="trainees-tab" data-bs-toggle="tab" href="#trainees" role="tab"
                            aria-controls="trainees" aria-selected="false">
                            المتدربون
                        </a>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                            aria-controls="info" aria-selected="false">
                            معلومات التدريب
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#attachments"
                            role="tab" aria-controls="attachments" aria-selected="false">
                            المرفقات
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link" id="assistants-tab" data-bs-toggle="tab" href="#assistants" role="tab"
                            aria-controls="assistants" aria-selected="false">
                            مساعدو المدرب
                        </a>
                    </li> --}}
                </ul>
                <div class="tab-content" id="mainTabsContent">
                    <div class="tab-pane fade show active px-5" id="stats" role="tabpanel"
                        aria-labelledby="stats-tab">
                        @include('orgTrainings.training.tabs.statistics')
                    </div>
                    <div class="tab-pane fade  px-5" id="sessions" role="tabpanel" aria-labelledby="sessions-tab">
                        @include('orgTrainings.training.tabs.sessions')
                    </div>
                    {{-- <div class="tab-pane fade" id="registrants" role="tabpanel" aria-labelledby="registrants-tab">
                        @include('orgTrainings.training.tabs.registrants')
                    </div> --}}
                    <div class="tab-pane fade  px-5" id="trainees" role="tabpanel" aria-labelledby="trainees-tab">
                        @include('orgTrainings.training.tabs.trainees')
                    </div>
                    {{-- <div class="tab-pane fade  px-5" id="info" role="tabpanel" aria-labelledby="info-tab">
                        @include('orgTrainings.training.tabs.info')
                    </div> --}}
                    {{-- <div class="tab-pane fade  px-5" id="attachments" role="tabpanel" aria-labelledby="attachments-tab">
                        @include('orgTrainings.training.tabs.attachments')
                    </div> --}}
                    {{-- <div class="tab-pane fade  px-5" id="assistants" role="tabpanel" aria-labelledby="assistants-tab">
                        @include('orgTrainings.training.tabs.assistants')
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash) {
                const tabTrigger = document.querySelector(`a.nav-link[href="${hash}"]`);
                if (tabTrigger) {
                    const tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            }
        });
        document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tabLink) {
            tabLink.addEventListener('shown.bs.tab', function(e) {
                const hash = e.target.getAttribute('href');
                localStorage.setItem('activeTab', hash);
                history.replaceState(null, null, hash);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            let activeTab = window.location.hash || localStorage.getItem('activeTab');
            if (activeTab) {
                const tabTrigger = document.querySelector(`a.nav-link[href="${activeTab}"]`);
                if (tabTrigger) {
                    const tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            }
        });
    </script>
    <script>
        function toggleRejectionReason(button) {
            const participantId = button.getAttribute('data-participant');
            const box = document.getElementById('reason-box-' + participantId);
            if (box) {
                box.classList.toggle('d-none');
            }
        }
    </script>

    <script>
        const tabNames = {
            '#stats': 'إحصائيات',
            '#sessions': 'الجلسات التدريبية',
            '#registrants': 'المسجلون',
            '#trainees': 'المتدربون',
            '#info': 'معلومات التدريب',
            '#attachments': 'المرفقات',
            '#assistants': 'مساعدو المدرب'
        };
        function updateBreadcrumbTabName(hash) {
            const name = tabNames[hash] || 'التبويب';
            const nameElement = document.getElementById('current-tab-name');
            if (nameElement) nameElement.textContent = name;
        }
        document.addEventListener('DOMContentLoaded', function() {
            let activeTab = window.location.hash || localStorage.getItem('activeTab') || '#stats';
            updateBreadcrumbTabName(activeTab);
            const tabTrigger = document.querySelector(`a.nav-link[href="${activeTab}"]`);
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        });
        document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tabLink) {
            tabLink.addEventListener('shown.bs.tab', function(e) {
                const hash = e.target.getAttribute('href');
                localStorage.setItem('activeTab', hash);
                history.replaceState(null, null, hash);
                updateBreadcrumbTabName(hash);
            });
        });
    </script>
@endsection