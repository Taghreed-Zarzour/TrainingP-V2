@extends('frontend.layouts.master')
@section('title', 'الإعدادات الإضافية')
@section('css')
@endsection
@section('content')
    <style>
        /* النص */
        .switch-label {
            color: #1e293b;
            font-weight: 500;
        }

        .profile-image-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            aspect-ratio: initial;
            border-radius: 8px;
            overflow: visible;
        }

        .profile-image-shown {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            object-fit: cover;
        }

        .profile-image-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .profile-image-btn:hover {
            background: #2563eb;
        }

        .profile-image-default {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-direction: column;
        }
    </style>
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        <!-- خطوات التقدم -->
                        @include('trainings.partials.stepper', [
                            'currentStep' => 5,
                            'trainingId' => $training->id ?? null,
                            'isEditMode' => true,
                        ])
                    </div>
                </div>
                <div class="left-col">
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif --}}

                    <div class="info-message">
                        <div class="info-badge">
                            <img src="{{ asset('images/icons/hint.svg') }}" alt="" />
                        </div>
                        <div class="info-message-content">
                            أضف الإعدادات الإضافية الخاصة بالتدريب مثل تكلفة الدورة، موقع انعقادها، الحد الأقصى للمشاركين،
                            الملفات المرفقة، والصورة التعريفية. تساعد هذه المعلومات في تقديم تجربة واضحة للمتدربين وتنظيم
                            الدورة بشكل فعّال
                        </div>
                    </div>

                    <form id="publish-training-5-form" method="POST"
                        action="{{ route('training.store.settings', $training->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group">
                            <label class="switch">
                                <span class="switch-label">دورة مجانية</span>
                                <input type="checkbox" name="is_free" id="is_free"
                                    {{ old('is_free', $settings->is_free ?? false) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <!-- حذف الحقل المخفي تماماً -->
                        </div>

                        <div class="input-group" id="cost-section"
                            style="{{ old('is_free', $settings->is_free ?? false) ? 'display: none;' : '' }}">
                            <label>تكلفة التدريب <span class="required">*</span></label>
                            <div class="sub-label">
                                حدد الرسوم المطلوبة لحضور التدريب إن كان التدريب مأجورًا
                            </div>
                            <div class="input-group-2col" style="align-items: flex-start;">
                                <div style="width: 100%;">
                                    @php
                                        $cost = old('cost', $settings->cost ?? 0);
                                        // إذا كانت القيمة رقمية، قم بتنسيقها بشكل مناسب
                                        if (is_numeric($cost)) {
                                            $formattedCost =
                                                $cost == floor($cost)
                                                    ? number_format($cost, 0, '', '')
                                                    : number_format($cost, 2, '.', '');
                                        } else {
                                            $formattedCost = 0;
                                        }
                                    @endphp
                                    <input type="number" step="0.01" name="cost" value="{{ $formattedCost }}"
                                        placeholder="مثال: 200" class="@error('cost') error-border @enderror" />
                                    @error('cost')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="width: 100%;">
                                    <select class="custom-singleselect @error('currency') error-border @enderror"
                                        name="currency">
                                        @foreach (\App\Enums\Currency::cases() as $currency)
                                            <option value="{{ $currency->value }}"
                                                {{ old('currency', $settings->currency ?? '') === $currency->value ? 'selected' : '' }}>
                                                {{ $currency->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="input-group mt-4">
                                <label>آلية الدفع <span class="required">*</span></label>
                                <div class="sub-label">
                                    اكتب شرحًا يوضح للمتدربين كيف ستتم آلية دفع رسوم التدريب
                                </div>
                                <textarea name="payment_method" rows="5" placeholder="اكتب هنا"
                                    class="@error('payment_method') error-border @enderror">{{ old('payment_method', $settings->payment_method ?? '') }}</textarea>
                                @error('payment_method')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @php
                            use App\Enums\TrainingAttendanceType;
                            $presentation_method_name = $training->program_presentation_method_id;
                        @endphp

                        @unless (
                            $presentation_method_name === TrainingAttendanceType::HYBRID->value ||
                                $presentation_method_name === TrainingAttendanceType::REMOTE->value)
                            <div class="input-group location-group">
                                <label>مكان انعقاد الدورة <span class="required">*</span></label>
                                <div class="sub-label">
                                    اكتب الموقع الذي سيتم فيه التدريب إن كان حضوريًا.
                                </div>
                                <select class="custom-singleselect @error('country_id') error-border @enderror"
                                    name="country_id" id="country_id" data-placeholder="اختر الدولة">
                                    <option value="" selected disabled>اختر الدولة</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id', $settings->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                                <select class="custom-singleselect @error('city') error-border @enderror" name="city"
                                    id="city" data-placeholder="اختر المدينة"
                                    {{ old('city', $settings->city ?? '') ? '' : 'disabled' }}>
                                    <option value="" disabled {{ old('city', $settings->city ?? '') ? '' : 'selected' }}>
                                        اختر المدينة</option>
                                </select>
                                @error('city')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                                <textarea name="residential_address" rows="2" placeholder="العنوان بالتفصيل"
                                    class="@error('residential_address') error-border @enderror">{{ old('residential_address', $settings->residential_address ?? '') }}</textarea>
                                @error('residential_address')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        @endunless

                        <div class="input-group">
                            <label>تاريخ انتهاء التقديم<span class="required">*</span></label>
                            <div class="sub-label">
                                حدد تاريخ انتهاء التقديم على التدريب
                            </div>
                            <input type="date" name="application_deadline"
                                value="{{ old('application_deadline', $settings->application_deadline ? $settings->application_deadline->format('Y-m-d') : '') }}"
                                placeholder="مثال 12/06/2026"
                                class="@error('application_deadline') error-border @enderror" />
                            @error('application_deadline')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label>العدد الأقصى للمتدربين <span class="required">*</span></label>
                            <div class="sub-label">
                                حدد الحد الأعلى لعدد المشاركين في التدريب
                            </div>
                            <input type="number" name="max_trainees"
                                value="{{ old('max_trainees', $settings->max_trainees ?? '') }}" placeholder="مثال: 20"
                                class="@error('max_trainees') error-border @enderror" />
                            @error('max_trainees')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label>ما الطريقة التي تفضلها لاستقبال طلبات المشاركة بالتدريب: <span
                                    class="required">*</span></label>
                            <div class="sub-label">
                                توفر عليك المنصة إدارة المتدربين ومتابعتهم وإجراء الاختبارات والتقييمات بعد انتهاء التدريب
                            </div>
                            <div class="radio-group">
                                @foreach (\App\Enums\ApplicationSubmissionMethod::cases() as $method)
                                    <div class="radio-group-item">
                                        <input type="radio" name="application_submission_method"
                                            value="{{ $method->value }}" id="{{ $method->value }}"
                                            {{ old('application_submission_method', $submissionMethod) == $method->value ? 'checked' : '' }}
                                            class="@error('application_submission_method') error-border @enderror" />
                                        <label for="{{ $method->value }}">{{ $method->label() }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('application_submission_method')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group" id="registration-link-section"
                            style="{{ old('application_submission_method', $submissionMethod) === 'outside_platform' ? '' : 'display: none;' }}">
                            <label>رابط التسجيل</label>
                            <input type="url" name="registration_link" placeholder="الصق هنا"
                                value="{{ old('registration_link', $settings->registration_link ?? '') }}"
                                class="@error('registration_link') error-border @enderror" />
                            @error('registration_link')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label>الصورة التعريفية للتدريب</label>
                            <div class="sub-label">
                                تنبيه: يُفضل أن تكون الصورة مربعة (بنسبة 1:1) لضمان عرضها بشكل مناسب في جميع أجزاء المنصة.
                            </div>
                            <div class="file-upload-wrapper">
                                <div class="profile-image-wrapper">
                                    @if (empty($settings->profile_image))
                                        <div class="profile-image-default">
                                            <img src="{{ asset('images/icons/upload.svg') }}" alt="رفع صورة" />
                                            <button type="button" class="profile-image-btn select-profile-image">تصفح
                                                الملفات</button>
                                        </div>
                                    @else
                                        <div class="profile-image-preview">
                                            <img src="{{ asset('storage/' . $settings->profile_image) }}"
                                                alt="صورة التدريب" class="profile-image-shown image-show" />
                                            <input type="hidden" name="existing_profile_image"
                                                value="{{ $settings->profile_image }}">
                                            <button type="button" class="profile-image-btn change-profile-image">تغيير
                                                الصورة</button>
                                        </div>
                                    @endif
                                    <input type="file" id="profile_image" name="profile_image" accept="image/*"
                                        class="visually-hidden @error('profile_image') error-border @enderror">
                                </div>
                                @error('profile_image')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="input-group">
                            <label>ملفات التدريب (اختياري)</label>
                            <div class="sub-label">قم بإرفاق أي ملفات تعريفية أو مرفقات ترغب بعرضها مسبقًا</div>
                            <div class="training-files-wrapper file-upload-wrapper" data-multiple="true">
                                <div class="training-files-default profile-image-default">
                                    <img src="{{ asset('images/icons/upload.svg') }}" />
                                    <button type="button"
                                        class="training-files-btn profile-image-btn select-training-files">تصفح
                                        الملفات</button>
                                    <input type="file" class="training-files-input visually-hidden"
                                        name="training_files[]" multiple>
                                </div>
                                <div class="training-files-preview" style="display: none;">
                                    @php
                                        $trainingFiles = $settings->training_files ?? [];
                                        if (is_string($trainingFiles)) {
                                            $trainingFiles = json_decode($trainingFiles, true);
                                        }
                                    @endphp
                                    @if (!empty($trainingFiles))
                                        @foreach ($trainingFiles as $file)
                                            <div class="training-files-preview-file">
                                                <span>{{ basename($file) }}</span>
                                                <input type="hidden" name="existing_training_files[]"
                                                    value="{{ $file }}">
                                                <button type="button" class="remove-training-file">&times;</button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div id="real-files-container"></div>
                                <button type="button" class="add-training-files add-more-training profile-image-btn"
                                    style="display:none;">إضافة المزيد</button>
                            </div>
                            @error('training_files')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            @error('training_files.*')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label>الرسالة الترحيبية للمتدربين</label>
                            <div class="sub-label">
                                اكتب رسالة ترحيبية ستظهر للمتدربين عند قبول طلباتهم
                            </div>
                            <textarea name="welcome_message" rows="5" placeholder="اكتب رسالة ترحيبية هنا"
                                class="@error('welcome_message') error-border @enderror">{{ old('welcome_message', $settings->welcome_message) }}</textarea>
                            @error('welcome_message')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="input-group-2col mt-4">
                            <div class="input-group">
                                <a href="{{ route('training.schedule', $training->id) }}"
                                    class="pbtn pbtn-outlined-main">
                                    السابق
                                </a>
                            </div>
                            <div class="input-group">
                                <button type="submit" class="pbtn pbtn-main" id="publish-training-5-submit-btn">
                                    حفظ والمتابعة للمراجعة
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/validator@13.9.0/validator.min.js"></script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('country_id');
            const citySelect = document.getElementById('city');
            const oldCountryId = "{{ old('country_id', $settings->country_id ?? '') }}";
            const oldCityName = "{{ old('city', $settings->city ?? '') }}";

            function loadCities(countryId, selectedCityName = null) {
                citySelect.innerHTML = '<option value="" disabled selected>جاري تحميل المدن...</option>';
                citySelect.disabled = true;

                fetch('/cities')
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="" disabled selected>اختر المدينة</option>';
                        const filtered = data.filter(city => city.country_id == countryId);
                        filtered.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.name; // استخدام اسم المدينة كقيمة
                            option.textContent = city.name;
                            // مقارنة اسم المدينة وليس المعرف
                            if (selectedCityName && selectedCityName === city.name) {
                                option.selected = true;
                            }
                            citySelect.appendChild(option);
                        });
                        citySelect.disabled = false;
                        if (typeof initCustomSelect === 'function') {
                            initCustomSelect(citySelect);
                        }
                    })
                    .catch(err => {
                        console.error("فشل تحميل المدن:", err);
                        citySelect.innerHTML = '<option disabled selected>فشل التحميل</option>';
                    });
            }

            if (countrySelect && citySelect) {
                countrySelect.addEventListener('change', function() {
                    const selectedCountryId = this.value;
                    loadCities(selectedCountryId);
                });

                // تحميل المدن عند فتح الصفحة إذا كانت الدولة محددة
                if (oldCountryId) {
                    countrySelect.value = oldCountryId;
                    loadCities(oldCountryId, oldCityName);
                }

                // إذا كانت هناك قيمة محفوظة في قاعدة البيانات ولم يتم إرسال النموذج
                const savedCountryId = "{{ $settings->country_id ?? '' }}";
                const savedCityName = "{{ $settings->city ?? '' }}";

                if (savedCountryId && !oldCountryId) {
                    countrySelect.value = savedCountryId;
                    loadCities(savedCountryId, savedCityName);
                }
            }

            // إظهار/إخفاء قسم التكلفة
            // إظهار/إخفاء قسم التكلفة
            document.getElementById('is_free').addEventListener('change', function() {
                const costSection = document.getElementById('cost-section');
                const costInput = document.querySelector('input[name="cost"]');
                const currencySelect = document.querySelector('select[name="currency"]');
                const paymentMethod = document.querySelector('textarea[name="payment_method"]');
                const isFreeHidden = document.querySelector('input[name="is_free_hidden"]');

                if (this.checked) {
                    costSection.style.display = 'none';
                    costInput.value = '';
                    currencySelect.value = '';
                    paymentMethod.value = '';
                    // إزالة خاصية required من الحقول
                    costInput.removeAttribute('required');
                    currencySelect.removeAttribute('required');
                    paymentMethod.removeAttribute('required');
                    // تحديث الحقل المخفي
                    isFreeHidden.value = '0';
                } else {
                    costSection.style.display = 'block';
                    // إضافة خاصية required للحقول
                    costInput.setAttribute('required', 'required');
                    currencySelect.setAttribute('required', 'required');
                    paymentMethod.setAttribute('required', 'required');
                    // تحديث الحقل المخفي
                    isFreeHidden.value = '1';
                }
            });
            // إظهار/إخفاء رابط التسجيل
            function updateRegistrationLinkSection() {
                const selectedMethod = document.querySelector(
                'input[name="application_submission_method"]:checked');
                const registrationLinkSection = document.getElementById('registration-link-section');

                if (selectedMethod && selectedMethod.value === 'outside_platform') {
                    registrationLinkSection.style.display = 'block';
                } else {
                    registrationLinkSection.style.display = 'none';
                }
            }

            // استدعاء الدالة عند تحميل الصفحة
            updateRegistrationLinkSection();

            // إضافة مستمع للأحداث لأزرار الاختيار
            document.querySelectorAll('input[name="application_submission_method"]').forEach(radio => {
                radio.addEventListener('change', updateRegistrationLinkSection);
            });
            // استدعاء الدالة عند تحميل الصفحة
            document.querySelectorAll('input[name="application_submission_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'outside_platform') {
                        registrationLinkSection.style.display = 'block';
                    } else {
                        registrationLinkSection.style.display = 'none';
                    }
                });
            });

            // إدارة ملفات التدريب
            const wrapper = document.querySelector(".training-files-wrapper[data-multiple='true']");
            if (wrapper) {
                const fileInput = wrapper.querySelector(".training-files-input");
                const selectBtn = wrapper.querySelector(".select-training-files");
                const defaultView = wrapper.querySelector(".training-files-default");
                const previewContainer = wrapper.querySelector(".training-files-preview");
                const addMoreBtn = wrapper.querySelector(".add-more-training");

                selectBtn.addEventListener("click", () => fileInput.click());
                addMoreBtn.addEventListener("click", () => fileInput.click());

                fileInput.addEventListener("change", () => {
                    if (fileInput.files.length > 0) {
                        addFiles(Array.from(fileInput.files));
                        fileInput.value = "";
                    }
                });

                function addFiles(files) {
                    const realFilesContainer = document.getElementById("real-files-container");
                    files.forEach(file => {
                        const fileDiv = document.createElement("div");
                        fileDiv.className = "training-files-preview-file";
                        fileDiv.innerHTML = `
                            <span>${file.name}</span>
                            <button type="button" class="remove-training-file">&times;</button>
                        `;
                        const input = document.createElement("input");
                        input.type = "file";
                        input.name = "training_files[]";
                        input.className = "visually-hidden";
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                        realFilesContainer.appendChild(input);
                        fileDiv.querySelector(".remove-training-file").addEventListener("click", () => {
                            fileDiv.remove();
                            input.remove();
                            toggleView();
                        });
                        previewContainer.appendChild(fileDiv);
                    });
                    toggleView();
                }

                function toggleView() {
                    const hasFiles = previewContainer.querySelectorAll(".training-files-preview-file").length > 0;
                    defaultView.style.display = hasFiles ? "none" : "flex";
                    previewContainer.style.display = hasFiles ? "flex" : "none";
                    addMoreBtn.style.display = hasFiles ? "inline-block" : "none";
                }

                previewContainer.querySelectorAll(".remove-training-file").forEach(btn => {
                    btn.addEventListener("click", function() {
                        this.closest(".training-files-preview-file").remove();
                        toggleView();
                    });
                });

                toggleView();
            }

            // إدارة الصورة التعريفية
            const profileWrapper = document.querySelector(".profile-image-wrapper");
            if (profileWrapper) {
                const fileInput = document.getElementById("profile_image");
                const selectBtn = profileWrapper.querySelector(".select-profile-image");
                const changeBtn = profileWrapper.querySelector(".change-profile-image");

                if (selectBtn) selectBtn.addEventListener("click", () => fileInput.click());
                if (changeBtn) changeBtn.addEventListener("click", () => fileInput.click());

                fileInput.addEventListener("change", function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profileWrapper.innerHTML = `
                                <div class="profile-image-preview">
                                    <img src="${e.target.result}" alt="صورة التدريب" class="profile-image-shown image-show" />
                                    <button type="button" class="profile-image-btn change-profile-image">تغيير الصورة</button>
                                </div>
                            `;
                            const changeNew = profileWrapper.querySelector(".change-profile-image");
                            changeNew.addEventListener("click", () => fileInput.click());
                            profileWrapper.appendChild(fileInput);
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Show loading indicator during form submission
            const form = document.getElementById('publish-training-5-form');
            form.addEventListener('submit', function() {
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        جاري الحفظ...
                    `;
                }
            });
        });
    </script>
@endsection
