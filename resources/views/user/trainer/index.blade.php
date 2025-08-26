@extends('frontend.layouts.master')

@section('title', 'المدربون')

@section('content')
<style>
    .trainer-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: transform 0.2s ease;
        display: flex;
        flex-direction: row;
        height: 100%;
    }
    .trainer-card:hover {
        transform: translateY(-4px);
    }
    .trainer-image {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        object-fit: cover;
        margin-left: 20px;
    }
    .trainer-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .trainer-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #343a40;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .trainer-title {
        color: #6c757d;
        margin-bottom: 12px;
    }
    .trainer-section {
        margin-bottom: 8px;
    }
    .trainer-section-title {
        font-weight: 500;
        color: #495057;
        margin-bottom: 4px;
        font-size: 0.9rem;
    }
    .badge {
        margin: 2px 4px 2px 0;
        font-size: 0.75rem;
    }
    .filter-section {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
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
    .price-range {
        width: 100%;
        height: 8px;
        border-radius: 4px;
        background: #e0e0e0;
        outline: none;
        -webkit-appearance: none;
    }
    .price-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #003090;
        cursor: pointer;
    }
    .price-range::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #003090;
        cursor: pointer;
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
        margin-bottom: 24px;
    }
    .search-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 8px 0 0 8px;
        font-size: 1rem;
    }
    .search-button {
        background-color: #003090;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 0 8px 8px 0;
        cursor: pointer;
        font-size: 1rem;
    }
    .star-rating {
        color: #ffc107;
        margin-left: 5px;
    }
    .reviews-count {
        color: #6c757d;
        font-size: 0.9rem;
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
        border: 1px solid #003090;
        color: #003090;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
    }
    .apply-filter-btn {
        background-color: #003090;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
    }
    .custom-multiselect {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: white;
    }
    .city-country-container {
        display: flex;
        gap: 10px;
    }
    .city-country-container .custom-singleselect {
        flex: 1;
    }
</style>

