@extends('frontend.layouts.master')
@section('title', 'جدولة الجلسات التدريبية')
@section('content')
    <style>
        .session-header,
        .training-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .remove-session-btn,
        .remove-training-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            margin-right: 10px;
        }

        .template {
            display: none !important;
            visibility: hidden;
            height: 0;
            overflow: hidden;
            position: absolute;
            left: -9999px;
        }

        .time-picker-container {
            position: relative;
            width: 100%;
        }

        .time-picker {
            cursor: pointer;
        }

        .time-picker-dropdown {
            display: none;
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            width: 100%;
            box-sizing: border-box;
            top: 100%;
            left: 0;
        }

        .time-option {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .time-option:hover {
            background-color: #f0f0f0;
        }

        .time-option:last-child {
            border-bottom: none;
        }

        .error-border {
            border: 1px solid red !important;
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

        .training-files-preview-file {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .remove-training-file {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 18px;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .remove-training-file:hover {
            background: #f8d7da;
        }
        /* أضف هذا الـ CSS لجعل حدود الخطأ أكثر وضوحًا */
.custom-singleselect.error-border,
.custom-singleselect.error-border .select-selected,
.custom-singleselect.error-border .select-items {
    border: 2px solid #dc3545 !important;
    border-radius: 4px !important;
    background-color: #fff8f8 !important;
}

.time-picker.error-border {
    border: 2px solid #dc3545 !important;
    border-radius: 4px !important;
    background-color: #fff8f8 !important;
}

select.error-border {
    border: 2px solid #dc3545 !important;
    border-radius: 4px !important;
    background-color: #fff8f8 !important;
}
    </style>
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        @include('orgTrainings.partials.stepper', [
                            'currentStep' => 3,
                            'trainingId' => $training->id ?? null,
                            'isEditMode' => true,
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
                    <div class="info-message">
                        <div class="info-badge">
                            <img src="{{ asset('images/icons/hint.svg') }}" alt="" />
                        </div>
                        <div class="info-message-content">
                            أضف التدريبات المكوّنة للبرنامج، وأضف تفاصيل الجلسات لكل تدريب على حدة ضمن البرنامج التدريبي.
                            يساعد ذلك في تتبع حضور المتدربين لكل جلسة بدقة. تأكّد من تحديد التاريخ والتوقيت ومدة كل جلسة
                            بوضوح. يمكنك إضافة عدد غير محدود من التدريبات.
                        </div>
                    </div>
                    <form id="publish-training-4-form" method="POST"
                        action="{{ route('orgTraining.storeTrainingDetails', $training->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="form-errors-container" class="error-container" style="display: none;"></div>

                        <div class="input-group m-0">
                            <h4>إضافة تدريب</h4>
                            <p>قم بإضافة معلومات كل تدريب ضمن البرنامج التدريبي</p>
                        </div>

                        <div id="trainings-container">
                            @php
                                $trainings = $trainings ?? collect();
                                $availableTrainers = $availableTrainers ?? collect();
                                $schedules_later = $schedules_later ?? false;

                                if (old('program_title')) {
                                    $trainingsData = [];
                                    foreach (old('program_title') as $index => $title) {
                                        $trainingsData[] = [
                                            'title' => $title,
                                            'program_title' => $title,
                                            'trainer_id' => old('trainer_id.' . $index, ''),
                                            'schedules_later' => old('schedules_later.' . $index, false),
                                            'num_of_session' => old('num_of_session.' . $index, null),
                                            'num_of_hours' => old('num_of_hours.' . $index, null),
                                            'schedules' => old('schedules.' . $index, []),
                                        ];
                                    }
                                } else {
                                    $trainingsData =
                                        $trainings->count() > 0
                                            ? $trainings->toArray()
                                            : [
                                                [
                                                    'title' => '',
                                                    'program_title' => '',
                                                    'trainer_id' => '',
                                                    'schedules_later' => false,
                                                    'num_of_session' => null,
                                                    'num_of_hours' => null,
                                                    'schedules' => [
                                                        [
                                                            'date' => '',
                                                            'start_time' => '',
                                                            'end_time' => '',
                                                        ],
                                                    ],
                                                ],
                                            ];
                                }
                            @endphp

                            @foreach ($trainingsData as $trainingIndex => $trainingItem)
                                @include('orgTrainings.partials.training_section', [
                                    'trainingIndex' => $trainingIndex,
                                    'trainingItem' => $trainingItem,
                                    'availableTrainers' => $availableTrainers,
                                    'schedules_later' => $schedules_later,
                                    'displayNumber' => $trainingIndex + 1,
                                    'canRemove' => $trainingIndex > 0,
                                ])
                            @endforeach
                        </div>

                        <div class="input-group">
                            <button type="button" class="add-more-btn" id="add-training-btn">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف تدريب جديد</span>
                            </button>
                        </div>
                        <div class="training-files">
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
                                        $trainingFiles = $trainingFiles ?? [];
                                    @endphp
                                    @if (!empty($trainingFiles))
                                        @foreach ($trainingFiles as $file)
                                            @php
                                                // التحقق من نوع البيانات
                                                $filePath = '';
                                                $fileName = '';

                                                if (is_array($file)) {
                                                    // إذا كان مصفوفة، حاول الحصول على المسار أو الاسم
                                                    $filePath = $file['path'] ?? '';
                                                    $fileName =
                                                        $file['name'] ??
                                                        ($filePath ? basename($filePath) : 'ملف غير معروف');
                                                } elseif (is_string($file)) {
                                                    // إذا كان نصًا، استخدمه كمسار
                                                    $filePath = $file;
                                                    $fileName = basename($file);
                                                }
                                            @endphp
                                            <div class="training-files-preview-file" data-file-path="{{ $filePath }}">
                                                <span>{{ $fileName }}</span>
                                                <input type="hidden" name="existing_training_files[]"
                                                    value="{{ $filePath }}" class="existing-file-input">
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

                        <div class="input-group-2col mt-4">
                            <div class="input-group">
                                <a href="{{ route('orgTraining.goals', $training->id) }}" class="pbtn pbtn-outlined-main">
                                    السابق
                                </a>
                            </div>
                            <div class="input-group">
                                <button type="submit" class="pbtn pbtn-main" id="publish-training-4-submit-btn">
                                    حفظ والمتابعة للإعدادات
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <div id="templates" class="template">
        <div id="training-template">
            <div class="training-section border rounded-4 p-3 mt-4" data-training-index="{trainingIndex}">
                <div class="training-details mb-5">
                    <div class="training-section-header">
                        <div class="input-group">
                            <h5 class="">{displayNumber}- عنوان التدريب و المدرب الرئيسي</h5>
                            <div class="sub-label">
                                اذكر عنوان التدريب بالإضافة إلى اسم المدرب المسؤول عن تنفيذ التدريب
                            </div>
                        </div>
                        <button type="button" class="remove-training-btn"
                            style="top: -50px;position: relative; display: {removeButtonDisplay}"
                            data-training-index="{trainingIndex}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000"
                                viewBox="0 0 256 256">
                                <path
                                    d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="input-group-2col">
                        <div class="input-group">
                            <input type="text" name="program_title[{trainingIndex}]" placeholder="أدخل عنوان التدريب">
                            <span class="error-message" id="program-title-error-{trainingIndex}"
                                style="display:none;"></span>
                        </div>

                        <div class="input-group">
                            <select name="trainer_id[{trainingIndex}]" class="custom-singleselect">
                                {trainersOptions}
                            </select>
                            <span class="error-message" id="trainer-id-error-{trainingIndex}" style="display:none;"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label class="switch w-100">
                        <span class="switch-label">سيتم تحديد الجلسات لاحقًا بعد اكتمال عدد المشاركين</span>
                        <input type="checkbox" name="schedules_later[{trainingIndex}]" value="1"
                            id="schedules_later_{trainingIndex}">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="session-details-container" id="session-details-{trainingIndex}" style="display: none;">
                    <div class="input-group-2col">
                        <div class="input-group">
                            <label>عدد الجلسات</label>
                            <input type="number" name="num_of_session[{trainingIndex}]" min="1"
                                placeholder="مثال: 5">
                            <span class="error-message" id="num-of-session-error-{trainingIndex}"
                                style="display:none;"></span>
                        </div>
                        <div class="input-group">
                            <label>عدد الساعات</label>
                            <input type="number" name="num_of_hours[{trainingIndex}]" min="0.5" step="0.5"
                                placeholder="مثال: 10">
                            <span class="error-message" id="num-of-hours-error-{trainingIndex}"
                                style="display:none;"></span>
                        </div>
                    </div>
                </div>

                <div class="session-container" id="sessions-container-{trainingIndex}" style="display: none;">
                </div>

                <div class="input-group">
                    <button type="button" class="add-more-btn add-session-btn" data-training-index="{trainingIndex}"
                        style="display: none;">
                        <img src="{{ asset('images/icons/plus-main.svg') }}" />
                        <span>أضف جلسة جديدة</span>
                    </button>
                </div>
            </div>
        </div>

        <div id="session-template">
            <div class="session-group" style="margin-bottom: 15px;" data-training-index="{trainingIndex}"
                data-session-index="{sessionIndex}">
                <div class="session-header">
                    <div class="input-group">
                        <h5 class="w-100">تاريخ الجلسة {sessionNumber} و مدتها <span class="required">*</span></h5>
                        <div class="sub-label">
                            اختر التاريخ الذي ستُعقد فيه الجلسة و وقت بداية ونهاية الجلسة.
                        </div>
                    </div>
                    <button type="button" style="position: relative; right: 5px; display: {removeButtonDisplay}"
                        class="remove-session-btn" data-training-index="{trainingIndex}"
                        data-session-index="{sessionIndex}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000"
                            viewBox="0 0 256 256">
                            <path
                                d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="session-details">
                    <div class="input-group-2col inner" style="align-items: flex-start;">
                        <div class="input-group">
                            <input type="date" name="schedules[{trainingIndex}][{sessionIndex}][date]"
                                placeholder="مثال: 15 يونيو 2025" class="session-date-input w-100">
                            <span class="error-message" id="schedule-date-error-{trainingIndex}-{sessionIndex}"
                                style="display:none;"></span>
                        </div>

                        <div class="input-group">
                            <div class="time-picker-container">
                                <div class="time-picker" data-training-index="{trainingIndex}"
                                    data-session-index="{sessionIndex}" data-type="start">وقت بدء الجلسة</div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden" name="schedules[{trainingIndex}][{sessionIndex}][start_time]"
                                    class="time-picker-input" value="">
                            </div>
                            <span class="error-message" id="start-time-error-{trainingIndex}-{sessionIndex}"
                                style="display:none;"></span>
                        </div>

                        <div class="input-group">
                            <div class="time-picker-container">
                                <div class="time-picker" data-training-index="{trainingIndex}"
                                    data-session-index="{sessionIndex}" data-type="end">وقت انتهاء الجلسة</div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden" name="schedules[{trainingIndex}][{sessionIndex}][end_time]"
                                    class="time-picker-input" value="">
                            </div>
                            <span class="error-message" id="end-time-error-{trainingIndex}-{sessionIndex}"
                                style="display:none;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/validator@13.9.0/validator.min.js"></script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script>
        const availableTrainers = [
            @foreach ($availableTrainers as $trainer)
                {
                    id: {{ $trainer->id }},
                    name: "{{ $trainer->getTranslation('name', 'ar') }} {{ $trainer->trainer?->getTranslation('last_name', 'ar') }}"
                },
            @endforeach
        ];
        let appState = {
            nextTrainingIndex: {{ count($trainingsData) }},
            sessionCounters: {}
        };
        @foreach ($trainingsData as $trainingIndex => $trainingItem)
            appState.sessionCounters[{{ $trainingIndex }}] =
                {{ count(is_array($trainingItem) ? $trainingItem['schedules'] ?? [] : $trainingItem->schedules ?? []) }};
        @endforeach

        document.addEventListener('DOMContentLoaded', function() {
            initializeAllTimePickers();
            const addTrainingBtn = document.getElementById('add-training-btn');
            if (addTrainingBtn) {
                addTrainingBtn.addEventListener('click', addNewTraining);
            }
            setupEventDelegation();
            initializeExistingSwitches();
            updateCounters();
            
            // إضافة مستمعي الأحداث للتحقق الفوري
            addValidationListeners();
            
            // إدارة ملفات التدريب
            const wrapper = document.querySelector(".training-files-wrapper[data-multiple='true']");
            if (wrapper) {
                const fileInput = wrapper.querySelector(".training-files-input");
                const selectBtn = wrapper.querySelector(".select-training-files");
                const defaultView = wrapper.querySelector(".training-files-default");
                const previewContainer = wrapper.querySelector(".training-files-preview");
                const addMoreBtn = wrapper.querySelector(".add-training-files");
                
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
            
            const form = document.getElementById('publish-training-4-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // تحديث الحقول المخفية قبل التحقق
                    updateHiddenInputsBeforeSubmit();

                    // التحقق من صحة النموذج
                    if (!validateFormBeforeSubmit()) {
                        e.preventDefault();
                        // التمرير إلى أول رسالة خطأ
                        const firstError = document.querySelector('.error-message[style="display: block;"]');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        return false;
                    }
                    
                    // إذا كان كل شيء صحيحًا، قم بتعطيل الزر وإرسال النموذج
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = `
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            جاري الحفظ...
                        `;
                    }
                });
            }
        });

        function generateTimeOptions() {
            const options = [];
            for (let hour = 0; hour < 24; hour++) {
                for (let minute = 0; minute < 60; minute += 30) {
                    const time24 = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                    let hour12 = hour % 12 || 12;
                    const ampm = hour < 12 ? 'صباحاً' : 'مساءً';
                    const time12 = `${hour12}:${minute.toString().padStart(2, '0')} ${ampm}`;
                    options.push({
                        value: time24,
                        label: time12
                    });
                }
            }
            return options;
        }

        const timeOptions = generateTimeOptions();

        function initializeAllTimePickers() {
            document.querySelectorAll('.time-picker-container').forEach(container => {
                if (!container.dataset.initialized) {
                    initializeTimePicker(container);
                }
            });
        }

        function initializeTimePicker(container) {
            const picker = container.querySelector('.time-picker');
            const dropdown = container.querySelector('.time-picker-dropdown');
            const hiddenInput = container.querySelector('.time-picker-input');
            const currentValue = hiddenInput.value;
            
            if (currentValue) {
                const option = timeOptions.find(opt => opt.value === currentValue);
                if (option) {
                    picker.textContent = option.label;
                }
            }
            
            dropdown.innerHTML = '';
            timeOptions.forEach(option => {
                const optionElement = document.createElement('div');
                optionElement.className = 'time-option';
                optionElement.textContent = option.label;
                optionElement.dataset.value = option.value;
                
                if (option.value === currentValue) {
                    optionElement.classList.add('selected');
                }
                
                optionElement.addEventListener('click', function(e) {
                    e.stopPropagation();
                    picker.textContent = option.label;
                    hiddenInput.value = option.value;
                    dropdown.querySelectorAll('.time-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    optionElement.classList.add('selected');
                    dropdown.style.display = 'none';
                    
                    // التحقق الفوري بعد تغيير الوقت
                    const sessionGroup = picker.closest('.session-group');
                    if (sessionGroup) {
                        validateSession(sessionGroup);
                        validateSessionsOrder(sessionGroup.closest('.training-section'));
                    }
                });
                
                dropdown.appendChild(optionElement);
            });
            
            picker.addEventListener('click', function(e) {
                e.stopPropagation();
                document.querySelectorAll('.time-picker-dropdown').forEach(d => {
                    if (d !== dropdown) d.style.display = 'none';
                });
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
            
            container.dataset.initialized = 'true';
        }

        function closeAllTimeDropdowns() {
            document.querySelectorAll('.time-picker-dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        }

        function setupEventDelegation() {
            const trainingsContainer = document.getElementById('trainings-container');
            if (!trainingsContainer) {
                return;
            }
            
            trainingsContainer.addEventListener('click', function(e) {
                const addSessionBtn = e.target.closest('.add-session-btn');
                if (addSessionBtn) {
                    const trainingIndex = parseInt(addSessionBtn.dataset.trainingIndex);
                    if (!isNaN(trainingIndex)) {
                        addNewSession(trainingIndex);
                    }
                    return;
                }
                
                const removeSessionBtn = e.target.closest('.remove-session-btn');
                if (removeSessionBtn) {
                    const trainingIndex = parseInt(removeSessionBtn.dataset.trainingIndex);
                    const sessionIndex = parseInt(removeSessionBtn.dataset.sessionIndex);
                    if (!isNaN(trainingIndex) && !isNaN(sessionIndex)) {
                        removeSession(trainingIndex, sessionIndex);
                    }
                    return;
                }
                
                const removeTrainingBtn = e.target.closest('.remove-training-btn');
                if (removeTrainingBtn) {
                    const trainingIndex = parseInt(removeTrainingBtn.dataset.trainingIndex);
                    if (!isNaN(trainingIndex)) {
                        removeTraining(trainingIndex);
                    }
                    return;
                }
                
                if (e.target.classList.contains('time-picker')) {
                    handleTimePickerClick(e.target);
                    return;
                }
                
                if (e.target.classList.contains('time-option')) {
                    handleTimeOptionClick(e.target);
                    return;
                }
            });
            
            document.addEventListener('click', function(e) {
                if (!e.target.classList.contains('time-picker') &&
                    !e.target.classList.contains('time-option')) {
                    closeAllTimeDropdowns();
                }
            });
        }

        function handleTimePickerClick(picker) {
            closeAllTimeDropdowns();
            const dropdown = picker.nextElementSibling;
            if (dropdown && dropdown.classList.contains('time-picker-dropdown')) {
                dropdown.style.display = 'block';
            }
        }

        function handleTimeOptionClick(option) {
            const time = option.getAttribute('data-value');
            const dropdown = option.closest('.time-picker-dropdown');
            const picker = dropdown ? dropdown.previousElementSibling : null;
            const hiddenInput = dropdown ? dropdown.nextElementSibling : null;
            
            if (picker && hiddenInput) {
                picker.textContent = option.textContent;
                hiddenInput.value = time;
                dropdown.style.display = 'none';
                
                // التحقق الفوري بعد تغيير الوقت
                const sessionGroup = picker.closest('.session-group');
                if (sessionGroup) {
                    validateSession(sessionGroup);
                    validateSessionsOrder(sessionGroup.closest('.training-section'));
                }
            }
        }

        function initializeExistingSwitches() {
            document.querySelectorAll('input[name^="schedules_later"]').forEach(checkbox => {
                const name = checkbox.getAttribute('name');
                const matches = name.match(/schedules_later\[(\d+)\]/);
                if (matches && matches.length > 1) {
                    const trainingIndex = parseInt(matches[1]);
                    if (!isNaN(trainingIndex)) {
                        checkbox.setAttribute('id', `schedules_later_${trainingIndex}`);
                        checkbox.addEventListener('change', function() {
                            toggleScheduleFields(trainingIndex);
                        });
                        toggleScheduleFields(trainingIndex);
                    }
                }
            });
        }

        function addNewTraining() {
            const container = document.getElementById('trainings-container');
            if (!container) {
                return;
            }
            
            const existingIndices = Array.from(container.querySelectorAll('.training-section'))
                .map(section => {
                    const index = section.getAttribute('data-training-index');
                    return index && !isNaN(parseInt(index)) ? parseInt(index) : -1;
                })
                .filter(index => index >= 0);
                
            const trainingIndex = existingIndices.length > 0 ? Math.max(...existingIndices) + 1 : 0;
            const trainingTemplate = document.getElementById('training-template');
            
            if (!trainingTemplate) {
                return;
            }
            
            let trainersOptions = '<option value="" disabled selected style="color: silver !important;">اختر مدربًا</option>';
            availableTrainers.forEach(trainer => {
                trainersOptions += `<option value="${trainer.id}">${trainer.name}</option>`;
            });
            
            let newTrainingHtml = trainingTemplate.innerHTML
                .replace(/{trainingIndex}/g, trainingIndex)
                .replace(/{displayNumber}/g, existingIndices.length + 1)
                .replace(/{removeButtonDisplay}/g, existingIndices.length > 0 ? 'block' : 'none')
                .replace(/{trainersOptions}/g, trainersOptions);
                
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newTrainingHtml;
            const newTraining = tempDiv.firstElementChild;
            container.appendChild(newTraining);
            
            const allElements = newTraining.querySelectorAll('*');
            allElements.forEach(element => {
                Array.from(element.attributes).forEach(attr => {
                    if (attr.value.includes('{trainingIndex}')) {
                        element.setAttribute(attr.name, attr.value.replace(/{trainingIndex}/g, trainingIndex));
                    }
                });
                
                if (element.textContent && element.textContent.includes('{trainingIndex}')) {
                    element.textContent = element.textContent.replace(/{trainingIndex}/g, trainingIndex);
                }
                
                if (element.innerHTML && element.innerHTML.includes('{trainingIndex}')) {
                    element.innerHTML = element.innerHTML.replace(/{trainingIndex}/g, trainingIndex);
                }
            });
            
            appState.sessionCounters[trainingIndex] = 0;
            
            const newCheckbox = newTraining.querySelector(`input[name="schedules_later[${trainingIndex}]"]`);
            if (newCheckbox) {
                newCheckbox.setAttribute('id', `schedules_later_${trainingIndex}`);
                newCheckbox.addEventListener('change', function() {
                    toggleScheduleFields(trainingIndex);
                });
                newCheckbox.checked = false;
                toggleScheduleFields(trainingIndex);
            }
            
            const trainerSelect = newTraining.querySelector(`select[name="trainer_id[${trainingIndex}]"]`);
            if (trainerSelect) {
                populateTrainersEnhanced(trainerSelect);
            }
            
            initializeTimePickersForElement(newTraining);
            
            // إضافة مستمعي الأحداث للتحقق الفوري
            const programTitleInput = newTraining.querySelector(`input[name="program_title[${trainingIndex}]"]`);
            if (programTitleInput) {
                programTitleInput.addEventListener('blur', function() {
                    validateTraining(newTraining);
                });
            }
            
            const numOfSessionInput = newTraining.querySelector(`input[name="num_of_session[${trainingIndex}]"]`);
            if (numOfSessionInput) {
                numOfSessionInput.addEventListener('blur', function() {
                    validateTraining(newTraining);
                });
            }
            
            const numOfHoursInput = newTraining.querySelector(`input[name="num_of_hours[${trainingIndex}]"]`);
            if (numOfHoursInput) {
                numOfHoursInput.addEventListener('blur', function() {
                    validateTraining(newTraining);
                });
            }
            
            updateCounters();
        }

        function populateTrainersEnhanced(selectElement) {
            if (!selectElement) {
                return false;
            }
            
            try {
                selectElement.innerHTML = '';
                const defaultOption = document.createElement('option');
                defaultOption.value = "";
                defaultOption.disabled = true;
                defaultOption.selected = true;
                defaultOption.style.color = "silver";
                defaultOption.textContent = "اختر مدربًا";
                selectElement.appendChild(defaultOption);
                
                if (!availableTrainers || availableTrainers.length === 0) {
                    return false;
                }
                
                availableTrainers.forEach((trainer) => {
                    const option = document.createElement('option');
                    option.value = trainer.id;
                    option.textContent = trainer.name;
                    selectElement.appendChild(option);
                });
                
                if (typeof window.initCustomSelect === 'function') {
                    window.initCustomSelect(selectElement);
                }
                
                return true;
            } catch (error) {
                return false;
            }
        }

        function addNewSession(trainingIndex) {
            const container = document.getElementById(`sessions-container-${trainingIndex}`);
            if (!container) {
                return;
            }
            
            const currentSessions = container.querySelectorAll('.session-group').length;
            const sessionIndex = currentSessions;
            const sessionTemplate = document.getElementById('session-template');
            
            if (!sessionTemplate) {
                return;
            }
            
            let newSessionHtml = sessionTemplate.innerHTML
                .replace(/{trainingIndex}/g, trainingIndex)
                .replace(/{sessionIndex}/g, sessionIndex)
                .replace(/{sessionNumber}/g, sessionIndex + 1)
                .replace(/{removeButtonDisplay}/g, sessionIndex > 0 ? 'block' : 'none');
                
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newSessionHtml;
            const newSessionGroup = tempDiv.firstElementChild;
            container.appendChild(newSessionGroup);
            
            const allElements = newSessionGroup.querySelectorAll('*');
            allElements.forEach(element => {
                Array.from(element.attributes).forEach(attr => {
                    if (attr.value.includes('{trainingIndex}') || attr.value.includes('{sessionIndex}')) {
                        element.setAttribute(attr.name,
                            attr.value
                            .replace(/{trainingIndex}/g, trainingIndex)
                            .replace(/{sessionIndex}/g, sessionIndex)
                        );
                    }
                });
                
                if (element.textContent && (element.textContent.includes('{trainingIndex}') || element.textContent.includes('{sessionIndex}'))) {
                    element.textContent = element.textContent
                        .replace(/{trainingIndex}/g, trainingIndex)
                        .replace(/{sessionIndex}/g, sessionIndex);
                }
                
                if (element.innerHTML && (element.innerHTML.includes('{trainingIndex}') || element.innerHTML.includes('{sessionIndex}'))) {
                    element.innerHTML = element.innerHTML
                        .replace(/{trainingIndex}/g, trainingIndex)
                        .replace(/{sessionIndex}/g, sessionIndex);
                }
            });
            
            appState.sessionCounters[trainingIndex] = sessionIndex + 1;
            initializeTimePickersForElement(newSessionGroup);
            
            // إضافة مستمعي الأحداث للتحقق الفوري
            const dateInput = newSessionGroup.querySelector('input[name$="[date]"]');
            if (dateInput) {
                dateInput.addEventListener('change', function() {
                    validateSession(newSessionGroup);
                    validateSessionsOrder(newSessionGroup.closest('.training-section'));
                });
            }
            
            updateCounters();
        }

        function initializeTimePickersForElement(element) {
            element.querySelectorAll('.time-picker-container').forEach(container => {
                if (!container.dataset.initialized) {
                    initializeTimePicker(container);
                }
            });
        }

        function removeSession(trainingIndex, sessionIndex) {
            const container = document.getElementById(`sessions-container-${trainingIndex}`);
            if (!container) return;
            
            const sessionElement = container.querySelector(`.session-group[data-session-index="${sessionIndex}"]`);
            if (sessionElement) {
                sessionElement.remove();
                updateCounters();
                
                // التحقق من ترتيب الجلسات بعد الحذف
                const trainingSection = container.closest('.training-section');
                if (trainingSection) {
                    validateSessionsOrder(trainingSection);
                }
            }
        }

        function removeTraining(trainingIndex) {
            const container = document.getElementById('trainings-container');
            if (!container) return;
            
            const trainingElement = container.querySelector(`.training-section[data-training-index="${trainingIndex}"]`);
            if (trainingElement) {
                trainingElement.remove();
                delete appState.sessionCounters[trainingIndex];
                updateCounters();
            }
        }

        function toggleScheduleFields(trainingIndex) {
            if (!isValidIndex(trainingIndex.toString())) {
                return;
            }
            
            const checkbox = document.getElementById(`schedules_later_${trainingIndex}`);
            const sessionContainer = document.getElementById(`sessions-container-${trainingIndex}`);
            const detailsContainer = document.getElementById(`session-details-${trainingIndex}`);
            const addSessionBtn = document.querySelector(`.add-session-btn[data-training-index="${trainingIndex}"]`);
            
            if (!checkbox || !sessionContainer || !detailsContainer) {
                return;
            }
            
            if (checkbox.checked) {
                detailsContainer.style.display = 'block';
                sessionContainer.style.display = 'none';
                if (addSessionBtn) addSessionBtn.style.display = 'none';
                sessionContainer.innerHTML = '';
                appState.sessionCounters[trainingIndex] = 0;
            } else {
                detailsContainer.style.display = 'none';
                sessionContainer.style.display = 'block';
                if (addSessionBtn) addSessionBtn.style.display = 'flex';
                if (sessionContainer.querySelectorAll('.session-group').length === 0) {
                    addNewSession(trainingIndex);
                }
            }
        }

        function updateCounters() {
            const trainingSections = document.querySelectorAll('.training-section:not(.template)');
            trainingSections.forEach((section, index) => {
                const originalTrainingIndex = section.getAttribute('data-training-index');
                if (!originalTrainingIndex ||
                    originalTrainingIndex.includes('{') ||
                    section.closest('.template') ||
                    isNaN(parseInt(originalTrainingIndex))) {
                    return;
                }
                
                const trainingIndex = parseInt(originalTrainingIndex);
                const header = section.querySelector('.training-section-header h5');
                if (header) {
                    header.textContent = `${index + 1}- عنوان التدريب و المدرب الرئيسي`;
                }
                
                const deleteBtn = section.querySelector('.remove-training-btn');
                if (deleteBtn) {
                    deleteBtn.style.display = trainingSections.length > 1 ? 'block' : 'none';
                    deleteBtn.setAttribute('data-training-index', trainingIndex);
                }
                
                const sessionContainer = section.querySelector('.session-container');
                if (sessionContainer) {
                    sessionContainer.setAttribute('id', `sessions-container-${trainingIndex}`);
                }
                
                const detailsContainer = section.querySelector('.session-details-container');
                if (detailsContainer) {
                    detailsContainer.setAttribute('id', `session-details-${trainingIndex}`);
                }
                
                const scheduleLaterCheckbox = section.querySelector(`input[name^="schedules_later"]`);
                if (scheduleLaterCheckbox) {
                    scheduleLaterCheckbox.setAttribute('id', `schedules_later_${trainingIndex}`);
                }
                
                const sessionGroups = section.querySelectorAll('.session-group');
                sessionGroups.forEach((session, sessionIndex) => {
                    const header = session.querySelector('.session-header h5');
                    if (header) {
                        header.innerHTML = `تاريخ الجلسة ${sessionIndex + 1} و مدتها <span class="required">*</span>`;
                    }
                    
                    const deleteBtn = session.querySelector('.remove-session-btn');
                    if (deleteBtn) {
                        deleteBtn.style.display = sessionGroups.length > 1 ? 'block' : 'none';
                        deleteBtn.setAttribute('data-training-index', trainingIndex);
                        deleteBtn.setAttribute('data-session-index', sessionIndex);
                    }
                    
                    session.setAttribute('data-session-index', sessionIndex);
                    session.setAttribute('data-training-index', trainingIndex);
                    
                    const dateInput = session.querySelector('input[name$="[date]"]');
                    if (dateInput) {
                        dateInput.setAttribute('name', `schedules[${trainingIndex}][${sessionIndex}][date]`);
                    }
                    
                    const startTimeInput = session.querySelector('input[name$="[start_time]"]');
                    if (startTimeInput) {
                        startTimeInput.setAttribute('name', `schedules[${trainingIndex}][${sessionIndex}][start_time]`);
                    }
                    
                    const endTimeInput = session.querySelector('input[name$="[end_time]"]');
                    if (endTimeInput) {
                        endTimeInput.setAttribute('name', `schedules[${trainingIndex}][${sessionIndex}][end_time]`);
                    }
                    
                    const startTimePicker = session.querySelector('.time-picker[data-type="start"]');
                    if (startTimePicker) {
                        startTimePicker.setAttribute('data-training-index', trainingIndex);
                        startTimePicker.setAttribute('data-session-index', sessionIndex);
                    }
                    
                    const endTimePicker = session.querySelector('.time-picker[data-type="end"]');
                    if (endTimePicker) {
                        endTimePicker.setAttribute('data-training-index', trainingIndex);
                        endTimePicker.setAttribute('data-session-index', sessionIndex);
                    }
                });
                
                appState.sessionCounters[trainingIndex] = sessionGroups.length;
                const addSessionBtn = section.querySelector('.add-session-btn');
                if (addSessionBtn) {
                    addSessionBtn.setAttribute('data-training-index', trainingIndex);
                }
            });
        }

        function isValidIndex(indexString) {
            return indexString &&
                !indexString.includes('{') &&
                !isNaN(parseInt(indexString)) &&
                parseInt(indexString) >= 0;
        }

        // دالة لعرض رسائل الخطأ
// دالة لعرض رسائل الخطأ
function showFieldError(fieldElement, message) {
    // البحث عن عنصر رسالة الخطأ المرتبط بالحقل
    let errorElement;
    let targetElement = fieldElement;
    
    // إذا كان الحقل مخفي، استخدم الحقل الظاهر المرتبط به
    if (fieldElement.type === 'hidden') {
        if (fieldElement.name.includes('start_time') || fieldElement.name.includes('end_time')) {
            targetElement = fieldElement.previousElementSibling; // time-picker
        }
    }
    
    // البحث عن حاوية رسالة الخطأ
    let container;
    if (targetElement.classList.contains('time-picker')) {
        container = targetElement.closest('.time-picker-container');
    } else if (targetElement.tagName === 'SELECT') {
        container = targetElement.closest('.input-group');
    } else {
        container = targetElement.closest('.input-group');
    }
    
    errorElement = container.querySelector('.error-message');
    
    // إذا لم يكن هناك عنصر رسالة خطأ، قم بإنشائه
    if (!errorElement) {
        errorElement = document.createElement('span');
        errorElement.className = 'error-message';
        errorElement.style.display = 'none';
        errorElement.style.color = 'red';
        errorElement.style.fontSize = '12px';
        errorElement.style.marginTop = '5px';
        errorElement.style.fontWeight = 'bold';
        container.appendChild(errorElement);
    }
    
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    // إضافة حدود حمراء للحقل
    if (targetElement.classList.contains('time-picker')) {
        targetElement.style.border = '2px solid red';
        targetElement.style.borderRadius = '4px';
        targetElement.style.backgroundColor = '#fff8f8';
    } else if (targetElement.tagName === 'SELECT') {
        targetElement.style.border = '2px solid red';
        targetElement.style.borderRadius = '4px';
        targetElement.style.backgroundColor = '#fff8f8';
    } else {
        targetElement.style.border = '2px solid red';
        targetElement.style.borderRadius = '4px';
    }
    
    // إذا كان الحقل هو قائمة منسدلة مخصصة، أضف حدودًا للحاوية الخارجي
    const customSelect = targetElement.closest('.custom-singleselect');
    if (customSelect) {
        customSelect.style.border = '2px solid red';
        customSelect.style.borderRadius = '4px';
        customSelect.style.backgroundColor = '#fff8f8';
    }
}
        // دالة لإخفاء رسائل الخطأ
// دالة لإخفاء رسائل الخطأ
function hideFieldError(fieldElement) {
    // البحث عن عنصر رسالة الخطأ المرتبط بالحقل
    let errorElement;
    let targetElement = fieldElement;
    
    // إذا كان الحقل مخفي، استخدم الحقل الظاهر المرتبط به
    if (fieldElement.type === 'hidden') {
        if (fieldElement.name.includes('start_time') || fieldElement.name.includes('end_time')) {
            targetElement = fieldElement.previousElementSibling; // time-picker
        }
    }
    
    // البحث عن حاوية رسالة الخطأ
    let container;
    if (targetElement.classList.contains('time-picker')) {
        container = targetElement.closest('.time-picker-container');
    } else if (targetElement.tagName === 'SELECT') {
        container = targetElement.closest('.input-group');
    } else {
        container = targetElement.closest('.input-group');
    }
    
    errorElement = container.querySelector('.error-message');
    
    if (errorElement) {
        errorElement.style.display = 'none';
    }
    
    // إزالة الحدود الحمراء
    if (targetElement.classList.contains('time-picker')) {
        targetElement.style.border = '';
        targetElement.style.borderRadius = '';
        targetElement.style.backgroundColor = '';
    } else if (targetElement.tagName === 'SELECT') {
        targetElement.style.border = '';
        targetElement.style.borderRadius = '';
        targetElement.style.backgroundColor = '';
    } else {
        targetElement.style.border = '';
        targetElement.style.borderRadius = '';
    }
    
    // إذا كان الحقل هو قائمة منسدلة مخصصة، أزل الحدود من الحاوية الخارجي
    const customSelect = targetElement.closest('.custom-singleselect');
    if (customSelect) {
        customSelect.style.border = '';
        customSelect.style.borderRadius = '';
        customSelect.style.backgroundColor = '';
    }
}

        // دالة للتحقق من صحة الجلسة
        function validateSession(sessionGroup) {
            let isValid = true;
            
            const dateInput = sessionGroup.querySelector('input[name$="[date]"]');
            const startTimeInput = sessionGroup.querySelector('input[name$="[start_time]"]');
            const endTimeInput = sessionGroup.querySelector('input[name$="[end_time]"]');
            
            // التحقق من تاريخ الجلسة
            if (dateInput && !dateInput.value.trim()) {
                showFieldError(dateInput, 'تاريخ الجلسة مطلوب');
                isValid = false;
            } else if (dateInput) {
                // التحقق من أن التاريخ ليس في الماضي
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const selectedDate = new Date(dateInput.value);
                
                if (selectedDate < today) {
                    showFieldError(dateInput, 'تاريخ الجلسة يجب أن يكون اليوم أو تاريخ لاحق');
                    isValid = false;
                } else {
                    hideFieldError(dateInput);
                }
            }
            
            // التحقق من وقت البدء
            if (startTimeInput && !startTimeInput.value.trim()) {
                showFieldError(startTimeInput, 'وقت بدء الجلسة مطلوب');
                isValid = false;
            } else if (startTimeInput) {
                hideFieldError(startTimeInput);
            }
            
            // التحقق من وقت الانتهاء
            if (endTimeInput && !endTimeInput.value.trim()) {
                showFieldError(endTimeInput, 'وقت انتهاء الجلسة مطلوب');
                isValid = false;
            } else if (endTimeInput) {
                hideFieldError(endTimeInput);
            }
            
            // التحقق من أن وقت الانتهاء بعد وقت البداية
            if (startTimeInput && endTimeInput && startTimeInput.value.trim() && endTimeInput.value.trim()) {
                if (startTimeInput.value >= endTimeInput.value) {
                    showFieldError(endTimeInput, 'وقت الانتهاء يجب أن يكون بعد وقت البداية');
                    isValid = false;
                } else {
                    hideFieldError(endTimeInput);
                }
            }
            
            return isValid;
        }

        // دالة للتحقق من ترتيب الجلسات
        function validateSessionsOrder(trainingSection) {
            let isValid = true;
            const sessionGroups = trainingSection.querySelectorAll('.session-group');
            
            if (sessionGroups.length > 1) {
                for (let i = 1; i < sessionGroups.length; i++) {
                    const prevDateInput = sessionGroups[i-1].querySelector('input[name$="[date]"]');
                    const currentDateInput = sessionGroups[i].querySelector('input[name$="[date]"]');
                    
                    if (prevDateInput && currentDateInput && prevDateInput.value && currentDateInput.value) {
                        const prevDate = new Date(prevDateInput.value);
                        const currentDate = new Date(currentDateInput.value);
                        
                        if (currentDate < prevDate) {
                            showFieldError(currentDateInput, `تاريخ الجلسة يجب أن يكون بعد تاريخ الجلسة السابقة (${prevDateInput.value})`);
                            isValid = false;
                        } else if (currentDate.getTime() === prevDate.getTime()) {
                            // إذا كان التاريخ نفسه، تحقق من الأوقات
                            const prevStartTimeInput = sessionGroups[i-1].querySelector('input[name$="[start_time]"]');
                            const currentStartTimeInput = sessionGroups[i].querySelector('input[name$="[start_time]"]');
                            
                            if (prevStartTimeInput && currentStartTimeInput && 
                                prevStartTimeInput.value && currentStartTimeInput.value &&
                                currentStartTimeInput.value <= prevStartTimeInput.value) {
                                showFieldError(currentDateInput, 'وقت الجلسة يجب أن يكون بعد وقت الجلسة السابقة في نفس اليوم');
                                isValid = false;
                            } else {
                                hideFieldError(currentDateInput);
                            }
                        } else {
                            hideFieldError(currentDateInput);
                        }
                    }
                }
            }
            
            return isValid;
        }

        // دالة للتحقق من صحة التدريب
function validateTraining(trainingSection) {
    let isValid = true;
    
    const trainingIndex = trainingSection.getAttribute('data-training-index');
    // التأكد من أن الفهرس صالح
    if (!trainingIndex || trainingIndex.includes('{') || isNaN(parseInt(trainingIndex))) {
        return true; // تجاهل العناصر غير الصالحة
    }
    
    // استخدام محدد الاسم بدلاً من المعرف
    const schedulesLater = trainingSection.querySelector(`input[name="schedules_later[${trainingIndex}]"]`);
    const programTitleInput = trainingSection.querySelector(`input[name="program_title[${trainingIndex}]"]`);
    
    // التحقق من عنوان التدريب
    if (!programTitleInput || !programTitleInput.value.trim()) {
        showFieldError(programTitleInput, 'عنوان التدريب مطلوب');
        isValid = false;
    } else {
        hideFieldError(programTitleInput);
    }
    
    // التحقق من المدرب
    const trainerSelect = trainingSection.querySelector(`select[name="trainer_id[${trainingIndex}]"]`);
    if (!trainerSelect || !trainerSelect.value) {
        showFieldError(trainerSelect, 'يجب اختيار مدرب');
        isValid = false;
    } else {
        hideFieldError(trainerSelect);
    }
    
    // التحقق من الجلسات
    if (schedulesLater && schedulesLater.checked) {
        // التحقق من عدد الجلسات والساعات عند تحديد "الجلسات لاحقاً"
        const numOfSessionInput = trainingSection.querySelector(`input[name="num_of_session[${trainingIndex}]"]`);
        const numOfHoursInput = trainingSection.querySelector(`input[name="num_of_hours[${trainingIndex}]"]`);
        
        if (numOfSessionInput && !numOfSessionInput.value.trim()) {
            showFieldError(numOfSessionInput, 'عدد الجلسات مطلوب');
            isValid = false;
        } else if (numOfSessionInput) {
            hideFieldError(numOfSessionInput);
        }
        
        if (numOfHoursInput && !numOfHoursInput.value.trim()) {
            showFieldError(numOfHoursInput, 'عدد الساعات مطلوب');
            isValid = false;
        } else if (numOfHoursInput) {
            hideFieldError(numOfHoursInput);
        }
    } else {
        // التحقق من تفاصيل الجلسات
        const sessionGroups = trainingSection.querySelectorAll('.session-group');
        if (sessionGroups.length === 0) {
            isValid = false;
            // إظهار رسالة خطأ عامة
            const errorContainer = document.getElementById('form-errors-container');
            const errorMsg = document.createElement('div');
            errorMsg.className = 'alert alert-danger';
            errorMsg.textContent = 'يجب إضافة جلسة واحدة على الأقل لكل تدريب';
            errorContainer.appendChild(errorMsg);
            errorContainer.style.display = 'block';
        }
        
        // التحقق من صحة كل جلسة
        sessionGroups.forEach((sessionGroup) => {
            if (!validateSession(sessionGroup)) {
                isValid = false;
            }
        });
        
        // التحقق من ترتيب الجلسات
        if (!validateSessionsOrder(trainingSection)) {
            isValid = false;
        }
    }
    
    return isValid;
}

        // دالة للتحقق من صحة النموذج بالكامل
function validateFormBeforeSubmit() {
    let isValid = true;
    // استخدم محدد أكثر تحديدًا لتجنب العناصر المخفية والقوالب
    const trainingSections = document.querySelectorAll('#trainings-container > .training-section');
    const errorContainer = document.getElementById('form-errors-container');
    let errorMessages = [];
    
    // إخفاء جميع رسائل الخطأ السابقة
    document.querySelectorAll('.error-message').forEach(error => {
        error.style.display = 'none';
    });
    
    // إزالة الحدود الحمراء من جميع الحقول
    document.querySelectorAll('.error-border').forEach(field => {
        field.classList.remove('error-border');
        field.style.border = '';
    });
    
    // التحقق من كل تدريب
    trainingSections.forEach((section, index) => {
        // تخطي العناصر المخفية
        if (section.style.display === 'none') {
            return;
        }
        
        // التحقق من أن الفهرس صالح
        const trainingIndex = section.getAttribute('data-training-index');
        if (!trainingIndex || trainingIndex.includes('{') || isNaN(parseInt(trainingIndex))) {
            return;
        }
        
        if (!validateTraining(section)) {
            isValid = false;
            errorMessages.push(`التدريب ${index + 1}: يوجد أخطاء في البيانات`);
        }
    });
    
    // // عرض رسائل الخطأ العامة
    // if (errorMessages.length > 0) {
    //     errorContainer.innerHTML = '<div class="alert alert-danger"><ul>' + errorMessages.map(msg => '<li>' + msg + '</li>').join('') + '</ul></div>';
    //     errorContainer.style.display = 'block';
    // } else {
    //     errorContainer.style.display = 'none';
    // }
    
    return isValid;
}

        // إضافة مستمعي الأحداث للتحقق الفوري
        function addValidationListeners() {
            // التحقق من حقول التدريب الأساسية
            document.querySelectorAll('input[name^="program_title"]').forEach(input => {
                input.addEventListener('blur', function() {
                    const trainingSection = this.closest('.training-section');
                    if (trainingSection) {
                        validateTraining(trainingSection);
                    }
                });
            });
            
            document.querySelectorAll('select[name^="trainer_id"]').forEach(select => {
                select.addEventListener('change', function() {
                    const trainingSection = this.closest('.training-section');
                    if (trainingSection) {
                        validateTraining(trainingSection);
                    }
                });
            });
            
            // التحقق من حقول الجلسات
            document.querySelectorAll('input[name$="[date]"]').forEach(input => {
                input.addEventListener('change', function() {
                    const sessionGroup = this.closest('.session-group');
                    if (sessionGroup) {
                        validateSession(sessionGroup);
                        const trainingSection = sessionGroup.closest('.training-section');
                        if (trainingSection) {
                            validateSessionsOrder(trainingSection);
                        }
                    }
                });
            });
            
            // التحقق من حقول عدد الجلسات والساعات
            document.querySelectorAll('input[name^="num_of_session"]').forEach(input => {
                input.addEventListener('blur', function() {
                    const trainingSection = this.closest('.training-section');
                    if (trainingSection) {
                        validateTraining(trainingSection);
                    }
                });
            });
            
            document.querySelectorAll('input[name^="num_of_hours"]').forEach(input => {
                input.addEventListener('blur', function() {
                    const trainingSection = this.closest('.training-section');
                    if (trainingSection) {
                        validateTraining(trainingSection);
                    }
                });
            });
        }

        function updateHiddenInputsBeforeSubmit() {
            document.querySelectorAll('.session-group').forEach((sessionGroup) => {
                const startTimePicker = sessionGroup.querySelector('.time-picker[data-type="start"]');
                const endTimePicker = sessionGroup.querySelector('.time-picker[data-type="end"]');
                const startTimeHidden = sessionGroup.querySelector('input[name$="[start_time]"]');
                const endTimeHidden = sessionGroup.querySelector('input[name$="[end_time]"]');
                
                if (startTimePicker && startTimeHidden) {
                    const pickerText = startTimePicker.textContent.trim();
                    if (pickerText !== 'وقت بدء الجلسة') {
                        const option = timeOptions.find(opt => opt.label === pickerText);
                        if (option) {
                            startTimeHidden.value = option.value;
                        }
                    }
                }
                
                if (endTimePicker && endTimeHidden) {
                    const pickerText = endTimePicker.textContent.trim();
                    if (pickerText !== 'وقت انتهاء الجلسة') {
                        const option = timeOptions.find(opt => opt.label === pickerText);
                        if (option) {
                            endTimeHidden.value = option.value;
                        }
                    }
                }
            });
        }
    </script>
@endsection