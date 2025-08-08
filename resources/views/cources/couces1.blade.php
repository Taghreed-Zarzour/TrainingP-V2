@extends('frontend.layouts.master')

push('css')
@section('title', 'التدريبات')

@section('css')

@endsection

@section('content')

    <style>
        .hero-section {

            display: flex;
            flex-wrap: wrap;
            width: 100%;
            min-height: 400px;
            padding: 10px 40px;
        }

        .hero-image {
            flex: 1;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .hero-text {
            flex: 1;

            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: right;
        }

        .highlight {
            color: #0d6efd;
            font-weight: bold;
            text-decoration: underline;
        }

        .search-section {
            width: 100%;
            padding: 30px 15px;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
        }

        .search-bar {
            max-width: 900px;
            width: 100%;
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            flex-grow: 1;
            border-radius: 12px;
            padding: 10px 15px;
        }

        .intro-slogan {
            font-weight: 500;
            font-size: 2.5rem;
            line-height: 5rem;
            color: var(--color-heading);
            margin: 0 0 1.5rem 0;
            position: relative;
            text-align: right;
            padding: 0;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .intro-highlighted-text {
            position: relative;
            display: inline-block;
            color: var(--color-highlight);
            /* تأكد من تعريف هذا المتغير أو استخدم لون ثابت */
        }

        .intro-highlighted-text::after {
            content: "";
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 100%;
            height: 12px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 173 12' fill='none'%3E%3Cpath d='M2 9.99999C36.3365 -1.82835 84.0857 0.561548 171 10' stroke='%23003090' stroke-width='4' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: repeat-x;
            background-size: 173px 12px;
            z-index: 5;
        }

        .custom-search-bar {
            border: 1px solid #D9D9D9;
            border-radius: 12px;
            height: 85px;
            max-width: 1280px;
            opacity: 1;
        }

        .custom-filter-btn {
            border: 1px solid #5A5A5A;
            border-radius: 8px;
            background-color: #fff;
            color: #000;
            font-weight: 500;
            transition: all 0.2s ease;
            padding: 10px 20px;
        }

        .custom-filter-btn:hover {
            background-color: #f8f9fa;
            border-color: #bfbfbf;
        }





        @media (max-width: 992px) {
            .hero-section {
                flex-direction: column;
                align-items: center;
            }

            .intro-slogan {
                text-align: center;
                font-size: 2rem;
            }

            .text-align-center {
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .custom-search-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                height: auto;
                padding: 15px;
            }

            .custom-search-bar input {
                width: 100%;
                text-align: center;
            }

            .custom-filter-btn {
                width: 100%;
                justify-content: center;
            }
        }



        .card-slide {
            flex: 0 0 100%;
            max-width: 100%;
            transition: all 0.3s ease-in-out;
        }

        @media (min-width: 768px) {
            .card-slide {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (min-width: 992px) {
            .card-slide {
                flex: 0 0 25%;
                max-width: 25%;
            }
        }

        .badge-position {
            position: absolute;
            top: 31px;
            left: 11px;
            background-color: #003c80;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .trainer-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .trainer-info img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
        }

        .price-tag {
            font-weight: bold;
            color: white;
            background-color: #0d6efd;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 14px;
        }

        .price-free {
            background-color: #28a745 !important;
        }

        .arrow-btn {
            width: 36px;
            height: 36px;
            border: none;
            background-color: #003c80;
            color: white;
            border-radius: 8px;
        }

        .image-custom {
            padding: 10px;
        }

        .image-custom img {
            border-radius: 16px;
            max-height: 276px;
            object-fit: fill;
        }

        #cardCarousel {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE & Edge */
        }

        #cardCarousel::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .filter-btn {
            padding: 10px 24px;
  
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            background-color: #003090;
            color: #ffffff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .filter-btn:hover {
            background-color: #001f5a;
        }
    </style>
    <!-- ✅ السطر الأول: صورة يسار + نص يمين -->
    <div class="hero-section">



        <div class="hero-text">
            <h1 class="intro-slogan mb-3">
                طور مسيرتك المهنية ووسع فرصك في سوق العمل مع
                <span class="intro-highlighted-text">
                    TrainingP
                    <img src="{{ asset('images/cots-style.svg') }}" class="cots-style-img" alt="" />

                </span>
            </h1>
            <p class="mt-3 pb-3 text-muted text-align-center">
                اكتشف تدريبات مصممة خصيصًا لك، بإشراف نخبة من المدربين.<br />
                انطلق الآن، وتعلّم ما يفتح لك أبواب المستقبل.
            </p>
        </div>

        <div class="hero-image">
            <img src="{{ asset('images/cources/cources.svg') }}"alt="Training Image" />
        </div>

    </div>

    <!-- ✅ السطر الثاني: البحث + زر الفلترة -->
    <div class="container-fluid py-4 bg-white">
        <div class="row justify-content-center">
            <div class="col-md-11">

                <div
                    class="d-flex align-items-center justify-content-between px-3 py-2 shadow-sm bg-white custom-search-bar">
                    <div class="d-flex align-items-center ">
                        <!-- أيقونة البحث + النص (يمين) -->
                        <img src="{{ asset('images/cources/search.svg') }}"alt="search icon" />
                        <input type="text" class="form-control border-0 flex-grow-1" placeholder="ابحث عن أي شيء"
                            style="box-shadow: none; background: transparent;" />
                    </div>
                    <!-- زر فلترة مخصص -->
                    <button class="btn custom-filter-btn d-flex align-items-center gap-2" type="button"
                        data-bs-toggle="modal" data-bs-target="#filterModal">
                        <svg width="23" height="22" viewBox="0 0 23 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.4789 3.34844C22.3459 4.16944 21.5499 4.71744 20.7509 4.57844C20.7109 4.57144 16.6429 3.89844 11.4999 3.89844C6.35693 3.89844 2.28893 4.57144 2.24893 4.57844C1.43293 4.70944 0.658927 4.16444 0.520927 3.34844C0.383927 2.53144 0.933927 1.75744 1.75093 1.61944C1.92593 1.59044 6.09293 0.898438 11.4999 0.898438C16.9069 0.898438 21.0739 1.58944 21.2489 1.61944C22.0649 1.75744 22.6169 2.53044 22.4789 3.34844ZM18.2259 9.91644C16.6779 9.68044 14.2539 9.39844 11.4999 9.39844C8.74593 9.39844 6.32293 9.67944 4.77393 9.91644C3.95493 10.0404 3.39293 10.8064 3.51693 11.6244C3.63793 12.4484 4.42493 13.0094 5.22593 12.8814C6.67193 12.6614 8.93493 12.3994 11.4999 12.3994C14.0649 12.3994 16.3279 12.6624 17.7739 12.8814C18.5919 13.0094 19.3589 12.4444 19.4819 11.6244C19.6069 10.8064 19.0449 10.0404 18.2259 9.91644ZM15.6479 18.1054C12.8559 17.8304 10.1439 17.8304 7.35293 18.1054C6.52893 18.1874 5.92593 18.9214 6.00793 19.7464C6.08893 20.5704 6.81993 21.1704 7.64793 21.0924C10.2429 20.8344 12.7569 20.8344 15.3529 21.0924C16.1639 21.1754 16.9149 20.5744 16.9939 19.7464C17.0749 18.9224 16.4729 18.1874 15.6479 18.1054Z"
                                fill="#5A5A5A" />
                        </svg>
                        <span>فلترة</span>
                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.5012 14.0032C10.2025 14.0033 9.90663 13.9444 9.63065 13.83C9.35467 13.7157 9.10396 13.5479 8.89289 13.3365L3.45955 7.90069C3.35142 7.78181 3.29322 7.62585 3.29705 7.4652C3.30089 7.30454 3.36646 7.15154 3.48014 7.03796C3.59383 6.92438 3.7469 6.85896 3.90755 6.85527C4.06821 6.85159 4.22412 6.90993 4.34289 7.01819L9.77789 12.4507C9.97024 12.6428 10.231 12.7508 10.5029 12.7508C10.7748 12.7508 11.0355 12.6428 11.2279 12.4507L16.6612 7.01735C16.7797 6.90695 16.9364 6.84685 17.0983 6.84971C17.2602 6.85256 17.4147 6.91816 17.5292 7.03267C17.6437 7.14718 17.7093 7.30167 17.7122 7.46358C17.7151 7.6255 17.655 7.78221 17.5446 7.90069L12.1112 13.3365C11.8999 13.5481 11.649 13.716 11.3727 13.8304C11.0964 13.9448 10.8003 14.0035 10.5012 14.0032Z"
                                fill="#292D32" />
                        </svg>

                    </button>

                </div>

            </div>
        </div>
    </div>

    </div>


    <!-- ✅ مودال الفلترة -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content p-4">
                <div class="modal-header border-0 justify-content-end">
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <!-- التكلفة -->
                    <div class="mb-4">
                        <label class="form-label">التكلفة</label>
                        <div class="d-flex gap-4 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cost" id="all" checked>
                                <label class="form-check-label" for="all">جميع التدريبات</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cost" id="paid">
                                <label class="form-check-label" for="paid">تدريبات مدفوعة</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cost" id="free">
                                <label class="form-check-label" for="free">تدريبات مجانية</label>
                            </div>
                        </div>
                    </div>

                    <!-- الجهة المعلنة -->
                    <div class="mb-4">
                        <label class="form-label">الجهة المعلنة</label>
                        <div class="d-flex gap-4 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="provider" id="all2" checked>
                                <label class="form-check-label" for="all2">جميع الجهات</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="provider" id="company">
                                <label class="form-check-label" for="company">مؤسسة</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="provider" id="trainer">
                                <label class="form-check-label" for="trainer">مدرب</label>
                            </div>
                        </div>
                    </div>

                    <!-- مجال التدريب -->
                    <div class="mb-4">
                        <label class="form-label">مجال التدريب</label>
                        <select class="form-select">
                            <option>كل المجالات التدريبية</option>
                            <option>برمجة</option>
                            <option>تصميم</option>
                            <option>إدارة أعمال</option>
                        </select>
                    </div>
                </div>

                <!-- أزرار -->


                <div class="modal-footer border-0 d-flex justify-content-between gap-3">
                    <button type="button" class="filter-btn flex-fill" data-bs-dismiss="modal">تطبيق الفلترة ←</button>
                    <button type="button" class="btn btn-outline-secondary flex-fill">إعادة تعيين</button>
                </div>





            </div>
        </div>
    </div>


    {{-- cards --}}
    <div class="container my-5" dir="rtl">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">موصى به لك</h4>
            <div class="d-flex gap-2">
                <button class="arrow-btn" id="carouselPrev"><svg width="22" height="22" viewBox="0 0 22 22"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.0374 11.0001C15.0375 11.3085 14.9767 11.6139 14.8586 11.8988C14.7405 12.1837 14.5674 12.4425 14.3491 12.6604L8.73743 18.2696C8.61471 18.3812 8.4537 18.4413 8.28785 18.4373C8.122 18.4334 7.96404 18.3657 7.84679 18.2483C7.72953 18.1309 7.66199 17.9729 7.65819 17.8071C7.65439 17.6412 7.71462 17.4803 7.82637 17.3576L13.4346 11.7468C13.633 11.5482 13.7444 11.279 13.7444 10.9984C13.7444 10.7177 13.633 10.4485 13.4346 10.2499L7.82551 4.64078C7.71154 4.51847 7.64949 4.35669 7.65244 4.18954C7.65539 4.02238 7.72311 3.86289 7.84132 3.74468C7.95954 3.62646 8.11903 3.55875 8.28618 3.5558C8.45334 3.55285 8.61511 3.61489 8.73743 3.72887L14.3491 9.33798C14.5676 9.55609 14.7408 9.81519 14.8589 10.1004C14.9771 10.3856 15.0377 10.6914 15.0374 11.0001Z"
                            fill="white" />
                    </svg>
                    </i></button>
                <button class="arrow-btn" id="carouselNext"><svg width="22" height="22" viewBox="0 0 22 22"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.96264 11.0001C6.96254 11.3085 7.02328 11.6139 7.14138 11.8988C7.25948 12.1837 7.43261 12.4425 7.65088 12.6604L13.2626 18.2696C13.3853 18.3812 13.5463 18.4413 13.7122 18.4373C13.878 18.4334 14.036 18.3657 14.1532 18.2483C14.2705 18.1309 14.338 17.9729 14.3418 17.8071C14.3456 17.6412 14.2854 17.4803 14.1736 17.3576L8.56537 11.7468C8.367 11.5482 8.25557 11.279 8.25557 10.9984C8.25557 10.7177 8.367 10.4485 8.56537 10.2499L14.1745 4.64078C14.2885 4.51847 14.3505 4.35669 14.3476 4.18954C14.3446 4.02238 14.2769 3.86289 14.1587 3.74468C14.0405 3.62646 13.881 3.55875 13.7138 3.5558C13.5467 3.55285 13.3849 3.61489 13.2626 3.72887L7.65088 9.33798C7.43241 9.55609 7.25915 9.81519 7.14105 10.1004C7.02295 10.3856 6.96232 10.6914 6.96264 11.0001Z"
                            fill="white" />
                    </svg>
                    </i></button>
            </div>
        </div>

        <div class="carousel-wrapper position-relative">
            <div class="overflow-hidden" style="width: 100%;">
                <div class="d-flex flex-nowrap" id="cardCarousel" style="scroll-behavior: smooth; overflow-x: auto;">
                    @foreach (range(1, 6) as $index)
                        <div class="card-slide p-2">
                            <div class="card h-100 shadow-sm rounded-4 position-relative">


                                <div class="d-flex flex-column justify-content-between image-custom">
                                    <span class="badge-position">تصميم</span>
                                    <img src="{{ asset('images/cources/training-default-img.svg') }}" class="card-img-top"
                                        alt="صورة التدريب">

                                </div>

                                <div class="card-body d-flex flex-column justify-content-between gap-1">
                                    <h6 class="fw-bold">برنامج تجربة المستخدم لتطبيقات الجوال</h6>
                                    <div class="trainer-info mt-2 mb-2">
                                        <img class="trainer-img" src="https://randomuser.me/api/portraits/men/1.jpg"
                                            alt="]" />
                                        <span>أحمد الرفاعي</span>

                                    </div>
                                    <ul class="list-unstyled d-flex flex-wrap gap-3 text-muted small mb-2">

                                        <li class="d-flex align-items-center gap-2">
                                            <img src="{{ asset(path: 'images/cources/clock.svg') }}" alt="المدة">
                                            12 ساعة
                                        </li>

                                        @if ($index == 3)
                                            <li class="d-flex align-items-center gap-2">
                                                <img src="{{ asset(path: 'images/cources/online.svg') }}"
                                                    alt="نوع الدورة">
                                                أونلاين
                                            </li>
                                        @else
                                            <li class="d-flex align-items-center gap-2">
                                                <img src="{{ asset(path: 'images/cources/location.svg') }}"
                                                    alt="الموقع">
                                                تركيا، اسطنبول
                                            </li>
                                        @endif

                                        <li class="d-flex align-items-center gap-2">
                                            <img src="{{ asset(path: 'images/cources/calender.svg') }}"
                                                alt="تاريخ الانتهاء">
                                            ينتهي التسجيل بـ 12/يونيو/2025
                                        </li>

                                    </ul>

                                    <div class="text-start mt-2">
                                        @if ($index == 2)
                                            <span class="price-tag price-free">مجاني</span>
                                        @else
                                            <span class="price-tag">199.9 $</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
            </div>
    @endsection


    {{-- تضمين ملفات حافا سكريبت جديدة JS --}}
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            //التنقل بين الكروت عن طريق الأزرار
            const container = document.getElementById('cardCarousel');
            const slides = Array.from(container.querySelectorAll('.card-slide'));
            const prevBtn = document.getElementById('carouselPrev');
            const nextBtn = document.getElementById('carouselNext');

            let currentIndex = 0;

            function scrollToCurrentCard() {
                slides[currentIndex].scrollIntoView({
                    behavior: 'smooth',
                    inline: 'start',
                    block: 'nearest'
                });
            }

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                scrollToCurrentCard();
            });

            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                scrollToCurrentCard();
            });

            // للتأكد من البداية
            scrollToCurrentCard();
        </script>
    @endsection
