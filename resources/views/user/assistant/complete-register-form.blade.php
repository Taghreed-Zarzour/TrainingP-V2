<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إنشاء حساب مساعد</title>
    <!-- روابط CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logos/logo.svg') }}">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trainer_complete_profile.css') }}">

</head>

<body>
  @include('frontend.partials.loader')

    <div class="verify-bg mb-5">
        <!-- العنوان الرئيسي -->
        <div class="header">
            <h1 class="page-title">منصة واحدة لتطويرك في مجال دعم
                <span class="intro-highlighted-text">
                    التدريب
                    <img src="../images/cots-style.svg" class="cots-style-img" alt="" />
                </span>
            </h1>
        </div>

        <!-- Stepper للتنقل بين الخطوات -->
        <div class="stepper-container">
            <div class="stepper">
                <div class="progress-line" style="width: 0%;"></div>
                <!-- الخطوة 1 -->
                <div class="step" data-step="1" onclick="goToStep(1)">
                    <div class="step-title">المعلومات الرئيسية</div>
                    <div class="step-circle">1</div>
                </div>
                <!-- الخطوة 2 -->
                <div class="step" data-step="2" onclick="goToStep(2)">
                    <div class="step-title">ملخص الخبرات والتعليم</div>
                    <div class="step-circle">2</div>
                </div>
                <!-- الخطوة 3 -->
                <div class="step" data-step="3" onclick="goToStep(3)">
                    <div class="step-title">معلومات التواصل</div>
                    <div class="step-circle">3</div>
                </div>
            </div>
        </div>

        <div class="container-lg">
            <!-- نموذج متعدد الخطوات -->
            <div class="form-container">
                <form id="multiStepForm" method="POST" action="{{ route('assistant.complete-register', $user->id) }}"
                    onsubmit="return validateForm()">
                    @csrf

                    <!-- الخطوة 1: معلومات التواصل -->
                    <div class="step-form active" id="step1">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">الاسم (بالعربية)</label>
                                <input type="text" id="name_ar" name="name_ar" class="form-control" required
                                    placeholder="مثال: أحمد" pattern="[\u0600-\u06FF\s]+"
                                    title="يجب أن يحتوي على حروف عربية فقط">
                                <div class="error-message" id="name_ar_error">يجب إدخال الاسم بالعربية بشكل صحيح</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الكنية (بالعربية)</label>
                                <input type="text" id="last_name_ar" name="last_name_ar" class="form-control"
                                    required placeholder="مثال: حمدي" pattern="[\u0600-\u06FF\s]+"
                                    title="يجب أن يحتوي على حروف عربية فقط">
                                <div class="error-message" id="last_name_ar_error">يجب إدخال الكنية بالعربية بشكل صحيح
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <label class="form-label">الاسم (بالإنجليزية)</label>
                                <input type="text" id="name_en" name="name_en"  style="direction: ltr"
                                    class="form-control" placeholder="Example: Ahmad" pattern="[A-Za-z\s]+"
                                    title="يجب أن يحتوي على حروف إنجليزية فقط">
                                <div class="error-message" id="name_en_error">يجب إدخال الاسم بالإنجليزية بشكل صحيح
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الكنية (بالإنجليزية)</label>
                                <input type="text" id="last_name_en" name="last_name_en" 
                                    style="direction: ltr" class="form-control" placeholder="Example: Hamdi"
                                    pattern="[A-Za-z\s]+" title="يجب أن يحتوي على حروف إنجليزية فقط">
                                <div class="error-message" id="last_name_en_error">يجب إدخال الكنية بالإنجليزية بشكل
                                    صحيح</div>
                            </div> --}}
                            <div class="col-md-6">
                                <label class="form-label">العنوان Headline (بالعربية)</label>
                                <input type="text" id="headline" name="headline" required class="form-control"
                                    placeholder="مثال: مدرب في المهارات الرقمية" pattern="[\u0600-\u06FF\s]+"
                                    title="يجب أن يحتوي على حروف عربية فقط">
                                <div class="error-message" id="headline_error">يجب إدخال العنوان بالعربية بشكل صحيح
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الجنسية</label>
                                <select id="nationality" class="form-select select2" name="nationality[]"
                                    data-placeholder="اختر واحدة أو أكثر" multiple required>
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="nationality_error">يجب اختيار الجنسية</div>
                            </div>
                            <div class="col-md-12 d-flex gap-3 align-items-center mt-4">
                                @foreach (\App\Enums\SexEnum::cases() as $sex)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sex"
                                            id="sex_{{ $sex->value }}" value="{{ $sex->value }}"
                                            {{ old('sex') == $sex->value ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="gender_{{ $sex->value }}">
                                            {{ $sex->value }}
                                        </label>

                                    </div>
                                @endforeach

                            </div>
                            <div class="error-message" id="gender_error">يجب اختيار الجنس</div>


                        </div>

                        <button type="button" class="btn btn-primary w-100 mt-4" onclick="validateStep1()">أدخل
                            ملخص الخبرات والتعليم
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

                    <!-- الخطوة 2: الخبرات والتعليم -->
                    <div class="step-form" id="step2">
                        <div class="row g-3">
                            <div class="col-12">
                                <h4 class="section-title">الخبرات</h4>
                                <p class="section-subtitle">نبذة عن مساعد المدرب</p>
                                <textarea class="form-control" id="bio" name="bio" style="min-height: 112px;"
                                    placeholder="شارك نبذة مختصرة تبرز خبرتك وهويتك المهنية" required minlength="50"></textarea>
                                <div class="error-message" id="bio_error">يجب كتابة نبذة لا تقل عن 50 حرفاً</div>
                            </div>




                            <div class="col-md-6">
                                <label class="form-label">سنوات الخبرة</label>
                                <input type="text" id="years_of_experience" name="years_of_experience"
                                    class="form-control" placeholder="مثال: 5" required>
                                <div class="error-message" id="years_of_experience_error">يجب إدخال عدد سنوات الخبرة
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">مجالات الخبرة السابقة</label>
                                <select class="form-select select2" id="experience_areas" name="experience_areas[]"
                                    data-placeholder="اختر من القائمة مجالات الخبرة" multiple required>
                                    @foreach ($experience_areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="experience_areas_error">يجب اختيار مجالات الخبرة
                                    السابقة</div>
                            </div>



                            <div class="col-md-6 mb-4">
                                <label class="form-label">الخدمات</label>
                                <select class="form-select select2" id="provided_services" name="provided_services[]"
                                    multiple data-placeholder="اختر واحدة أو أكثر" required>

                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="provided_services_error">يجب اختيار الخدمات</div>
                            </div>


                            <div class="border-top mt-1 col-12">
                                <div class="pt-4">
                                    <h4 class="section-title">التعليم</h4>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">مستوى الشهادة</label>
                                <select class="form-select" id="education_levels_id" name="education_levels_id"
                                    required>
                                    <option value="" selected disabled>آخر مؤهل تعليمي حصلت عليه</option>
                                    @foreach ($education_levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="education_levels_error">يجب اختيار الخدمات</div>

                            </div>


                            <div class="col-md-6">
                                <label class="form-label">التخصص</label>
                                <input type="text" id="specialization" name="specialization" class="form-control"
                                    placeholder="مثال: هندسة البرمجيات" required>
                                <div class="error-message" id="specialization_error">يجب إدخال التخصص</div>
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">الجامعة</label>
                                <input type="text" id="university" name="university" class="form-control"
                                    placeholder="مثال: جامعة حلب" required>
                                <div class="error-message" id="university_error">يجب إدخال الجامعة</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">عام التخرج</label>
                                {{-- <select id="graduation_year" name="graduation_year" class="form-select" required>
                                    <option value="" selected disabled>اختر من القائمة عام التخرج</option>
                                    @for ($year = date('Y'); $year >= 1980; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select> --}}
                                <input type="date" class="form-control" id="graduation_year" name="graduation_year" required>

                                <div class="error-message" id="graduation_year_error">يجب اختيار عام التخرج</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">اللغات</label>
                                <select id="languages" class="form-select select2" name="languages[]"
                                    data-placeholder="اختر واحدة أو أكثر" multiple required>
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="languages_error">يجب اختيار لغة أو أكثر</div>
                            </div>

                        </div>

                        <!-- أزرار -->
                        <div class="d-flex justify-content-between mt-4 gap-3">
                            <button type="submit" class="btn btn-primary flex-grow-1" onclick="validateStep2()">
                                أدخل معلومات التواصل
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

                    <!-- الخطوة 3: معلومات التواصل -->
                    <div class="step-form" id="step3">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">رقم الهاتف</label>
                                <div class="form-control p-0" dir="ltr">
                                    <div class="d-flex align-items-center w-100 ps-3 pe-3 gap-2"
                                        style="min-height: 48px;" id="phoneWrapper">

                                        <!-- Dropdown العلم -->


                                        <div class="dropdown position-relative" id="flagDropdown" dir="rtl">
                                            <div class="selected-flag d-flex align-items-center gap-1">
                                                <span class="dropdown-arrow">🞃</span>
                                                <img src="{{ asset('flags/tr.svg') }}" id="selectedFlag"
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
                                                        <span class="flag-code">+{{ $country->phonecode }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Divider -->
                                        <div class="divider-line"></div>

                                        <!-- رمز الدولة -->
                                        <div class="code-box" id="phoneCode" dir="ltr">+90</div>

                                        <!-- حقل الإدخال -->
                                        <input type="text" id="phone_number" name="phone_number" required
                                            class="flex-grow-1 border-0 ps-2 phone-input" pattern="[0-9]{6,15}"
                                            title="يجب أن يحتوي على أرقام فقط (6-15 رقم)">
                                    <!-- حقل مخفي لرمز الدولة -->
                                        <input type="hidden" id="phone_code" name="phone_code" value="+90">
                                  
                                          </div>
                                </div>
                                <div class="error-message" id="phone_number_error">يجب إدخال رقم هاتف صحيح</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الدولة</label>
                                <select id="country_id" name="country_id" class="form-select" name="country"
                                    required>
                                    <option value="" selected disabled>اختر الدولة</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message" id="country_id_error">يجب اختيار الدولة</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">المدينة</label>
                                <select id="city" name="city" class="form-select" name="city" required>
                                    <option value="" selected disabled>اختر المدينة</option>
                                </select>
                                <div class="error-message" id="city_error">يجب اختيار المدينة</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4">إنهاء التسجيل
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

    <!-- روابط JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // دالة للتنقل بين الخطوات
        function goToStep(stepNumber) {
            document.querySelectorAll('.step-form').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(`step${stepNumber}`).classList.add('active');

            const steps = document.querySelectorAll('.stepper .step');
            steps.forEach((step, index) => {
                const stepCircle = step.querySelector('.step-circle');
                const stepTitle = step.querySelector('.step-title');
                const stepNum = index + 1;

                if (stepNum < stepNumber) {
                    step.classList.add('completed');
                    step.classList.remove('active');
                    stepCircle.innerHTML = '';
                    stepCircle.classList.add('completed');
                    stepTitle.classList.add('completed');
                } else if (stepNum === stepNumber) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                    stepCircle.innerHTML = stepNum;
                    stepCircle.classList.add('active');
                    stepCircle.classList.remove('completed');
                    stepTitle.classList.add('active');
                } else {
                    step.classList.remove('active', 'completed');
                    stepCircle.innerHTML = stepNum;
                    stepCircle.classList.remove('active', 'completed');
                    stepTitle.classList.remove('active', 'completed');
                }
            });

            const progressLine = document.querySelector('.progress-line');
            let percent = 0;
            if (stepNumber === 1) percent = 0;
            else if (stepNumber === 2) percent = 50;
            else if (stepNumber === 3) percent = 100;
            progressLine.style.width = percent + '%';
        }

        function showError(elementId, errorId, message) {
            const element = document.getElementById(elementId);
            const errorElement = document.getElementById(errorId);

            if (element) {
                element.classList.add('is-invalid');
            }

            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
        }

        function hideError(elementId, errorId) {
            const element = document.getElementById(elementId);
            const errorElement = document.getElementById(errorId);

            if (element) {
                element.classList.remove('is-invalid');
            }

            if (errorElement) {
                errorElement.style.display = 'none';
            }
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
                    errorMessage: 'يجب إدخال الاسم بالعربية بشكل صحيح',
                    isSelect2: false
                },
                {
                    id: 'last_name_ar',
                    errorId: 'last_name_ar_error',
                    validation: (value) => value && /^[\u0600-\u06FF\s]+$/.test(value),
                    errorMessage: 'يجب إدخال الكنية بالعربية بشكل صحيح',
                    isSelect2: false
                },
//               {
//     id: 'name_en',
//     errorId: 'name_en_error',
//     validation: (value) => !value || /^[A-Za-z\s]+$/.test(value),
//     errorMessage: 'يجب إدخال الاسم بالإنجليزية بشكل صحيح',
//     isSelect2: false
// },
// {
//     id: 'last_name_en',
//     errorId: 'last_name_en_error',
//     validation: (value) => !value || /^[A-Za-z\s]+$/.test(value),
//     errorMessage: 'يجب إدخال الكنية بالإنجليزية بشكل صحيح',
//     isSelect2: false
// },

                {
                    id: 'headline',
                    errorId: 'headline_error',
                    validation: (value) => value && /^[\u0600-\u06FF\s]+$/.test(value),
                    errorMessage: 'يجب إدخال العنوان بالعربية بشكل صحيح',
                    isSelect2: false
                },
                {
                    id: 'nationality',
                    errorId: 'nationality_error',
                    validation: (value) => value && value.length > 0,
                    errorMessage: 'يجب اختيار الجنسية',
                    isSelect2: true
                }
            ];

            const isValid = validateFields(fields);


            const genderSelected = document.querySelector('input[name="sex"]:checked');
            const genderError = document.getElementById('gender_error');
            if (!genderSelected) {
                genderError.style.display = 'block';
                isValid = false;
            } else {
                genderError.style.display = 'none';
            }


            if (isValid) {
                goToStep(2);
            }
        }

        // تحقق من صحة الخطوة 2
        function validateStep2() {
            const fields = [{
                    id: 'bio',
                    errorId: 'bio_error',
                    validation: (value) => value && value.length >= 50,
                    errorMessage: 'يجب كتابة نبذة لا تقل عن 50 حرفاً',
                    isSelect2: false
                },
                {
                    id: 'years_of_experience',
                    errorId: 'years_of_experience_error',
                    validation: (value) => value && !isNaN(value),
                    errorMessage: 'يجب إدخال عدد سنوات الخبرة',
                    isSelect2: false
                },

                {
                    id: 'experience_areas',
                    errorId: 'experience_areas_error',
                    validation: (value) => value && value.length > 0,
                    errorMessage: 'يجب اختيار مجالات الخبرة السابقة',
                    isSelect2: true
                },
                {
                    id: 'provided_services',
                    errorId: 'provided_services_error',
                    validation: (value) => value && value.length > 0,
                    errorMessage: 'يجب اختيار الخدمات',
                    isSelect2: true
                },
                {
                    id: 'education_levels_id',
                    errorId: 'education_levels_error',
                    validation: (value) => value && value.trim() !== '',
                    errorMessage: 'يجب إدخال مستوى الشهادة',
                    isSelect2: false
                },
                {
                    id: 'specialization',
                    errorId: 'specialization_error',
                    validation: (value) => value && value.trim() !== '',
                    errorMessage: 'يجب إدخال التخصص',
                    isSelect2: false
                },
                {
                    id: 'graduation_year',
                    errorId: 'graduation_year_error',
                    validation: (value) => value && value !== '',
                    errorMessage: 'يجب اختيار عام التخرج',
                    isSelect2: false
                },
                {
                    id: 'university',
                    errorId: 'university_error',
                    validation: (value) => value && value.trim() !== '',
                    errorMessage: 'يجب إدخال الجامعة',
                    isSelect2: false
                },
                {
                    id: 'languages',
                    errorId: 'languages_error',
                    validation: (value) => value && value.length > 0,
                    errorMessage: 'يجب إدخال اللغات',
                    isSelect2: true
                }
            ];

            const isValid = validateFields(fields);

            if (isValid) {
                goToStep(3);
            }
        }

        // تحقق نهائي قبل الإرسال
        function validateForm() {
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
                }
            ];

            return validateFields(fields);
        }

        // تهيئة الصفحة عند التحميل
        window.addEventListener('load', () => {
            document.querySelector('.step[data-step="1"] .step-circle').classList.add('active');

            // تهيئة select2
            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%'
                });
            });

            // جلب بيانات الدول والمدن
            const citySelect = document.getElementById("city");

            $(document).ready(function() {
                $('#country_id').on('change', function() {
                    var selected_country_id = $(this).val();
                    $('#city').empty().append(
                        '<option value="" selected disabled>اختر المدينة</option>');

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
            });


// تهيئة اختيار رمز الدولة
        const dropdown = document.getElementById("flagDropdown");
        const flagOptions = document.getElementById("flagOptions");
        const selectedFlag = document.getElementById("selectedFlag");
        const phoneCode = document.getElementById("phoneCode");
        const dropdownArrow = dropdown.querySelector(".dropdown-arrow");
        const phoneCodeInput = document.getElementById("phone_code"); // الحقل المخفي

        // متغير لتتبع حالة القائمة
        let isDropdownOpen = false;

        // حدث النقر على السهم أو المنطقة المحيطة به
        dropdown.addEventListener("click", (e) => {
            // إذا كان النقر على السهم تحديداً
            if (e.target.classList.contains("dropdown-arrow")) {
                isDropdownOpen = !isDropdownOpen;
                flagOptions.style.display = isDropdownOpen ? "flex" : "none";
            }
            e.stopPropagation();
        });

        // حدث اختيار علم
        document.querySelectorAll(".flag-item").forEach(item => {
            item.addEventListener("click", () => {
                const iso = item.getAttribute("data-iso");
                const code = item.getAttribute("data-code");
                selectedFlag.src = `/flags/${iso}.svg`;
                phoneCode.textContent = `+${code}`;
                phoneCodeInput.value = `+${code}`; // تحديث الحقل المخفي
                flagOptions.style.display = "none";
                isDropdownOpen = false;
            });
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
        });  });
    </script>
</body>

</html>
