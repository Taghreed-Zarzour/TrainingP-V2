<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إنشاء حساب منظمة</title>
    <!-- روابط CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trainer_complete_profile.css') }}">

</head>


<body>
  @include('frontend.partials.loader')

    <div class="verify-bg mb-5">
        <div class="container-lg py-4">
            <!-- Form Container -->

            <form id="organizationForm"action="{{ route('organization-complete-register', $user->id) }}" method="POST">
                @csrf

                <!-- الخطوة 1: المعلومات الرئيسية -->
                <div class="step-form active" id="step1">
                    <div class="header text-center mb-5">
                        <h1 class="page-title">المعلومات
                            <span class="intro-highlighted-text">
                                الرئيسية
                                <img src="../images/cots-style.svg" class="cots-style-img" alt="" />
                            </span>
                        </h1>
                    </div>
                    <div class="form-container">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">اسم المؤسسة (بالعربية)</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar"
                                    placeholder="مثال: مسك" pattern="[\u0600-\u06FF\s]+"
                                    title="يجب أن يحتوي على حروف عربية فقط" required value="{{ old('name_ar') }}">
                                <div class="error-message" id="name_ar_error">يجب إدخال اسم المؤسسة بالعربية</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">اسم المؤسسة بالإنجليزية (اختياري)</label>
                                <input type="text" class="form-control" id="name_en" name="name_en"
                                    placeholder="Example: Misk" style="direction: ltr" value="{{ old('name_en') }}">
                                <div class="error-message" id="name_en_error">يجب إدخال اسم صحيح بالإنجليزية</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">نوع المؤسسة</label>
                                <select class="form-select" id="organization_type_id" name="organization_type_id"
                                    required>
                                    <option value="" selected disabled>اختر من القائمة نوع مؤسستك</option>
                                    @foreach ($organization_type as $type)
                                        <option value="{{ $type->id }}" {{ old('organization_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="organization_type_id_error">يجب اختيار نوع المؤسسة</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">قطاعات العمل
                                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18 9.5C18 11.28 17.4722 13.0201 16.4832 14.5001C15.4943 15.9802 14.0887 17.1337 12.4442 17.8149C10.7996 18.4961 8.99002 18.6743 7.24419 18.3271C5.49836 17.9798 3.89472 17.1226 2.63604 15.864C1.37737 14.6053 0.520204 13.0016 0.172937 11.2558C-0.17433 9.50998 0.00389957 7.70038 0.685088 6.05585C1.36628 4.41131 2.51983 3.00571 3.99987 2.01677C5.47991 1.02784 7.21997 0.5 9 0.5C11.3862 0.502581 13.6738 1.45162 15.3611 3.13889C17.0484 4.82616 17.9974 7.11384 18 9.5ZM9.75 11.1928C9.74059 10.9318 9.80011 10.6729 9.92255 10.4422C10.045 10.2115 10.2261 10.0172 10.4475 9.87875C10.911 9.62345 11.2986 9.25012 11.5712 8.79662C11.8438 8.34312 11.9916 7.82559 11.9997 7.29653C12.0077 6.76747 11.8756 6.2457 11.6169 5.78415C11.3582 5.3226 10.982 4.93769 10.5265 4.66846C10.071 4.39923 9.55238 4.25526 9.02327 4.25115C8.49417 4.24705 7.97339 4.38296 7.51377 4.64509C7.05414 4.90722 6.67202 5.28626 6.40617 5.74374C6.14032 6.20122 6.00019 6.72088 6 7.25H7.5C7.49982 7.02933 7.54832 6.81134 7.64205 6.61157C7.73578 6.4118 7.87244 6.23517 8.04227 6.09427C8.2121 5.95338 8.41093 5.85169 8.62457 5.79646C8.83822 5.74123 9.06142 5.73382 9.27825 5.77475C9.57453 5.83226 9.84694 5.97679 10.0607 6.18987C10.2744 6.40295 10.4198 6.6749 10.4783 6.971C10.5373 7.2818 10.4965 7.60331 10.3618 7.88955C10.2271 8.1758 10.0054 8.41213 9.72825 8.56475C9.26938 8.8306 8.89019 9.21464 8.6302 9.67685C8.3702 10.1391 8.23891 10.6625 8.25 11.1928V11.75H9.75V11.1928ZM9.75 13.25H8.25V14.75H9.75V13.25Z"
                                            fill="#333333" />
                                    </svg>
                                </label>
                                <select class="form-select select2" id="organization_sectors"
                                    name="organization_sectors[]" multiple required>
                                    @foreach ($organization_sectors as $sector)
                                        <option value="{{ $sector->id }}" {{ in_array($sector->id, old('organization_sectors', [])) ? 'selected' : '' }}>{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="organization_sectors_error">يجب اختيار قطاع واحد على
                                    الأقل</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">عدد الموظفين</label>
                                <select class="form-select" id="employee_numbers_id" name="employee_numbers_id"
                                    required>
                                    <option value="" selected disabled>اختر من القائمة مجال عدد الموظفين</option>
                                    @foreach ($employee_number as $number)
                                        <option value="{{ $number->id }}" {{ old('employee_numbers_id') == $number->id ? 'selected' : '' }}>{{ $number->range }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="employee_numbers_id_error">يجب اختيار عدد الموظفين</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الموازنة السنوية</label>
                                <select class="form-select" id="annual_budgets_id" name="annual_budgets_id" required>
                                    <option value="" selected disabled>اختر من القائمة مجال الموازنة السنوية
                                    </option>
                                    @foreach ($annual_budget as $budget)
                                        <option value="{{ $budget->id }}" {{ old('annual_budgets_id') == $budget->id ? 'selected' : '' }}>{{ $budget->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="annual_budgets_id_error">يجب اختيار الموازنة السنوية
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">سنة التأسيس</label>
                                <select class="form-select" id="established_year" name="established_year" required>
                                    <option value="" selected disabled>اختر من القائمة عام تأسيس المؤسسة</option>
                                    @for ($year = date('Y'); $year >= 1900; $year--)
                                        <option value="{{ $year }}" {{ old('established_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                                <div class="error-message" id="established_year_error">يجب اختيار سنة التأسيس</div>
                            </div>
                            <div class="col-md-12 position-relative">
                                <label class="form-label">نبذة عن المؤسسة</label>
                                <textarea class="form-control pe-5" style="min-height: 112px;" id="bio" name="bio"
                                    placeholder="عرفنا بمؤسستك: نبذة مختصرة تعرف بالمؤسسة وتبرز مجالات عملها وأهدافها الرئيسية." required minlength="50" maxlength="500">{{ old('bio') }}</textarea>
                                <div class="char-counter-badge" id="charCounter">500</div>
                                <div class="error-message" id="bio_error">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    <span>يجب كتابة نبذة لا تقل عن 50 حرفاً ولا تزيد عن 500 حرفاً</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary w-100 mt-4" onclick="validateStep1()">التالي
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.0706 18.819C9.97208 18.8194 9.87448 18.8001 9.78348 18.7623C9.69248 18.7246 9.60992 18.669 9.54061 18.599L3.47161 12.529C3.33213 12.3879 3.25391 12.1975 3.25391 11.999C3.25391 11.8006 3.33213 11.6102 3.47161 11.469L9.54061 5.40002C9.68278 5.26754 9.87083 5.19542 10.0651 5.19885C10.2594 5.20228 10.4448 5.28099 10.5822 5.4184C10.7196 5.55581 10.7984 5.7412 10.8018 5.9355C10.8052 6.1298 10.7331 6.31785 10.6006 6.46002L5.06061 12L10.6006 17.54C10.7401 17.6812 10.8183 17.8716 10.8183 18.07C10.8183 18.2685 10.7401 18.4589 10.6006 18.6C10.5318 18.6706 10.4493 18.7265 10.3582 18.7642C10.2671 18.8018 10.1692 18.8205 10.0706 18.819Z"
                                    fill="white" />
                                <path
                                    d="M20.9999 12.75H4.16992C3.97141 12.7487 3.78141 12.6693 3.64104 12.5289C3.50067 12.3885 3.42123 12.1985 3.41992 12C3.42123 11.8015 3.50067 11.6115 3.64104 11.4711C3.78141 11.3307 3.97141 11.2513 4.16992 11.25H20.9999C21.1984 11.2513 21.3884 11.3307 21.5288 11.4711C21.6692 11.6115 21.7486 11.8015 21.7499 12C21.7486 12.1985 21.6692 12.3885 21.5288 12.5289C21.3884 12.6693 21.1984 12.7487 20.9999 12.75Z"
                                    fill="white" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- الخطوة 2: معلومات التواصل -->
                <div class="step-form" id="step2">
                    <div class="header text-center mb-5">
                        <h1 class="page-title">معلومات
                            <span class="intro-highlighted-text">
                                التواصل
                                <img src="../images/cots-style.svg" class="cots-style-img" alt="" />
                            </span>
                        </h1>
                    </div>
                    <div class="form-container">
                        <div class="row g-3">

                          <div class="col-md-6">
                                <label class="form-label">رقم الهاتف</label>
                                <div class="form-control p-0" dir="ltr">
                                    <div class="d-flex align-items-center w-100 ps-3 pe-3 gap-2"
                                        style="min-height: 48px;" id="phoneWrapper">
                                        <div class="dropdown position-relative" id="flagDropdown" dir="rtl">
                                            <div class="selected-flag d-flex align-items-center gap-1">
                                                <span class="dropdown-arrow">🞃</span>
                                                <img src="{{ asset('flags/' . old('country_code', 'tr') . '.svg') }}" id="selectedFlag"
                                                    class="flag-img" alt="flag">
                                            </div>
                                            <div class="flag-options" id="flagOptions">
                                                <input type="text" id="searchBox" class="search-box"
                                                    placeholder="اكتب رمز الدولة...">
                                                @foreach ($countries as $country)
                                                    <div class="flag-item" data-code="{{ $country->phonecode }}"
                                                        data-iso="{{ strtolower($country->iso2) }}">
                                                        <img src="{{ asset('flags/' . strtolower($country->iso2) . '.svg') }}"
                                                            class="flag-img">
                                                        <span class="flag-code">{{ $country->phonecode }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Divider -->
                                        <div class="divider-line"></div>

                                        <!-- رمز الدولة -->
                                        <div class="code-box" id="phoneCode" dir="ltr">{{ old('phone_code', '+90') }}</div>

                                        <!-- حقل الإدخال -->
                                        <input type="text" id="phone_number" name="phone_number" required
                                            class="flex-grow-1 border-0 ps-2 phone-input" pattern="[0-9]{6,15}"
                                            title="يجب أن يحتوي على أرقام فقط (6-15 رقم)" value="{{ old('phone_number') }}">

                                        <!-- حقل مخفي لرمز الدولة -->
                                        <input type="hidden" id="phone_code" name="phone_code" value="{{ old('phone_code', '+90') }}">
                                    </div>
                                </div>
                                <div class="error-message" id="phone_number_error">يجب إدخال رقم هاتف صحيح</div>
                            </div>

                            <!-- الإيميل -->
                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني للتواصل</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                <input type="hidden" name="email" value="{{ $user->email }}">
                            </div>

                            <!-- العنوان الرئيسي -->
                            <div class="col-md-3">
                                <label class="form-label">عنوان المركز الرئيسي</label>
                                <select class="form-select" id="country_id" name="country_id" required>
                                    <option value="" selected disabled>اختر الدولة</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="country_id_error">يجب اختيار الدولة</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">المدينة</label>
                                <select class="form-select" id="city" name="city" required>
                                    <option value="" selected disabled>اختر المدينة</option>
                                    @if(old('city'))
                                        <option value="{{ old('city') }}" selected>{{ old('city') }}</option>
                                    @endif
                                </select>
                                <div class="error-message" id="city_error">يجب اختيار المدينة</div>
                            </div>

                            <!-- الموقع الإلكتروني -->
                            <div class="col-md-6">
                                <label class="form-label">الموقع الإلكتروني</label>
                                <input type="url" class="form-control" id="website" name="website"
                                    placeholder="أدخل الموقع الإلكتروني الخاص بمؤسستك" style="direction: rtl;"
                                    required value="{{ old('website') }}">
                                <div class="error-message" id="website_error">يجب إدخال موقع إلكتروني صحيح</div>
                            </div>

                            <!-- زر إضافة فرع -->
                            <div class="col-md-12">
                                <a href="javascript:void(0);" class="text-primary" onclick="addBranch()">➕ إضافة فرع
                                    للمنظمة</a>
                            </div>

                            <!-- حاوية الفروع -->
                            <div id="branchesContainer" class="col-12"></div>
                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between mt-4 gap-3">
                            <button type="submit" class="btn btn-primary flex-grow-1" onclick="validateStep2()">
                                إنهاء التسجيل
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="..." fill="white" />
                                    <path d="..." fill="white" />
                                </svg>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" style="min-width: 120px;"
                                onclick="goToStep(1)">رجوع</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- عرض الأخطاء والرسائل -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // تهيئة الصفحة عند التحميل
        $(document).ready(function() {
            // تهيئة Select2
            $('.select2').select2({
                width: '100%',
                placeholder: "اختر من القائمة أهم قطاعات العمل",
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    }
                }
            });

            // جلب بيانات الدول والمدن
            const citySelect = document.getElementById("city");

            $('#country_id').on('change', function() {
                var selected_country_id = $(this).val();
                $('#city').empty().append('<option value="" selected disabled>اختر المدينة</option>');

                fetch('/cities')
                    .then(response => response.json())
                    .then(data => {
                        let filteredCities = data.filter(city => city.country_id ==
                            selected_country_id);
                        filteredCities.forEach(city => {
                            let option = new Option(city.name, city.name);
                            $('#city').append(option);
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching cities:", error);
                    });
            });

            // تهيئة اختيار رمز الدولة
            const dropdown = document.getElementById("flagDropdown");
            const flagOptions = document.getElementById("flagOptions");
            const selectedFlag = document.getElementById("selectedFlag");
            const phoneCode = document.getElementById("phoneCode");

            dropdown.addEventListener("click", (e) => {
                flagOptions.style.display = flagOptions.style.display === "flex" ? "none" : "flex";
                e.stopPropagation();
            });

            document.querySelectorAll(".flag-item").forEach(item => {
                item.addEventListener("click", () => {
                    const iso = item.getAttribute("data-iso");
                    const code = item.getAttribute("data-code");
                    selectedFlag.src = `/flags/${iso}.svg`;
                    phoneCode.textContent = `${code}`;
                    flagOptions.style.display = "none";
                });
            });

            document.addEventListener("click", (e) => {
                if (!dropdown.contains(e.target)) {
                    flagOptions.style.display = "none";
                }
            });

            // بحث رمز الدولة
            const searchBox = document.getElementById("searchBox");
            searchBox.addEventListener("input", function() {
                const value = this.value.trim();
                document.querySelectorAll(".flag-item").forEach(item => {
                    const code = item.getAttribute("data-code");
                    item.style.display = code.startsWith(value) ? "flex" : "none";
                });
            });
              // إغلاق القائمة عند النقر خارجها
        document.addEventListener("click", (e) => {
            const isClickInside = dropdown.contains(e.target) ||
                flagOptions.contains(e.target) ||
                searchBox.contains(e.target);

            if (!isClickInside) {
                flagOptions.style.display = "none";
                isDropdownOpen = false;
            }
        });

        // منع إغلاق القائمة عند النقر داخل حقل البحث
        searchBox.addEventListener("click", function(e) {
            e.stopPropagation();
            flagOptions.style.display = "flex";
            isDropdownOpen = true;
        });
            // تحميل البيانات المحفوظة
            loadFormState();
            
            // تحديث عداد النبذة عند التحميل
            updateBioCounter();
        });

        // دالة للتنقل بين الخطوات
        function goToStep(stepNumber) {
            document.querySelectorAll('.step-form').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(`step${stepNumber}`).classList.add('active');
        }

        // إظهار رسالة الخطأ
        function showError(elementId, errorId, message) {
            const element = document.getElementById(elementId);
            const errorElement = document.getElementById(errorId);

            element.classList.add('is-invalid');
            errorElement.textContent = message;
            errorElement.style.display = 'block';

        }

        // إخفاء رسالة الخطأ
        function hideError(elementId, errorId) {
            const element = document.getElementById(elementId);
            const errorElement = document.getElementById(errorId);

            element.classList.remove('is-invalid');
            errorElement.style.display = 'none';

  

        }

function handleSelect2Validation(id, isValid) {
    const container = $('#' + id).next('.select2-container');
    if (!isValid) {
        container.addClass('is-invalid');
    } else {
        container.removeClass('is-invalid');
    }
}


        // تحقق من صحة الحقول المحددة
        function validateFields(fields) {
            let isValid = true;

            fields.forEach(field => {
                const element = document.getElementById(field.id);
                const value = field.isSelect2 ? $(element).val() : element.value;

if (!field.validation(value)) {
    showError(field.id, field.errorId, field.errorMessage);

    // معالجة خاصية select2
    if (field.isSelect2) {
        handleSelect2Validation(field.id, false);
    }

    isValid = false;
} else {
    hideError(field.id, field.errorId);

    if (field.isSelect2) {
        handleSelect2Validation(field.id, true);
    }
}

            });

            return isValid;
        }

        // تحقق من صحة الخطوة 1
        function validateStep1() {
            const fields = [{
                    id: 'name_ar',
                    errorId: 'name_ar_error',
                    validation: (value) => value && /^[\u0600-\u06FF\s]+$/.test(value),
                    errorMessage: 'يجب إدخال اسم المؤسسة بالعربية بشكل صحيح',
                    isSelect2: false
                },
                {
                    id: 'name_en',
                    errorId: 'name_en_error',
                    validation: (value) => !value || /^[A-Za-z\s]+$/.test(value),
                    errorMessage: 'يجب إدخال الاسم بالإنجليزية بشكل صحيح',
                    isSelect2: false
                },
                {
                    id: 'organization_type_id',
                    errorId: 'organization_type_id_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار نوع المؤسسة',
                    isSelect2: false
                },
                {
                    id: 'organization_sectors',
                    errorId: 'organization_sectors_error',
                    validation: (value) => value && value.length > 0,
                    errorMessage: 'يجب اختيار قطاع واحد على الأقل',
                    isSelect2: true
                },
                {
                    id: 'employee_numbers_id',
                    errorId: 'employee_numbers_id_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار عدد الموظفين',
                    isSelect2: false
                },
                {
                    id: 'annual_budgets_id',
                    errorId: 'annual_budgets_id_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار الموازنة السنوية',
                    isSelect2: false
                },
                {
                    id: 'established_year',
                    errorId: 'established_year_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار سنة التأسيس',
                    isSelect2: false
                },
                {
                    id: 'bio',
                    errorId: 'bio_error',
                    validation: (value) => value && value.length >= 50 && value.length <= 500,
                    errorMessage: 'يجب كتابة نبذة لا تقل عن 50 حرفاً ولا تزيد عن 500 حرفاً',
                    isSelect2: false
                }
            ];

            const isValid = validateFields(fields);

            if (isValid) {
                goToStep(2);
            }
        }

        // تحقق من صحة الخطوة 2
        function validateStep2() {
            const fields = [{
                    id: 'phone_number',
                    errorId: 'phone_number_error',
                    validation: (value) => value && /^[0-9]{6,15}$/.test(value),
                    errorMessage: 'يجب إدخال رقم هاتف صحيح',
                    isSelect2: false
                },
                {
                    id: 'country_id',
                    errorId: 'country_id_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار الدولة',
                    isSelect2: false
                },
                {
                    id: 'city',
                    errorId: 'city_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار المدينة',
                    isSelect2: false
                },
                {
                    id: 'website',
                    errorId: 'website_error',
                    validation: (value) => value && /^https?:\/\/.+\..+/.test(value),
                    errorMessage: 'يجب إدخال موقع إلكتروني صحيح',
                    isSelect2: false
                }
            ];

            return validateFields(fields);
        }
        let branchCount = 0;
        let allCities = [];

        window.addEventListener("DOMContentLoaded", function() {
            // تحميل المدن من السيرفر
            fetch('/cities')
                .then(response => response.json())
                .then(data => {
                    allCities = data;
                });
        });

        function addBranch() {
            branchCount++;

            const countries = @json($countries);
            let countryOptions = `<option value="" disabled selected>اختر الدولة</option>`;
            countries.forEach(c => {
                countryOptions += `<option value="${c.id}">${c.name}</option>`;
            });

            const branchHtml = `
        <div class="row g-3 border p-3 rounded mb-3 position-relative branch-item m-3" id="branch_${branchCount}">
            <div class="col-md-6">
                <label class="form-label">الدولة (فرع)</label>
                <select class="form-select branch-country select2" name="branch_country_id[]" data-branch="${branchCount}">
                    ${countryOptions}
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">المدينة (فرع)</label>
                <select class="form-select select2" name="branch_city[]" id="branch_city_${branchCount}">
                    <option value="" selected disabled>اختر المدينة</option>
                </select>
            </div>
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="removeBranch(${branchCount})" title="حذف الفرع"></button>
        </div>`;

            document.getElementById('branchesContainer').insertAdjacentHTML('beforeend', branchHtml);
        }

        function removeBranch(id) {
            const el = document.getElementById(`branch_${id}`);
            if (el) el.remove();
        }

        // تحديث المدن عند تغيير الدولة داخل أي فرع
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('branch-country')) {
                const selectedCountryId = e.target.value;
                const branchId = e.target.getAttribute('data-branch');
                const citySelect = document.getElementById(`branch_city_${branchId}`);

                citySelect.innerHTML = `<option value="" disabled selected>اختر المدينة</option>`;

                const cities = allCities.filter(city => city.country_id == selectedCountryId);
                cities.forEach(city => {
                    const option = new Option(city.name, city.name);
                    citySelect.appendChild(option);
                });
            }
        });
        
        // تحديث عداد النبذة
        function updateBioCounter() {
            const bioTextarea = document.getElementById('bio');
            const charCounter = document.getElementById('charCounter');
            const bioError = document.getElementById('bio_error');
            const maxLength = 500;
            const minLength = 50;

            if (bioTextarea) {
                const currentLength = bioTextarea.value.length;
                const remaining = maxLength - currentLength;
                
                charCounter.textContent = remaining;
                
                if (currentLength > maxLength) {
                    charCounter.classList.add('char-counter-danger');
                    charCounter.classList.remove('char-counter-warning');
                    bioError.querySelector('span').textContent = 'لقد تجاوزت الحد الأقصى لعدد الأحرف (500)';
                    bioError.style.display = 'flex';
                    bioTextarea.classList.add('is-invalid');
                } 
                else if (currentLength < minLength) {
                    charCounter.classList.remove('char-counter-danger', 'char-counter-warning');
                    bioError.querySelector('span').textContent = 'يجب كتابة نبذة لا تقل عن 50 حرفاً';
                    bioError.style.display = 'flex';
                    bioTextarea.classList.add('is-invalid');
                } 
                else if (remaining < 30) {
                    charCounter.classList.add('char-counter-warning');
                    charCounter.classList.remove('char-counter-danger');
                    bioError.style.display = 'none';
                    bioTextarea.classList.remove('is-invalid');
                }
                else {
                    charCounter.classList.remove('char-counter-danger', 'char-counter-warning');
                    bioError.style.display = 'none';
                    bioTextarea.classList.remove('is-invalid');
                }
            }
        }

        // استماع لتغييرات النبذة
        document.getElementById('bio')?.addEventListener('input', updateBioCounter);
        
        // حفظ حالة النموذج
      function saveFormState() {
    const formData = {};
    
    // حفظ حقول النموذج الأساسية
    $('#organizationForm').find('input, select, textarea').each(function() {
        const $el = $(this);
        const id = $el.attr('id');
        
        if (id) {
            if ($el.attr('type') === 'radio' || $el.attr('type') === 'checkbox') {
                if ($el.is(':checked')) {
                    formData[id] = $el.val();
                }
            } else if ($el.is('select[multiple]')) {
                formData[id] = $el.val() || [];
            } else {
                formData[id] = $el.val();
            }
        }
    });
    
    // حفظ بيانات الفروع
    const branchesData = [];
    $('.branch-item').each(function() {
        const branchId = $(this).attr('id').replace('branch_', '');
        const country = $(this).find('.branch-country').val();
        const city = $(this).find('select[name="branch_city[]"]').val();
        
        branchesData.push({
            id: branchId,
            country: country,
            city: city
        });
    });
    
    formData.branches = branchesData;
    
    localStorage.setItem('organizationFormData', JSON.stringify(formData));
}
        // تحميل حالة النموذج
    function loadFormState() {
    const savedData = localStorage.getItem('organizationFormData');
    if (savedData) {
        const formData = JSON.parse(savedData);
        
        // تحميل الحقول الأساسية
        for (const id in formData) {
            if (id === 'branches') continue; // نتخطى بيانات الفروع مؤقتاً
            
            const $el = $('#' + id);
            if ($el.length) {
                if ($el.attr('type') === 'radio' || $el.attr('type') === 'checkbox') {
                    $el.prop('checked', $el.val() == formData[id]);
                } else if ($el.is('select[multiple]')) {
                    $el.val(formData[id]).trigger('change');
                } else {
                    $el.val(formData[id]);
                }
            }
        }
        
        // تحميل بيانات المدينة
        if (formData.city) {
            $('#city').val(formData.city);
        }
        
        // تحميل بيانات الفروع
        if (formData.branches && formData.branches.length > 0) {
            formData.branches.forEach(branch => {
                // إنشاء الفرع أولاً
                addBranch();
                
                // تعبئة بيانات الفرع
                const branchEl = $(`#branch_${branch.id}`);
                if (branchEl.length) {
                    // تعيين الدولة
                    branchEl.find('.branch-country').val(branch.country).trigger('change');
                    
                    // بعد تأخير بسيط لضمان تحميل المدن
                    setTimeout(() => {
                        branchEl.find('select[name="branch_city[]"]').val(branch.city);
                    }, 500);
                }
            });
        }
        
        // تحديث select2 إذا كان مستخدماً
        if ($.fn.select2) {
            $('.select2').each(function() {
                const $select = $(this);
                if ($select.val()) {
                    $select.trigger('change');
                }
            });
        }
        
        // تحديث عداد النبذة
        updateBioCounter();
    }
}

        
        // استماع لتغييرات النموذج
        $('#organizationForm').on('change', 'input, select, textarea', function() {
            saveFormState();
        });
        
        // تنظيف البيانات عند إرسال النموذج بنجاح
        $('#organizationForm').on('submit', function() {
            localStorage.removeItem('organizationFormData');
        });
    </script>
</body>

</html>