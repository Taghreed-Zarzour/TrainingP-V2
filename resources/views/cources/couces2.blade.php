@extends('frontend.layouts.master')

@section('title', 'التدريبات')

@section('css')

@endsection

@section('content')

    <style>
        .full-width-header {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
        }

        .blue-header {
            background-image: url(../images/cources/background.svg);
            background-color: #003090;
            color: white;
            padding: 50px 0 30px;
            position: relative;
            margin-bottom: 50px;
        }

        .cards-container {
            position: relative;
            margin-bottom: 30px;
        }

        .small-card {
            position: relative;
            background-color: white;
            border-radius: 10px;
            border: 2px solid #EFF0F6;
            z-index: 20;
            padding: 30px;
            margin-top: -250px;
            margin-bottom: 30px;
        }

        .large-card {
            background-color: white;
            border-radius: 10px;
            min-height: 300px;
        }

        .price-section {
            margin-bottom: 15px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;

        }

        .time-left {
            color: #F55157;
            font-weight: 500;
            font-size: 14px;
        }

        .btn-join {
            background-color: #1a73e8;
            color: white;
            width: 100%;
            margin-bottom: 10px;
        }

        .training-details {
            margin-top: 20px;
        }

        .detail-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ddd;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-title {
            font-weight: bold;
            color: #555;
        }

        .user-join-container {
            display: flex;
            align-items: start;
            gap: 10px;
      
            direction: rtl;
            flex-direction: column;
        }

        .avatar-stack {
            display: flex;
            position: relative;
            height: 40px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .user-avatar:not(:first-child) {
            margin-right: -20px;
        }

        .join-text {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 5px;
        }



        .training-type {
            background-color: white;
            color: #003090;
            display: inline-block;
            padding: 3px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            margin-left: 8px;
            vertical-align: middle;
        }

        .trainer-name {
            margin-bottom: 10px;
        }

        .training-meta {
            margin-bottom: 15px;
        }

        .training-meta span {
            margin-left: 15px;
        }

        .info-box {
            border: 2px solid #EFF0F6;
            border-radius: 32px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-title {
            color: #333333;
            margin-bottom: 15px;

            padding-bottom: 10px;
        }

        .square-image {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 16px;
        }

        /* تحسينات للاستجابة */
        @media (max-width: 992px) {
            .small-card {
                margin-top: 0px;
            }
        }

        @media (max-width: 768px) {


            .training-meta span {
                display: block;
                margin-left: 0;
                margin-bottom: 5px;
            }
        }

        .custom-btn {
            padding: 10px 24px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            background-color: #003090;
            color: #ffffff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .custom-btn:hover {
            background-color: #001f5a;
        }

        .custom-share-btn {
            padding: 10px 10px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            background-color: #D9E6FF;
            color: #003090;
            border: none;
            transition: background-color 0.3s ease;
        }

        .custom-share-btn:hover {
            background-color: #8bb4ff;
        }





        /*تنسيقات الجدول*/
        .session-schedule {

        }

        .session-schedule .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 15px;
        }

        .session-schedule .info-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
            text-align: right;
            /* المحاذاة اليمنى للعنوان */
        }

        .session-schedule .table {
            width: 100%;
        }

        .session-schedule th {
            font-weight: 600;
            color: #495057;
            background-color: #D9E6FF;
        }

        .session-schedule td {
            color: #6c757d;
        }

        .text-center {
            text-align: center !important;
            vertical-align: middle !important;
        }

        @media (max-width: 768px) {
            .session-schedule .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .session-schedule th,
            .session-schedule td {
                white-space: nowrap;
                min-width: 120px;
            }

            .session-schedule .info-title {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {

            .session-schedule th,
            .session-schedule td {
                padding: 0.75rem 0.5rem;
                font-size: 0.9rem;
            }
        }

        @media (min-width: 992px) {

            /* ابتداء من lg */
            .text-lg-force-right {
                text-align: right !important;
            }
        }


        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .trainer-card {
            padding: 10px;
        }

        .custom-rounded {
            border-radius: 20px !important;
            /* أو أي قيمة أكبر مثل 20px */
        }

        .trainer-image img {
            object-fit: cover;
            border: 3px solid #D9E6FF;

        }



        .trainer-position {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .trainer-rating {
            font-size: 1rem;
        }

        .trainer-bio {
            color: #34495e;
            line-height: 1.6;
            font-size: 0.95rem;
        }


        .facilitator-card img {
            object-fit: cover;
        }

        .facilitator-name {
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .trainer-image img {
                width: 100px;
                height: 100px;
            }

            .facilitators-container {
                flex-direction: column;
                gap: 10px !important;
            }
        }

        @media (max-width: 576px) {
            .trainer-image img {
                width: 80px;
                height: 80px;
            }

            .facilitator-card img {
                width: 50px;
                height: 50px;
            }
        }
            .btn-cancel {
            padding: 10px 10px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #003090;
            color: #003090;
            background-color: white;
            transition: background-color 0.3s ease;
        }

        .btn-cancel:hover {
            background-color: #e4e4e4;
        }

        /* تنسيقات مخصصة للمودال */
        #confirmEnrollmentModal .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        #confirmEnrollmentModal .modal-header {
            padding: 0;
        }

        #confirmEnrollmentModal .modal-title {
            color: #003090;
            font-size: 1.25rem;
        }

        #confirmEnrollmentModal .btn-close {
            font-size: 1rem;
            margin-left: 0;
        }

        #confirmEnrollmentModal .btn {
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
        }

        /* تجاوبية */
        @media (max-width: 576px) {
            #confirmEnrollmentModal .modal-dialog {
                margin: 0.5rem;
            }

            #confirmEnrollmentModal .modal-title {
                font-size: 1.1rem;
            }

            #confirmEnrollmentModal .btn {
                padding: 0.6rem;
                font-size: 0.9rem;
            }
        }
          /* تنسيقات مخصصة للمودال */
        #inviteFriendModal .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        #inviteFriendModal .modal-header {
            padding: 1.5rem 1.5rem 0;
            position: relative;
            border: none;
        }

        #inviteFriendModal .modal-title {
            font-size: 1.5rem;
            color: #003090;
            text-align: center;
            width: 100%;
        }

        #inviteFriendModal .modal-body {
            padding: 0 1.5rem 1.5rem;
        }

        #inviteFriendModal .btn-close {
            position: absolute;

            font-size: 1rem;
        }

        .btn-social {

            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-social:hover {
            transform: translateY(-3px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* تجاوبية */
        @media (max-width: 768px) {
            #inviteFriendModal .modal-dialog {
                margin: 1rem auto;
            }

            .btn-social {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 576px) {
            #inviteFriendModal .modal-dialog {
                margin: 1rem;
            }

            #inviteFriendModal .modal-title {
                font-size: 1.25rem;
            }

            .btn-social {
                width: 36px;
                height: 36px;
            }

            .share-section .row>div {
                padding-right: 0;
                padding-left: 0;
            }
        }

        @media (max-width: 480px) {
            .share-section .row {
                flex-direction: column;
            }

            .share-section .col-md-9,
            .share-section .col-md-3 {
                width: 100%;
            }

            .share-section .col-md-3 {
                margin-top: 0.5rem;
            }
        }
    </style>

    <!-- Blue Header Section -->
    <div class="blue-header full-width-header">
        <div class="container d-flex justify-content-start">
            <div class="col-12 col-lg-7 text-center text-lg-force-right">
                <div class="title-wrapper">
                    <h1 class="d-inline-block lh-base">
                        برنامج تصميم تجربة المستخدم لتطبيقات الهواتف الذكية
                        <span class="training-type ms-2">تصميم</span>
                    </h1>
                </div>
                <div class="trainer-name">تم الإنشاء بواسطة:
                    <span class="text-decoration-underline">أحمد الرفاعي</span>
                </div>
                <div
                    class="training-meta d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start text-center text-lg-start">
                    <span class="mb-2 mb-sm-0">

                        <img src="{{ asset('images/cources/language.svg') }}" alt="لغة التدريب">

                        لغة التدريب: عربية</span>
                    <span class="ms-sm-3">

                        <img src="{{ asset('images/cources/Training-type.svg') }}" alt="نوع البرنامج">

                        نوع البرنامج: تدريب</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Container -->
    <div class="container">
        <div class="row flex-row-reverse flex-col-reverse ">
            <!-- Small Card -->
            <div class="col-lg-4 order-lg-1 ">
                <div class="small-card ">

                    <img src="{{ asset('images/cources/sample-course.jpg') }}" class="square-image" alt="صورة التدريب">
                    <div class="price-section mt-3 ">
                        <div class="price mb-3">سعر التسجيل: 199.9 دولار أمريكي</div>
                        <div class="time-left">
                            <img class="pe-2" src="{{ asset('images/cources/price.svg') }}" alt="سعر التسجيل">
                            متبق 5 أيام و 4 ساعات على انتهاء التسجيل
                        </div>
                    </div>
                    <h5>تفاصيل التدريب</h5>
                    <div class="training-details">
                        <div>
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/level.svg') }}" alt="مستوى التدريب">
                                مستوى التدريب: متقدم
                            </div>
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/type.svg') }}" alt="طريقة تقديم التدريب">
                                طريقة تقديم التدريب: حضوري
                            </div>
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/clock2.svg') }}" alt="عدد الساعات">
                                عدد الساعات: 30 ساعة
                            </div>
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/Register.svg') }}" alt="طريقة التسجيل">
                                طريقة التسجيل: من خلال المنصة
                            </div>
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/members.svg') }}" alt="العدد الأقصى للمشاركين">
                                العدد الأقصى للمشاركين: 20 مشارك
                            </div>
                            <div class="mb-3">
                                <img class="pe-2" src="{{ asset('images/cources/location2.svg') }}" alt="العدد الأقصى للمشاركين">
                                مكان التدريب: تركيا، اسطنبول، القاعة
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-12 col-md-7">
                            <button type="button" class="custom-btn w-100" data-bs-toggle="modal"
                                data-bs-target="#confirmEnrollmentModal">
                                انضم الآن ←
                            </button>
                        </div>
                        <div class="col-12 col-md-5">
                            <button type="button" class="custom-share-btn w-100" data-bs-toggle="modal"
                                data-bs-target="#inviteFriendModal">دعوة صديق</button>
                        </div>
                    </div>
                    <div class="user-join-container mt-4">
                        <div class="join-text">
                            <span class="join-message">انضم أحمد ياسر و 55 آخرون</span>
                        </div>
                        <div class="user-avatars">
                            <!-- سيكون هنا صور المستخدمين متداخلة -->
                            <div class="avatar-stack">
                                @foreach (range(1, 3) as $index)
                                    <img src="{{ asset('images/icons/user.svg') }}" alt="أحمد" class="user-avatar">
                                    <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                                @endforeach
                                <!-- يمكن إضافة المزيد من الصور هنا -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-lg-8 order-lg-2 ">
                <div class="large-card">
                    <div class="info-box">
                        <h4 class="info-title">ما الذي سيتعلمه المشاركون في هذا التدريب؟</h4>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-start mb-2">
                                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" class="me-2"
                                    width="20" height="20">
                                <span>
                                    تاريخ السياسات الجديدة المستخدم (UAX) وصلاح المصمم المركز على الإنسان.
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="info-box">
                        <h4 class="info-title">وصف التدريب</h4>
                        <p>هذا البرنامج التدريبي المكثف يهدف إلى تأهيل المصممين لفهم احتياجات المستخدمين وتصميم تجارب مستخدم
                            مميزة لتطبيقات الهواتف الذكية. سيتعلم المشاركون أحدث الأدوات والتقنيات في مجال تصميم تجربة
                            المستخدم، مع التركيز على الجوانب العملية والتطبيقية.</p>
                        <p>يشمل البرنامج جلسات نظرية وعملية، ودراسات حالة، وتطبيقات على مشاريع حقيقية. بنهاية البرنامج،
                            سيكون المشاركون قادرين على تصميم واجهات مستخدم فعالة وجذابة تلبي احتياجات المستخدمين وتزيد من
                            معدلات الاحتفاظ بالعملاء.</p>
                        <div class="mt-4">
                            <h4 class="info-title">الفئة المستهدفة من التدريب؟</h4>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-2">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" class="me-2"
                                        width="20" height="20">
                                    <span>
                                        المصممون المبتدئون الراغبون في دخول مجال تجربة المستخدم </span>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <h4 class="info-title">المتطلبات أو الشروط اللازمة للالتحاق بالتدريب</h4>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-2">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" class="me-2"
                                        width="20" height="20">
                                    <span>
                                        قدرة على استخدام الحاسوب والتعامل مع الإنترنت
                                </li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <h4 class="info-title">ميزات التدريب</h4>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-2">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check"
                                        class="me-2" width="20" height="20">
                                    <span>
                                        محتوى تدريبي متكامل يغطي أساسيات ومهارات تصميم تجربة المستخدم
                                </li>
                            </ul>
                        </div>
                        <div class="container mt-5">
                            <div class="mt-4 session-schedule">
                                <h4 class="info-title">جدولة الجلسات</h4>
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-borderless m-0">
                                                <thead>
                                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                                        <th class="p-3 text-center">اليوم</th>
                                                        <th class="p-3 text-center">التاريخ</th>
                                                        <th class="p-3 text-center">عنوان الجلسة</th>
                                                        <th class="p-3 text-center">مدة الجلسة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- الجلسة الأولى -->
                                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                                        <td class="p-3 text-center">الأحد</td>
                                                        <td class="p-3 text-center">22 حزيران</td>
                                                        <td class="p-3 text-center">مقدمة للدورة</td>
                                                        <td class="p-3 text-center">60 دقيقة</td>
                                                    </tr>
                                                    <!-- الجلسة الثانية -->
                                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                                        <td class="p-3 text-center">الاثنين</td>
                                                        <td class="p-3 text-center">23 حزيران</td>
                                                        <td class="p-3 text-center">أساسيات البرمجة</td>
                                                        <td class="p-3 text-center">90 دقيقة</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info-box">
                        <!-- عنوان القسم -->
                        <h4 class="info-title">مقدم التدريب</h4>
                        <!-- معلومات مقدم التدريب -->
                        <div class="trainer-card d-flex flex-column flex-md-row align-items-start  gap-4">
                            <!-- الصورة -->
                            <div class="trainer-image text-center">
                                <img src="{{ asset('images/icons/user.svg') }}" alt="أحمد الرفاعي"
                                    class="custom-rounded" width="120" height="120">
                            </div>
                            <!-- المعلومات -->
                            <div class="text-start align-self-center">
                                <h5 class="trainer-name mb-1">أحمد الرفاعي</h5>
                                <p class="trainer-position mb-2">مصمم تجربة مستخدم</p>
                                <!-- التقييم -->
                                <div class="trainer-rating mb-2">
                                    @foreach (range(1, 4) as $index)
                                        <img src="{{ asset('images/cources/Star.svg') }}" alt="نجمة">
                                    @endforeach
                                    <img src="{{ asset('images/cources/Star-gray.svg') }}" alt="نجمة">
                                </div>
                            </div>
                        </div>
                        <!-- النبذة -->
                        <p class="trainer-bio mt-3">
                            أنا متخصص وممارس في إدارة المنتجات الرقمية، حيث قمت بالإشراف على إنتاج 5 منتجات رقمية متميزة،
                            وأدرت فرقاً تتراوح أحجامها بين 10 إلى 20 شخصاً في كل فريق، مما ساهم في تحقيق نتائج رائعة.
                        </p>
                        <!-- ميسرو التدريب -->
                        <h5 class="section-title mt-5">ميسرو التدريب</h5>
                        <div class="facilitators-container d-flex flex-column flex-md-row gap-4">
                            <!-- الميسر الأول -->
                            <div class="facilitator-card d-flex align-items-center gap-3">
                                <img src="{{ asset('images/icons/user.svg') }}" alt="محمد عوابدة" class="rounded-circle"
                                    width="60" height="60">
                                <span class="facilitator-name">محمد عوابدة</span>
                            </div>
                          <!-- الميسر الثاني -->
                            <div class="facilitator-card d-flex align-items-center gap-3">
                                <img src="{{ asset('images/icons/user.svg') }}" alt="سامي الخطيب" class="rounded-circle"
                                    width="60" height="60">
                                <span class="facilitator-name">سامي الخطيب</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- المودال -->
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
                    <!-- وسائل التواصل -->
                    <div class="social-share">
                        <div class="d-flex justify-content-start flex-wrap gap-3 mb-4">
                            <a href="#" class="btn btn-social btn-facebook p-2">
                                <img src="{{ asset('images/cources/facebook.svg') }}" alt="فيسبوك">
                            </a>
                            <a href="#" class="btn btn-social btn-twitter p-2">
                                <img src="{{ asset('images/cources/twitter.svg') }}" alt="فيسبوك">
                            </a>
                            <a href="#" class="btn btn-social btn-linkedin p-2">
                                <img src="{{ asset('images/cources/linkedin.svg') }}" alt="لينكدان">
                            </a>
                            <a href="#" class="btn btn-social btn-email p-2">
                                <img src="{{ asset('images/cources/email.svg') }}" alt="ايميل">
                            </a>
                            <a href="#" class="btn btn-social btn-whatsapp p-2">
                                <img src="{{ asset('images/cources/SMS.svg') }}" alt="رسالة">
                            </a>
                        </div>
                    </div>

                    <!-- روابط المشاركة -->
                    <div class="share-section mb-4">
                        <div class="row align-items-center g-2">
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="shareLinkInput" readonly>
                            </div>
                            <div class="col-md-3">
                                <button class=" custom-btn w-100" type="button" id="copyLinkBtn">
                                    <i class="far fa-copy me-1"></i> نسخ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- مودال تأكيد الاشتراك -->
    <div class="modal fade" id="confirmEnrollmentModal" tabindex="-1" aria-labelledby="confirmEnrollmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <!-- رأس المودال مع زر الإغلاق على اليسار -->
                <div class="modal-header border-0 position-relative justify-content-end pb-3">
                    <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>

                <!-- محتوى المودال -->
                <div class="modal-body text-center pt-0">
                    <img src="{{ asset('/images/cources/join.svg') }}" />
                    <!-- عنوان المودال -->
                    <h5 class="modal-title fw-bold mb-3" id="confirmEnrollmentModalLabel">هل أنت متأكد من الاشتراك في هذا
                        التدريب؟</h5>

                    <!-- نص التحذير -->
                    <p class="text-muted mb-4">
                        عند تأكيد الاشتراك، سيتم إضافتك إلى قائمة المشاركين في تدريب "مهارات العرض التقديمي".<br>
                        قد يتطلب الأمر موافقة من المدرب أو خطوات إضافية.
                    </p>
                </div>

                <!-- أزرار التأكيد والإلغاء -->
                <div class="modal-footer border-0 d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="#" class="custom-btn flex-fill">نعم، أؤكد اشتراكي</a>

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
