@extends('frontend.layouts.master')
@section('title', 'أهداف التدريب')
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
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        @include('orgTrainings.partials.stepper', [
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
                            ستكون المعلومات التالية مرئية للجمهور على صفحة المسار التدريبي وستؤثر بشكل مباشر في قرار
                            المتدربين في الانضمام إلى مسارك. لذلك أضف النتائج بشكل واضح، وحدد المتطلبات إن وجدت، واختر خصائص
                            الفئة المستهدفة بدقة، وأضف ميزات للمسار إن توفرت. </div>
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
                    <form action="{{ route('orgTraining.storeGoals', $training->id) }}" method="POST"
                        id="training-goals-form">
                        @csrf
                        <!-- قسم مخرجات البرنامج -->
                        <div class="input-group">
                            <label>ما هي مخرجات البرنامج؟ <span class="required">*</span></label>
                            <div class="sub-label">
                                يجب عليك تحديد 4 أهداف أو نتائج للتعلم على الأقل.
                            </div>
                            @php
                                // استخدام البيانات القديمة أولاً إذا موجودة (عند وجود أخطاء)
                                // ثم البيانات من قاعدة البيانات
                                $learningOutcomes = old(
                                    'learning_outcomes', 
                                    isset($trainingGoal->learning_outcomes) 
                                        ? (is_array($trainingGoal->learning_outcomes) 
                                            ? $trainingGoal->learning_outcomes 
                                            : json_decode($trainingGoal->learning_outcomes, true)) 
                                        : []
                                );
                                
                                // ضمان وجود 4 عناصر على الأقل
                                if (count($learningOutcomes) < 4) {
                                    $learningOutcomes = array_merge(
                                        $learningOutcomes,
                                        array_fill(0, 4 - count($learningOutcomes), '')
                                    );
                                }
                            @endphp
                            @foreach ($learningOutcomes as $index => $outcome)
                                <div class="{{ $index < 4 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="learning_outcomes[]" value="{{ $outcome }}"
                                        placeholder="مثال: سيتمكّن المشاركون من تطوير خارطة طريق لمنتج رقمي بناءً على تحليل احتياجات السوق والمستخدمين. " />
                                    @error('learning_outcomes.' . $index)
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد إلى ردك</span>
                            </button>
                        </div>
                        <!-- قسم الفئة المستهدفة -->
                        <div class="input-group ">
                            <label>من هي الفئة المستهدفة؟<span class="required">*</span></label>
                            <div class="sub-label">
                                قم باختيار خصائص الفئة المستهدفة في هذا المسار ، والذين سيجدون محتواه ذا قيمة. سيساعدك هذا
                                في جذب المتدربين المناسبين إلى برنامجك.
                            </div>
                            <!-- السؤال الأول: المستوى التعليمي -->
                            <div class="education-level-section mt-3">
                                <div class="input-group mt-3">
                                    <label>المستوى التعليمي</label>
                                    <div class="custom-select-container">
                                        <select name="education_level_id[]" class="custom-multiselect" multiple>
                                            @foreach ($educationLevels as $education_level)
                                                <option value="{{ $education_level->id }}"
                                                    {{ in_array($education_level->id, old('education_level_id', 
                                                        is_array($trainingGoal->education_level_id) 
                                                            ? $trainingGoal->education_level_id 
                                                            : json_decode($trainingGoal->education_level_id ?? '[]', true)
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
                                <!-- السؤال الثاني: حالة العمل -->
                                <div class="input-group mt-3">
                                    <label>حالة العمل</label>
                                    <div class="custom-select-container">
                                        <select name="work_status[]" id="employment-status-select"
                                            class="custom-multiselect" multiple>
                                            <option value="working"
                                                {{ in_array('working', old('work_status',
                                                    is_array($trainingGoal->work_status)
                                                        ? $trainingGoal->work_status
                                                        : json_decode($trainingGoal->work_status ?? '[]', true)
                                                )) ? 'selected' : '' }}>
                                                يعمل
                                            </option>
                                            <option value="not_working"
                                                {{ in_array('not_working', old('work_status',
                                                    is_array($trainingGoal->work_status)
                                                        ? $trainingGoal->work_status
                                                        : json_decode($trainingGoal->work_status ?? '[]', true)
                                                )) ? 'selected' : '' }}>
                                                لا يعمل
                                            </option>
                                        </select>
                                    </div>
                                    @error('work_status')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- السؤال الثالث: القطاع -->
                                <div class="input-group mt-3">
                                    <label>القطاع</label>
                                    <div class="custom-select-container">
                                        <select name="work_sector_id[]" id="sector-select" class="custom-multiselect"
                                            multiple>
                                            @foreach ($workSectors as $sector)
                                                <option value="{{ $sector->id }}"
                                                    {{ in_array($sector->id, old('work_sector_id', 
                                                        is_array($trainingGoal->work_sector_id) 
                                                            ? $trainingGoal->work_sector_id 
                                                            : json_decode($trainingGoal->work_sector_id ?? '[]', true)
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
                                <!-- السؤال الرابع: المستوى الوظيفي -->
                                <div class="input-group mt-3">
                                    <label>المستوى الوظيفي</label>
                                    <div class="custom-select-container">
                                        <select name="job_position[]" id="job-level-select" class="custom-multiselect"
                                            multiple>
                                            @foreach ($jobPositions as $job)
                                                <option value="{{ $job->value }}"
                                                    {{ in_array($job->value, old('job_position', 
                                                        is_array($trainingGoal->job_position) 
                                                            ? $trainingGoal->job_position 
                                                            : json_decode($trainingGoal->job_position ?? '[]', true)
                                                        )) ? 'selected' : '' }}>
                                                    {{ $job->value }}
                                                </option>
                                            @endforeach>
                                        </select>
                                    </div>
                                    @error('job_position')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- السؤال الخامس: الجنسية أو المنطقة -->
                                <div class="input-group mt-3">
                                    <label>الجنسية أو المنطقة</label>
                                    <div class="custom-select-container">
                                        <select name="country_id[]" id="nationality-region-select"
                                            class="custom-multiselect" multiple>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ in_array($country->id, old('country_id', 
                                                        is_array($trainingGoal->country_id) 
                                                            ? $trainingGoal->country_id 
                                                            : json_decode($trainingGoal->country_id ?? '[]', true)
                                                        )) ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach>
                                        </select>
                                    </div>
                                    @error('country_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="input-group-2col mt-4">
                                <div class="input-group">
                                    <a href="{{ route('orgTraining.basicInformation', $training->id) }}"
                                        class="pbtn pbtn-outlined-main">
                                        السابق
                                    </a>
                                </div>
                                <div class="input-group">
                                    <button type="submit" class="pbtn pbtn-main">
                                        حفظ والمتابعة
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
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById("training-goals-form");
        
        // إضافة حقول جديدة
        document.querySelectorAll(".add-more-btn").forEach(function(btn) {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const group = btn.closest(".input-group");
                const inputs = group.querySelectorAll('input[type="text"]');
                const lastInput = inputs[inputs.length - 1];
                
                // إنشاء حقل جديد
                const newInputDiv = document.createElement("div");
                newInputDiv.className = "input-with-remove";
                
                // إنشاء عنصر الإدخال
                const newInput = document.createElement("input");
                newInput.type = "text";
                newInput.name = lastInput.name;
                newInput.required = lastInput.required;
                newInput.placeholder = lastInput.placeholder;
                
                // إنشاء زر الحذف
                const removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.className = "remove-input-btn";
                removeBtn.innerHTML = "&times;";
                removeBtn.onclick = function() {
                    newInputDiv.remove();
                };
                
                // تجميع العناصر
                newInputDiv.appendChild(newInput);
                newInputDiv.appendChild(removeBtn);
                
                // إضافة رسالة الخطأ إن وجدت
                const errorMsg = document.createElement("p");
                errorMsg.className = "error-message";
                newInputDiv.appendChild(errorMsg);
                
                // إدراج الحقل الجديد قبل زر الإضافة
                group.insertBefore(newInputDiv, btn);
            });
        });
        
        // إضافة أزرار الحذف للحقول الموجودة مسبقًا
        document.querySelectorAll(".input-with-remove").forEach(function(div) {
            if (!div.querySelector(".remove-input-btn")) {
                const removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.className = "remove-input-btn";
                removeBtn.innerHTML = "&times;";
                removeBtn.onclick = function() {
                    div.remove();
                };
                div.appendChild(removeBtn);
            }
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
        
        // دالة التحقق من حقول مخرجات البرنامج
        function validateLearningOutcomes() {
            const learningOutcomes = document.querySelectorAll('input[name^="learning_outcomes"]');
            let isValid = true;
            let filledOutcomes = 0;
            
            learningOutcomes.forEach((input, index) => {
                // إزالة أي رسائل خطأ سابقة
                const errorId = `error-${input.name.replace(/[^a-zA-Z0-9]/g, '-')}-${index}`;
                const existingError = document.getElementById(errorId);
                if (existingError) {
                    existingError.remove();
                }
                
                input.classList.remove("error-border");
                
                // التحقق من أن الحقل ليس فارغًا
                if (!input.value.trim()) {
                    isValid = false;
                    
                    // إضافة حدود حمراء
                    input.classList.add("error-border");
                    
                    // إضافة رسالة الخطأ تحت الحقل
                    const errorMsg = document.createElement("p");
                    errorMsg.className = "error-message";
                    errorMsg.textContent = 'هذا الحقل مطلوب';
                    errorMsg.id = errorId;
                    
                    // البحث عن الحاوية المناسبة لإضافة رسالة الخطأ
                    const parentContainer = input.closest('.input-without-remove') || input.closest('.input-with-remove');
                    if (parentContainer) {
                        parentContainer.appendChild(errorMsg);
                    } else {
                        input.parentNode.insertBefore(errorMsg, input.nextSibling);
                    }
                } else {
                    filledOutcomes++;
                }
            });
            
            // التحقق من وجود 4 نتائج تعلم على الأقل (بدون رسالة عامة)
            if (filledOutcomes < 4) {
                isValid = false;
            }
            
            return isValid;
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
        
        // دالة التحقق الشامل عند الإرسال
        function validateForm() {
            let isValid = true;
            
            // التحقق من حقول مخرجات البرنامج
            if (!validateLearningOutcomes()) {
                isValid = false;
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
                    }
                }
            });
            
            return isValid;
        }
        
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
        
        // التحقق من صحة النموذج عند الإرسال
        form.addEventListener("submit", function(e) {
            // التحقق من جميع الحقول عند الإرسال
            const isValid = validateForm();
            
            // منع إرسال النموذج إذا كان غير صالح
            if (!isValid) {
                e.preventDefault();
                console.log("❌ الفورم فيه حقول ناقصة، الإرسال توقف");
                
                // التمرير إلى أول حقل غير صالح
                const firstError = document.querySelector('.error-border');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                console.log("✅ الفورم جاهز، رح ينرسل");
            }
        });
    });
    </script>
@endsection