<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تدريباتي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-4 text-primary">تدريباتي</h2>
        <section class="mb-5">
            <h4 class="text-info">التدريبات المرتقبة</h4>

            {{-- تدريبات TrainingProgram --}}
            @if(count($scheduledTrainings))
                <ul class="list-group mt-3">
                    @foreach($scheduledTrainings as $item)
                        @if(isset($item['program']) && $item['program'])
                            @php
                                $training = $item['program'];
                                $status = $item['status'];
                            @endphp

                            <li class="list-group-item">
                                <div>
                                    <strong>{{ $training->title }}</strong><br>
                                    <strong>{{ $training->trainer->name ?? '' }} {{ $training->trainer->trainer->last_name ?? '' }}</strong><br>
                                    <strong>{{ $training->AdditionalSetting->country->name ?? '' }} - {{ $training->AdditionalSetting->city ?? '' }}</strong><br>
                                    <strong>{{ $training->total_duration_hours ?? '0' }} ساعة</strong><br>

                                    @if($status === 'pending')
                                        <div class="text-info mt-2">طلب التسجيل قيد المراجعة من قبل الإدارة.</div>
                                    @elseif($status === 'rejected')
                                        <div class="text-danger mt-2">تم رفض طلب التسجيل لهذا التدريب.</div>
                                    @elseif($status === 'accepted')
                                        <div class="text-success mt-2">تم قبول طلب التسجيل لهذا التدريب. وسيبدأ {{ $item['start_date'] ?? 'لاحقاً' }}</div>
                                    @endif
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-info mt-2">عرض التفاصيل</a>
                            </li>
                        @endif
                    @endforeach

                </ul>
            @endif

            {{-- تدريبات OrgTrainingProgram --}}
            @if(count($scheduledOrgTrainings))
                <ul class="list-group mt-3">
                    @foreach($scheduledOrgTrainings as $item)
                        @php
                            $orgTraining = $item['program'];
                            $status = $item['status'];
                        @endphp
                        <li class="list-group-item">
                            <div>
                                <strong>{{ $orgTraining->title }}</strong><br>
                                <strong>{{ $orgTraining->organization->user->name }}</strong><br>
                                <strong>{{ $orgTraining->country->name }} - {{ $orgTraining->city }}</strong><br>
                                <strong>{{ count($orgTraining->details) }} برامج</strong><br>

                                @if($status === 'pending')
                                    <div class="text-info mt-2">طلب التسجيل قيد المراجعة من قبل المؤسسة.</div>
                                @elseif($status === 'rejected')
                                    <div class="text-danger mt-2">تم رفض طلب التسجيل لهذا التدريب المؤسسي.</div>
                                @elseif($status === 'accepted')
                                    <div class="text-success mt-2"> تم قبول طلب التسجيل لهذا التدريب المؤسسي. وسيبدأ {{ $item['start_date'] }}</div>
                                @endif
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-info mt-2">عرض التفاصيل</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if(!count($scheduledTrainings) && !count($scheduledOrgTrainings))
                <div class="alert alert-secondary mt-3">لا توجد تدريبات مجدولة حالياً.</div>
            @endif
        </section>



        <section class="mb-5">
            <h4 class="text-success">التدريبات الحالية</h4>

            {{-- تدريب عام --}}
            @if(count($ongoingTrainings))
                <ul class="list-group mt-3">
                    @foreach($ongoingTrainings as $item)
                        @php
                            $training = $item['program'];
                            $rate = $item['completionRate'];
                            $nextSession = $item['nextSession'];
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $training->title }}</strong><br>
                                <strong>{{ $training->trainer->name ?? '' }} {{ $training->trainer->trainer->last_name ?? '' }}</strong><br>
                                <small class="text-muted">نسبة الإنجاز: {{ $rate }}%</small>
                                <small class="text-muted">الجلسة القادمة: {{ $nextSession }}%</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-success">عرض التفاصيل</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            {{-- تدريب مؤسسي --}}
            @if(count($ongoingOrgTrainings))
                <ul class="list-group mt-3">
                    @foreach($ongoingOrgTrainings as $item)
                        @php
                            $orgTraining = $item['program'];
                            $rate = $item['completionRate'];
                            $nextSession = $item['nextSession'];
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $orgTraining->title }}</strong><br>
                                <strong>{{ $orgTraining->organization->user->name }}</strong><br>
                                <small class="text-muted">نسبة الإنجاز: {{ $rate }}%</small>
                                <small class="text-muted">الجلسة القادمة: {{ $nextSession }}%</small>

                            </div>
                            <a href="#" class="btn btn-sm btn-outline-success">عرض التفاصيل</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if(!count($ongoingTrainings) && !count($ongoingOrgTrainings))
                <div class="alert alert-secondary mt-3">لا توجد تدريبات حالياً.</div>
            @endif
        </section>

        <section class="mb-5">
            <h4 class="text-dark">التدريبات المكتملة</h4>

            {{-- تدريب عام --}}
            @if(count($completedTrainings))
                <ul class="list-group mt-3">
                    @foreach($completedTrainings as $item)
                        @php
                            $training = $item['program'];
                            $rate = $item['completionRate'];
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $training->title }}</strong><br>
                                <strong>{{ $training->trainer->name ?? '' }} {{ $training->trainer->trainer->last_name ?? '' }}</strong><br>
                                <small class="text-muted">نسبة الإنجاز: {{ $rate }}%</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-dark">عرض التفاصيل</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            {{-- تدريب مؤسسي --}}
            @if(count($completedOrgTrainings))
                <ul class="list-group mt-3">
                    @foreach($completedOrgTrainings as $item)
                        @php
                            $orgTraining = $item['program'];
                            $rate = $item['completionRate'];
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $orgTraining->title }}</strong><br>
                                <strong>{{ $orgTraining->organization->user->name }}</strong><br>
                                <small class="text-muted">نسبة الإنجاز: {{ $rate }}%</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-dark">عرض التفاصيل</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if(!count($completedTrainings) && !count($completedOrgTrainings))
                <div class="alert alert-secondary mt-3">لا توجد تدريبات مكتملة.</div>
            @endif
        </section>


        {{-- التدريبات المعلقة --}}
       <section class="mb-5">
    <h4 class="text-warning">التدريبات المعلقة</h4>

    {{-- تدريب عام --}}
    @if(count($pausedTrainings))
        <ul class="list-group mt-3">
            @foreach($pausedTrainings as $training)
                @if($training)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $training->title }}</strong><br>
                            <strong>{{ $training->trainer->name }} {{ $training->trainer->trainer->last_name }}</strong><br>
                            <strong>{{ $training->AdditionalSetting->country->name }} - {{ $training->AdditionalSetting->city }}</strong><br>
                            <strong>{{ $training->total_duration_hours }} ساعة</strong><br>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-warning">عرض التفاصيل</a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif

    {{-- تدريب مؤسسي --}}
    @if(count($pausedOrgTrainings))
        <ul class="list-group mt-3">
            @foreach($pausedOrgTrainings as $orgTraining)
                @if($orgTraining)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $orgTraining->title }}</strong><br>
                            <strong>{{ $orgTraining->organization->user->name }}</strong><br>
                            <strong>{{ $orgTraining->country->name }} - {{ $orgTraining->city }}</strong><br>
                            <strong>{{ count($orgTraining->details) }} برامج</strong><br>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-warning">عرض التفاصيل</a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif

    @if(!count($pausedTrainings) && !count($pausedOrgTrainings))
        <div class="alert alert-secondary mt-3">لا توجد تدريبات معلقة.</div>
    @endif
</section>
    </div>
</body>
</html>