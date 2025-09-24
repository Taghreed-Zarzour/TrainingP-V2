@extends('frontend.layouts.master')
@section('title', 'المدربون')
@section('content')
    <style>
        .trainer-card {
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
            align-items: center;
            cursor: pointer; /* إضافة مؤشر الفأرة للإشارة إلى أن البطاقة قابلة للنقر */
        }
        .trainer-card:hover {
            transform: translateY(-4px);
        }
    .trainer-image-container {
    width: 40%;
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    margin-left: 20px;
    /* إضافة هذه الخاصية لجعل الحاوية مربعة دائمًا */
    padding-bottom: 40%; /* نسبة 1:1 */
    height: 0; /* إلغاء الارتفاع الثابت */
}
.trainer-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    /* إضافة هذه الخاصية لضمان ملء الصورة للحاوية */
    object-position: center;
}
@media (max-width: 992px) {
    .trainer-image-container {
        width: 100%;
        padding-bottom: 100%; /* نسبة 1:1 */
        margin: 0 auto 15px;
        height: 0; /* إلغاء الارتفاع الثابت */
    }
}

@media (max-width: 768px) {
    .trainer-image-container {
        padding-bottom: 100%; /* نسبة 1:1 */
        height: 0; /* إلغاء الارتفاع الثابت */
    }
}
@media (max-width: 576px) {
    .trainer-image-container {
        padding-bottom: 100%; /* نسبة 1:1 */
        height: 0; /* إلغاء الارتفاع الثابت */
    }
}
        .trainer-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            text-align: right;
        }
        .trainer-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .trainer-title {
            color: #333333;
            margin-bottom: 12px;
            font-weight: 700;
            font-size: 18px
        }
        .trainer-section {
            margin-bottom: 8px;
        }
        .trainer-section-title {
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
          text-align: center;
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
            .trainer-card {
                flex-direction: column;
                text-align: center;
            }
            .trainer-image-container {
                width: 100%;
                height: 200px;
                margin: 0 auto 15px;
            }
            .trainer-info {
                text-align: center;
            }
            .trainer-name {
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
            .trainer-image-container {
                
            }
            .trainer-name {
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
            .trainer-card {
                padding: 15px;
            }
            .trainer-image-container {
              
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
        .location-title{
          color: #000000;
          font-size: 0.9rem;
          margin-bottom: 8px;
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
                        <label>قطاع العمل</label>
                        <select name="work_sectors[]" class="custom-multiselect" multiple>
                            @foreach ($work_sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
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
                        <label>مجالات العمل</label>
                        <select name="work_fields[]" class="custom-multiselect" multiple>
                            @foreach ($work_fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group">
                        <label>مواضيع التدريب</label>
                        <select name="important_topics[]" class="custom-multiselect" multiple>
                            @foreach (\App\Enums\ImportantTopicsType::cases() as $topic)
                                <option value="{{ $topic->value }}">{{ $topic->value }}</option>
                            @endforeach
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
                    <div class="input-group">
                        <label>عدد النجوم</label>
                        <div class="star-filter-container">
                            <div class="star-rating" id="star-filter">
                                <span class="star empty" data-rating="1">★</span>
                                <span class="star empty" data-rating="2">★</span>
                                <span class="star empty" data-rating="3">★</span>
                                <span class="star empty" data-rating="4">★</span>
                                <span class="star empty" data-rating="5">★</span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>وجود نماذج سابقة</label>
                        <div class="filter-checkbox-label">
                            <input type="checkbox" class="filter-checkbox" id="has_samples" value="1"
                                style="width: auto;">
                            <p for="has_samples" class="m-0 p-0">عرض فقط المدربين الذين لديهم نماذج سابقة</p>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>سعر الساعة ($)</label>
                        <div class="dual-range-container" id="price-range-container">
                            <div class="dual-range-track"></div>
                            <div class="dual-range-fill" id="range-fill"></div>
                            <div class="dual-range-thumb" id="thumb-min" data-value="0">
                                <div class="dual-range-value">0$</div>
                            </div>
                            <div class="dual-range-thumb" id="thumb-max" data-value="500">
                                <div class="dual-range-value">500$</div>
                            </div>
                        </div>
                        <div class="price-display" style="display: none">
                            <span id="max-price-display">500$</span>
                            <span id="min-price-display">0$</span>
                        </div>
                    </div>
                    <div class="mx-lg-5">
                      @php
// تحديد إذا المستخدم مؤسسة
if (auth()->check()) {
$isOrg = auth()->user()->user_type_id == 4;
} else {
// قراءة من الـ type في الرابط إذا ما في تسجيل دخول
$isOrg = request('type') === 'organization';
}
$subscriptionsRoute = $isOrg ? 'subscriptions.organization' : 'subscriptions.trainer';
@endphp
                        <a href="{{ route($subscriptionsRoute) }}{{ !$isOrg && !auth()->check() ? '?type=individual' : ($isOrg && !auth()->check() ? '?type=organization' : '') }}" class="apply-filter-btn">
    <img src="{{ asset('images/icons/Premium.svg') }}" alt="search icon" class="me-2" />
    تطبيق التصفية (Premium)
</a>
                    </div>
                </div>
            </div>
            <!-- العمود الرئيسي -->
            <div class="col-lg-8 col-md-8">
                <div class="page-title">
                    <h2>المدربون</h2>
                    <div class="search-container">
                        {{-- <img src="{{ asset('images/cources/search.svg') }}" alt="search icon" style="width: 20px; height: 20px;"/> --}}
                        <input type="text" class="search-input" placeholder="اكتب ما تود البحث عنه">
                        <button class="search-button">بحث</button>
                    </div>
                </div>
                <div class="row">
                    @foreach ($trainers->take(4) as $trainer)
                        <div class="col-12 mb-4">
                            <!-- جعل البطاقة قابلة للنقر وإضافة رابط لصفحة الملف الشخصي -->
                            <a href="{{ route('show_trainer_profile', ['id' => $trainer->id]) }}" style="text-decoration: none; color: inherit;">
                                <div class="trainer-card">
                                    <div class="trainer-image-container">
                                        @if ($trainer->user->photo)
                                            <img src="{{ asset('storage/' . $trainer->user->photo) }}"
                                                alt="{{ $trainer->user->name }}" class="trainer-image">
                                        @else
                                            <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية"
                                                class="trainer-image">
                                        @endif
                                    </div>
                                    <div class="trainer-info align-items-start">
                                        <div class="trainer-name w-100">
                                            {{ $trainer->user->getTranslation('name', 'ar') }}
                                            {{ $trainer->getTranslation('last_name', 'ar') }}
                                            <div class="d-flex align-items-center">
                                                <div class="star-rating" data-trainer-id="{{ $trainer->id }}">
                                                    @php
                                                        $avgRating = 0;
                                                        if (
                                                            isset($ratings) &&
                                                            $ratings->where('trainer_id', $trainer->id)->count() > 0
                                                        ) {
                                                            $trainerRatings = $ratings->where('trainer_id', $trainer->id);
                                                            $avgRating =
                                                                ($trainerRatings->sum('clarity') +
                                                                    $trainerRatings->sum('interaction') +
                                                                    $trainerRatings->sum('organization')) /
                                                                ($trainerRatings->count() * 3);
                                                        }
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="star {{ $i <= round($avgRating) ? 'filled' : 'empty' }}"
                                                            data-rating="{{ $i }}">★</span>
                                                    @endfor
                                                </div>
                                                <span
                                                    class="reviews-count">({{ $ratings->where('trainer_id', $trainer->id)->count() }}
                                                    مراجعة)</span>
                                            </div>
                                        </div>
                                        <div class="location-title"><span class="budget-label"> <img src="{{ asset('images/cources/location2.svg') }}"
                                                    style="width: 20px; height: 23px;"></span>
                                            {{ $trainer->user->country->name ?? '—' }} , {{ $trainer->user->city ?? '—' }}
                                        </div>
                                        <div class="trainer-name" style="color: #333333;">{{ $trainer->headline }}</div>
                                        <div class="trainer-section">
                                            <div class="trainer-section-title">الخدمات:</div>
                                            <div>
                                                @foreach ($trainer->provided_services as $serviceId)
                                                    <span class="badge">{{ $services[$serviceId] ?? 'Unknown' }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="trainer-section">
                                            <div class="trainer-section-title">مجالات العمل:</div>
                                            <div>
                                                @foreach ($trainer->work_fields as $fieldId)
                                                    <span
                                                        class="badge">{{ $work_fields_trainer[$fieldId] ?? 'Unknown' }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="trainer-section">
                                            <div class="trainer-section-title">مواضيع التدريب:</div>
                                            <div>
                                                @foreach ($trainer->important_topics as $topic)
                                                    <span class="badge">{{ $topic }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
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
                <h3 class="premium-title">قم بالترقية للخطة المدفوعة لتتمكن من تصفح جميع مزايا المنصة</h3>
              <a href="{{ route($subscriptionsRoute) }}{{ !$isOrg && !auth()->check() ? '?type=individual' : ($isOrg && !auth()->check() ? '?type=organization' : '') }}" class="subscribe-btn">
                    <img src="{{ asset('images/icons/Premium.svg') }}" alt="Premium Icon">
                    اشترك الآن
              </a>
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
            // Interactive star rating in trainer cards
            document.querySelectorAll('.star-rating[data-trainer-id]').forEach(rating => {
                const stars = rating.querySelectorAll('.star');
                let currentRating = 0;
                // Set initial rating based on filled stars
                stars.forEach((star, index) => {
                    if (star.classList.contains('filled')) {
                        currentRating = index + 1;
                    }
                });
                stars.forEach((star, index) => {
                    star.addEventListener('click', function(e) {
                        e.stopPropagation(); // منع الانتقال إلى صفحة الملف الشخصي عند النقر على النجوم
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
                            `Rated trainer ${rating.dataset.trainerId} with ${ratingValue} stars`
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
            rating.addEventListener('mouseleave', function() {
                stars.forEach(s => {
                    s.style.color = '';
                });
            });
        });
        // Star filter
        const starFilter = document.getElementById('star-filter');
        const starFilterStars = starFilter.querySelectorAll('.star');
        let selectedStarRating = 0;
        starFilterStars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const clickedRating = parseInt(this.dataset.rating);
                // If clicking the same star that's already selected, deselect all
                if (selectedStarRating === clickedRating) {
                    selectedStarRating = 0;
                    starFilterStars.forEach(s => {
                        s.classList.remove('filled');
                        s.classList.add('empty');
                    });
                } else {
                    selectedStarRating = clickedRating;
                    // Update star display
                    starFilterStars.forEach((s, i) => {
                        if (i < selectedStarRating) {
                            s.classList.remove('empty');
                            s.classList.add('filled');
                        } else {
                            s.classList.remove('filled');
                            s.classList.add('empty');
                        }
                    });
                }
                console.log(`Selected star rating filter: ${selectedStarRating}`);
            });
        });
        // Dual range slider for price
        const rangeContainer = document.getElementById('price-range-container');
        const thumbMin = document.getElementById('thumb-min');
        const thumbMax = document.getElementById('thumb-max');
        const rangeFill = document.getElementById('range-fill');
        const minValueDisplay = document.getElementById('min-price-display');
        const maxValueDisplay = document.getElementById('max-price-display');
        let minVal = 0;
        let maxVal = 500;
        let minPercent = 0;
        let maxPercent = 100;
        function updateRangeDisplay() {
            // Update fill
            rangeFill.style.left = minPercent + '%';
            rangeFill.style.width = (maxPercent - minPercent) + 2 + '%';
            // Update thumb positions
            thumbMin.style.left = minPercent + '%';
            thumbMax.style.left = maxPercent + '%';
            // Update value displays
            minValueDisplay.textContent = minVal + '$';
            maxValueDisplay.textContent = maxVal + '$';
            // Update balloon values above thumbs
            const minBalloon = thumbMin.querySelector('.dual-range-value');
            const maxBalloon = thumbMax.querySelector('.dual-range-value');
            minBalloon.textContent = minVal + '$';
            maxBalloon.textContent = maxVal + '$';
        }
        function handleThumbMove(thumb, isMin) {
            let isDragging = false;
            thumb.addEventListener('mousedown', function(e) {
                isDragging = true;
                e.preventDefault();
            });
            thumb.addEventListener('touchstart', function(e) {
                isDragging = true;
                e.preventDefault();
            });
            document.addEventListener('mousemove', function(e) {
                if (!isDragging) return;
                const containerRect = rangeContainer.getBoundingClientRect();
                const containerWidth = containerRect.width;
                const position = Math.max(0, Math.min(100, ((e.clientX - containerRect.left) / containerWidth) *
                    100));
                if (isMin) {
                    minPercent = Math.max(0, Math.min(position, maxPercent - 5));
                    minVal = Math.round((minPercent / 100) * 500);
                } else {
                    maxPercent = Math.min(100, Math.max(position, minPercent + 5));
                    maxVal = Math.round((maxPercent / 100) * 500);
                }
                updateRangeDisplay();
            });
            document.addEventListener('touchmove', function(e) {
                if (!isDragging) return;
                const touch = e.touches[0];
                const containerRect = rangeContainer.getBoundingClientRect();
                const containerWidth = containerRect.width;
                const position = Math.max(0, Math.min(100, ((touch.clientX - containerRect.left) / containerWidth) *
                    100));
                if (isMin) {
                    minPercent = Math.max(0, Math.min(position, maxPercent - 5));
                    minVal = Math.round((minPercent / 100) * 500);
                } else {
                    maxPercent = Math.min(100, Math.max(position, minPercent + 5));
                    maxVal = Math.round((maxPercent / 100) * 500);
                }
                updateRangeDisplay();
            });
            document.addEventListener('mouseup', function() {
                isDragging = false;
            });
            document.addEventListener('touchend', function() {
                isDragging = false;
            });
        }
        handleThumbMove(thumbMin, true);
        handleThumbMove(thumbMax, false);
        // Initialize display
        updateRangeDisplay();
    </script>
@endsection