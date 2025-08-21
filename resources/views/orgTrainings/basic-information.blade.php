@extends('frontend.layouts.master')

@section('title', 'إنشاء برنامج تدريبي جديد')

@section('content')

    <style>
        /* إضافة هذه الأنماط إلى قسم الـ style */
        .error-border {
            border: 1px solid red !important;
            border-radius: 12px !important;
        }

        .error-message {
            color: red;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .custom-singleselect-wrapper .error-border {
            border-color: red;
        }
    </style>
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">

                        @include('orgTrainings.partials.stepper', [
                            'currentStep' => 1,
                            'trainingId' => $training->id ?? null,
                            'isEditMode' => $isEditMode ?? false,
                        ])

                    </div>
                </div>
                <div class="left-col">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($isEditMode)
                        <form id="publish-training-1-form"
                            action="{{ route('orgTraining.updateBasicInformation', $training->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                        @else
                            <form id="publish-training-1-form" action="{{ route('orgTraining.storeBasicInformation') }}"
                                method="POST">
                                @csrf
                    @endif


                    <!-- عنوان المسار التدريبي -->
                    <div class="input-group">
                        <label>عنوان المسار التدريبي <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $training->title ?? '') }}"
                            placeholder="مثال: مخيم ريادة الأعمال" class="validate" />
                        @error('title')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- لغة البرنامج ونوع البرنامج -->
                    <div class="input-group-2col">
                        <div class="input-group">
                            <label>لغة المسار التدريبي<span class="required">*</span></label>
                            <div class="custom-select-container">
                                <select name="language_id" class="custom-singleselect">
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang->id }}"@selected(old('language_id', $training->language_id ?? $languages->first()->id) == $lang->id)>
                                            {{ $lang->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <label>نوع المسار التدريبي <span class="required">*</span></label>
                            <div class="custom-select-container">
                                <select name="program_type" class="custom-singleselect">
                                    @foreach ($programType as $type)
                                        <option value="{{ $type->id }}" @selected(old('program_type', $training->program_type ?? $programType->first()->id) == $type->id)>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- مستوى البرنامج وطريقة تقديم البرنامج -->
                    <div class="input-group-2col">
                        <div class="input-group">
                            <label>مستوى المسار التدريبي <span class="required">*</span></label>
                            <div class="custom-select-container">
                                <select name="training_level_id" class="custom-singleselect">
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}" @selected(old('training_level_id', $training->training_level_id ?? $levels->first()->id) == $level->id)>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <label>طريقة تقديم المسار <span class="required">*</span></label>
                            <div class="custom-select-container">
                                <select name="program_presentation_method" class="custom-singleselect"
                                    id="presentation-method">
                                    @foreach ($programPresentationMethod as $method)
                                        <option value="{{ $method->value }}"
                                            {{ old('program_presentation_method', $training->program_presentation_method ?? '') == $method->value ? 'selected' : '' }}>
                                            {{ $method->value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- مكان انعقاد البرنامج (حضوري) -->
                    <div id="location-fields" class="location-fields">
                        <div class="input-group">
                            <label>مكان انعقاد المسار التدريبي <span class="required">*</span></label>
                            <div class="sub-label">اكتب الموقع الذي سيتم فيه المسار إن كان حضوريًا.</div>
                            <div class="input-group-3col">
                                <!-- الدولة -->
                                <div class="input-group">
                                    <div class="custom-select-container">
                                        <select name="country_id" class="custom-singleselect" id="country_id">
                                            <option value="">الدولة</option>
                                            @foreach ($countries as $country)
                                                <option
                                                    value="{{ $country->id }}"{{ old('country_id', $training->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('country_id')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- المدينة -->
                                <div class="input-group">
                                    <div class="custom-select-container">
                                        <select name="city" class="custom-singleselect" id="city"
                                            data-placeholder="المدينة"
                                            {{ old('city', $training->city ?? '') ? '' : 'disabled' }}>
                                            <option value="" disabled
                                                {{ old('city', $training->city ?? '') ? '' : 'selected' }}>المدينة
                                            </option>
                                            @if (old('city', $training->city ?? false))
                                                <option value="{{ old('city', $training->city) }}" selected>
                                                    {{ old('city', $training->city) }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                    @error('city')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <input type="text" name="address_in_detail"
                                        value="{{ old('address_in_detail', $training->address_in_detail ?? '') }}"
                                        placeholder="العنوان بالتفصيل" class="validate">
                                    @error('address_in_detail')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- تصنيفات المسار -->
                    <div class="input-group">
                        <label>تصنيفات المسار
                            <img src="{{ asset('images/icons/question-mark.svg') }}">
                            <span class="required">*</span>
                        </label>
                        <div class="custom-select-container">
                            <select name="org_training_classification_id[]" id="classification-select"
                                class="custom-multiselect" multiple>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->id }}"
                                        @if (in_array(
                                                $classification->id,
                                                old('org_training_classification_id', $training ? $training->org_training_classification_id : []))) selected @endif>
                                        {{ $classification->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('org_training_classification_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        @error('org_training_classification_id.*')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- وصف البرنامج -->
                    <div class="input-group position-relative char-counter-container">
                        <label>وصف المسار التدريبي<span class="required">*</span></label>
                        <textarea name="program_description" placeholder="اكتب نبذة مختصرة عن المسار التدريبي" rows="5" class="validate"
                            minlength="50" maxlength="500" id="description">{{ old('program_description', $training->program_description ?? '') }}</textarea>
                        <div class="char-counter-badge-new" id="description-counter">0/500</div>
                        @error('program_description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- أزرار التنقل -->
                    <div class="input-group-2col mt-4">
                        <div class="input-group">
                            <a href="{{ route('homePageOrganization') }}" class="pbtn pbtn-outlined-main">
                                إلغاء
                            </a>
                        </div>
                        <div class="input-group">
                            <button type="submit" class="pbtn pbtn-main" id="submit-btn">
                                حفظ ومتابعة
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
    <!-- يجب تحميل jQuery أولاً -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/counter.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // عناصر DOM
            const countrySelect = document.getElementById('country_id');
            const citySelect = document.getElementById('city');
            const oldCountryId = "{{ old('country_id', $training->country_id ?? '') }}";
            const savedCity = "{{ old('city', $training->city ?? '') }}";
            const presentationMethod = document.getElementById('presentation-method');
            const locationFields = document.getElementById('location-fields');
            const descriptionTextarea = document.getElementById('description');
            const charCounter = document.getElementById('description-counter');
            const form = document.getElementById("publish-training-1-form");
            const maxLength = 500;

            // تحميل المدن حسب الدولة
            function loadCities(countryId, selectedCity = null) {
                if (!countryId) {
                    citySelect.innerHTML = '<option value="" disabled selected>اختر الدولة أولاً</option>';
                    citySelect.disabled = true;
                    return;
                }

                citySelect.innerHTML = '<option value="" disabled selected>جاري تحميل المدن...</option>';
                citySelect.disabled = true;

                fetch(`/cities?country_id=${countryId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        citySelect.innerHTML = '<option value="" disabled selected hidden>اختر المدينة</option>';

                        data.forEach(city => {
                            const option = new Option(city.name, city.name);
                            if (selectedCity && selectedCity === city.name) {
                                option.selected = true;
                            }
                            citySelect.add(option);
                        });

                        if (selectedCity && !Array.from(citySelect.options).some(o => o.value ===
                                selectedCity)) {
                            citySelect.add(new Option(selectedCity, selectedCity, true, true));
                        }

                        citySelect.disabled = false;

                        // تهيئة custom select إذا كانت الدالة موجودة
                        if (typeof initCustomSelect === 'function') {
                            initCustomSelect(citySelect);
                        }
                    })
                    .catch(err => {
                        console.error("فشل تحميل المدن:", err);
                        citySelect.innerHTML = '<option disabled selected>فشل في تحميل المدن</option>';
                    });
            }

            // عرض/إخفاء حقول الموقع حسب طريقة التقديم
            function toggleLocationFields() {
                const selectedMethod = presentationMethod.value;
                locationFields.style.display = (selectedMethod === 'حضوري' || selectedMethod === 'هجين') ?
                    'block' :
                    'none';

                // إذا كانت الطريقة غير حضورية، قم بإزالة علامات الخطأ من حقول الموقع
                if (selectedMethod !== 'حضوري' && selectedMethod !== 'هجين') {
                    const locationInputs = ['country_id', 'city', 'address_in_detail'];
                    locationInputs.forEach(inputName => {
                        const input = form.elements[inputName];
                        if (input) {
                            input.classList.remove("error-border");
                            const errorElement = document.getElementById(`error-${inputName}`);
                            if (errorElement) errorElement.remove();
                        }
                    });
                }
            }

            // تحديث عداد الأحرف
            function updateCounter() {
                const currentLength = descriptionTextarea.value.length;
                charCounter.textContent = `${currentLength}/${maxLength}`;
            }

            // إظهار رسائل الخطأ
            function showError(input, message) {
                const errorId = `error-${input.name}`;
                const existingError = document.getElementById(errorId);

                if (existingError) {
                    existingError.remove();
                }

                input.classList.add("error-border");
                const errorMsg = document.createElement("span");
                errorMsg.className = "error-message";
                errorMsg.textContent = message;
                errorMsg.id = errorId;

                const parentContainer = input.closest('.input-group') || input.closest('.custom-select-container');
                if (parentContainer) {
                    parentContainer.appendChild(errorMsg);
                } else {
                    input.parentNode.insertBefore(errorMsg, input.nextSibling);
                }
            }

            // أحداث المستخدم
            countrySelect.addEventListener('change', function() {
                loadCities(this.value);
            });

            presentationMethod.addEventListener('change', toggleLocationFields);
            descriptionTextarea.addEventListener('input', updateCounter);

            form.addEventListener("submit", function(e) {
                // تأكد من إرسال city حتى لو كانت فارغة
                if (!form.elements['city']) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'city';
                    hiddenInput.value = '';
                    form.appendChild(hiddenInput);
                }

                let valid = true;

                // الحقول المطلوبة للتحقق
                const requiredFields = {
                    title: "يرجى إدخال عنوان التدريب",
                    program_description: "يرجى إدخال وصف التدريب",
                    "org_training_classification_id[]": "يرجى اختيار تصنيف واحد على الأقل"
                };

                // التحقق من الحقول المطلوبة الأساسية
                Object.keys(requiredFields).forEach(fieldName => {
                    const input = form.elements[fieldName];
                    if (!input) return;

                    input.classList.remove("error-border");
                    if (input.parentNode && input.parentNode.classList.contains(
                            'custom-select-container')) {
                        input.parentNode.classList.remove("error-border");
                    }

                    // إزالة أي رسائل خطأ سابقة
                    const errorId = `error-${fieldName}`;
                    const existingError = document.getElementById(errorId);
                    if (existingError) existingError.remove();

                    let isEmpty = false;

                    if (fieldName === "org_training_classification_id[]") {
                        // التحقق من التصنيفات المتعددة
                        const selectedOptions = Array.from(input.options).filter(opt => opt
                            .selected);
                        isEmpty = selectedOptions.length === 0;
                    } else {
                        isEmpty = !input.value.trim();
                    }

                    if (isEmpty) {
                        valid = false;
                        showError(input, requiredFields[fieldName]);
                    }
                });

                // تحقق إضافي للحقول المشروطة (مكان الانعقاد)
                const delivery = form.elements["program_presentation_method"];
                if (delivery.value === 'حضوري' || delivery.value === 'هجين') {
                    const locationFields = {
                        country_id: "يرجى إدخال الدولة",
                        city: "يرجى إدخال المدينة",
                        address_in_detail: "يرجى إدخال العنوان التفصيلي"
                    };

                    Object.keys(locationFields).forEach(fieldName => {
                        const input = form.elements[fieldName];
                        if (!input || !input.value.trim()) {
                            valid = false;
                            showError(input, locationFields[fieldName]);
                        }
                    });
                }

                // تحقق من طول الوصف
                const description = form.elements["program_description"];
                if (description.value.length < 50) {
                    valid = false;
                    showError(description, "الوصف يجب أن يحتوي على 50 أحرف على الأقل");
                }

                if (!valid) {
                    console.log("❌ الفورم فيه حقول ناقصة، الإرسال توقف");
                    e.preventDefault();
                } else {
                    console.log("✅ الفورم جاهز، رح ينرسل");
                }
            });

            // التهيئة الأولية
            if (oldCountryId) {
                loadCities(oldCountryId, savedCity);
            }
            toggleLocationFields();
            updateCounter();
        });
    </script>
@endsection
