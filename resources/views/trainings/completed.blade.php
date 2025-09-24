@extends('frontend.layouts.master')

@section('title', 'تم نشر التدريب بنجاح')

@section('css')

@endsection

@section('content')
    <main>
        <div class="training-finished-page-wrapper">
            <div class="training-finished-page">
                <img src="../images/training-finished.svg" alt="">
                <div class="training-finished-page-content">
                    <h1>تم نشر التدريب <div class="text-underlined text-top">بنجاح</div>
                    </h1>
                    <p>
                        أصبح تدريبك الآن جاهزًا للعرض على المنصة ويمكن للمستخدمين التسجيل وفق الإعدادات التي حددتها
                        يمكنك
                        متابعة حالة التسجيلات، إدارة الجلسات، والتفاعل مع المتدربين من خلال صفحة التدريب.</p>

                    <a href="{{ route('training.details', ['id' => $training->id]) }}#info"
                        class="pbtn pbtn-main piconed">
                        <span>انتقل لصفحة التدريب </span>
                        <img src="{{ asset('images/arrow-left.svg') }}" alt="">
                    </a>


                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
@endsection
