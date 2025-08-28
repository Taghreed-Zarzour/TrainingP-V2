@extends('frontend.layouts.master')
@section('title', 'المساعدون')
@section('content')
    <style>
        .assistant-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E9E9E9;
            margin-bottom: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: row;
            height: 100%;
        }

        .assistant-card:hover {
            transform: translateY(-4px);
        }

        .assistant-image-container {
            width: 40%;
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            margin-left: 20px;
        }

        .assistant-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .assistant-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .assistant-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .assistant-title {
            color: #333333;
            margin-bottom: 12px;
            font-weight: 700;
            font-size: 18px
        }

        .assistant-section {
            margin-bottom: 8px;
        }

        .assistant-section-title {
            font-weight: 500;
            color: #686868;
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .badge {
            margin: 2px 4px 2px 0;
            font-size: 1rem;
            background-color: #D9E6FF !important;
            color: #003090 !important;
            padding: 5px 8px;
            border-radius: 3px;
        }

        .filter-section {
            border: 1px solid #E9E9E9;
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: #343a40;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-group {
            margin-bottom: 20px;
        }

        .filter-group-title {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .price-range-container {
            margin-top: 10px;
        }

        .dual-range-container {
            position: relative;
            height: 40px;
            margin: 20px 20px 0px 20px !important;
        }

        .dual-range-track {
            position: absolute;
            width: 100%;
            height: 5px;
            background: #e0e0e0;
            border-radius: 4px;
            top: 16px;
        }

        .dual-range-fill {
            position: absolute;
            height: 5px;
            background: #003090;
            border-radius: 4px;
            top: 16px;
        }

        .dual-range-thumb {
            position: absolute;
            width: 13px;
            height: 13px;
            background: #003090;
            border-radius: 50%;
            top: 12px;
            cursor: pointer;
            z-index: 2;
        }

        .dual-range-value {
            position: absolute;
            top: -25px;
            transform: translateX(-50%);
            color: #003090;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .price-display {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .search-container {
            display: flex;
            justify-content: space-between;
        }

        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            margin-left: 10px;
        }

        .search-button {
            background-color: #003090;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        .star-rating {
            color: #ffc107;
            margin-left: 5px;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
        }

        .star-rating .star {
            transition: color 0.2s;
            margin-left: 2px;
        }

        .star-rating .star.filled {
            color: #ffc107;
        }

        .star-rating .star.empty {
            color: #ddd;
        }

        .reviews-count {
            color: #6c757d;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .filter-checkbox {
            margin-left: 8px;
        }

        .filter-checkbox-label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .reset-filter-btn {
            background: transparent;
            color: #005FDC;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .reset-filter-btn:hover {
            background: #e8efff;
            color: #005FDC;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .apply-filter-btn {
            background-color: #FFC62A;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            margin-top: 10px;
            border: none;
            font-weight: 700;
            transition: all 0.3s ease;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
        }

        .apply-filter-btn:hover {
            background-color: #ffb400;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 198, 42, 0.4);
        }

        .custom-multiselect {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: white;
            box-sizing: border-box;
        }

        .custom-singleselect {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: white;
            box-sizing: border-box;
        }

        .city-country-container {
            display: flex;
            gap: 10px;
        }

        .city-country-container .custom-singleselect {
            flex: 1;
        }

        .page-title {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #E9E9E9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding: 20px;
            border-radius: 10px;
        }

        .page-title h2 {
            margin: 0;
        }

        .star-filter-container {
            display: flex;
            margin-bottom: 10px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #495057;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .assistant-card {
                flex-direction: column;
                text-align: center;
            }

            .assistant-image-container {
                width: 100%;
                height: 200px;
                margin: 0 auto 15px;
            }

            .assistant-info {
                text-align: center;
            }

            .assistant-name {
                justify-content: center;
                flex-direction: column;
            }

            .search-container {
                flex-direction: column;
            }

            .search-input {
                margin-left: 0;
                margin-bottom: 10px;
            }

            .page-title {
                flex-direction: column;
                text-align: center;
            }

            .page-title h2 {
                margin-bottom: 15px;
            }

            .city-country-container {
                flex-direction: column;
                gap: 8px;
            }
        }

        @media (max-width: 768px) {
            .assistant-image-container {
                height: 150px;
            }

            .assistant-name {
                font-size: 1.1rem;
            }

            .filter-section {
                margin-bottom: 15px;
                padding: 15px;
            }

            .filter-title {
                font-size: 1rem;
            }

            .input-group label {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .assistant-card {
                padding: 15px;
            }

            .assistant-image-container {
                height: 120px;
            }

            .badge {
                font-size: 0.7rem;
            }

            .filter-section {
                padding: 12px;
            }

            .dual-range-value {
                font-size: 0.7rem;
            }
        }

        @media (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 100%;
            }
        }

        /* أنماط قسم الترقية المميزة */
        .premium-promo-section {
            margin: 40px 0;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            border: 1px solid #E9E9E9;
            padding: 50px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .premium-card {
            background-image: url('/../images/general/Premium-bg.png');
            background-size: cover;
            background-position: center;
            text-align: center;
            color: rgb(0, 0, 0);
            position: relative;
            z-index: 1;
            text-align: -webkit-center;
        }

        .premium-title {
            font-size: 1.6rem;
            font-weight: 500;
            margin-bottom: 15px;
            line-height: 34px;
            width: 30%
        }

        @media (max-width: 768px) {
            .premium-title {
                width: 100%
            }
        }

        .subscribe-btn {
            background-color: #FFC62A;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
        }

        .subscribe-btn:hover {
            background-color: #ffb400;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 198, 42, 0.4);
        }

        .subscribe-btn img {
            margin-left: 8px;
            width: 20px;
            height: 20px;
        }

        @media (max-width: 768px) {
            .premium-title {
                font-size: 1.5rem;
            }

            .subscribe-btn {
                padding: 10px 20px;
                font-size: 1rem;
            }
        }

        .location-title {
            color: #000000;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .bio-style {
            font-weight: 500;
            font-size: 1.1rem;
            line-height: 36px;
            color: #5A5A5A;
        }
    </style>
    <div class="container py-4">
        <div class="row">
            <!-- عمود التصفية -->
            <div class="col-lg-4 col-md-4">
                <div class="filter-section">
                    <div class="filter-title">
                        <span>التصفية</span>
                        <button class="reset-filter-btn">
                            <img src="{{ asset('images/icons/reset.svg') }}">
                            إعادة ضبط
                        </button>
                    </div>

                    <div class="input-group">
                        <label>الخدمات المقدمة</label>
                        <select name="provided_services[]" class="custom-multiselect" multiple>
                            @foreach ($provided_services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label>سنوات الخبرة</label>
                        <select name="experience_years" class="custom-singleselect">
                            <option value="">الكل</option>
                            <option value="1">أقل من سنة</option>
                            <option value="2">1-3 سنوات</option>
                            <option value="3">3-5 سنوات</option>
                            <option value="4">5-10 سنوات</option>
                            <option value="5">أكثر من 10 سنوات</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>المستوى التعليمي</label>
                        <select name="education_level" class="custom-singleselect">
                            <option value="">الكل</option>
                            @foreach ($education_levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label>التخصص</label>
                        <select name="specialization" class="custom-singleselect">
                            <option value="">الكل</option>
                            {{-- @foreach ($specializations as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach --}}
                        </select>
                    </div>

                    <div class="input-group">
                        <label>الموقع</label>
                        <div class="city-country-container">
                            <select name="country_id" id="country_id" class="custom-singleselect">
                                <option value="">الدولة</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <select name="city" id="city" class="custom-singleselect">
                                <option value="">المدينة</option>
                            </select>
                        </div>
                    </div>

                    <div class="mx-5">
                        <button class="apply-filter-btn">
                            <img src="{{ asset('images/icons/Premium.svg') }}" alt="search icon" class="me-2" />
                            تطبيق التصفية (Premium)
                        </button>
                    </div>
                </div>
            </div>

            <!-- العمود الرئيسي -->
            <div class="col-lg-8 col-md-8">
                <div class="page-title">
                    <h2>المساعدون</h2>
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="اكتب ما تود البحث عنه">
                        <button class="search-button">بحث</button>
                    </div>
                </div>

                <div class="row">
                    @foreach ($assistants->take(4) as $assistant)
                        <div class="col-12 mb-4">
                            <div class="assistant-card">
                                <div class="assistant-image-container">
                                    @if ($assistant->image)
                                        <img src="{{ asset('storage/' . $assistant->image) }}"
                                            alt="{{ $assistant->user->name }}" class="assistant-image">
                                    @else
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية"
                                            class="assistant-image">
                                    @endif
                                </div>

                                <div class="assistant-info align-items-start justify-content-center">
                                    <div class="assistant-name w-100">
                                        {{ $assistant->user->getTranslation('name', 'ar') ?? '—' }}
                                        {{ $assistant->getTranslation('last_name', 'ar') }}

                                    </div>
                                    @if ($assistant->university && $assistant->graduation_year)
                                        <div class="location-title">
                                            <span class="budget-label">
                                                <img src="{{ asset('images/cources/teach.svg') }}"
                                                    style="width: 20px; height: 23px;">
                                            </span>
                                            {{ $assistant->specialization }} ,
                                            {{ $assistant->educationLevel->name ?? '—' }} ,
                                            {{ $assistant->university }} -
                                            {{ $assistant->graduation_year ? date('Y', strtotime($assistant->graduation_year)) : 'غير محدد' }}
                                        @else
                                            غير محدد
                                    @endif
                                </div>
                                <div class="location-title">
                                    <span class="budget-label">
                                        <img src="{{ asset('images/cources/location2.svg') }}"
                                            style="width: 20px; height: 23px;">
                                    </span>
                                    {{ $assistant->user->country->name ?? '—' }} , {{ $assistant->user->city ?? '—' }}
                                </div>
                                <div class="assistant-section">
                                    <p class="bio-style text-muted m-0">{{ $assistant->user->bio ?? '—' }}</p>
                                </div>


                                <div class="assistant-section">
                                    <div class="assistant-section-title">الخدمات:</div>
                                    <div>
                                        @foreach ($assistant->provided_services as $serviceId)
                                            <span class="badge">{{ $services[$serviceId] ?? 'Unknown' }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="assistant-section">
                                    <div class="assistant-section-title">مجالات الخبرة:</div>
                                    <div>
                                        @foreach ($assistant->experience_areas as $areaId)
                                            <span class="badge">{{ $experience_areas[$areaId] ?? 'Unknown' }}</span>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>

    <!-- قسم الترقية المميزة الجديد -->
    <div class="container">
        <div class="premium-promo-section">
            <div class="premium-card">
                <h3 class="premium-title">اشترك بباقة البريميوم لتتمكن من تصفح جميع ميزاتنا الذكية</h3>
                <button class="subscribe-btn">
                    <img src="{{ asset('images/icons/Premium.svg') }}" alt="Premium Icon">
                    اشترك الآن
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize custom select elements
            document.querySelectorAll('.custom-singleselect').forEach(select => {
                initCustomSelect(select);
            });

            document.querySelectorAll('.custom-multiselect').forEach(select => {
                initCustomMultiSelect(select);
            });

            // City dropdown based on country selection
            const countrySelect = document.getElementById('country_id');
            const citySelect = document.getElementById('city');

            countrySelect.addEventListener('change', function() {
                const countryId = this.value;
                citySelect.innerHTML = '<option value="">المدينة</option>';

                if (countryId) {
                    fetch('/cities')
                        .then(response => response.json())
                        .then(data => {
                            const filtered = data.filter(city => String(city.country_id) === String(
                                countryId));
                            filtered.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.name;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            });
                            // Re-initialize the custom select
                            initCustomSelect(citySelect);
                        })
                        .catch(error => {
                            console.error("خطأ أثناء جلب المدن:", error);
                        });
                }
            });

            // Interactive star rating in assistant cards
            document.querySelectorAll('.star-rating[data-assistant-id]').forEach(rating => {
                const stars = rating.querySelectorAll('.star');
                let currentRating = 0;

                // Set initial rating based on filled stars
                stars.forEach((star, index) => {
                    if (star.classList.contains('filled')) {
                        currentRating = index + 1;
                    }
                });

                stars.forEach((star, index) => {
                    star.addEventListener('click', function() {
                        const ratingValue = parseInt(this.dataset.rating);
                        currentRating = ratingValue;

                        // Update star display
                        stars.forEach((s, i) => {
                            if (i < ratingValue) {
                                s.classList.remove('empty');
                                s.classList.add('filled');
                            } else {
                                s.classList.remove('filled');
                                s.classList.add('empty');
                            }
                        });

                        // Here you would typically send the rating to the server
                        console.log(
                            `Rated assistant ${rating.dataset.assistantId} with ${ratingValue} stars`
                            );
                    });

                    star.addEventListener('mouseenter', function() {
                        const ratingValue = parseInt(this.dataset.rating);

                        stars.forEach((s, i) => {
                            if (i < ratingValue) {
                                s.style.color = '#ffc107';
                            } else {
                                s.style.color = '#ddd';
                            }
                        });
                    });
                });

                rating.addEventListener('mouseleave', function() {
                    // Restore the current rating state
                    stars.forEach((s, i) => {
                        if (i < currentRating) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });
            });
        });
    </script>
@endsection
