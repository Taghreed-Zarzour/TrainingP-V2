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
                        {{ $program->title ?? 'التدريب' }}
                        <span class="training-type ms-2">{{ $program->trainingClassification?->name ?? '' }}</span>
                    </h1>
                </div>
                <div class="trainer-name">تم الإنشاء بواسطة:
                    @if ($trainer)
                        <a href="{{ route('show_trainer_profile', ['id' => $trainer->id]) }}"
                            style="display: contents;  text-decoration: none; color: inherit;">
                            <span class="text-decoration-underline">{{ $trainer->getTranslation('name', 'ar') }}
                                {{ $trainer->trainer?->getTranslation('last_name', 'ar') }}</span></a>
                    @else
                        <span>غير محدد</span>
                    @endif
                </div>
                <div
                    class="training-meta d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start text-center text-lg-start">
                    <span class="mb-2 mb-sm-0">
                        <img src="{{ asset('images/cources/language.svg') }}" alt="لغة التدريب">
                        لغة التدريب: {{ $program->language?->name ?? 'غير محدد' }}
                    </span>
                    <span class="ms-sm-3">
                        <img src="{{ asset('images/cources/Training-type.svg') }}" alt="نوع البرنامج">
                        نوع البرنامج: {{ $program->programType?->name ?? 'غير محدد' }}
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
                    @if ($program->AdditionalSetting?->profile_image)
                        <img src="{{ asset('storage/' . $program->AdditionalSetting->profile_image) }}"
                            class="square-image" alt="صورة التدريب">
                    @else
                        <img src="{{ asset('images/cources/training-default-img.svg') }}" class="square-image" alt="صورة التدريب">
                    @endif
                    <div class="price-section mt-3">
                        <div class="price mb-3">
                            سعر التسجيل:
                            @php
                                $cost = $program->AdditionalSetting?->cost ?? 0;
                            @endphp
                            @if ($cost > 0)
                                @if (floor($cost) == $cost)
                                    {{ number_format($cost, 0, '', ',') }}
                                @else
                                    {{ number_format($cost, 2, '.', ',') }}
                                @endif
                                {{ $program->AdditionalSetting?->currency ?? '' }}
                            @else
                                مجاني
                            @endif
                        </div>
<div class="time-left">
    <img class="pe-2" src="{{ asset('images/cources/calender-red.svg') }}" alt="سعر التسجيل">
    {{ $remainingText }}
</div>

                    </div>
                    <h5>تفاصيل التدريب</h5>
                    <div class="training-details">
                        <div>
                                                      <div class="mb-3">
                                  <img src="{{ asset('images/training-details/calendar.svg') }}" alt="">
                                    تاريخ انتهاء التقديم: 
                                    {{ $program?->AdditionalSetting?->application_deadline 
    ? \Carbon\Carbon::parse($program->AdditionalSetting->application_deadline)
        ->locale('ar')
        ->translatedFormat('d F Y')
    : 'غير معروف' }}
                                </div>


                            @if ($program->programLevel)
                                <div class="mb-3">
                                    <img class="pe-2" src="{{ asset('images/cources/level.svg') }}" alt="مستوى التدريب">
                                    مستوى التدريب: {{ $program->programLevel->name }}
                                </div>
                            @endif
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/type.svg') }}" alt="طريقة تقديم التدريب">
                                طريقة تقديم التدريب: {{ $program->program_presentation_method_id ?? 'غير محدد' }}
                            </div>
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/clock2.svg') }}" alt="عدد الساعات">

