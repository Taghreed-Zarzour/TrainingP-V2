@extends('frontend.layouts.master')
@section('title', 'أهداف التدريب')
@section('content')
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
                                    <input type="text" name="learning_outcomes[]" required value="{{ $outcome }}"
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
                                        <select name="work_status" id="employment-status-select"
                                            class="custom-multiselect" multiple>
                                            <option value="working" 
                                                {{ old('work_status', $trainingGoal->work_status) === 'working' ? 'selected' : '' }}>
                                                يعمل
                                            </option>
                                            <option value="not_working"
                                                {{ old('work_status', $trainingGoal->work_status) === 'not_working' ? 'selected' : '' }}>
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
                                            @endforeach
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
                                            @endforeach
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

            // التحقق من الصحة قبل الإرسال
            document.getElementById('training-goals-form').addEventListener('submit', function(e) {
                let isValid = true;

                // التحقق من وجود 4 نتائج تعلم على الأقل
                const learningOutcomes = document.querySelectorAll('input[name^="learning_outcomes"]');
                if (learningOutcomes.length < 4) {
                    isValid = false;
                    alert('يجب إدخال 4 نتائج تعلم على الأقل');
                }

                // التحقق من تحديد خيار واحد على الأقل في كل سؤال من أسئلة الفئة المستهدفة
                const targetAudienceSelects = [
                    'education_level',
                    'employment_status',
                    'sector',
                    'job_level',
                    'nationality_region'
                ];

                targetAudienceSelects.forEach(function(selectName) {
                    const select = document.querySelector(`select[name="${selectName}[]"]`);
                    if (select && select.selectedOptions.length === 0) {
                        isValid = false;
                        select.classList.add('error-border');

                        // إضافة رسالة خطأ إذا لم تكن موجودة
                        let errorMsg = select.parentNode.nextElementSibling;
                        if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                            errorMsg = document.createElement("p");
                            errorMsg.className = "error-message";
                            errorMsg.textContent = "يجب تحديد خيار واحد على الأقل";
                            select.parentNode.parentNode.insertBefore(errorMsg, select.parentNode
                                .nextSibling);
                        }
                    } else if (select) {
                        select.classList.remove('error-border');
                        // إزالة رسالة الخطأ إذا كانت موجودة
                        let errorMsg = select.parentNode.nextElementSibling;
                        if (errorMsg && errorMsg.classList.contains('error-message')) {
                            errorMsg.remove();
                        }
                    }
                });

                // التحقق من الحقول المطلوبة
                document.querySelectorAll('input[required]').forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('error-border');
                        const errorMsg = input.nextElementSibling;
                        if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                            const errorElement = document.createElement('p');
                            errorElement.className = 'error-message';
                            errorElement.textContent = 'هذا الحقل مطلوب';
                            input.parentNode.appendChild(errorElement);
                        }
                    } else {
                        input.classList.remove('error-border');
                        const errorMsg = input.nextElementSibling;
                        if (errorMsg && errorMsg.classList.contains('error-message')) {
                            errorMsg.remove();
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
