@extends('frontend.layouts.master')
@section('title', 'تدريباتي')

@section('content')
    <style>
        .card-img-wrapper {
            width: 100%;
            padding-top: 100%;
            /* يجعل الحاوية مربعة */
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            /* اختياري لتنعيم الزوايا */
        }

        .card-img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* تغطي الحاوية بالكامل بدون تشويه */
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
                        <button class="nav-link active" id="announced-tab" data-bs-toggle="tab" data-bs-target="#announced"
                            type="button" role="tab">التدريبات المعلنة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="under-construction-tab" data-bs-toggle="tab"
                            data-bs-target="#under-construction" type="button" role="tab">تدريبات قيد الإنشاء</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ongoing-tab" data-bs-toggle="tab" data-bs-target="#ongoing"
                            type="button" role="tab">التدريبات الجارية</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed"
                            type="button" role="tab">التدريبات المكتملة</button>
                    </li>
                </ul>
            </div>
        </div>
        <!-- محتوى التبويبات -->
        <div class="tab-content" id="myTabContent">
            <!-- تبويب التدريبات المعلنة والمتوقفة -->
            <div class="tab-pane fade show active mb-4" id="announced" role="tabpanel">
                <!-- قسم التدريبات المعلنة -->
                <div class="section-title">
                    <span>
                        التدريبات المعلنة
                        <span class="section-count">({{ count($announced) }})</span>
                    </span>
                    @if (empty($announced))
                        <a href="{{ route('training.create') }}" class="custom-btn btn-sm">إنشاء تدريب جديد</a>
                    @endif
                </div>

                <div class="row">
                    @if (empty($announced))
                        <div
                            class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                            <h4>لا توجد تدريبات معلنة حالياً</h4>
                            <p>يمكنك البدء بإنشاء تدريب جديد أو تفعيل تدريباتك الحالية</p>
                            <a href="{{ route('training.create') }}" class="custom-btn">إنشاء تدريب جديد</a>
                        </div>
                    @else
                        @foreach ($announced as $p)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card p-3">
                                    <div class="card-img-wrapper">
                                        @if ($p->AdditionalSetting && $p->AdditionalSetting->profile_image)
                                            <img src="{{ asset('storage/' . $p->AdditionalSetting->profile_image) }}"
                                                class="card-img-top" alt="صورة التدريب">
                                        @else
                                            <img src="{{ asset('images/cources/sample-course.jpg') }}" class="card-img-top"
                                                alt="صورة التدريب">
                                        @endif
                                    </div>
                                    <div class="card-body justify-content-start">
                                        <h5 class="card-title m-0">{{ $p->title }}</h5>
                                        <div class="stats">
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/member-admin.svg') }}">
                                                <span>
                                                    @php
                                                        $pendingCount = 0;
                                                        if ($p->enrollments) {
                                                            foreach ($p->enrollments as $enrollment) {
                                                                if ($enrollment->status === 'pending') {
                                                                    $pendingCount++;
                                                                }
                                                            }
                                                        }
                                                        echo $pendingCount;
                                                    @endphp
                                                    متقدم
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/clock-admin.svg') }}">
                                                @php
                                                    $hours = floor($p->total_session_duration_minutes / 60);
                                                    $minutes = $p->total_session_duration_minutes % 60;
                                                @endphp
                                                <span>
                                                    {{ $hours }} ساعة
                                                    @if ($minutes > 0)
                                                        و{{ $minutes }} دقيقة
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/views.svg') }}">
                                                <span>{{ $p->views ?? 0 }} مشاهدة</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex gap-2">
                                            <div class="edit-btn">
                                                {{-- <a href="{{ route('training.basic', $p->id) }}" title="تعديل">
                                                    <img src="{{ asset('images/cources/edit.svg') }}">
                                                </a> --}}
                                                <a href="{{ route('training.basic', $p->id) }}" title="تعديل">
                                                    <img src="{{ asset('images/cources/edit.svg') }}">
                                                </a>

                                            </div>
                                            <div class="stop-btn">
                                                <a href="#" class="pb-1" title="إيقاف الإعلان"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#stopAdModal-{{ $p->id }}">
                                                    <img src="{{ asset('images/cources/stop.svg') }}">
                                                </a>
                                            </div>
                                        </div>
                                        <a href="{{ route('training.details', $p->id) }}#registrants"
                                            class="btn btn-register">
                                            <img src="{{ asset('images/cources/register-icon.svg') }}">
                                            قائمة المسجلين
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- مودال إيقاف الإعلان لكل تدريب -->
                            <div class="modal fade" id="stopAdModal-{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <div class="text-center mb-4">
                                                <img src="{{ asset('images/cources/pause-training.svg') }}"
                                                    class="img-fluid">
                                            </div>
                                            <h4 class="modal-title text-center mb-3 fw-bold custom-style">
                                                إيقاف الإعلان عن التدريب: {{ $p->title }}
                                            </h4>
                                            <p class="text-center text-muted">
                                                هل أنت متأكد من إيقاف الإعلان عن التدريب؟<br>
                                                بعد الإيقاف، لن يظهر التدريب للمستخدمين، ولن يتمكن أحد من التسجيل، لكن ستظل
                                                البيانات محفوظة.
                                            </p>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <div class="row w-100 g-2">
                                                <div class="col-12 col-md-6">
                                                    <form method="POST" class="p-0"
                                                        action="{{ route('trainings.stopSharing', $p->id) }}">
                                                        @csrf
                                                        <button type="submit" class="custom-btn w-100">
                                                            نعم، أوقف الإعلان
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <button type="button" class="btn-cancel w-100"
                                                        data-bs-dismiss="modal">
                                                        إلغاء
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- قسم التدريبات المتوقفة -->
                @if (!empty($stoppedPrograms) && count($stoppedPrograms) > 0)

                <div class="section-title mt-5">
                    <span>
                        التدريبات المتوقفة
                        <span class="section-count">({{ count($stoppedPrograms ?? []) }})</span>
                    </span>
                </div>

                <div class="row">
                    @if (empty($stoppedPrograms ?? []))
                        <div
                            class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                            <h4>لا توجد تدريبات متوقفة حالياً</h4>
                            <p>جميع تدريباتك المعلنة نشطة ومتاحة للمستخدمين</p>
                        </div>
                    @else
                        @foreach ($stoppedPrograms as $p)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card p-3 stopped-program">
                                    <div class="stopped-badge">متوقف</div>
                                    <div class="card-img-wrapper">
                                        @if ($p->AdditionalSetting && $p->AdditionalSetting->profile_image)
                                            <img src="{{ asset('storage/' . $p->AdditionalSetting->profile_image) }}"
                                                class="card-img-top" alt="صورة التدريب">
                                        @else
                                            <img src="{{ asset('images/cources/sample-course.jpg') }}"
                                                class="card-img-top" alt="صورة التدريب">
                                        @endif
                                    </div>
                                    <div class="card-body justify-content-start">
                                        <h5 class="card-title">{{ $p->title }}</h5>
                                        <div class="stats">
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/member-admin.svg') }}">
                                                <span>
                                                    @php
                                                        $pendingCount = 0;
                                                        if ($p->enrollments) {
                                                            foreach ($p->enrollments as $enrollment) {
                                                                if ($enrollment->status === 'pending') {
                                                                    $pendingCount++;
                                                                }
                                                            }
                                                        }
                                                        echo $pendingCount;
                                                    @endphp
                                                    متقدم
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/clock-admin.svg') }}">
                                                @php
                                                    $hours = floor($p->total_session_duration_minutes / 60);
                                                    $minutes = $p->total_session_duration_minutes % 60;
                                                @endphp
                                                <span>
                                                    {{ $hours }} ساعة
                                                    @if ($minutes > 0)
                                                        و{{ $minutes }} دقيقة
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/views.svg') }}">
                                                <span>{{ $p->views ?? 0 }} مشاهدة</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex gap-2">
                                            <div class="edit-btn">
                                                <a href="{{ route('training.basic', $p->id) }}" title="تعديل">
                                                    <img src="{{ asset('images/cources/edit.svg') }}">
                                                </a>
                                            </div>
                                            <div class="">
                                                <form class="p-0" method="POST"
                                                    action="{{ route('trainings.rePublish', $p->id) }}">
                                                    @csrf
                                                    <button type="submit" class="restart-btn" title="إعادة نشر التدريب">

                                                        إعادة النشر
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <a href="{{ route('training.details', $p->id) }}#registrants"
                                            class="btn btn-register restart">
                                            <img src="{{ asset('images/cources/register-icon.svg') }}">
                                            قائمة المسجلين
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- مودال تأكيد إعادة النشر -->
                            <div class="modal fade" id="restartAdModal-{{ $p->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <div class="text-center mb-4">
                                                <img src="{{ asset('images/courses/restart.svg') }}" class="img-fluid">
                                            </div>
                                            <h4 class="modal-title text-center mb-3 fw-bold custom-style">
                                                إعادة نشر التدريب: {{ $p->title }}
                                            </h4>
                                            <p class="text-center text-muted">
                                                هل أنت متأكد من إعادة نشر هذا التدريب؟<br>
                                                بعد إعادة النشر، سيظهر التدريب للمستخدمين مرة أخرى، وسيتمكنون من التسجيل
                                                فيه.
                                            </p>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <div class="row w-100 g-2">
                                                <div class="col-12 col-md-6">
                                                    <form method="POST" class="p-0"
                                                        action="{{ route('trainings.rePublish', $p->id) }}">
                                                        @csrf
                                                        <button type="submit" class="custom-btn w-100">
                                                            نعم، أعد النشر
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <button type="button" class="btn-cancel w-100"
                                                        data-bs-dismiss="modal">
                                                        إلغاء
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        @endforeach
                    @endif
                </div>
                @endif
            </div>

            <!-- تبويب تدريبات قيد الإنشاء -->
            <div class="tab-pane fade mb-4" id="under-construction" role="tabpanel">
                <div class="row">
                    @if (empty($drafts))
                        <div
                            class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                            <h4>لا توجد تدريبات قيد الإنشاء</h4>
                            <p>ابدأ بإنشاء تدريب جديد لبناء مسارك التدريبي</p>
                            <a href="{{ route('training.create') }}" class="custom-btn">بدء إنشاء تدريب</a>
                        </div>
                    @else
                        @foreach ($drafts as $p)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card p-3">
                                      <div class="card-img-wrapper">
                                    @if ($p->AdditionalSetting && $p->AdditionalSetting->profile_image)
                                        <img src="{{ asset('storage/' . $p->AdditionalSetting->profile_image) }}"
                                            class="card-img-top">
                                    @else
                                        <img src="{{ asset('images/cources/sample-course.jpg') }}" class="card-img-top">
                                    @endif
                                        </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $p->title }}</h5>
                                        <!-- شريط التقدم -->
                                        <div class="progress-container my-3 mt-5"
                                            data-progress="{{ $p->completion_percentage }}">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"></div>
                                            </div>
                                            <div class="progress-label"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer gap-2">
                                        <div class="d-flex">
                                            <div class="stop-btn">
                                                <a href="#" class="pb-1" title="حذف" data-bs-toggle="modal"
                                                    data-bs-target="#deleteTrainingModal-{{ $p->id }}">
                                                    <img src="{{ asset('images/cources/delete.svg') }}">
                                                </a>
                                            </div>
                                        </div>
                                        <a href="{{ route('training.basic', $p->id) }}" class="custom-btn">
                                            إكمال معلومات التدريب
                                            <img src="{{ asset('images/cources/arrow-left.svg') }}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- مودال الحذف لكل تدريب -->
                            <div class="modal fade" id="deleteTrainingModal-{{ $p->id }}" tabindex="-1"
                                aria-labelledby="deleteTrainingModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0 pb-0 justify-content-end">
                                            <button type="button" class="btn-close align-self-end"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <div class="text-center mb-4">
                                                <img src="{{ asset('images/cources/delete-img.svg') }}"
                                                    class="img-fluid">
                                            </div>
                                            <h4 class="modal-title text-center mb-3 fw-bold custom-style">
                                                حذف التدريب: {{ $p->title }}
                                            </h4>
                                            <p class="text-center text-muted">
                                                هل أنت متأكد من رغبتك في حذف هذا التدريب؟
                                                <br>
                                                لم يتم نشر هذا التدريب بعد، وسيتم حذف جميع البيانات المدخلة نهائياً ولن
                                                تتمكن من استعادتها لاحقاً.
                                            </p>
                                        </div>
                                        <div
                                            class="modal-footer border-0 justify-content-center flex-row-reverse w-100 d-flex">
                                            <button type="button" class="btn-cancel mx-2 flex-fill"
                                                data-bs-dismiss="modal">
                                                إلغاء
                                            </button>
                                            <form method="POST" action="{{ route('trainings.destroy', $p->id) }}"
                                                class="d-inline-flex flex-fill">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="custom-btn mx-2 w-100">
                                                    احذف التدريب
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- تبويب التدريبات الجارية -->
            <div class="tab-pane fade mb-4" id="ongoing" role="tabpanel">
                <div class="row">
                    @if (empty($ongoing))
                        <div
                            class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                            <h4>لا توجد تدريبات جارية حالياً</h4>
                            <p>يمكنك تفعيل تدريباتك المعلنة لبدء الجلسات التدريبية</p>
                        </div>
                    @else
                        @foreach ($ongoing as $p)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card p-3">
                                    <div class="card-img-wrapper">
                                        @if ($p->AdditionalSetting && $p->AdditionalSetting->profile_image)
                                            <img src="{{ asset('storage/' . $p->AdditionalSetting->profile_image) }}"
                                                class="card-img-top" alt="صورة التدريب">
                                        @else
                                            <img src="{{ asset('images/cources/sample-course.jpg') }}"
                                                class="card-img-top" alt="صورة التدريب">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $p->title }}</h5>
                                        <div class="stats">
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/member-admin.svg') }}">
                                                <span>
                                                    @php
                                                        $acceptedCount = 0;
                                                        if ($p->enrollments) {
                                                            foreach ($p->enrollments as $enrollment) {
                                                                if ($enrollment->status === 'accepted') {
                                                                    $acceptedCount++;
                                                                }
                                                            }
                                                        }
                                                        echo $acceptedCount;
                                                    @endphp
                                                    متدرب
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/clock-admin.svg') }}">
                                                @php
                                                    $hours = floor($p->total_session_duration_minutes / 60);
                                                    $minutes = $p->total_session_duration_minutes % 60;
                                                @endphp
                                                <span>
                                                    {{ $hours }} ساعة
                                                    @if ($minutes > 0)
                                                        و{{ $minutes }} دقيقة
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/views.svg') }}">
                                                <span>{{ $p->views ?? 0 }} مشاهدة</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('training.details', $p->id) }}#trainees"
                                            class="btn btn-register w-100">
                                            <img src="{{ asset('images/cources/members.svg') }}">
                                            المتدربين المنضمين
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- تبويب التدريبات المكتملة -->
            <div class="tab-pane fade mb-4" id="completed" role="tabpanel">
                <div class="row">
                    @if (empty($completed))
                        <div
                            class="col-12 w-100 empty-state d-flex flex-column text-center justify-content-center align-items-center">
                            <h4>لا توجد تدريبات مكتملة بعد</h4>
                            <p>سيتم عرض التدريبات المكتملة هنا بعد انتهاء جميع جلساتها</p>
                        </div>
                    @else
                        @foreach ($completed as $p)
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card p-3">
                                    <div class="card-img-wrapper">
                                        @if ($p->AdditionalSetting && $p->AdditionalSetting->profile_image)
                                            <img src="{{ asset('storage/' . $p->AdditionalSetting->profile_image) }}"
                                                class="card-img-top" alt="صورة التدريب">
                                        @else
                                            <img src="{{ asset('images/cources/sample-course.jpg') }}"
                                                class="card-img-top" alt="صورة التدريب">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $p->title }}</h5>
                                        <div class="stats">
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/member-admin.svg') }}">
                                                <span>
                                                    @php
                                                        $acceptedCount = 0;
                                                        if ($p->enrollments) {
                                                            foreach ($p->enrollments as $enrollment) {
                                                                if ($enrollment->status === 'accepted') {
                                                                    $acceptedCount++;
                                                                }
                                                            }
                                                        }
                                                        echo $acceptedCount;
                                                    @endphp
                                                    متدرب
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/clock-admin.svg') }}">
                                                @php
                                                    $hours = floor($p->total_session_duration_minutes / 60);
                                                    $minutes = $p->total_session_duration_minutes % 60;
                                                @endphp
                                                <span>
                                                    {{ $hours }} ساعة
                                                    @if ($minutes > 0)
                                                        و{{ $minutes }} دقيقة
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <img class="pe-2" src="{{ asset('images/cources/views.svg') }}">
                                                <span>{{ $p->views ?? 0 }} مشاهدة</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('training.details', $p->id) }}#trainees"
                                            class="btn btn-register w-100">
                                            <img src="{{ asset('images/cources/members.svg') }}">
                                            المتدربون المنضمون
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // حفظ واستعادة التبويب النشط
            const activeTabKey = 'myTrainingsActiveTab';

            // استعادة التبويب النشط من localStorage
            const savedTab = localStorage.getItem(activeTabKey);
            if (savedTab) {
                const tab = new bootstrap.Tab(document.querySelector(savedTab));
                tab.show();

                // تحديث حالة التبويبات
                document.querySelectorAll('#myTab .nav-link').forEach(tabEl => {
                    tabEl.classList.remove('active');
                });
                document.querySelector(savedTab).classList.add('active');

                // تحديث حالة محتوى التبويبات
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });
                const targetPane = document.querySelector(document.querySelector(savedTab).getAttribute(
                    'data-bs-target'));
                targetPane.classList.add('show', 'active');
            }

            // حفظ التبويب النشط عند التغيير
            document.querySelectorAll('#myTab .nav-link').forEach(tabEl => {
                tabEl.addEventListener('click', function() {
                    localStorage.setItem(activeTabKey, `#${this.id}`);
                });
            });

            // معالجة أشرطة التقدم
            document.querySelectorAll('.progress-container').forEach(container => {
                let progress = container.getAttribute('data-progress');
                let bar = container.querySelector('.progress-bar');
                let label = container.querySelector('.progress-label');
                bar.style.width = progress + "%";
                label.textContent = progress + "%";
                if (document.dir === "rtl") {
                    label.style.right = progress + "%";
                } else {
                    label.style.left = progress + "%";
                }
            });

            // تأكيد الحذف
            document.querySelectorAll('form[method="DELETE"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('هل أنت متأكد من الحذف؟')) {
                        e.preventDefault();
                    }
                });
            });

            // إضافة عنوان التدريب في رسائل التأكيد
            document.querySelectorAll(
                '[data-bs-target^="#stopAdModal"], [data-bs-target^="#deleteTrainingModal"], [data-bs-target^="#restartAdModal"]'
            ).forEach(btn => {
                btn.addEventListener('click', function() {
                    const trainingTitle = this.closest('.card').querySelector('.card-title')
                        .textContent;
                    const modal = document.querySelector(this.getAttribute('data-bs-target'));
                    if (modal) {
                        const modalTitle = modal.querySelector('.modal-title');
                        if (modalTitle) {
                            const titleParts = modalTitle.textContent.split(':');
                            modalTitle.textContent = titleParts[0] + `: ${trainingTitle}`;
                        }
                    }
                });
            });

            // Swipe بين التبويبات على الأجهزة المحمولة
            let touchStartX = 0;
            let touchEndX = 0;
            const tabPane = document.querySelector('.tab-content');
            tabPane.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            }, false);
            tabPane.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, false);

            function handleSwipe() {
                if (touchEndX < touchStartX - 50) {
                    // swipe left - next tab
                    const activeTab = document.querySelector('#myTab .nav-link.active');
                    const nextTab = activeTab.parentElement.nextElementSibling?.querySelector('.nav-link');
                    if (nextTab) {
                        bootstrap.Tab.getOrCreateInstance(nextTab).show();
                        localStorage.setItem(activeTabKey, `#${nextTab.id}`);
                    }
                }
                if (touchEndX > touchStartX + 50) {
                    // swipe right - previous tab
                    const activeTab = document.querySelector('#myTab .nav-link.active');
                    const prevTab = activeTab.parentElement.previousElementSibling?.querySelector('.nav-link');
                    if (prevTab) {
                        bootstrap.Tab.getOrCreateInstance(prevTab).show();
                        localStorage.setItem(activeTabKey, `#${prevTab.id}`);
                    }
                }
            }
        });
    </script>
@endsection