عدد الساعات: {{ $program->duration_text }}

                            </div>
                            @if ($program->AdditionalSetting?->application_submission_method)
                                <div class="mb-3">
                                    <img class="pe-2" src="{{ asset('images/cources/Register.svg') }}"
                                        alt="طريقة التسجيل">
                                    طريقة التسجيل:
                                    {{ $program->AdditionalSetting->application_submission_method->label() }}
                                </div>
                            @endif
                            @if ($program->AdditionalSetting?->max_trainees)
                                <div class="mb-3">
                                    <img class="pe-2" src="{{ asset('images/cources/members.svg') }}"
                                        alt="العدد الأقصى للمشاركين">
                                    العدد الأقصى للمشاركين: {{ $program->AdditionalSetting->max_trainees == 0 ? 'لا يوجد عدد محدد' : $program->AdditionalSetting->max_trainees . 'مشارك' }}
                                </div>
                            @endif
                            @if ($program->AdditionalSetting?->country)
                                <div class="mb-3">
                                    <img class="pe-2" src="{{ asset('images/cources/location2.svg') }}"
                                        alt="مكان التدريب">
                                    مكان التدريب: {{ $program->AdditionalSetting->country?->name ?? '' }} -
                                    {{ $program->AdditionalSetting->city ?? '' }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row g-2">
                      @auth
    @if (auth()->user()->userType?->type === 'متدرب')
        @if ($training_has_ended) <!-- تحقق إذا انتهى موعد التسجيل -->
            <div class="col-12">
                <div class="alert alert-danger text-center mb-0">
                    انتهى موعد التسجيل في هذا التدريب
                </div>
            </div>
        @elseif (!$has_enrolled)
            <div class="col-12 col-md-7">
                <button type="button" class="custom-btn w-100" data-bs-toggle="modal"
                    data-bs-target="#confirmEnrollmentModal">
                    انضم الآن ←
                </button>
            </div>
        @else
            @switch($enrollment?->status)
                @case('pending')
                    <div class="col-12">
                        <div class="alert alert-warning text-center mb-0">
                            تم إرسال طلبك مسبقًا، في انتظار الموافقة.
                        </div>
                    </div>
                @break

                @case('accepted')
                    <div class="col-12">
                        <div class="alert alert-success text-center mb-0">
                            تم قبولك في التدريب، بالتوفيق!
                        </div>
                    </div>
                @break

                @case('rejected')
                    <div class="col-12">
                        <div class="alert alert-danger text-center mb-0">
                            تم رفض طلبك للانضمام.
                            @if (!empty($enrollment?->rejection_reason))
                                <br>
                                <strong>السبب:</strong> {{ $enrollment->rejection_reason }}
                            @endif
                        </div>
                    </div>
                @break

                @default
                    <div class="col-12">
                        <div class="alert alert-info text-center mb-0">
                            حالة طلبك: {{ $enrollment?->status ?? 'غير محدد' }}
                        </div>
                    </div>
            @endswitch
        @endif
    @else
        <div class="col-12 ">
            <div class="alert alert-warning text-center mb-0">
                الرجاء التسجيل بحساب متدرب للانضمام إلى التدريب
            </div>
        </div>
    @endif
@else
    <div class="col-12">
        <div class="alert alert-info text-center mb-0">
            الرجاء تسجيل الدخول أولاً بحساب متدرب للانضمام إلى التدريب
        </div>
    </div>
@endauth
                        <div class="col-12 col-md-5">
                            <button type="button" class="custom-share-btn w-100" data-bs-toggle="modal"
                                data-bs-target="#inviteFriendModal">دعوة صديق</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-lg-8 order-lg-2">
                <div class="large-card">
                    @php
                        $details = [
                            'ما الذي سيتعلمه المشاركون في هذا التدريب' => $program->detail?->learning_outcomes ?? [],
                        ];
                    @endphp
                    @foreach ($details as $title => $items)
                        <div class="info-box">
                            <h4 class="info-title">{{ $title }}</h4>
                            @php
                                $items = is_array($items) ? $items : json_decode($items, true);
                            @endphp
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
                        $details = [
                            'الفئة المستهدفة من هذا التدريب' => $program->detail?->target_audience ?? [],
                            'المتطلبات او الشروط اللازمة للالتحاق بالتدريب' => $program->detail?->requirements ?? [],
                            'ميزات التدريب' => $program->detail?->benefits ?? [],
                        ];

                        // نحول كل عنصر لمصفوفة ونتأكد إنه فيه بيانات غير فاضية
                        $hasAnyData = collect($details)->some(function ($items) {
                            $items = is_array($items) ? $items : json_decode($items, true);
                            $items = array_filter($items, fn($value) => !empty($value)); // إزالة العناصر الفارغة
                            return !empty($items);
                        });
                    @endphp

                    @if ($hasAnyData)
                        <div class="info-box">
                            <h4 class="info-title mt-1">وصف التدريب</h4>
                            <p>{{ $program->description ?? 'لا يوجد وصف متاح' }}</p>

                            @foreach ($details as $title => $items)
                                @php
                                    $items = is_array($items) ? $items : json_decode($items, true);
                                    $items = array_filter($items, fn($value) => !empty($value)); // حذف القيم الفارغة
                                @endphp

                                @if (!empty($items))
                                    <div class="">
                                        <h4 class="info-title mt-5">{{ $title }}</h4>
                                        <ul class="list-unstyled">
                                            @foreach ($items as $item)
                                                <li class="d-flex align-items-start mb-2">
                                                    <img src="{{ asset('images/icons/check-circle.svg') }}"
                                                        alt="check" class="me-2" width="20" height="20">
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
                    @if (!$program->sessions || $program->sessions->isEmpty())
                      <div class="info-block py-4 px-2">
                        <!-- عرض عدد الجلسات والساعات عند عدم وجود جلسات -->
                        <div class="info-block-content">
                                                      
                            @if (isset($program->num_of_session))
                                <div class="info-block-content-item">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                                    <div class="info-block-content-item-title">
                                        عدد الجلسات {{ $program->num_of_session }} جلسة
                                    </div>
                                </div>
                            @endif
                            
                            @if (isset($program->num_of_hours))
                                <div class="info-block-content-item">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="">
                                    <div class="info-block-content-item-title">
                                        عدد الساعات
                                        {{ rtrim(rtrim(number_format($program->num_of_hours, 1), '0'), '.') }}
                                        ساعة
                                    </div>
                                </div>
                            @endif
                        </div>
                            </div>
                    @else
                        <!-- عرض جدول الجلسات عند وجود جلسات -->
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
                                @foreach ($program->sessions as $i => $session)
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td class="p-3 text-center">
                                            {{ isset($session_day[$i]) ? \Carbon\Carbon::parse($session_day[$i])->locale('ar')->dayName : '' }}
                                        </td>
                                        <td class="p-3 text-center">
                                            {{ isset($date_display[$i]) ? \Carbon\Carbon::parse($date_display[$i])->locale('ar')->translatedFormat('d F Y') : '' }}
                                        </td>
                                        <td class="p-3 text-center">
                                            {{ formatTimeArabic($session->session_start_time) }} -
                                            {{ formatTimeArabic($session->session_end_time) }}
                                        </td>
                                        <td class="p-3 text-center">
                                            {{ calculateDurationArabic($session->session_start_time, $session->session_end_time) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
                    <!-- مقدم التدريب -->
                    <div class="info-box mt-5">
                        <h4 class="info-title">مقدم التدريب</h4>
                        @if ($trainer)
                            <div class="trainer-card d-flex flex-column flex-md-row align-items-start gap-4">
                                <a href="{{ route('show_trainer_profile', ['id' => $program->user_id]) }}"
                                    style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">

                                    <div class="trainer-image text-center">
                                        @if ($trainer->photo)
                                            <img src="{{ asset('storage/' . $trainer->photo) }}"
                                                alt="{{ $trainer->name }}" class="custom-rounded" width="120"
                                                height="120">
                                        @else
                                            <img src="{{ asset('images/icons/user.svg') }}" alt="{{ $trainer->name }}"
                                                class="custom-rounded" width="120" height="120">
                                        @endif
                                    </div>

                                    <div class="text-start align-self-center">
                                        <h5 class="trainer-name mb-1">{{ $trainer->getTranslation('name', 'ar') }}
                                            {{ $trainer->trainer?->getTranslation('last_name', 'ar') }}</h5>
                                        <p class="trainer-position mb-2">{{ $trainer->trainer?->headline ?? '' }}</p>

                                        <div class="trainer-rating mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($averageTrainerRating))
                                                    <img src="{{ asset('images/cources/Star.svg') }}" alt="نجمة">
                                                @elseif ($i - $averageTrainerRating < 1)
                                                    <img src="{{ asset('images/cources/Star-half.svg') }}"
                                                        alt="نصف نجمة">
                                                @else
                                                    <img src="{{ asset('images/cources/Star-gray.svg') }}"
                                                        alt="نجمة رمادية">
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <p class="trainer-bio mt-3">{{ $trainer->bio ?? 'لا يوجد نبذة متاحة' }}</p>

                            @if (count($assistantUsers) > 0)
                                <h5 class="section-title mt-5">ميسرو التدريب</h5>
                                <div class="facilitators-container d-flex flex-column flex-md-row gap-4">
                                    @foreach ($assistantUsers as $assistant)
                                        <div class="facilitator-card d-flex align-items-center gap-3">
                                            @if ($assistant->photo)
                                                <img src="{{ asset('storage/' . $assistant->photo) }}"
                                                    alt="{{ $assistant->getTranslation('name', 'ar') }}"
                                                    class="rounded-circle" width="60" height="60">
                                            @else
                                                <img src="{{ asset('images/icons/user.svg') }}"
                                                    alt="{{ $assistant->getTranslation('name', 'ar') }}"
                                                    class="rounded-circle" width="60" height="60">
                                            @endif
                                            <span class="facilitator-name">{{ $assistant->getTranslation('name', 'ar') }}
                                                {{ $assistant->assistant?->getTranslation('last_name', 'ar') }} </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <p>لا يوجد مدرب محدد لهذا التدريب.</p>
                        @endif
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
                        عند تأكيد الاشتراك، سيتم إضافتك إلى قائمة المشاركين في تدريب "{{ $program->title ?? '' }}".<br>
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