<div class="container py-4">
    <div class="row">
        <!-- عمود التصفية -->
        <div class="col-lg-3 col-md-4">
            <div class="filter-section">
                <div class="filter-title">
                    <span>التصفية</span>
                    <button class="reset-filter-btn">إعادة ضبط</button>
                </div>
                
                <div class="filter-group">
                    <div class="filter-group-title">قطاع العمل</div>
                    <select name="work_sectors[]" class="custom-multiselect" multiple>
                        {{-- @foreach ($work_sectors as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                
                <div class="filter-group">
                    <div class="filter-group-title">الخدمات المقدمة</div>
                    <select name="provided_services[]" class="custom-multiselect" multiple>
                        {{-- @foreach ($provided_services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                
                <div class="filter-group">
                    <div class="filter-group-title">مجالات العمل</div>
                    <select name="work_fields[]" class="custom-multiselect" multiple>
                        {{-- @foreach ($work_fields as $field)
                            <option value="{{ $field->id }}">{{ $field->name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                
                <div class="filter-group">
                    <div class="filter-group-title">مواضيع التدريب</div>
                    <select name="important_topics[]" class="custom-multiselect" multiple>
                        @foreach (\App\Enums\ImportantTopicsType::cases() as $topic)
                            <option value="{{ $topic->value }}">{{ $topic->value }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <div class="filter-group-title">الموقع</div>
                    <div class="city-country-container">
                        <select name="country_id" id="country_id" class="custom-singleselect">
                            <option value="">الدولة</option>
                            {{-- @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach --}}
                        </select>
                        <select name="city" id="city" class="custom-singleselect">
                            <option value="">المدينة</option>
                        </select>
                    </div>
                </div>
                
                <div class="filter-group">
                    <div class="filter-group-title">عدد النجوم</div>
                    <div class="star-rating-filter">
                        <div class="filter-checkbox-label">
                            <input type="checkbox" class="filter-checkbox" id="star5" value="5">
                            <label for="star5" class="d-flex align-items-center">
                                <span class="star-rating">★★★★★</span>
                            </label>
                        </div>
                        <div class="filter-checkbox-label">
                            <input type="checkbox" class="filter-checkbox" id="star4" value="4">
                            <label for="star4" class="d-flex align-items-center">
                                <span class="star-rating">★★★★☆</span>
                            </label>
                        </div>
                        <div class="filter-checkbox-label">
                            <input type="checkbox" class="filter-checkbox" id="star3" value="3">
                            <label for="star3" class="d-flex align-items-center">
                                <span class="star-rating">★★★☆☆</span>
                            </label>
                        </div>
                        <div class="filter-checkbox-label">
                            <input type="checkbox" class="filter-checkbox" id="star2" value="2">
                            <label for="star2" class="d-flex align-items-center">
                                <span class="star-rating">★★☆☆☆</span>
                            </label>
                        </div>
                        <div class="filter-checkbox-label">
                            <input type="checkbox" class="filter-checkbox" id="star1" value="1">
                            <label for="star1" class="d-flex align-items-center">
                                <span class="star-rating">★☆☆☆☆</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="filter-group">
                    <div class="filter-checkbox-label">
                        <input type="checkbox" class="filter-checkbox" id="has_samples" value="1">
                        <label for="has_samples">عرض فقط المدربين الذين لديهم نماذج سابقة</label>
                    </div>
                </div>
                
                <div class="filter-group">
                    <div class="filter-group-title">سعر الساعة ($)</div>
                    <div class="price-range-container">
                        <input type="range" min="10" max="100" value="50" class="price-range" id="priceRange">
                        <div class="price-display">
                            <span>10$</span>
                            <span id="priceValue">50$</span>
                            <span>100$</span>
                        </div>
                    </div>
                </div>
                
                <button class="apply-filter-btn">تطبيق التصفية</button>
            </div>
        </div>
        
        <!-- العمود الرئيسي -->
        <div class="col-lg-9 col-md-8">
            <h2 class="mb-4">المدربون</h2>
            
            <div class="search-container">
                <input type="text" class="search-input" placeholder="ما تود البحث عنه">
                <button class="search-button">بحث</button>
            </div>
            
            <div class="row">
                @foreach ($trainers as $trainer)
                    <div class="col-12 mb-4">
                        <div class="trainer-card">
                            @if ($trainer->user->photo)
                                <img src="{{ asset('storage/' . $trainer->user->photo) }}" alt="{{ $trainer->user->name }}" class="trainer-image">
                            @else
                                <img src="{{ asset('images/icons/user.svg') }}" alt="صورة افتراضية" class="trainer-image">
                            @endif
                            
                            <div class="trainer-info">
                                <div class="trainer-name">
                                    {{ $trainer->user->getTranslation('name', 'ar') }} {{ $trainer->getTranslation('last_name', 'ar') }}
                                    <div>
                                        <span class="star-rating">
                                            @php
                                                $avgRating = 0;
                                                if (isset($ratings) && $ratings->where('trainer_id', $trainer->id)->count() > 0) {
                                                    $trainerRatings = $ratings->where('trainer_id', $trainer->id);
                                                    $avgRating = (
                                                        $trainerRatings->sum('clarity') +
                                                        $trainerRatings->sum('interaction') +
                                                        $trainerRatings->sum('organization')
                                                    ) / ($trainerRatings->count() * 3);
                                                }
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($avgRating))
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="reviews-count">({{ $ratings->where('trainer_id', $trainer->id)->count() }} مراجعة)</span>
                                    </div>
                                </div>
                                
                                <div class="trainer-title">{{ $trainer->headline }}</div>
                                
                                <div class="trainer-section">
                                    <div class="trainer-section-title">الخدمات</div>
                                    <div>
                                        @foreach ($trainer->provided_services as $serviceId)
                                            <span class="badge bg-primary">{{ $services[$serviceId] ?? 'Unknown' }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="trainer-section">
                                    <div class="trainer-section-title">مجالات العمل</div>
                                    <div>
                                        @foreach ($trainer->work_fields as $fieldId)
                                            <span class="badge bg-secondary">{{ $work_fields[$fieldId] ?? 'Unknown' }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="trainer-section">
                                    <div class="trainer-section-title">مواضيع التدريب</div>
                                    <div>
                                        @foreach ($trainer->important_topics as $topic)
                                            <span class="badge bg-info text-dark">{{ $topic }}</span>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize custom select elements
        document.querySelectorAll('.custom-singleselect').forEach(select => {
            initCustomSelect(select);
        });
        
        document.querySelectorAll('.custom-multiselect').forEach(select => {
            initCustomMultiSelect(select);
        });
        
        // Price range slider
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        
        priceRange.addEventListener('input', function() {
            priceValue.textContent = this.value + '$';
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
                        const filtered = data.filter(city => String(city.country_id) === String(countryId));
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
    });
</script>
@endsection