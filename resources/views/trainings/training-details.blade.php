@extends('frontend.layouts.master')

@section('title', $program->title)

@section('content')


    <!-- Blue Header Section -->
    <div class="blue-header full-width-header mt-4">
        <div class="container d-flex justify-content-center">
            <div class="col-12 col-lg-7 text-center">
                <div class="title-wrapper">
                    <h1 class="d-inline-block lh-base">تدريباتي</h1>
                </div>
                <div class="mb-4">
<div class="mb-4" id="breadcrumb-tab-title">
    التدريبات/التدريبات الجارية/{{ $program->title }}/<span id="current-tab-name">إحصائيات</span>
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
                                @if ($program->AdditionalSetting && $program->AdditionalSetting->profile_image)
                                    <img src="{{ asset('storage/' . $program->AdditionalSetting->profile_image) }}"
                                        class="training-image" alt="صورة التدريب">
                                @else
                                    <img src="{{ asset('images/cources/sample-course.jpg') }}" class="training-image"
                                        alt="صورة التدريب">
                                @endif

                                <!-- أزرار التعديل والحذف -->
                                <div class="edit-buttons">
                                    <label for="edit-image-input" class="edit-btn btn-img m-0 cursor-pointer">
                                        <img src="{{ asset('images/cources/edit.svg') }}" alt="تعديل" title="تعديل"
                                            style="width: 32px;">
                                    </label>

                                    @if ($program->AdditionalSetting && $program->AdditionalSetting->profile_image)
                                        <form class="p-0" action="{{ route('program.photo.delete', $program->id) }}"
                                            method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الصورة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <div class="stop-btn btn-img">
                                                <button type="submit" class="border-0 bg-transparent p-0">
                                                    <img src="{{ asset('images/cources/delete.svg') }}" alt="حذف"
                                                        title="حذف" style="width: 32px;">
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- نموذج تعديل الصورة -->
                        <form action="{{ route('program.photo.update', $program->id) }}" method="POST"
                            enctype="multipart/form-data" id="edit-image-form" style="display: none;">
                            @csrf
                            <input type="file" name="profile_image" id="edit-image-input" accept="image/*"
                                onchange="document.getElementById('edit-image-form').submit();">
                        </form>
                    </div>


                    <!-- المعلومات -->
                    <div class="col-lg-8 content-column">
                        <div class="info-container h-100">
                            <div class="row h-100">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <img src="/images/cources/type-program.svg" class="info-icon" alt="نوع البرنامج">
                                        <span>نوع البرنامج: {{ $program->programType->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/level.svg" class="info-icon" alt="مستوى التدريب">
                                        <span>مستوى التدريب: {{ $program->programLevel }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/clock2.svg" class="info-icon" alt="عدد الجلسات">
                                        <span>عدد الجلسات: {{ count($program->sessions) }} جلسات</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/members.svg" class="info-icon" alt="العدد الأقصى">
                                        <span>العدد الأقصى للمشاركين:
                                            {{ $program->AdditionalSetting->max_trainees ?? 'غير محدد' }} مشارك</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/location2.svg" class="info-icon" alt="مكان التدريب">
                                        <span>مكان التدريب: {{ $countries[$program->country_id] ?? 'غير محدد' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/calender-primary.svg" class="info-icon"
                                            alt="تاريخ الانتهاء">
                                        <span>تاريخ انتهاء التقديم:
                                            {{ \Carbon\Carbon::parse($program->AdditionalSetting->application_deadline)->locale('ar')->translatedFormat('j/F/Y') ?? 'غير محدد' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <img src="/images/cources/language-primary.svg" class="info-icon" alt="لغة التدريب">
                                        <span>لغة التدريب: {{ $program->language->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/calssification.svg" class="info-icon" alt="تصنيف التدريب">
                                        <span>تصنيف التدريب: {{ $program->programClassification }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/type.svg" class="info-icon" alt="طريقة التقديم">
                                        <span>طريقة تقديم التدريب: {{ $program->program_presentation_method_id }}</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/Register.svg" class="info-icon" alt="طريقة التسجيل">
                                        <span>طريقة التسجيل:
                                            {{ $program->AdditionalSetting->application_submission_method->label() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- سعر الاشتراك -->
                            <div class="price-divider"></div>
                            <div class="price-section flex-row">
                                <strong>سعر الاشتراك</strong>
                                <strong class="price">

                                    @php
                                        $cost = $program->AdditionalSetting->cost ?? 0;
                                    @endphp

                                    @if ($cost > 0)
                                        @if (floor($cost) == $cost)
                                            {{ number_format($cost, 0, '', ',') }}
                                        @else
                                            {{ number_format($cost, 2, '.', ',') }}
                                        @endif
                                        {{ $program->AdditionalSetting->currency ?? '' }}
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
                <h1 class="training-title m-0">{{ $program->title }}</h1>
                <p class="trainer-name">المدرب: {{ $trainer->getTranslation('name', 'ar') }}
                    {{ $trainer->trainer->getTranslation('last_name', 'ar') }}


                </p>
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
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="registrants-tab" data-bs-toggle="tab" href="#registrants"
                            role="tab" aria-controls="registrants" aria-selected="false">
                            المسجلون
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="trainees-tab" data-bs-toggle="tab" href="#trainees" role="tab"
                            aria-controls="trainees" aria-selected="false">
                            المتدربون
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                            aria-controls="info" aria-selected="false">
                            معلومات التدريب
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#attachments"
                            role="tab" aria-controls="attachments" aria-selected="false">
                            المرفقات
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="assistants-tab" data-bs-toggle="tab" href="#assistants" role="tab"
                            aria-controls="assistants" aria-selected="false">
                            مساعدو المدرب
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="mainTabsContent">
                    <div class="tab-pane fade show active px-5" id="stats" role="tabpanel" aria-labelledby="stats-tab">
                        @include('trainings.tabs.statistics')
                    </div>

                    <div class="tab-pane fade  px-5" id="sessions" role="tabpanel" aria-labelledby="sessions-tab">
                        @include('trainings.tabs.sessions')
                    </div>

                    <div class="tab-pane fade" id="registrants" role="tabpanel" aria-labelledby="registrants-tab">
                        @include('trainings.tabs.registrants')
                    </div>

                    <div class="tab-pane fade  px-5" id="trainees" role="tabpanel" aria-labelledby="trainees-tab">
                        @include('trainings.tabs.trainees')
                    </div>

                    <div class="tab-pane fade  px-5" id="info" role="tabpanel" aria-labelledby="info-tab">
                        @include('trainings.tabs.info')
                    </div>

                    <div class="tab-pane fade  px-5" id="attachments" role="tabpanel" aria-labelledby="attachments-tab">
                        @include('trainings.tabs.attachments')
                    </div>

                    <div class="tab-pane fade  px-5" id="assistants" role="tabpanel" aria-labelledby="assistants-tab">
                        @include('trainings.tabs.assistants')
                    </div>
                </div>
            </div>
        </div>
    </div>




    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash) {
                // جرب البحث عن رابط التبويب الذي يحمل href مطابق للهاش
                const tabTrigger = document.querySelector(`a.nav-link[href="${hash}"]`);
                if (tabTrigger) {
                    // استدعاء الـ bootstrap tab API لعرض التبويب المطلوب
                    const tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            }
        });
        document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tabLink) {
            tabLink.addEventListener('shown.bs.tab', function(e) {
                const hash = e.target.getAttribute('href');
                // تخزين التبويب الحالي في localStorage
                localStorage.setItem('activeTab', hash);
                // تعديل رابط المتصفح
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
        // أكواد الجافاسكريبت الخاصة بك هنا
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
