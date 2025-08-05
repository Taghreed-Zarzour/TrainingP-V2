@extends('frontend.layouts.master')

@section('title', 'التدريبات')

@section('css')

@endsection

@section('content')

    <style>
    

        .training-card {
            border-radius: 20px;
            border: 1px solid #ddd;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: white;
            margin: 30px auto;
        }

        .training-header {
            padding: 40px;
        }

        .training-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .info-section {
            padding: 0 40px 40px;
        }

        .info-item {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .info-icon {
            margin-left: 10px;
            width: 24px;
            height: 24px;
        }

        .price-divider {
            border-top: 1px solid #eee;
            margin: 25px 0;
            position: relative;
        }

        .price-divider::before {
            content: "";
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #eee;
        }

        .price-section {
            display: flex;
            justify-content: space-between;
            align-items: center;

            width: 100%;
        }

        .price {
            font-weight: bold;
            font-size: 1.3rem;
            color: #003090;
        }

        .training-title {
            font-weight: bold;
            font-size: 2rem;
            margin: 30px 0 10px;
            color: #333;
        }

        .trainer-name {
            font-weight: 500;
            font-size: 1.3rem;
            margin-bottom: 20px;
        }

        .info-container {
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
        }

        /* تعديلات لموضع الصورة والمحتوى */
        .image-column {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .content-column {
            height: 100%;
        }

        /* تعديلات للهوامش */
        .container-xxl {
            padding-right: 40px;
            padding-left: 40px;
        }

        @media (max-width: 1200px) {
            .training-header {
                padding: 30px;
            }

            .info-container {
                padding: 25px;
            }

            .container-xxl {
                padding-right: 30px;
                padding-left: 30px;
            }
        }

        @media (max-width: 992px) {
            .training-header {
                padding: 25px;
            }

            .info-section {
                padding: 0 25px 25px;
            }

            .training-image {
                min-height: 300px;
                max-height: 450px;
                margin-bottom: 25px;
            }

            .container-xxl {
                padding-right: 25px;
                padding-left: 25px;
            }
        }

        @media (max-width: 768px) {
            .training-header {
                padding: 20px;
            }

            .info-section {
                padding: 0 20px 20px;
            }

            .info-container {
                padding: 20px;
            }

            .training-image {
                min-height: 250px;
            }

            .training-title {
                font-size: 1.8rem;
            }

            .container-xxl {
                padding-right: 20px;
                padding-left: 20px;
            }
        }

        @media (max-width: 576px) {
            .training-header {
                padding: 15px;
            }

            .info-section {
                padding: 0 15px 15px;
            }

            .info-container {
                padding: 15px;
            }

            .training-title {
                font-size: 1.6rem;
                text-align: center;
            }

            .trainer-name {
                text-align: center;
            }

            .container-xxl {
                padding-right: 0px;
                padding-left: 0px;
            }
        }

        /* تبويبات جديدة بدون تضارب */
        .simple-tabs {

            border-bottom: 1px solid #8F8F8F;
        }

        .simple-tabs .nav-link {
            color: #6D6D6D;
            font-weight: 500;
            padding: 12px 20px;
            border: none;
            position: relative;
            margin-bottom: -1px;
            background: transparent;
        }

        .simple-tabs .nav-link:hover {
            color: #003090;

        }

        .simple-tabs .nav-link.active {
            color: #003090;
            font-weight: bold;
            background: transparent;
            border: none;
        }

        .simple-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 3px;
            border-bottom: 2px solid #003090;
            text-align: center;
        }

        .simple-tabs .nav-link:not(.active)::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 1px;
            background-color: #e0e0e0;
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
                    التدريبات/التدريبات الجارية/تدريب أساسيات تجربة المستخدم/قائمة المسجلين
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl ">
        <div class="training-card">
            <div class="training-header">
                <div class="row align-items-center">
                    <!-- الصورة على اليمين -->
                    <div class="col-lg-4   image-column">
                        <img src="{{ asset('images/cources/sample-course.jpg') }}" class="training-image"
                            alt="صورة التدريب">
                    </div>

                    <!-- المعلومات على اليسار -->
                    <div class="col-lg-8   content-column">
                        <div class="info-container h-100">
                            <div class="row h-100">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <img src="/images/cources/type-program.svg" class="info-icon" alt="نوع البرنامج">
                                        <span>نوع البرنامج: تدريب</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/level.svg" class="info-icon" alt="مستوى التدريب">
                                        <span>مستوى التدريب: مبتدئ</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/clock2.svg" class="info-icon" alt="عدد الجلسات">
                                        <span>عدد الجلسات: 10 جلسات</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/members.svg" class="info-icon" alt="العدد الأقصى">
                                        <span>العدد الأقصى للمشاركين: 20 مشارك</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/location2.svg" class="info-icon" alt="مكان التدريب">
                                        <span>مكان التدريب: تركيا، اسطنبول، الفاتح</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/calender-primary.svg" class="info-icon"
                                            alt="تاريخ الانتهاء">
                                        <span>تاريخ انتهاء التقديم: 11 تشرين الثاني 2025</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <img src="/images/cources/language-primary.svg" class="info-icon" alt="لغة التدريب">
                                        <span>لغة التدريب: عربية</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/calssification.svg" class="info-icon" alt="تصنيف التدريب">
                                        <span>تصنيف التدريب: العلوم والتكنولوجيا</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/type.svg" class="info-icon" alt="طريقة التقديم">
                                        <span>طريقة تقديم التدريب: حضوري</span>
                                    </div>
                                    <div class="info-item">
                                        <img src="/images/cources/Register.svg" class="info-icon" alt="طريقة التسجيل">
                                        <span>طريقة التسجيل: من خلال المنصة</span>
                                    </div>
                                </div>
                            </div>

                            <!-- سعر الاشتراك مع حد علوي فقط -->
                            <div class="price-divider"></div>
                            <div class="price-section">
                                <strong>سعر الاشتراك</strong>
                                <strong class="price">199.9$</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- عنوان التدريب واسم المدرب في سطر جديد تحت الصورة -->
            <div class="info-section">
                <h1 class="training-title ">أساسيات تصميم تجربة المستخدم (UX Design Fundamentals)</h1>
                <p class="trainer-name">المدرب: أحمد الرفاعي</p>
            </div>




<div class="container-fluid py-3">
    <!-- التبويبات الرئيسية -->
    <ul class="nav simple-tabs justify-content-around mb-4" id="mainTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link " data-bs-toggle="tab" href="#stats">إحصائيات</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-bs-toggle="tab" href="#sessions">الجلسات التدريبية</a>
        </li>

        @if (1===1)
                <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#registrants">المسجلون</a>
        </li>

        @else
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#trainees">المتدربون</a>
        </li>
        @endif



        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#info">معلومات التدريب</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#attachments">المرفقات</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#assistants">مساعدو المدرب</a>
        </li>
    </ul>

    <!-- محتوى التبويبات -->
    <div class="tab-content">
        <div class="tab-pane fade" id="stats">
           @include('cources.tabs.statistics') 
        </div>
        <div class="tab-pane fade " id="sessions">
            @include('cources.tabs.sessions')
        </div>

        <div class="tab-pane fade" id="registrants">
            @include('cources.tabs.registrants')
        </div>

        <div class="tab-pane fade" id="trainees">
            @include('cources.tabs.trainees')
        </div>



        <div class="tab-pane fade" id="info">
            @include('cources.tabs.info')
        </div>
        <div class="tab-pane fade show active" id="attachments">
            @include('cources.tabs.attachments')
        </div>
        <div class="tab-pane fade" id="assistants">
            @include('cources.tabs.assistants')
        </div>
    </div>
</div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // تبديل بين العرض الشبكي والعرض كقائمة
            $('.view-toggle-btn').click(function() {
                $('.view-toggle-btn').removeClass('active');
                $(this).addClass('active');

                if ($(this).data('view') === 'grid') {
                    $('#traineesGrid').removeClass('d-none');
                    $('#traineesList').addClass('d-none');
                } else {
                    $('#traineesGrid').addClass('d-none');
                    $('#traineesList').removeClass('d-none');
                }
            });

            // تحديد الكل
            $('#selectAll').change(function() {
                const isChecked = $(this).prop('checked');
                $('.trainee-card').toggleClass('selected', isChecked);
                $('.selected-indicator').toggle(isChecked);
            });

            // تحديد بطاقة فردية
            $('.trainee-card').click(function(e) {
                if (!$(e.target).closest('button').length) {
                    $(this).toggleClass('selected');
                    $(this).find('.selected-indicator').toggle();
                }
            });
        });


        $('#selectAll').change(function() {
            $('.item-checkbox').prop('checked', this.checked);
        });
    </script>
@endsection
