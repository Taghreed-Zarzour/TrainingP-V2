@extends('frontend.layouts.master')
@section('title', $OrgProgram->title)
@section('content')
    <!-- Blue Header Section -->
    <div class="blue-header full-width-header mt-4">
        <div class="container d-flex justify-content-center">
            <div class="col-12 col-lg-7 text-center">
                <div class="title-wrapper">
                    <h1 class="d-inline-block lh-base">برامج المؤسسة التدريبية</h1>
                </div>
                <div class="mb-4">
                    <div class="mb-4" id="breadcrumb-tab-title">
                        المسارات التدريبية/{{ $OrgProgram->title }}/<span id="current-tab-name">إحصائيات</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-xxl">
        <!-- البطاقة الرئيسية للمحتوى -->
        <div class="training-card mb-4 position-relative">
          <div class="position-absolute top-0 end-0 my-3">
        <div class="bg-primary text-white d-inline-block px-3 py-1 rounded">
            مسار تدريبي
        </div>
    </div>
            <div class="row g-0 p-3">
                <!-- العمود الأيسر - الصورة والسعر -->
                <div class="col-lg-5 position-relative">
                    <div class="image-container h-100">
                        @if ($OrgProgram->registrationRequirements && $OrgProgram->registrationRequirements->training_image)
                            <img src="{{ asset('storage/' . $OrgProgram->registrationRequirements->training_image) }}"
                                class="img-fluid w-100 h-100 object-fit-cover" alt="صورة المسار التدريبي">
                        @else
                            <img src="{{ asset('images/cources/training-default-img.svg') }}" class="img-fluid w-100 h-100 object-fit-cover"
                                alt="صورة المسار التدريبي">
                        @endif
                        
                        <!-- أزرار التعديل والحذف -->
                        <div class="edit-buttons position-absolute bottom-0 start-0 m-3">
                            <label for="edit-image-input" class="edit-btn btn-img m-0 cursor-pointer">
                                <img src="{{ asset('images/cources/edit.svg') }}" alt="تعديل" title="تعديل"
                                    style="width: 32px;">
                            </label>
                            @if ($OrgProgram->registrationRequirements && $OrgProgram->registrationRequirements->training_image)
                                <form class="p-0" action="{{ route('orgImage.delete', $OrgProgram->registrationRequirements->id) }}"
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
                        
                        <!-- السعر في أسفل يسار الصورة -->
                        <div class="position-absolute bottom-0 end-0 m-3 bg-primary text-white px-3 py-2 rounded">
                            @if(isset($OrgProgram->registrationRequirements->cost) && $OrgProgram->registrationRequirements->cost > 0)
                                <span class="fw-bold">{{ number_format($OrgProgram->registrationRequirements->cost) }} 
                                  {{ $OrgProgram->registrationRequirements->currency ?? ''  }} 
                                </span>
                            @else
                                <span class="fw-bold">مجاني</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- نموذج تعديل الصورة -->
                    <form action="{{ route('orgImage.update', $OrgProgram->registrationRequirements->id) }}" method="POST"
                        enctype="multipart/form-data" id="edit-image-form" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="file" name="training_image" id="edit-image-input" accept="image/*"
                            onchange="document.getElementById('edit-image-form').submit();">
                    </form>
                </div>
                
                <!-- العمود الأيمن - المحتوى -->
                <div class="col-lg-7 p-4">

                    <!-- عنوان ووصف المسار -->
                    <h1 class="training-title m-3">{{ $OrgProgram->title }}</h1>
                    <p class="trainer-description mb-4">{{ $OrgProgram->program_description }}</p>
                    
                    <!-- البطاقات التسع -->
                    <div class="row g-2">
                        <!-- البطاقة 1: العدد الأقصى للمشاركين -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
                                    <div class="icon-circle bg-light rounded-circle p-2 me-2">
                                        <img src="/images/cources/members.svg" class="info-icon" alt="العدد الأقصى">
                                    </div>
                                    <div>
                                        <div class="text-muted small">العدد الأقصى للمشاركين</div>
                                        <div class="fw-bold">{{ $OrgProgram->registrationRequirements->max_trainees == 0 ? 'لا يوجد عدد محدد' :$OrgProgram->registrationRequirements->max_trainees . 'مشارك'  }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- البطاقة 2: مستوى التدريب -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
                                    <div class="icon-circle bg-light rounded-circle p-2 me-2">
                                        <img src="/images/cources/level.svg" class="info-icon" alt="مستوى التدريب">
                                    </div>
                                    <div>
                                        <div class="text-muted small">مستوى المسار</div>
                                        <div class="fw-bold">{{ $OrgProgram->trainingLevel->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- البطاقة 3: عدد الجلسات -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
                                    <div class="icon-circle bg-light rounded-circle p-2 me-2">
                                        <img src="/images/cources/clock2.svg" class="info-icon" alt="عدد الجلسات">
                                    </div>
                                    <div>
                                        <div class="text-muted small">عدد التدريبات</div>
                                        <div class="fw-bold">{{ count($OrgProgram->details) }} تدريب</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
<!-- البطاقة 4: تصنيف التدريب -->
<div class="col-md-4">
    <div class="card h-100 border-0 shadow-sm"
         data-bs-toggle="tooltip"
         data-bs-placement="bottom"
         title="{{ implode(', ', $orgTrainingClassification->toArray()) }}">
        <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
            <div class="icon-circle bg-light rounded-circle p-2 me-2">
                <img src="/images/cources/calssification.svg" class="info-icon" alt="تصنيف التدريب">
            </div>
            <div>
                <div class="text-muted small">تصنيف المسار</div>
                <div class="fw-bold">
                    @php
                        $items = $orgTrainingClassification->toArray();
                        $first = $items[0] ?? 'غير متاح';
                        $remaining = count($items) - 1;
                    @endphp
                    {{ $first }}@if($remaining > 0) +{{ $remaining }}@endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

                        
                        <!-- البطاقة 5: طريقة تقديم التدريب -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
                                    <div class="icon-circle bg-light rounded-circle p-2 me-2">
                                        <img src="/images/cources/type.svg" class="info-icon" alt="طريقة التقديم">
                                    </div>
                                    <div>
                                        <div class="text-muted small">طريقة تقديم المسار</div>
                                        <div class="fw-bold">{{ $OrgProgram->program_presentation_method }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- البطاقة 6: طريقة التسجيل -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
                                    <div class="icon-circle bg-light rounded-circle p-2 me-2">
                                        <img src="/images/cources/Register.svg" class="info-icon" alt="طريقة التسجيل">
                                    </div>
                                    <div>
                                        <div class="text-muted small">طريقة التسجيل</div>
                                        <div class="fw-bold">
                                            {{ $OrgProgram->registrationRequirements->application_submission_method == 'inside_platform' ? 'داخل المنصة' : 'خارج المنصة' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- البطاقة 7: اللغة -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
                                    <div class="icon-circle bg-light rounded-circle p-2 me-2">
                                        <img src="/images/cources/language-primary.svg" class="info-icon" alt="لغة التدريب">
                                    </div>
                                    <div>
                                        <div class="text-muted small">اللغة</div>
                                        <div class="fw-bold">{{ $OrgProgram->language->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
<!-- البطاقة 8: مكان التدريب أو أونلاين -->
<div class="col-md-4">
    <div class="card h-100 border-0 shadow-sm">
        <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
            <div class="icon-circle bg-light rounded-circle p-2 me-2">
                <img src="/images/cources/location2.svg" class="info-icon" alt="مكان التدريب">
            </div>
            <div>
                <div class="text-muted small">مكان التدريب</div>
                @if ($OrgProgram->program_presentation_method === \App\Enums\TrainingAttendanceType::HYBRID->value 
                    || $OrgProgram->program_presentation_method === \App\Enums\TrainingAttendanceType::REMOTE->value)
                    <div class="fw-bold">أونلاين</div>
                @else
                    <div class="fw-bold">
                        {{ $OrgProgram->city ?? '---' }}
                        {{ $OrgProgram->country ? ' - ' . $OrgProgram->country->name : '' }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

                        
                        <!-- البطاقة 9: تاريخ انتهاء التسجيل -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center p-2 flex-nowrap gap-1">
                                    <div class="icon-circle bg-light rounded-circle p-2 me-2">
                                        <img src="/images/training-details/calendar.svg" class="info-icon" alt="تاريخ الانتهاء">
                                    </div>
                                    <div>
                                        <div class="text-muted small">تاريخ انتهاء التسجيل</div>
                                        <div class="fw-bold">
                                            @if($OrgProgram->registrationRequirements->application_deadline)
                                                {{ date('Y/m/d', strtotime($OrgProgram->registrationRequirements->application_deadline)) }}
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
        </div>
        
        <!-- بطاقة عناوين التبويبات -->
        <div class="training-card mb-3" style="border-radius: 0.2rem;">
            <div class="card-body p-0 justify-content-center">
                <ul class="nav nav-tabs nav-fill border-0 gap-1" id="mainTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active bg-primary text-white" id="stats-tab" data-bs-toggle="tab" href="#stats" role="tab"
                            aria-controls="stats" aria-selected="true" style="border-radius: 0.2rem;">
                            إحصائيات
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="programs-tab" data-bs-toggle="tab" href="#programs" role="tab"
                            aria-controls="programs" aria-selected="false">
                            التدريبات
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="registrants-tab" data-bs-toggle="tab" href="#registrants"
                            role="tab" aria-controls="registrants" aria-selected="false">
                            المسجلون
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="trainees-tab" data-bs-toggle="tab" href="#trainees" role="tab"
                            aria-controls="trainees" aria-selected="false">
                            المتدربون
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                            aria-controls="info" aria-selected="false">
                            معلومات المسار
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="attachments-tab" data-bs-toggle="tab" href="#attachments"
                            role="tab" aria-controls="attachments" aria-selected="false">
                            المرفقات
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="assistants-tab" data-bs-toggle="tab" href="#assistants" role="tab"
                            aria-controls="assistants" aria-selected="false">
                            ميسرو المسار
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- محتوى التبويبات -->
        <div class="tab-content" id="mainTabsContent">
            <div class="tab-pane fade show active p-4" id="stats" role="tabpanel" aria-labelledby="stats-tab">
                @include('orgTrainings.tabs.statistics')
            </div>
            <div class="tab-pane fade p-4" id="programs" role="tabpanel" aria-labelledby="programs-tab">
                @include('orgTrainings.tabs.programs')
            </div>
            <div class="tab-pane fade p-4" id="registrants" role="tabpanel" aria-labelledby="registrants-tab">
                @include('orgTrainings.tabs.registrants')
            </div>
            <div class="tab-pane fade p-4" id="trainees" role="tabpanel" aria-labelledby="trainees-tab">
                @include('orgTrainings.tabs.trainees')
            </div>
            <div class="tab-pane fade p-4" id="info" role="tabpanel" aria-labelledby="info-tab">
                @include('orgTrainings.tabs.info')
            </div>
            <div class="tab-pane fade p-4" id="attachments" role="tabpanel" aria-labelledby="attachments-tab">
                @include('orgTrainings.tabs.attachments')
            </div>
            <div class="tab-pane fade p-4" id="assistants" role="tabpanel" aria-labelledby="assistants-tab">
                @include('orgTrainings.tabs.assistants')
            </div>
        </div>
    </div>
    
    <style>
        
        
        .icon-circle {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .icon-circle img {
            width: 20px;
            height: 20px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            border-radius: 0;
            padding: 10px 0;
            font-weight: 500;
            font-size: 1rem;
        }
        
        .nav-tabs .nav-link.active {
            background-color: #003090 !important;
            color: white !important;
            border-radius: 0.2rem !important;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link:not(.active):hover {
            color: #003090 !important;
            background-color: rgba(0, 48, 144, 0.1);
        }
        

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .image-container {
                padding-bottom: 60%; /* Adjust aspect ratio for mobile */
            }
            
            .training-card .row {
                flex-direction: column;
            }
            
            .training-card .col-lg-5 {
                margin-bottom: 1rem;
            }
            
            .nav-tabs .nav-link {
                font-size: 0.8rem;
                padding: 8px 0;
            }
        }
        .info-icon{
          margin-left: 0px !important;
        }
        .bg-primary{
          background-color: #003090 !important;
          
        }
    </style>
    
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
                
                // تحديث ألوان التبويبات
                document.querySelectorAll('.nav-link').forEach(link => {
                    if (link === e.target) {
                        link.classList.add('bg-primary', 'text-white');
                        link.style.borderRadius = '0.2rem';
                        link.classList.remove('text-muted');
                    } else {
                        link.classList.remove('bg-primary', 'text-white');
                        link.style.borderRadius = '0';
                        link.classList.add('text-muted');
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            let activeTab = window.location.hash || localStorage.getItem('activeTab');
            if (activeTab) {
                const tabTrigger = document.querySelector(`a.nav-link[href="${activeTab}"]`);
                if (tabTrigger) {
                    const tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                    
                    // تحديث ألوان التبويب النشط
                    document.querySelectorAll('.nav-link').forEach(link => {
                        if (link.getAttribute('href') === activeTab) {
                            link.classList.add('bg-primary', 'text-white');
                            link.style.borderRadius = '0.2rem';
                            link.classList.remove('text-muted');
                        } else {
                            link.classList.remove('bg-primary', 'text-white');
                            link.style.borderRadius = '0';
                            link.classList.add('text-muted');
                        }
                    });
                }
            }
        });
    </script>
    <script>
        const tabNames = {
            '#stats': 'إحصائيات',
            '#programs': 'التدريبات',
            '#registrants': 'المسجلون',
            '#trainees': 'المتدربون',
            '#info': 'معلومات المسار',
            '#attachments': 'المرفقات',
            '#assistants': 'ميسرو المسار'
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