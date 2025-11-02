@extends('frontend.layouts.master')
@section('title', 'الأهداف ومحتوى التدريب')
@section('content')
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        <!-- خطوات التقدم -->
                        @include('trainings.partials.stepper', [
                            'currentStep' => 2,
                            'trainingId' => $training->id ?? null,
                            'isEditMode' => true,
                        ])
                    </div>
                </div>
                <div class="left-col">
                    <div class="info-message">
                        <div class="info-badge">
                            <img src="{{ asset('images/icons/hint.svg') }}" alt="" />
                        </div>
                        <div class="info-message-content">
                            ستكون الأوصاف التالية مرئية للجمهور على الصفحة المقصودة للدورة وستؤثر بشكل مباشر في أداء دورتك.
                            كما ستساعد هذه الأوصاف المتعلمين على تحديد ما إذا كانت دورتك مناسبة لهم أم لا.
                        </div>
                    </div>
                    @if ($errors->any())
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
                    @endif
                    
                    <form action="{{ route('training.store.goals', $training->id) }}" method="POST" id="training-goals-form">
                        @csrf
                        <div class="input-group">
                            <label>ما الذي سيتعلمه المشاركون في هذا التدريب؟ <span class="required">*</span></label>
                            <div class="sub-label">
                                يجب عليك تحديد 4 أهداف أو نتائج للتعلم على الأقل يمكن للمتعلمين تحقيقها بعد إنهاء دورتك.
                            </div>
                            @php
                                $learningOutcomes = old(
                                    'learning_outcomes',
                                    isset($learning_outcomes) ? $learning_outcomes : array_fill(0, 2, ''),
                                );
                                if (is_string($learningOutcomes)) {
                                    $learningOutcomes = json_decode($learningOutcomes, true) ?? [];
                                }
                                $learningOutcomes = array_pad($learningOutcomes, 2, '');
                            @endphp
                            @foreach ($learningOutcomes as $index => $outcome)
                                <div class="{{ $index < 2 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="learning_outcomes[]"
                                        value="{{ is_array($outcome) ? '' : $outcome }}"
                                        placeholder="مثال: سيتمكّن المشاركون من تطوير خارطة طريق لمنتج رقمي بناءً على تحليل احتياجات السوق والمستخدمين." />
                                    @error('learning_outcomes.' . $index)
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn" data-field="learning_outcomes">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد إلى ردك</span>
                            </button>
                        </div>
                        
                        <div class="input-group">
                            <label>ما المتطلبات أو الشروط اللازمة للالتحاق بتدريبك؟<span class="required">*</span></label>
                            <div class="sub-label">
                                اذكر المهارات أو الخبرة أو الأدوات أو المعدات المطلوبة.
                            </div>
                            @php
                                $requirements = old(
                                    'requirements',
                                    isset($requirements) ? $requirements : array_fill(0, 1, ''),
                                );
                                if (is_string($requirements)) {
                                    $requirements = json_decode($requirements, true) ?? [];
                                }
                                $requirements = array_pad($requirements, 1, '');
                            @endphp
                            @foreach ($requirements as $index => $requirement)
                                <div class="{{ $index == 0 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="requirements[]"
                                        value="{{ is_array($requirement) ? '' : $requirement }}"
                                        placeholder="مثال: امتلاك جهاز حاسوب مع اتصال إنترنت مستقر." />
                                    @error('requirements.' . $index)
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn" data-field="requirements">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد إلى ردك</span>
                            </button>
                        </div>
                        
                        <div class="input-group">
                            <label>من هي الفئة المستهدفة؟<span class="required">*</span></label>
                            <div class="sub-label">
                                قم باختيار خصائص الفئة المستهدفة في هذا التدريب، والذين سيجدون محتواه ذا قيمة.
                            </div>
                            
                            <!-- المستوى التعليمي -->
                            <div class="input-group mt-3">
                                <label>المستوى التعليمي</label>
                                <div class="custom-select-container">
                                    <select name="education_level_id[]" class="custom-multiselect" multiple>
                                        @foreach ($educationLevels as $education_level)
                                            <option value="{{ $education_level->id }}"
                                                {{ in_array($education_level->id, old('education_level_id', 
                                                    is_array($trainingDetail->education_level_id) 
                                                        ? $trainingDetail->education_level_id 
                                                        : json_decode($trainingDetail->education_level_id ?? '[]', true)
                                                    )) ? 'selected' : '' }}>
                                                {{ $education_level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('education_level_id')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- حالة العمل -->
                            <div class="input-group mt-3">
                                <label>حالة العمل</label>
                                <div class="custom-select-container">
                                    <select name="work_status[]" class="custom-multiselect" multiple>
                                        <option value="working"
                                            {{ in_array('working', old('work_status',
                                                is_array($trainingDetail->work_status)
                                                    ? $trainingDetail->work_status
                                                    : json_decode($trainingDetail->work_status ?? '[]', true)
                                            )) ? 'selected' : '' }}>
                                            يعمل
                                        </option>
                                        <option value="not_working"
                                            {{ in_array('not_working', old('work_status',
                                                is_array($trainingDetail->work_status)
                                                    ? $trainingDetail->work_status
                                                    : json_decode($trainingDetail->work_status ?? '[]', true)
                                            )) ? 'selected' : '' }}>
                                            لا يعمل
                                        </option>
                                        <option value="not_specified"
                                            {{ in_array('not_specified', old('work_status',
                                                is_array($trainingDetail->work_status)
                                                    ? $trainingDetail->work_status
                                                    : json_decode($trainingDetail->work_status ?? '[]', true)
                                            )) ? 'selected' : '' }}>
                                            غير مقيد
                                        </option>
                                        <option value="all"
                                            {{ in_array('all', old('work_status',
                                                is_array($trainingDetail->work_status)
                                                    ? $trainingDetail->work_status
                                                    : json_decode($trainingDetail->work_status ?? '[]', true)
                                            )) ? 'selected' : '' }}>
                                            الكل
                                        </option>
                                    </select>
                                </div>
                                @error('work_status')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- القطاع -->
                            <div class="input-group mt-3">
                                <label>القطاع</label>
                                <div class="custom-select-container">
                                    <select name="work_sector_id[]" class="custom-multiselect" multiple>
                                        @foreach ($workSectors as $sector)
                                            <option value="{{ $sector->id }}"
                                                {{ in_array($sector->id, old('work_sector_id', 
                                                    is_array($trainingDetail->work_sector_id) 
                                                        ? $trainingDetail->work_sector_id 
                                                        : json_decode($trainingDetail->work_sector_id ?? '[]', true)
                                                    )) ? 'selected' : '' }}>
                                                {{ $sector->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('work_sector_id')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- المستوى الوظيفي -->
                            <div class="input-group mt-3">
                                <label>المستوى الوظيفي</label>
                                <div class="custom-select-container">
                                    <select name="job_position[]" class="custom-multiselect" multiple>
                                        @foreach ($jobPositions as $job)
                                            <option value="{{ $job->value }}"
                                                {{ in_array($job->value, old('job_position', 
                                                    is_array($trainingDetail->job_position) 
                                                        ? $trainingDetail->job_position 
                                                        : json_decode($trainingDetail->job_position ?? '[]', true)
                                                    )) ? 'selected' : '' }}>
                                                {{ $job->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('job_position')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- الجنسية أو المنطقة -->
                            <div class="input-group mt-3">
                                <label>الجنسية أو المنطقة</label>
                                <div class="custom-select-container">
                                    <select name="country_id[]" class="custom-multiselect" multiple>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ in_array($country->id, old('country_id', 
                                                    is_array($trainingDetail->country_id) 
                                                        ? $trainingDetail->country_id 
                                                        : json_decode($trainingDetail->country_id ?? '[]', true)
                                                    )) ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('country_id')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label>ما هي ميزات التدريب؟</label>
                            <div class="sub-label">
                                اذكر النقاط التي تميز هذا التدريب عن غيره.
                            </div>
                            @php
                                $benefits = old('benefits', isset($benefits) ? $benefits : array_fill(0, 1, ''));
                                if (is_string($benefits)) {
                                    $benefits = json_decode($benefits, true) ?? [];
                                }
                                $benefits = array_pad($benefits, 1, '');
                            @endphp
                            @foreach ($benefits as $index => $benefit)
                                <div class="{{ $index == 0 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="benefits[]"
                                        value="{{ is_array($benefit) ? '' : $benefit }}"
                                        placeholder="مثال: شهادة معتمدة" />
                                    @error('benefits.' . $index)
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn" data-field="benefits">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد إلى ردك</span>
                            </button>
                        </div>
                        
                        <div class="input-group-2col mt-4">
                            <div class="input-group">
                                <a href="{{ route('training.basic', $training->id) }}" class="pbtn pbtn-outlined-main">
                                    السابق
                                </a>
                            </div>
                            <div class="input-group">
                                <button type="submit" class="pbtn pbtn-main">
                                    حفظ والمتابعة للفريق
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
    <style>
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
        .custom-select-container .error-border {
            border-color: red;
        }
        .custom-multiselect.error-border {
            border: 1px solid red !important;
            border-radius: 12px !important;
        }
        .remove-input-btn {
            background: none;
            border: none;
            color: red;
            font-size: 18px;
            cursor: pointer;
            margin-right: 10px;
        }
        .custom-select-container.error-border {
            border: 1px solid red !important;
            border-radius: 12px !important;
        }
        .custom-select-container.error-border .custom-multiselect {
            border-color: transparent !important;
        }
        .error-border .custom-multiselect-wrapper{
            border-color: transparent !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // دالة للتحقق من أن جميع الحقول في مجموعة معينة مملوءة
            function areAllFieldsFilled(fieldName) {
                const inputs = document.querySelectorAll(`input[name="${fieldName}[]"]`);
                for (let input of inputs) {
                    if (!input.value.trim()) {
                        return false;
                    }
                }
                return true;
            }

            // إضافة حقول جديدة
            document.querySelectorAll(".add-more-btn").forEach(function(btn) {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();
                    
                    const fieldName = this.dataset.field;
                    const group = btn.closest(".input-group");
                    
                    // // بالنسبة لحقل الميزات فقط، التحقق من أن جميع الحقول مملوءة قبل الإضافة
                    // if (fieldName === 'benefits') {
                    //     if (!areAllFieldsFilled(fieldName)) {
                    //         alert('يرجى ملء جميع حقول الميزات الحالية قبل إضافة حقل جديد');
                    //         return;
                    //     }
                    // }
                    
                    // استخدم أول حقل ثابت كقالب دائمًا
                    const templateDiv = group.querySelector(".input-without-remove");
                    if (!templateDiv) return;
                    
                    // نسخ الحقل
                    const newInputDiv = templateDiv.cloneNode(true);
                    // تغيير الكلاس ليكون قابلًا للإزالة
                    newInputDiv.classList.remove("input-without-remove");
                    newInputDiv.classList.add("input-with-remove");
                    // مسح القيم القديمة
                    const newInput = newInputDiv.querySelector('input[type="text"]');
                    newInput.value = "";
                    // إضافة زر الحذف
                    const removeBtn = document.createElement("button");
                    removeBtn.type = "button";
                    removeBtn.className = "remove-input-btn";
                    removeBtn.innerHTML = "&times;";
                    removeBtn.title = "حذف";
                    removeBtn.onclick = function() {
                        newInputDiv.remove();
                    };
                    newInputDiv.appendChild(removeBtn);
                    // إضافة الحقل الجديد قبل زر "أضف المزيد"
                    group.insertBefore(newInputDiv, btn);
                });
            });
            
            // إضافة أزرار الحذف للحقول الموجودة مسبقًا عند تحميل الصفحة
            document.querySelectorAll(".input-group").forEach(function(group) {
                group.querySelectorAll(".input-with-remove").forEach(function(div) {
                    if (!div.querySelector(".remove-input-btn")) {
                        const removeBtn = document.createElement("button");
                        removeBtn.type = "button";
                        removeBtn.className = "remove-input-btn";
                        removeBtn.innerHTML = "&times;";
                        removeBtn.title = "حذف";
                        removeBtn.onclick = function() {
                            div.remove();
                        };
                        div.appendChild(removeBtn);
                    }
                });
            });
            
            // دالة إظهار رسائل الخطأ
            function showError(input, message) {
                // إزالة أي رسائل خطأ سابقة
                const errorId = `error-${input.name.replace(/[^a-zA-Z0-9]/g, '-')}`;
                const existingError = document.getElementById(errorId);
                if (existingError) {
                    existingError.remove();
                }
                
                // إضافة الحدود الحمراء
                if (input.tagName === 'SELECT' && input.multiple) {
                    // لحقول الاختيار المتعددة، أضف الحدود الحمراء للحاوية الخارجية
                    const container = input.closest('.custom-select-container');
                    if (container) {
                        container.classList.add("error-border");
                    }
                } else {
                    input.classList.add("error-border");
                }
                
                // إنشاء رسالة الخطأ
                const errorMsg = document.createElement("p");
                errorMsg.className = "error-message";
                errorMsg.textContent = message;
                errorMsg.id = errorId;
                
                // تحديد مكان إضافة رسالة الخطأ
                const parentContainer = input.closest('.input-group') || input.closest('.custom-select-container');
                if (parentContainer) {
                    parentContainer.appendChild(errorMsg);
                } else {
                    input.parentNode.insertBefore(errorMsg, input.nextSibling);
                }
            }
            
            // دالة التحقق من صحة الحقل
            function validateField(field) {
                let isValid = true;
                
                // إزالة أي رسائل خطأ سابقة
                const errorId = `error-${field.name.replace(/[^a-zA-Z0-9]/g, '-')}`;
                const existingError = document.getElementById(errorId);
                if (existingError) {
                    existingError.remove();
                }
                
                // إزالة الحدود الحمراء
                if (field.tagName === 'SELECT' && field.multiple) {
                    const container = field.closest('.custom-select-container');
                    if (container) {
                        container.classList.remove("error-border");
                    }
                } else {
                    field.classList.remove("error-border");
                }
                
                // التحقق من حقول الإدخال النصية
                if (field.tagName === 'INPUT' && field.type === 'text' && field.hasAttribute('required')) {
                    if (!field.value.trim()) {
                        isValid = false;
                        showError(field, 'هذا الحقل مطلوب');
                    }
                }
                
                // التحقق من القوائم المنسدلة
                if (field.tagName === 'SELECT' && field.multiple) {
                    if (field.selectedOptions.length === 0) {
                        isValid = false;
                        showError(field, 'يجب تحديد خيار واحد على الأقل');
                    }
                }
                
                return isValid;
            }
            
            // التحقق من صحة النموذج عند الإرسال
            document.getElementById('training-goals-form').addEventListener('submit', function(e) {
                let isValid = true;
                let firstErrorField = null;
                
                // التحقق من وجود 2 نتائج تعلم على الأقل
                const learningOutcomes = document.querySelectorAll('input[name^="learning_outcomes"]');
                let filledOutcomes = 0;
                
                learningOutcomes.forEach(input => {
                    if (input.value.trim()) {
                        filledOutcomes++;
                    }
                    
                    // التحقق من أن الحقل ليس فارغًا
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add("error-border");
                        
                        // إضافة رسالة الخطأ تحت الحقل
                        if (!input.parentNode.querySelector(".error-message")) {
                            const errorMsg = document.createElement("p");
                            errorMsg.className = "error-message";
                            errorMsg.textContent = 'هذا الحقل مطلوب';
                            input.parentNode.appendChild(errorMsg);
                        }
                        
                        // تحديد أول حقل خطأ للتمرير إليه
                        if (!firstErrorField) {
                            firstErrorField = input;
                        }
                    } else {
                        input.classList.remove("error-border");
                        // إزالة رسالة الخطأ إذا كانت موجودة
                        const errorMsg = input.parentNode.querySelector(".error-message");
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });
                
                if (filledOutcomes < 2) {
                    isValid = false;
                    // alert('يجب إدخال 2 نتائج تعلم على الأقل');
                }
                
                // التحقق من وجود متطلب واحد على الأقل
                const requirements = document.querySelectorAll('input[name^="requirements"]');
                let filledRequirements = 0;
                
                requirements.forEach(input => {
                    if (input.value.trim()) {
                        filledRequirements++;
                    }
                    
                    // التحقق من أن الحقل ليس فارغًا
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add("error-border");
                        
                        // إضافة رسالة الخطأ تحت الحقل
                        if (!input.parentNode.querySelector(".error-message")) {
                            const errorMsg = document.createElement("p");
                            errorMsg.className = "error-message";
                            errorMsg.textContent = 'هذا الحقل مطلوب';
                            input.parentNode.appendChild(errorMsg);
                        }
                        
                        // تحديد أول حقل خطأ للتمرير إليه
                        if (!firstErrorField) {
                            firstErrorField = input;
                        }
                    } else {
                        input.classList.remove("error-border");
                        // إزالة رسالة الخطأ إذا كانت موجودة
                        const errorMsg = input.parentNode.querySelector(".error-message");
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });
                
                if (filledRequirements < 1) {
                    isValid = false;
                    // alert('يجب إدخال متطلب واحد على الأقل');
                }
                
                // التحقق من حقول الفئة المستهدفة
                const targetAudienceSelects = [
                    'education_level_id[]',
                    'work_status[]',
                    'work_sector_id[]',
                    'job_position[]',
                    'country_id[]'
                ];
                
                targetAudienceSelects.forEach(function(selectName) {
                    const select = document.querySelector(`select[name="${selectName}"]`);
                    if (select) {
                        if (!validateField(select)) {
                            isValid = false;
                            // تحديد أول حقل خطأ للتمرير إليه
                            if (!firstErrorField) {
                                firstErrorField = select;
                            }
                        }
                    }
                });
                
                // التحقق من الحقول المطلوبة
                document.querySelectorAll('input[required]').forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                        // تحديد أول حقل خطأ للتمرير إليه
                        if (!firstErrorField) {
                            firstErrorField = input;
                        }
                    }
                });
                
                // بالنسبة لحقل الميزات، التحقق من أنه إذا أضاف حقولاً إضافية، يجب أن تكون مملوءة
                const benefits = document.querySelectorAll('input[name^="benefits"]');
                if (benefits.length > 1) { // إذا كان هناك أكثر من حقل ميزات
                    for (let i = 1; i < benefits.length; i++) { // تخطي الحقل الأول
                        if (!benefits[i].value.trim()) {
                            isValid = false;
                            benefits[i].classList.add("error-border");
                            
                            // إضافة رسالة الخطأ تحت الحقل
                            if (!benefits[i].parentNode.querySelector(".error-message")) {
                                const errorMsg = document.createElement("p");
                                errorMsg.className = "error-message";
                                errorMsg.textContent = 'يجب ملء حقل الميزات إذا أضفته';
                                benefits[i].parentNode.appendChild(errorMsg);
                            }
                            
                            // تحديد أول حقل خطأ للتمرير إليه
                            if (!firstErrorField) {
                                firstErrorField = benefits[i];
                            }
                        } else {
                            benefits[i].classList.remove("error-border");
                            // إزالة رسالة الخطأ إذا كانت موجودة
                            const errorMsg = benefits[i].parentNode.querySelector(".error-message");
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    
                    // التمرير إلى أول حقل غير صالح
                    if (firstErrorField) {
                        firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
            
            // إضافة أحداث التحقق للحقول عند فقدان التركيز
            document.querySelectorAll('input[required]').forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });
            
            document.querySelectorAll('select[multiple]').forEach(select => {
                select.addEventListener('change', function() {
                    validateField(this);
                });
            });
        });
    </script>
@endsection