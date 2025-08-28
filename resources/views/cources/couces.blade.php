@extends('frontend.layouts.master')
@section('title', 'مسار تصميم تجربة المستخدم')
@section('content')
    <style>
        .blue-light-header {
            background-color: #D9E6FF;
            background-size: cover;
            color: black;
            padding: 50px 0 0px;
            position: relative;
            margin-bottom: 30px;
        }

        .training-path-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .training-tag {
            background-color: #1a73e8;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-left: 30px;
        }

        .info-item img {
            margin-left: 10px;
        }

        .description {
            margin: 20px 0;
            line-height: 1.6;
        }

        .creator-info {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .creator-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-left: 15px;
            border: 1px solid #000;
        }

        .join-section {
            margin-bottom: 10px;
            width: 367px;
        }


        .time-left {
            color: #F55157;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .participants {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .avatar-stack {
            display: flex;
            position: relative;
            height: 40px;
            margin-top: 10px;
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

        .info-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            margin-top: -50px;
            text-align-last: center;
        }

        .info-card-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .info-card-item {
            width: 16.66%;
    align-self: center;
            text-align: right;
            align-items: center;
            padding: 0 5px;
              justify-items: start;
        }

        .info-card-item-value {
          text-align-last: right;
            font-size: 20px;
            font-weight: 600;
            color: #0F1114;
        }

        .info-card-item-label {
            font-size: 14px;
            color: #5B6780;
        }

        .tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            flex-wrap: wrap;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #777;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
        }

        .tab.active {
            color: #003090;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #003090;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .learning-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .learning-item img {
            margin-left: 10px;
            margin-top: 3px;
        }

        .audience-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .audience-tag {
            background-color: #1a73e8;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

        .training-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .training-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            cursor: pointer;
        }

        .training-item-info {
            display: flex;
            align-items: center;
        }

        .training-item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            margin-left: 15px;
        }

        .training-item-details {
            flex: 1;
        }

        .training-item-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .training-item-meta {
            display: flex;
            flex-wrap: wrap;
            font-size: 14px;
            color: #777;
        }

        .training-item-meta span {
            margin-left: 15px;
        }

        .training-item-content {
            display: none;
            padding: 15px;
            border-top: 1px solid #ddd;
        }

        .training-item.active .training-item-content {
            display: block;
        }

        .training-item.active .arrow-icon {
            transform: rotate(180deg);
        }

        .arrow-icon {
            transition: transform 0.3s;
        }

        .sessions-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sessions-table th,
        .sessions-table td {
            padding: 10px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }

        .sessions-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .facilitator {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .facilitator-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-left: 15px;
        }

        .organization-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .organization-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin-left: 20px;
        }

        .organization-details h3 {
            margin-bottom: 5px;
        }

        .organization-rating {
            color: #f5a623;
        }

        .organization-description {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .training-type {
            background-color: #005FDC;
            color: #ffffff;
        }

        .info-box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .info-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .trainer-card {
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .trainer-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .trainer-position {
            font-size: 14px;
            color: #777;
        }

        .trainer-rating {
            display: flex;
            align-items: center;
        }

        .trainer-bio {
            line-height: 1.6;
            color: #555;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .facilitators-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .facilitator-card {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .facilitator-name {
            font-size: 16px;
            font-weight: 500;
        }

        .session-schedule {
            margin-top: 30px;
        }

        .session-schedule .card {
            border-radius: 8px;
            overflow: hidden;
        }

        .session-schedule .table {
            margin-bottom: 0;
        }

        .session-schedule .table th,
        .session-schedule .table td {
            text-align: center;
            padding: 12px;
        }

        /* تعديلات للشاشات المتوسطة والصغيرة */
        @media (max-width: 992px) {
            .info-card-item {
                width: 33.33%;
  margin-bottom: 20px;
                /* 3 عناصر في السطر للشاشات المتوسطة */
            }

            .img-orgtrainer {
                display: none;

            }

            .blue-light-header {
                padding: 30px 0 0px;
            }

            .join-section {
                width: 100%;
                max-width: 367px;
            }
        }

        @media (max-width: 768px) {
            .info-card-item {
                width: 50%;
                  
                /* عنصرين في السطر للشاشات الصغيرة */
            }

            .info-card-item-label {
                font-size: 12px;
                /* تصغير الخط للشاشات الصغيرة */
            }

            .info-card-item-value {
                font-size: 18px;
                /* تصغير الخط للشاشات الصغيرة */
            }

            .blue-light-header .row {
                flex-direction: column;
            }

            .blue-light-header .col-lg-7 {
                order: 2;
            }

            .blue-light-header .col-lg-5 {
                order: 1;
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }


        }

        @media (max-width: 576px) {
            .info-card-item {
                width: 100%;
                /* عنصر واحد في السطر للشاشات الصغيرة جداً */
            }

            .info-card-item-label {
                font-size: 12px;
            }

            .info-card-item-value {
                font-size: 18px;
            }

            .img-orgtrainer {
                max-width: 100%;
                height: auto;
            }

            .training-meta {
                flex-direction: column;
                gap: 10px;
            }

            .training-meta span {
                margin-left: 0 !important;
            }
        }

        /* تعديلات خاصة بشاشات اللابتوب */
        @media (min-width: 992px) and (max-width: 1200px) {
            .info-card-item-label {
                font-size: 12px;
                /* تصغير الخط ليتناسب مع شاشات اللابتوب */
            }

            .info-card-item-value {
                font-size: 20px;
                /* تصغير الخط ليتناسب مع شاشات اللابتوب */
            }

            .img-orgtrainer {
                max-width: 90%;
                height: auto;
            }
        }

        .img-orgtrainer {
            max-width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: contain;

        }
                @media (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 100%;
              
            }}
    </style>

    <!-- Blue Header Section -->
    <div class="blue-light-header full-width-header">
        <div class="container ">
            <div class="row px-5">
                <!-- العمود الأول للمعلومات -->
                <div class="col-12 col-lg-8 ps-5">
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
                            <img src="{{ asset('images/cources/language-black.svg') }}">
                            لغة المسار التدريبي - عربية</span>
                        <span class="ms-sm-3">
                            <img src="{{ asset('images/cources/Training-type-black.svg') }}">
                            نوع المسار التدريبي - مخيم</span>
                    </div>
                    <div class="description">
                        تمهّد هذه الدورة الطريق لدخول عالم تصميم تجربة المستخدم من خلال محتوى عملي ومبسط يغطّي المبادئ
                        الأساسية وأدوات البحث والتخطيط والنمذجة. ستتعلمين كيفية فهم احتياجات المستخدم، بناء الحلول بناءً على
                        البيانات، وتحويل الأفكار إلى تجارب رقمية فعّالة. الدورة مصممة لتناسب المبتدئين والراغبين بتطوير
                        مهاراتهم في مجال تصميم المنتجات الرقمية.
                    </div>
                    <div class="creator-info">
                        <img src="{{ asset('images/icons/user.svg') }}" alt="Syrian Geeks" class="creator-image">
                        <span>تم الإنشاء بواسطة Syrian Geeks</span>
                    </div>
                    <div class="">
                        <button class="join-section custom-btn">انضم الآن
                            <br>
                            <span dir="ltr">1999.9$</span>
                        </button>
                    </div>
                    <div class="time-left">متبق 5 أيام و 4 ساعات على انتهاء التسجيل . 3 مقاعد متاحة</div>

                    <!-- تعديل قسم المشاركين ليكون في سطرين -->
                    <div class="participants">
                        <div class="mb-2">
                            <span>انضم أحمد ياسر و 55 آخرون</span>
                        </div>
                        <div class="avatar-stack">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="مستخدم" class="user-avatar">
                        </div>
                    </div>
                </div>

                <!-- العمود الثاني للصورة -->
                <div class="col-12 col-lg-4 d-flex align-items-end px-5">
                    <img src="{{ asset('images/cources/orgtraining-bg.png') }}" alt="تصميم تجربة المستخدم"
                        class="img-orgtrainer">
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">

        <!-- بطاقة المعلومات -->
        <div class="info-card">
            <div class="info-card-row">
                <div class="info-card-item">
                    <div class="info-card-item-value">7 تدريبات</div>
                    <div class="info-card-item-label">محتويات المسار</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">للمبتدئين</div>
                    <div class="info-card-item-label">مستوى المسار</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">30 ساعة</div>
                    <div class="info-card-item-label">عدد الساعات التدريبية</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">حضوري</div>
                    <div class="info-card-item-label">طريقة تقديم المسار</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">من خلال المنصة</div>
                    <div class="info-card-item-label">طريقة التسجيل</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-item-value">تركيا, اسطنبول, الفاتح</div>
                    <div class="info-card-item-label">مكان تقديم المسار</div>
                </div>
            </div>
        </div>

        <!-- التابات -->
        <div class="tabs">
            <div class="tab active" data-tab="learn">ماذا ستتعلم؟</div>
            <div class="tab" data-tab="info">معلومات المسار</div>
            <div class="tab" data-tab="content">محتوى المسار</div>
            <div class="tab" data-tab="facilitators">ميسرو المسار</div>
        </div>

        <!-- محتوى التابات -->
        <div class="tab-content active" id="learn">
            <h3>النتائج التعليمية من المسار التدريبي</h3>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>فهم أساسيات تجربة المستخدم (UX) ومبادئ التصميم</span>
            </div>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>إجراء بحث المستخدم وتحليل الاحتياجات</span>
            </div>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>تصميم واجهات مستخدم فعالة وجذابة</span>
            </div>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>إنشاء نماذج أولية واختبارها</span>
            </div>
        </div>

        <div class="tab-content" id="info">
            <h3>الفئة المستهدفة من المسار التدريبي</h3>
            <div class="info-block-content-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>المستوى العلمي</span>
            </div>
            <div class="audience-tags">
                <span class="audience-tag">بكالوريوس</span>
                <span class="audience-tag">ماجستير</span>
                <span class="audience-tag">دكتوراه</span>
            </div>

            <h3 class="mt-4">المتطلبات أو الشروط اللازمة للالتحاق بالمسار</h3>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>قدرة على استخدام الحاسوب والتعامل مع الإنترنت</span>
            </div>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>اهتمام بمجال التصميم وتجربة المستخدم</span>
            </div>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>رغبة في تطوير المهارات الرقمية</span>
            </div>

            <h3 class="mt-4">ميزات المسار</h3>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>محتوى تدريبي متكامل يغطي أساسيات ومهارات تصميم تجربة المستخدم</span>
            </div>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>تدريب عملي على مشاريع حقيقية</span>
            </div>
            <div class="learning-item">
                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="تحقق">
                <span>شهادة إتمام معتمدة</span>
            </div>
        </div>

        <div class="tab-content" id="content">
            <div class="training-item">
                <div class="training-item-header" onclick="toggleTraining(this)">
                    <div class="training-item-info">
                        <img src="{{ asset('images/icons/training1.svg') }}" alt="التدريب 1"
                            class="training-item-image">
                        <div class="training-item-details">
                            <div class="training-item-title">بدء مشروع ناجح</div>
                            <div class="training-item-meta">
                                <span>التدريب 1</span>
                                <span>17 ساعة</span>
                                <span>المدرب أحمد رفاعي</span>
                            </div>
                        </div>
                    </div>
                    <svg class="arrow-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 10L12 15L17 10" stroke="#333" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="training-item-content">
                    <div class="session-schedule">
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
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="p-3 text-center">الأحد</td>
                                                <td class="p-3 text-center">2023-06-01</td>
                                                <td class="p-3 text-center">09:00 - 11:00</td>
                                                <td class="p-3 text-center">2 ساعة</td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="p-3 text-center">الاثنين</td>
                                                <td class="p-3 text-center">2023-06-02</td>
                                                <td class="p-3 text-center">09:00 - 12:00</td>
                                                <td class="p-3 text-center">3 ساعات</td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="p-3 text-center">الثلاثاء</td>
                                                <td class="p-3 text-center">2023-06-03</td>
                                                <td class="p-3 text-center">09:00 - 11:00</td>
                                                <td class="p-3 text-center">2 ساعة</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="training-item">
                <div class="training-item-header" onclick="toggleTraining(this)">
                    <div class="training-item-info">
                        <img src="{{ asset('images/icons/training2.svg') }}" alt="التدريب 2"
                            class="training-item-image">
                        <div class="training-item-details">
                            <div class="training-item-title">تصميم واجهات المستخدم</div>
                            <div class="training-item-meta">
                                <span>التدريب 2</span>
                                <span>13 ساعة</span>
                                <span>المدربة سارة أحمد</span>
                            </div>
                        </div>
                    </div>
                    <svg class="arrow-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 10L12 15L17 10" stroke="#333" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="training-item-content">
                    <div class="session-schedule">
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
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="p-3 text-center">الأربعاء</td>
                                                <td class="p-3 text-center">2023-06-04</td>
                                                <td class="p-3 text-center">09:00 - 12:00</td>
                                                <td class="p-3 text-center">3 ساعات</td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="p-3 text-center">الخميس</td>
                                                <td class="p-3 text-center">2023-06-05</td>
                                                <td class="p-3 text-center">09:00 - 11:00</td>
                                                <td class="p-3 text-center">2 ساعة</td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td class="p-3 text-center">الجمعة</td>
                                                <td class="p-3 text-center">2023-06-06</td>
                                                <td class="p-3 text-center">09:00 - 12:00</td>
                                                <td class="p-3 text-center">3 ساعات</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="facilitators">
            <div class="info-box mt-5">
                <h4 class="info-title">مقدم التدريب</h4>
                <div class="trainer-card d-flex flex-column flex-md-row align-items-start gap-4">
                    <a href="#"
                        style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                        <div class="trainer-image text-center">
                            <img src="{{ asset('images/icons/user.svg') }}" alt="أحمد الرفاعي" class="custom-rounded"
                                width="120" height="120">
                        </div>
                        <div class="text-start align-self-center">
                            <h5 class="trainer-name mb-1">Syrian Geeks</h5>
                            <p class="trainer-position mb-2">منظمة غير ربحية</p>
                            <div class="trainer-rating mb-2">
                                <img src="{{ asset('images/cources/Star.svg') }}" alt="نجمة">
                                <img src="{{ asset('images/cources/Star.svg') }}" alt="نجمة">
                                <img src="{{ asset('images/cources/Star.svg') }}" alt="نجمة">
                                <img src="{{ asset('images/cources/Star.svg') }}" alt="نجمة">
                                <img src="{{ asset('images/cources/Star-half.svg') }}" alt="نصف نجمة">
                            </div>
                        </div>
                    </a>
                </div>
                <p class="trainer-bio mt-3">مجتمع معرفي نابض بالحياة يهدف إلى تزويد الشباب السوري بالمعرفة والمهارات والأدوات الضرورية التي تساعدهم على
                دخول سوق العمل الحر بثقة واحترافية. يوفر هذا المجتمع بيئة تعليمية تشجع على الابتكار والتعاون، مما يمكّن
                الشباب من تطوير مهاراتهم وتحقيق طموحاتهم المهنية.
</p>

                <h5 class="section-title mt-5">ميسرو التدريب</h5>
                <div class="facilitators-container d-flex flex-column flex-md-row gap-4">
                    <div class="facilitator-card d-flex align-items-center gap-3">
                        <img src="{{ asset('images/icons/facilitator1.svg') }}" alt="محمد عوايدة" class="rounded-circle"
                            width="60" height="60">
                        <span class="facilitator-name">محمد عوايدة</span>
                    </div>
                    <div class="facilitator-card d-flex align-items-center gap-3">
                        <img src="{{ asset('images/icons/facilitator2.svg') }}" alt="أحمد ياسر" class="rounded-circle"
                            width="60" height="60">
                        <span class="facilitator-name">أحمد ياسر</span>
                    </div>
                    <div class="facilitator-card d-flex align-items-center gap-3">
                        <img src="{{ asset('images/icons/facilitator3.svg') }}" alt="سارة أحمد" class="rounded-circle"
                            width="60" height="60">
                        <span class="facilitator-name">سارة أحمد</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // تبديل التابات
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // إزالة النشط من جميع التابات والمحتويات
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                // إضافة النشط للتاب المحدد ومحتواه
                tab.classList.add('active');
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // تبديل عرض محتوى التدريب
        function toggleTraining(header) {
            const trainingItem = header.parentElement;
            trainingItem.classList.toggle('active');
        }
    </script>
@endsection
@section('scripts')
@endsection
