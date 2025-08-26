@extends('frontend.layouts.master')
@section('title', 'الملف الشخصي للمؤسسة')
@section('content')
    <style>
        /* تخصيصات التصميم */
        .org-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 20px;
        }
        .org-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .org-type {
            color: #666;
            font-size: 0.9rem;
        }
        .info-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
        .info-value {
            font-weight: bold;
            font-size: 1.1rem;
        }
        .edit-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
            font-size: 1rem;
            width: 100%;
            max-width: 180px;
            margin-left: auto;
        }
        .edit-btn:hover {
            background: #0069d9;
        }
        .about-container {}
        .about-content {
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .about-text {
            line-height: 1.6;
            color: #333;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
            padding: 0 10px;
        }
        .sectors-container {
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 10px;
            margin-top: 15px;
        }
        .sector-tag {
            background: #e1f5fe;
            color: #0288d1;
            padding: 10px 18px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin: 0 8px 0px 0;
            border: 1px solid #b3e5fc;
        }
        .contact-info {
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 20px;
        }
        .contact-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .contact-item:last-child {
            margin-bottom: 0;
        }
        .contact-label {
            font-size: 0.9rem;
            color: #666;
        }
        .contact-value {
            font-weight: bold;
            direction: ltr;
            text-align: left;
        }
        /* توزيع الأعمدة */
        .about-column {
            flex: 0 0 65%;
            max-width: 65%;
        }
        .contact-column {
            flex: 0 0 35%;
            max-width: 35%;
        }
        /* التجاوب مع أحجام الشاشات */
        @media (max-width: 992px) {
            .about-column,
            .contact-column {
                flex: 0 0 100%;
                max-width: 100%;
            }
            .contact-container {
                margin-top: 20px;
            }
        }
        @media (max-width: 768px) {
            .org-image {
                width: 80px;
                height: 80px;
                border-radius: 15px;
            }
            .org-name {
                font-size: 1.2rem;
            }
            .edit-btn {
                padding: 8px 15px;
                font-size: 0.9rem;
                max-width: 150px;
            }
            .about-container,
            .contact-container {
                border-radius: 20px;
                padding: 10px;
            }
            .about-content,
            .sectors-container,
            .contact-info {
                border-radius: 15px;
                padding: 10px;
            }
        }
        /* أنماط الفروع */
        .branches-container {
            margin-top: 15px;
        }
        .branch-item {
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .branch-info {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }
        .branch-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .branch-location {
            color: #666;
            font-size: 0.9rem;
        }
        .branch-actions {
            display: flex;
            gap: 10px;
        }
        .branch-action-btn {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .branch-action-btn:hover {
            color: #0056b3;
        }
        .branch-action-btn.delete {
            color: #dc3545;
        }
        .branch-action-btn.delete:hover {
            color: #c82333;
        }
        .add-branch-btn {
            background: none;
            border: 1px dashed #007bff;
            color: #007bff;
            border-radius: 20px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 0.9rem;
            width: 100%;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .add-branch-btn:hover {
            background: rgba(0, 123, 255, 0.1);
        }
        .disabled-input {
            background-color: #f8f9fa;
            opacity: 0.7;
            cursor: not-allowed;
        }
                .is-owner .edit-button-container {
            display: block;
        }
    </style>
    <div class="container py-4 {{ auth()->check() && auth()->id() == $organization->id ? 'is-owner' : '' }}">
        <!-- الصف الأول: معلومات المؤسسة الأساسية -->
        <div class="row align-items-center mb-4">
            <!-- العمود الأول: الصورة واسم المؤسسة -->
            <div class="col-md-3 col-sm-12 mb-3 mb-md-0">
                <div class="d-flex align-items-center">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="شعار المؤسسة" class="org-image me-3">
                    @else
                        <img src="{{ asset('images/icons/user.svg') }}" alt="شعار افتراضي" class="org-image me-3">
                    @endif
                    <div>
                        <div class="org-name">{{ $user->getTranslation('name', 'ar') }} </div>
                        <div class="org-type">{{ $organization->type->name ?? 'مؤسسة' }}</div>
                    </div>
                </div>
            </div>
            <!-- العمود الثاني: سنة التأسيس -->
            <div class="col-md-2 col-sm-4 mb-3 mb-md-0">
                <div class="info-label">سنة التأسيس</div>
                <div class="info-value">{{ $organization->established_year ?? '-' }}</div>
            </div>
            <!-- العمود الثالث: عدد الموظفين -->
            <div class="col-md-2 col-sm-4 mb-3 mb-md-0">
                <div class="info-label">عدد الموظفين</div>
                <div class="info-value">{{ $organization->employeeNumber->range ?? '-' }}</div>
            </div>
            <!-- العمود الرابع: الميزانية السنوية -->
            <div class="col-md-2 col-sm-4 mb-3 mb-md-0">
                <div class="info-label">الميزانية السنوية</div>
                <div class="info-value">{{ $organization->annualBudget->name ?? '-' }}</div>
            </div>
            <!-- العمود الخامس: زر التعديل -->
            <div class="col-md-3 col-sm-12 edit-button-container">
                <button class="custom-btn" onclick="openModal('organization-info')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.06 9.02L14.98 9.94L5.92 19H5V18.08L14.06 9.02ZM17.66 3C17.41 3 17.15 3.1 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C18.17 3.09 17.92 3 17.66 3ZM14.06 6.19L3 17.25V21H6.75L17.81 9.94L14.06 6.19Z"
                            fill="white" />
                    </svg>
                    تعديل المعلومات
                </button>
            </div>
        </div>
        <!-- الصف الثاني: حول المؤسسة والقطاعات مقابل معلومات التواصل -->
        <div class="row">
            <!-- العمود الأول: حول المؤسسة والقطاعات (أوسع) -->
            <div class="about-column col-lg-8 col-md-7">
                <div class="about-container">
                    <div class="section-title">حول المؤسسة</div>
                    <div class="about-content">
                        <p class="about-text m-0">
                            {{ $user->bio ?? 'لا يوجد وصف متاح' }}
                        </p>
                    </div>
                    <div class="section-title">القطاعات</div>
                    <div class="sectors-container">
                        @forelse ($organization_workSectors as $sector)
                            <span class="sector-tag">{{ $sector->name }}</span>
                        @empty
                            <span class="text-muted">لا توجد قطاعات محددة</span>
                        @endforelse
                    </div>
                </div>




                                        <!-- عرض الفروع تحت عنوان المركز الرئيسي -->
                        <div class="section-title mt-3">الفروع ({{ count($branches) }})</div>
                        <div class="branches-container">
                            @if(!empty($branches))
                                @foreach($branches as $index => $branch)
                                
                                        <div class="branch-item">
                                            <div class="branch-info">
                                                <div class="branch-title">فرع {{ $index + 1 }}:</div>
                                                <div class="branch-location">{{ $branch['country_name'] ?? '' }}، {{ $branch['city'] ?? '' }}</div>
                                            </div>
          
                                        </div>
                          
                                @endforeach
                            @else
                                <div class="text-muted text-center py-2">لا توجد فروع مضافة</div>
                            @endif

                        </div>
            </div>
            <!-- العمود الثاني: معلومات التواصل (أصغر) -->
            <div class="contact-column col-lg-4 col-md-5">
                <div class="contact-container">
                    <div class="contact-info">
                        <div class="section-title">معلومات التواصل</div>
                        <div class="contact-item">
                            <span class="contact-label">عنوان المركز الرئيسي</span>
                            <span class="contact-value">{{ $user->country->name ?? '-' }}، {{ $user->city ?? '-' }}</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-label">البريد الإلكتروني</span>
                            <span class="contact-value">{{ $user->email }}</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-label">الموقع الإلكتروني</span>
                            <span class="contact-value">{{ $organization->website ?? '-' }}</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-label">رقم الهاتف</span>
                            <span class="contact-value">{{ $user->phone_code ?? '' }}{{ $user->phone_number ?? '-' }}</span>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal التعديل -->
    <div id="customModalOverlay" class="modal-overlay" style="display: none"></div>
    <!-- Organization Info Modal -->
    <div id="organization-info" class="custom-modal" style="display: none">
        <div class="modal-header">
            <span class="modal-title">تعديل معلومات المؤسسة</span>
            <span class="modal-close" id="modalCloseBtn" data-modal="organization-info">&times;</span>
        </div>
        <div class="modal-desc">قم بتحديث معلومات المؤسسة الخاصة بك</div>
        <form class="modal-form" action="{{ route('update_organization_profile') }}" method="POST"
            enctype="multipart/form-data" id="organizationForm">
            @csrf
            @method('PUT')
          <div class="input-group">
    <div class="profile-upload-container">
        <label class="profile-image-label">
            <input type="file" accept="image/png, image/jpeg" id="photo" name="photo" hidden />
            <div class="profile-image-preview-container">
                <div class="profile-image-preview" id="photoPreview">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="شعار المؤسسة" />
                    @else
                        <img src="{{ asset('images/icons/user.svg') }}" alt="شعار افتراضي" />
                    @endif
                </div>
            </div>
        </label>
        <div class="profile-upload-desc">
            أرفق شعار المؤسسة (JPG أو PNG، حد أقصى 5MB).
        </div>
    </div>
</div>
            <div class="input-group-2col">
                <div class="input-group">
                    <label>اسم المؤسسة (بالعربية) <span class="required">*</span></label>
                    <input name="name_ar" type="text" value="{{ old('name_ar', $user->getTranslation('name', 'ar')) }}"
                        placeholder="اكتب هنا" required />
                </div>
                <div class="input-group">
                    <label>اسم المؤسسة (بالإنجليزية)</label>
                    <input name="name_en" type="text" value="{{ old('name_en', $user->getTranslation('name', 'en')) }}"
                        placeholder="اكتب هنا" />
                </div>
            </div>
            <div class="input-group-2col">
            <div class="input-group">
                <label>نوع المؤسسة <span class="required">*</span></label>
                <select name="organization_type_id" class="custom-singleselect" required>
                    <option value="" disabled>اختر نوع المؤسسة</option>
                    @foreach ($organizationTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ $organization->organization_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-group">
                <label>قطاعات العمل <span class="required">*</span></label>
                <select name="organization_sectors[]" class="custom-multiselect" multiple required>
                    @foreach ($organizationSectors as $sector)
                        <option value="{{ $sector->id }}"
                            {{ in_array($sector->id, $organization->organization_sectors ?? []) ? 'selected' : '' }}>
                            {{ $sector->name }}</option>
                    @endforeach
                </select>
            </div>
    </div>
      <div class="input-group-2col">
<div class="input-group">
                    <label>عدد الموظفين <span class="required">*</span></label>
                    <select name="employee_numbers_id" class="custom-singleselect" required>
                        <option value="" disabled>اختر عدد الموظفين</option>
                        @foreach ($employeeNumbers as $number)
                            <option value="{{ $number->id }}"
                                {{ $organization->employee_numbers_id == $number->id ? 'selected' : '' }}>
                                {{ $number->range }}</option>
                        @endforeach
                    </select>
                </div>
  <div class="input-group">
                <label>الموازنة السنوية <span class="required">*</span></label>
                <select name="annual_budgets_id" class="custom-singleselect" required>
                    <option value="" disabled>اختر الميزانية السنوية</option>
                    @foreach ($annualBudgets as $budget)
                        <option value="{{ $budget->id }}"
                            {{ $organization->annual_budgets_id == $budget->id ? 'selected' : '' }}>{{ $budget->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            </div>
                <div class="input-group">
                    <label>سنة التأسيس <span class="required">*</span></label>
                    <select name="established_year" class="custom-singleselect" required>
                        <option value="" disabled>اختر سنة التأسيس</option>
                        @for ($year = date('Y'); $year >= 1900; $year--)
                            <option value="{{ $year }}"
                                {{ $organization->established_year == $year ? 'selected' : '' }}>{{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                
    
          
            <div class="input-group">
                <label>نبذة عن المؤسسة <span class="required">*</span></label>
                <textarea name="bio" placeholder="عرفنا بمؤسستك: نبذة مختصرة تعرف بالمؤسسة وتبرز مجالات عملها وأهدافها الرئيسية."
                    rows="5" required>{{ old('bio', $user->bio) }}</textarea>
            </div>
    <div class="input-group-2col">
  <div class="input-group">
                <label>رقم الهاتف <span class="required">*</span></label>
                <div class="phone-container">
                    @php
                        $code = isset($user->phone_code) ? ltrim($user->phone_code, '+') : '90';
                        $defaultFlag = 'tr';
                        foreach ($countries as $country) {
                            if ((string) $country->phonecode === $code) {
                                $defaultFlag = strtolower($country->iso2);
                                break;
                            }
                        }
                    @endphp
                    <div class="phone-country-selector" id="flagBtn">
                        <span id="countryCode" dir="ltr">{{ $user->phone_code ?? '+90' }}</span>
                        <span class="divider"></span>
                        <span class="arrow-down">🞃</span>
                        <img class="flag-img" id="selectedFlag"
                            src="{{ asset('flags/' . ($defaultFlag ?? 'tr') . '.svg') }}">
                    </div>
                    <input type="tel" name="phone_number" class="phone-input" value="{{ $user->phone_number }}"
                        placeholder="ادخل رقم الهاتف" required>
                    <input type="hidden" name="phone_code" id="phoneCodeHidden"
                        value="{{ $user->phone_code ?? '+90' }}">
                </div>
                <div class="country-dropdown" id="countryDropdown">
                    <input type="text" class="search-box" placeholder="ابحث عن دولة...">
                    <div class="country-list">
                        @foreach ($countries as $country)
                            <div class="country-option" data-code="{{ $country->phonecode }}"
                                data-flag="{{ strtolower($country->iso2) }}">
                                <img src="{{ asset('flags/' . strtolower($country->iso2) . '.svg') }}" width="34"
                                    height="24">
                                <span>{{ $country->phonecode }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- البريد الإلكتروني معطل --}}
            <div class="input-group">
                <label>البريد الإلكتروني</label>
                <input name="email" type="email" value="{{ $user->email }}" disabled class="disabled-input" />
                <input type="hidden" name="email" value="{{ $user->email }}" />
            </div>
  </div>

            <div class="input-group-2col">
                <div class="input-group">
                    <label>الدولة <span class="required">*</span></label>
                    <select name="country_id" id="country_id" class="custom-singleselect" required>
                        <option value="" disabled>اختر الدولة</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ $user->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label>المدينة <span class="required">*</span></label>
                    <select name="city" id="city" class="custom-singleselect" required>
                        <option value="" disabled selected>اختر المدينة</option>
                        @if ($user->city)
                            <option value="{{ $user->city }}" selected>{{ $user->city }}</option>
                        @endif
                    </select>
                </div>
            </div>

            <!-- قسم الفروع -->
            <div class="input-group">
                <label>الفروع</label>
                <div id="branchesContainer">
                    @if(!empty($branches))
                        @foreach($branches as $index => $branch)
                            <div class="branch-item" id="branch_{{$index}}">
                                <div class="input-group-2col">
                                    <div class="input-group">
                                        <label>الدولة</label>
                                        <select name="branch_country_id[]" class="custom-singleselect branch-country" data-branch="{{$index}}" required>
                                            <option value="" disabled>اختر الدولة</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ isset($branch['country_id']) && $branch['country_id'] == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <label>المدينة</label>
                                        <select name="branch_city[]" class="custom-singleselect branch-city" id="branch_city_{{$index}}" required>
                                            <option value="" disabled>اختر المدينة</option>
                                            @if(isset($branch['city']))
                                                <option value="{{ $branch['city'] }}" selected>{{ $branch['city'] }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end mt-2">
                                    <button type="button" class="branch-action-btn delete" onclick="removeBranch({{$index}})">حذف الفرع</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="add-branch-btn" onclick="addNewBranch()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    إضافة فرع جديد
                </button>
            </div>

            <div class="input-group">
                <label>الموقع الإلكتروني</label>
                <input name="website" type="url" value="{{ old('website', $organization->website) }}"
                    placeholder="اكتب هنا" />
            </div>
          
            <div class="input-group">
                <button type="submit" class="pbtn pbtn-main piconed">
                    حفظ التعديل
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/validator@13.9.0/validator.min.js"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // معاينة الصورة عند تحديدها
        document.getElementById('photo')?.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').innerHTML =
                        `<img src="${e.target.result}" alt="شعار المؤسسة" />`;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // معالجة اختيار الدولة والمدن
        document.addEventListener('DOMContentLoaded', function() {
            const flagBtn = document.getElementById('flagBtn');
            const countryDropdown = document.getElementById('countryDropdown');
            const selectedFlag = document.getElementById('selectedFlag');
            const countryCode = document.getElementById('countryCode');
            const phoneCodeHidden = document.getElementById('phoneCodeHidden');
            
            flagBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                countryDropdown.style.display = countryDropdown.style.display === 'block' ? 'none' : 'block';
            });
            
            document.addEventListener('click', function() {
                countryDropdown.style.display = 'none';
            });
            
            document.querySelector('.search-box').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.country-option').forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? 'flex' : 'none';
                });
            });
            
            document.querySelectorAll('.country-option').forEach(option => {
                option.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    const flag = this.getAttribute('data-flag');
                    selectedFlag.src = `/flags/${flag}.svg`;
                    countryCode.textContent = code;
                    phoneCodeHidden.value = code;
                    countryDropdown.style.display = 'none';
                });
            });
            
            countryDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // تحميل المدن بناءً على الدولة المختارة
            const citySelect = document.querySelector("#city");
            const countrySelect = document.querySelector("#country_id");
            const previouslySelectedCity = "{{ $user->city ?? '' }}";
            
            function loadCities(countryId, setSelected = false, targetSelect = null) {
                // تحديد الهدف إذا لم يتم تحديده
                if (!targetSelect) {
                    targetSelect = citySelect;
                }
                
                // إظهار رسالة التحميل
                if (targetSelect.nextElementSibling && targetSelect.nextElementSibling.classList.contains('custom-singleselect-wrapper')) {
                    const input = targetSelect.nextElementSibling.querySelector('.custom-singleselect-input');
                    if (input) input.value = 'جاري التحميل...';
                }
                
                fetch('/cities')
                    .then(response => response.json())
                    .then(data => {
                        // تفريغ قائمة المدن الحالية
                        targetSelect.innerHTML = '<option value="" disabled selected>اختر المدينة</option>';
                        
                        // تصفية المدن حسب الدولة المختارة
                        const filtered = data.filter(city => String(city.country_id) === String(countryId));
                        
                        if (filtered.length === 0) {
                            targetSelect.innerHTML = '<option disabled>لا توجد مدن متاحة</option>';
                            if (targetSelect.nextElementSibling && targetSelect.nextElementSibling.classList.contains('custom-singleselect-wrapper')) {
                                const input = targetSelect.nextElementSibling.querySelector('.custom-singleselect-input');
                                if (input) input.value = 'لا توجد مدن متاحة';
                            }
                            return;
                        }
                        
                        // إضافة المدن إلى القائمة
                        filtered.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.name;
                            option.textContent = city.name;
                            targetSelect.appendChild(option);
                        });
                        
                        // تحديد المدينة المحددة مسبقًا
                        if (setSelected && previouslySelectedCity && targetSelect === citySelect) {
                            targetSelect.value = previouslySelectedCity;
                        }
                        
                        // تحديث القائمة المخصصة
                        initCustomSingleSelectForElement(targetSelect);
                    })
                    .catch(error => {
                        console.error("خطأ أثناء جلب المدن:", error);
                        targetSelect.innerHTML = '<option disabled>فشل تحميل المدن</option>';
                        if (targetSelect.nextElementSibling && targetSelect.nextElementSibling.classList.contains('custom-singleselect-wrapper')) {
                            const input = targetSelect.nextElementSibling.querySelector('.custom-singleselect-input');
                            if (input) input.value = 'فشل تحميل المدن';
                        }
                    });
            }
            
            countrySelect.addEventListener('change', function() {
                const selectedCountryId = this.value;
                if (selectedCountryId) {
                    loadCities(selectedCountryId, false);
                }
            });
            
            // تحميل المدن عند تحميل الصفحة إذا كانت الدولة محددة
            const initialCountryId = countrySelect.value;
            if (initialCountryId) {
                loadCities(initialCountryId, true);
            }
            
            // معالجة تغيير دول الفروع
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('branch-country')) {
                    const selectedCountryId = e.target.value;
                    const branchId = e.target.getAttribute('data-branch');
                    const citySelect = document.getElementById(`branch_city_${branchId}`);
                    
                    if (selectedCountryId && citySelect) {
                        loadCities(selectedCountryId, false, citySelect);
                    }
                }
            });
        });
        
        // دالة تهيئة القائمة المنسدلة المفردة لعنصر محدد
        function initCustomSingleSelectForElement(selectElement) {
            if (!selectElement) return;
            
            // التحقق إذا تم تهيئتها بالفعل
            if (selectElement.nextElementSibling && selectElement.nextElementSibling.classList.contains('custom-singleselect-wrapper')) {
                selectElement.nextElementSibling.remove();
            }
            
            const wrapper = document.createElement("div");
            wrapper.className = "custom-singleselect-wrapper";
            wrapper.tabIndex = 0;
            
            const input = document.createElement("input");
            input.type = "text";
            input.className = "custom-singleselect-input";
            input.placeholder = "اختر المدينة";
            input.autocomplete = "off";
            input.readOnly = true;
            
            const optionsList = document.createElement("div");
            optionsList.className = "options-list";
            
            const arrow = document.createElement("span");
            arrow.className = "dropdown-arrow";
            arrow.innerHTML = "&#9662;";
            
            const options = Array.from(selectElement.options).map((opt) => ({
                value: opt.value,
                name: opt.text,
                selected: opt.selected,
            }));
            
            let selected = selectElement.value;
            
            function renderOptions(filter = "") {
                optionsList.innerHTML = "";
                const filtered = options.filter((opt) =>
                    opt.name.toLowerCase().includes(filter.toLowerCase())
                );
                if (filtered.length === 0) {
                    optionsList.innerHTML = `<div class="option-item" style="color:#aaa;">لا توجد نتائج</div>`;
                    return;
                }
                filtered.forEach((opt) => {
                    const div = document.createElement("div");
                    div.className = "option-item";
                    div.textContent = opt.name;
                    if (opt.value === selected) div.classList.add("active");
                    div.onclick = () => {
                        selected = opt.value;
                        selectElement.value = selected;
                        input.value = opt.name;
                        optionsList.style.display = "none";
                        wrapper.classList.remove("open");
                        
                        // إطلاق حدث تغيير على العنصر الأصلي
                        const event = new Event('change', { bubbles: true });
                        selectElement.dispatchEvent(event);
                    };
                    optionsList.appendChild(div);
                });
            }
            
            function renderSelected() {
                const opt = options.find((o) => o.value === selected);
                input.value = opt ? opt.name : "";
            }
            
            input.addEventListener("click", () => {
                renderOptions("");
                optionsList.style.display = "block";
                wrapper.classList.add("open");
            });
            
            document.addEventListener("click", (e) => {
                if (!wrapper.contains(e.target)) {
                    optionsList.style.display = "none";
                    wrapper.classList.remove("open");
                    renderSelected();
                }
            });
            
            renderSelected();
            renderOptions();
            
            wrapper.appendChild(input);
            wrapper.appendChild(optionsList);
            wrapper.appendChild(arrow);
            selectElement.after(wrapper);
            selectElement.style.display = "none";
        }
        
        // دالة تهيئة القائمة المنسدلة المفردة للمدن
        function initCustomSingleSelectForCity() {
            const select = document.querySelector("#city");
            initCustomSingleSelectForElement(select);
        }
        
        // دالة إضافة فرع جديد في النموذج
        let branchCount = 0;
        function addNewBranch() {
            branchCount++;
            const countries = @json($countries);
            let countryOptions = `<option value="" disabled selected>اختر الدولة</option>`;
            countries.forEach(c => {
                countryOptions += `<option value="${c.id}">${c.name}</option>`;
            });
            
            const branchHtml = `
                <div class="branch-item" id="branch_${branchCount}">
                    <div class="input-group-2col">
                        <div class="input-group">
                            <label>الدولة</label>
                            <select name="branch_country_id[]" class="custom-singleselect branch-country" data-branch="${branchCount}" required>
                                ${countryOptions}
                            </select>
                        </div>
                        <div class="input-group">
                            <label>المدينة</label>
                            <select name="branch_city[]" class="custom-singleselect branch-city" id="branch_city_${branchCount}" required>
                                <option value="" disabled selected>اختر المدينة</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="button" class="branch-action-btn delete" onclick="removeBranch(${branchCount})">حذف الفرع</button>
                    </div>
                </div>`;
            
            document.getElementById('branchesContainer').insertAdjacentHTML('beforeend', branchHtml);
            
            // تهيئة القوائم المنسدلة الجديدة
            initCustomSingleSelectForElement(document.querySelector(`#branch_${branchCount} .branch-country`));
            initCustomSingleSelectForElement(document.querySelector(`#branch_city_${branchCount}`));
        }
        
        // دالة حذف فرع من النموذج
        function removeBranch(id) {
            const el = document.getElementById(`branch_${id}`);
            if (el) el.remove();
        }
        
        // دوال التعامل مع الفروع في صفحة العرض (ليست في النموذج)
        function addBranch() {
            // فتح نموذج التعديل والانتقال إلى قسم الفروع
            openModal('organization-info');
            // التمرير إلى قسم الفروع
            setTimeout(() => {
                const branchesSection = document.querySelector('#organization-info .input-group:nth-last-child(2)');
                if (branchesSection) {
                    branchesSection.scrollIntoView({ behavior: 'smooth' });
                }
            }, 100);
        }
        
        function editBranch(index) {
            // فتح نموذج التعديل والانتقال إلى الفرع المحدد
            openModal('organization-info');
            // التمرير إلى الفرع المحدد
            setTimeout(() => {
                const branchElement = document.getElementById(`branch_${index}`);
                if (branchElement) {
                    branchElement.scrollIntoView({ behavior: 'smooth' });
                }
            }, 100);
        }
        
        function deleteBranch(index) {
            if (confirm('هل أنت متأكد من حذف هذا الفرع؟')) {
                // إرسال طلب حذف الفرع
                fetch(`/organization/branch/delete/${index}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('حدث خطأ أثناء حذف الفرع');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ أثناء حذف الفرع');
                });
            }
        }

        // معاينة الصورة عند تحديدها
document.getElementById('photo')?.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').innerHTML =
                `<img src="${e.target.result}" alt="شعار المؤسسة" />`;
        }
        reader.readAsDataURL(this.files[0]);
    }
});
    </script>
@endsection