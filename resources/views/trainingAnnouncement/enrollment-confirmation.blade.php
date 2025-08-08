@extends('frontend.layouts.master')

@section('title', 'تم إرسال طلب انضمامك بنجاح')

@section('css')

@endsection

@section('content')
@php
    $program_id = request()->query('program_id');
    $program = \App\Models\TrainingProgram::with('AdditionalSetting')->find($program_id); // تحميل البرنامج والعلاقة
@endphp
        <div class="training-finished-page-wrapper">
            <div class="training-finished-page">
                <img src="../images/training-finished.svg" alt="">
                <div class="training-finished-page-content">
                    <h1>تم إرسال طلب انضمامك <div class="text-underlined text-top">بنجاح</div>
                    </h1>
                    <p>
                        تم إرسال طلب انضمامك بنجاح. يرجى إتمام عملية الدفع وفقًا للتعليمات الموجودة أدناه، وسيتم مراجعة طلبك
                        والموافقة عليه بعد استلام إثبات الدفع. يمكنك متابعة حالة الطلب من صفحة "تدريباتي". </p>
                    <a href="{{ route('show_trainings_announcements', $program_id) }}" class="pbtn pbtn-main piconed">
                        <span>انتقل لصفحة التدريب </span>
                        <img src="../images/arrow-left.svg" alt="">
                    </a>
                </div>
            </div>
        </div>
@php
    $program_id = request()->query('program_id');
    $program = \App\Models\TrainingProgram::with('AdditionalSetting')->find($program_id); // تحميل البرنامج والعلاقة
@endphp

  <div class="training-finished-page-wrapper">
        <div class="training-finished-page" style="margin-top: 0px; padding: 20px; background-color:#D9E6FF;">
           @if (!empty($program) && $program->AdditionalSetting)
            @if ($program->AdditionalSetting->is_free)
  
                <div class="alert alert-warning text-center w-100 m-0">
                    التدريب مجاني تم ارسال الطلب الى المدرب
                </div>
            @elseif (!empty($program->AdditionalSetting->payment_method))
                <div class="info-block-content bordered">
                    آلية الدفع:
                    {{ $program->AdditionalSetting->payment_method }}
                </div>
            @else
                <div class="alert alert-secondary text-center w-100 m-0">
                    لم يتم تحديد آلية الدفع
                </div>
            @endif
        @else
            <div class="alert alert-danger text-center w-100 m-0">
                لم يتم العثور على إعدادات البرنامج التدريبي
            </div>
        @endif
        </div>
    </div>

@endsection

@section('scripts')
@endsection
