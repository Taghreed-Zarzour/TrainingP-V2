@extends('frontend.layouts.master')
@section('title', 'جدولة الجلسات التدريبية')
@section('css')
@endsection
@section('content')
    <style>
        /* إضافة أنماط لتحسين موضع أزرار الحذف */
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
    </style>
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        <!-- خطوات التقدم -->
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
                            بوضوح. يمكنك إضافة عدد غير محدود من التدريبات. </div>
                    </div>
                    <form id="publish-training-4-form" method="POST"
                        action="{{ route('orgTraining.storeTrainingDetails', $training->id) }}">
                        @csrf
                        <div id="form-errors-container" class="error-container" style="display: none;"></div>
                        <div id="trainings-container">
                            @php
                                // إذا لم يتم تحديد "تحديد الجلسات لاحقاً"، فأضف تدريب واحد على الأقل
                                if (!$schedules_later) {
                                    $safeTrainings = $training->trainings ?? collect(); // ضمان أن trainings ليست null
                                    $trainings = old(
                                        'program_title',
                                        $safeTrainings->count() > 0
                                            ? $safeTrainings->toArray()
                                            : [
                                                [
                                                    'title' => '',
                                                    'trainer_id' => '',
                                                    'schedules' => [
                                                        [
                                                            'date' => '',
                                                            'start_time' => '',
                                                            'end_time' => '',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                    );
                                } else {
                                    $trainings = [];
                                }
                            @endphp
                            <div class="input-group m-0">
                                <h4>إضافة تدريب</h4>
                                <p>قم بإضافة معلومات كل تدريب ضمن البرنامج التدريبي</p>
                            </div>
                            @foreach ($trainings as $trainingIndex => $trainingItem)

                                <div class="training-section" data-training-index="{{ $trainingIndex }}">
                                    <div class=" border rounded-4 p-3">
                                        <div class="training-details mb-5">
                                            <div class="training-section-header">
                                                <div class="input-group">
                                                    <h5 class="">{{ $trainingIndex + 1 }}- عنوان التدريب و المدرب
                                                        الرئيسي
                                                    </h5>
                                                    <div class="sub-label">
                                                        اذكر عنوان التدريب بالإضافة إلى اسم المدرب المسؤول عن تنفيذ التدريب
                                                    </div>
                                                </div>

                                                @if ($trainingIndex > 0)
                                                    <button type="button" class="remove-training-btn"
                                                        style="top: -50px;position: relative;"
                                                        onclick="removeTraining({{ $trainingIndex }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="#e00000" viewBox="0 0 256 256">
                                                            <path
                                                                d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="input-group-2col">
                                                <div class="input-group-2col">
    <div class="input-group">
        <input type="text" name="program_title[{{ $trainingIndex }}]"
            value="{{ 
                is_array($trainingItem) ? 
                    ($trainingItem['title'] ?? $trainingItem['program_title'] ?? '') : 
                    (is_object($trainingItem) ? $trainingItem->title ?? $trainingItem->program_title ?? '' : '')
            }}"
            placeholder="مثال : التفكير التصميمي"
            class="@error('program_title.' . $trainingIndex) error-border @enderror">
        @error("program_title.$trainingIndex")
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
                                                <div class="input-group">
<select name="trainer_id[{{ $trainingIndex }}]"
    class="custom-singleselect @error('trainer_id.' . $trainingIndex) error-border @enderror">
    <option value="" disabled selected style="color: silver !important;">مثال : عبد الله المصري</option>
    @foreach ($availableTrainers as $trainer)
        <option value="{{ $trainer->id }}"
            {{ 
                (is_array($trainingItem) ? 
                    ($trainingItem['trainer_id'] ?? '') : 
                    (is_object($trainingItem) ? ($trainingItem->trainer_id ?? '') : '')
                ) == $trainer->id ? 'selected' : '' 
            }}>
            {{ $trainer->getTranslation('name', 'ar') }}
            {{ $trainer->trainer?->getTranslation('last_name', 'ar') }}
        </option>
    @endforeach
</select>                                @error("trainer_id.$trainingIndex")
                                                        <span class="error-message">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                      <div class="input-group">
    <label class="switch w-100">
        <span class="switch-label">سيتم تحديد الجلسات لاحقًا بعد اكتمال عدد المشاركين</span>
        <input type="checkbox"
            name="schedules_later" 
            value="1"
            id="schedules_later_{{ $trainingIndex }}"
            {{ 
                old('schedules_later', 
                    is_array($trainingItem) ? 
                        ($trainingItem['schedules_later'] ?? false) : 
                        (is_object($trainingItem) ? ($trainingItem->schedules_later ?? false) : false)
                ) ? 'checked' : '' 
            }}>
        <span class="slider"></span>
    </label>
</div>
                                        <div class="session-container" id="sessions-container-{{ $trainingIndex }}">
                                            @php
                                                // إذا لم يتم تحديد "تحديد الجلسات لاحقاً"، فأضف جلسة واحدة على الأقل
                                                if (
                                                    !(is_array($trainingItem)
                                                        ? $trainingItem['schedules_later'] ?? false
                                                        : $trainingItem->schedules_later)
                                                ) {
                                                    $safeSchedules = is_array($trainingItem)
                                                        ? $trainingItem['schedules'] ?? []
                                                        : $trainingItem->schedules ?? [];
                                                    $schedules = old(
                                                        'schedules',
                                                        count($safeSchedules) > 0
                                                            ? $safeSchedules
                                                            : [
                                                                [
                                                                    'date' => '',
                                                                    'start_time' => '',
                                                                    'end_time' => '',
                                                                ],
                                                            ],
                                                    );
                                                } else {
                                                    $schedules = [];
                                                }
                                            @endphp
                                            @foreach ($schedules as $scheduleIndex => $schedule)
                                                <div class="session-group" style="margin-bottom: 15px;"
                                                    data-session-index="{{ $scheduleIndex }}">
                                                    <div class="session-header">
                                                        <div class="input-group">
                                                            <h5 class="w-100">تاريخ الجلسة {{ $scheduleIndex + 1 }} و مدتها
                                                                <span class="required">*</span>
                                                            </h5>
                                                            <div class="sub-label">
                                                                اختر التاريخ الذي ستُعقد فيه الجلسة و وقت بداية ونهاية
                                                                الجلسة.
                                                            </div>
                                                        </div>

                                                        @if ($scheduleIndex > 0)
                                                            <button type="button" class="remove-session-btn"
                                                                style="position: relative; right: 5px;"
                                                                onclick="removeSession({{ $trainingIndex }}, {{ $scheduleIndex }})">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="#e00000" viewBox="0 0 256 256">
                                                                    <path
                                                                        d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="session-details">
                                                        <div class="input-group-2col inner"
                                                            style="align-items: flex-start;">
                                                            <div class="input-group">
                                                                <input type="date"
                                                                    name="schedules[{{ $scheduleIndex }}][date]"
                                                                    value="{{ is_array($schedule) ? $schedule['date'] ?? '' : $schedule->date }}"
                                                                    placeholder="مثال: 15 يونيو 2025"
                                                                    class="session-date-input w-100 @error('schedules.' . $scheduleIndex . '.date') error-border @enderror">
                                                                @error("schedules.$scheduleIndex.date")
                                                                    <span class="error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="input-group">
                                                                <div class="time-picker-container">
                                                                    <div class="time-picker"
                                                                        data-training-index="{{ $trainingIndex }}"
                                                                        data-session-index="{{ $scheduleIndex }}"
                                                                        data-type="start">
                                                                        {{ is_array($schedule) ? ($schedule['start_time'] ? \Carbon\Carbon::parse($schedule['start_time'])->format('g:i A') : 'وقت بدء الجلسة') : ($schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') : 'وقت بدء الجلسة') }}
                                                                    </div>
                                                                    <div class="time-picker-dropdown"></div>
                                                                    <input type="hidden"
                                                                        name="schedules[{{ $scheduleIndex }}][start_time]"
                                                                        value="{{ is_array($schedule) ? $schedule['start_time'] ?? '' : $schedule->start_time }}"
                                                                        class="time-picker-input @error('schedules.' . $scheduleIndex . '.start_time') error-border @enderror">
                                                                </div>
                                                                @error("schedules.$scheduleIndex.start_time")
                                                                    <span class="error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="input-group">
                                                                <div class="time-picker-container">
                                                                    <div class="time-picker"
                                                                        data-training-index="{{ $trainingIndex }}"
                                                                        data-session-index="{{ $scheduleIndex }}"
                                                                        data-type="end">
                                                                        {{ is_array($schedule) ? ($schedule['end_time'] ? \Carbon\Carbon::parse($schedule['end_time'])->format('g:i A') : 'وقت انتهاء الجلسة') : ($schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') : 'وقت انتهاء الجلسة') }}
                                                                    </div>
                                                                    <div class="time-picker-dropdown"></div>
                                                                    <input type="hidden"
                                                                        name="schedules[{{ $scheduleIndex }}][end_time]"
                                                                        value="{{ is_array($schedule) ? $schedule['end_time'] ?? '' : $schedule->end_time }}"
                                                                        class="time-picker-input @error('schedules.' . $scheduleIndex . '.end_time') error-border @enderror">
                                                                </div>
                                                                @error("schedules.$scheduleIndex.end_time")
                                                                    <span class="error-message">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="input-group">
                                            <button type="button" class="add-more-btn" id="add-session-btn"
                                                onclick="addSession({{ $trainingIndex }})">
                                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                                <span>أضف جلسة جديدة</span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
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
            <button type="button" class="training-files-btn profile-image-btn select-training-files">تصفح الملفات</button>
            <input type="file" class="training-files-input visually-hidden" name="training_files" multiple>
        </div>
        <div class="file-preview training-files-preview" style="display: none;"></div>
        <div id="real-files-container"></div>
        <button type="button" class="add-more-training profile-image-btn" style="display:none;">إضافة المزيد</button>
    </div>
</div>

                        <div class="input-group-2col mt-4">
                            <div class="input-group">
                                <a href="{{ route('orgTraining.goals', $training->id) }}"
                                    class="pbtn pbtn-outlined-main">
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
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/validator@13.9.0/validator.min.js"></script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // عدد التدريبات الحالية من السيرفر
            let currentTrainingCount = {{ count($trainings) }};
            let nextTrainingIndex = currentTrainingCount; // يستخدم فقط عند إضافة تدريب جديد

            // عدد الجلسات لكل تدريب
            let sessionIndices = {};
            @foreach ($trainings as $trainingIndex => $trainingItem)
                sessionIndices[{{ $trainingIndex }}] =
                    {{ count(is_array($trainingItem) ? $trainingItem['schedules'] ?? [] : $trainingItem->schedules ?? []) }};
            @endforeach

            // إنشاء قائمة بالأوقات المتاحة
            function generateTimeOptions() {
                const options = [];
                for (let hour = 0; hour < 24; hour++) {
                    for (let minute = 0; minute < 60; minute += 15) {
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

            // دالة لتحويل الوقت من 24 ساعة إلى 12 ساعة
            function formatTimeTo12Hour(time24) {
                if (!time24) return '';
                const [hours, minutes] = time24.split(':');
                const hour12 = hours % 12 || 12;
                const ampm = hours < 12 ? 'صباحاً' : 'مساءً';
                return `${hour12}:${minutes} ${ampm}`;
            }

            // دالة لتحويل الوقت من 12 ساعة إلى 24 ساعة
            function formatTimeTo24Hour(time12) {
                if (!time12) return '';
                // استخراج الساعات والدقائق والفترة
                const match = time12.match(/(\d{1,2}):(\d{2})\s*(صباحاً|مساءً)/);
                if (!match) return '';
                let hours = parseInt(match[1]);
                const minutes = match[2];
                const period = match[3];
                // تحويل إلى 24 ساعة
                if (period === 'مساءً' && hours < 12) {
                    hours += 12;
                } else if (period === 'صباحاً' && hours === 12) {
                    hours = 0;
                }
                return `${hours.toString().padStart(2, '0')}:${minutes}`;
            }

            // تهيئة منتقي الوقت
            function initializeTimePickers(container = document) {
                const timePickers = container.querySelectorAll('.time-picker');
                timePickers.forEach(picker => {
                    const dropdown = picker.nextElementSibling;
                    const hiddenInput = dropdown.nextElementSibling;
                    // الحصول على القيمة الحالية من الحقل المخفي
                    const currentValue = hiddenInput.value;
                    // تحديث النص المعروض بناءً على القيمة الحالية
                    if (currentValue && currentValue !== 'وقت بدء الجلسة' && currentValue !==
                        'وقت انتهاء الجلسة') {
                        // تحويل القيمة من 24 ساعة إلى 12 ساعة للعرض
                        picker.textContent = formatTimeTo12Hour(currentValue);
                        // التأكد من أن القيمة في الحقل المخفي بتنسيق 24 ساعة
                        hiddenInput.value = currentValue;
                    } else {
                        // تعيين النص الافتراضي إذا لم تكن هناك قيمة
                        const defaultText = picker.dataset.type === 'start' ? 'وقت بدء الجلسة' :
                            'وقت انتهاء الجلسة';
                        picker.textContent = defaultText;
                        // لا تقم بتعيين الحقل المخفي كفارغ إذا كان هناك قيمة صالحة من قبل
                        if (!currentValue || currentValue === 'وقت بدء الجلسة' || currentValue ===
                            'وقت انتهاء الجلسة') {
                            hiddenInput.value = '';
                        }
                    }

                    // إنشاء قائمة الخيارات
                    dropdown.innerHTML = '';
                    timeOptions.forEach(option => {
                        const optionElement = document.createElement('div');
                        optionElement.className = 'time-picker-option';
                        optionElement.textContent = option.label;
                        optionElement.dataset.value = option.value;
                        // تحديد الخيار المحدد مسبقاً
                        if (option.value === currentValue) {
                            optionElement.classList.add('selected');
                        }
                        optionElement.addEventListener('click', function() {
                            // تحديث القيمة المعروضة
                            picker.textContent = option.label;
                            // تحديث القيمة في الحقل المخفي
                            hiddenInput.value = option.value;
                            // تحديث الخيار المحدد
                            dropdown.querySelectorAll('.time-picker-option').forEach(
                            opt => {
                                opt.classList.remove('selected');
                            });
                            optionElement.classList.add('selected');
                            // إغلاق القائمة
                            dropdown.style.display = 'none';
                            // التحقق من صحة الوقت
                            validateTimeInputs(picker);
                        });
                        dropdown.appendChild(optionElement);
                    });

                    // إظهار/إخفاء القائمة عند النقر
                    picker.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' :
                            'block';
                    });

                    // إغلاق القائمة عند النقر في أي مكان آخر
                    document.addEventListener('click', function() {
                        dropdown.style.display = 'none';
                    });
                });
            }

            // التحقق من صحة حقول الوقت
            function validateTimeInputs(timePicker) {
                const sessionGroup = timePicker.closest('.session-group');
                const startTimeInput = sessionGroup.querySelector('input[name$="[start_time]"]');
                const endTimeInput = sessionGroup.querySelector('input[name$="[end_time]"]');
                if (startTimeInput.value && endTimeInput.value) {
                    const startTime = startTimeInput.value;
                    const endTime = endTimeInput.value;
                    if (startTime >= endTime) {
                        // إضافة رسالة خطأ
                        const errorElement = sessionGroup.querySelector('#end-time-error-' + timePicker.dataset
                            .sessionIndex);
                        if (errorElement) {
                            errorElement.textContent = 'وقت النهاية يجب أن يكون بعد وقت البداية';
                            errorElement.style.display = 'block';
                            endTimeInput.classList.add('error-border');
                        }
                    } else {
                        // إزالة رسالة الخطأ
                        const errorElement = sessionGroup.querySelector('#end-time-error-' + timePicker.dataset
                            .sessionIndex);
                        if (errorElement) {
                            errorElement.style.display = 'none';
                            endTimeInput.classList.remove('error-border');
                        }
                    }
                }
            }

            // دالة لتحديث الحقول المخفية للوقت
            function updateHiddenTimeInputs(sessionGroup) {
                const startTimePicker = sessionGroup.querySelector('.time-picker[data-type="start"]');
                const endTimePicker = sessionGroup.querySelector('.time-picker[data-type="end"]');
                const startTimeHidden = sessionGroup.querySelector('input[name$="[start_time]"]');
                const endTimeHidden = sessionGroup.querySelector('input[name$="[end_time]"]');
                // تحديث وقت البدء
                if (startTimePicker && startTimeHidden) {
                    const pickerText = startTimePicker.textContent.trim();
                    if (pickerText !== 'وقت بدء الجلسة' && pickerText !== '') {
                        const time24 = formatTimeTo24Hour(pickerText);
                        startTimeHidden.value = time24;
                    }
                }
                // تحديث وقت الانتهاء
                if (endTimePicker && endTimeHidden) {
                    const pickerText = endTimePicker.textContent.trim();
                    if (pickerText !== 'وقت انتهاء الجلسة' && pickerText !== '') {
                        const time24 = formatTimeTo24Hour(pickerText);
                        endTimeHidden.value = time24;
                    }
                }
            }

            // دالة لتحديث جميع الحقول المخفية قبل الإرسال
            function updateHiddenInputsBeforeSubmit() {
                document.querySelectorAll('.session-group').forEach((sessionGroup) => {
                    const startTimePicker = sessionGroup.querySelector('.time-picker[data-type="start"]');
                    const endTimePicker = sessionGroup.querySelector('.time-picker[data-type="end"]');
                    const startTimeHidden = sessionGroup.querySelector(
                        'input[name$="[start_time]"]');
                    const endTimeHidden = sessionGroup.querySelector('input[name$="[end_time]"]');
                    // معالجة وقت البداية
                    if (startTimePicker && startTimeHidden) {
                        const pickerText = startTimePicker.textContent.trim();
                        if (pickerText === 'وقت بدء الجلسة' || pickerText === '') {
                            startTimeHidden.value = '';
                        } else {
                            // تحويل النص إلى تنسيق 24 ساعة
                            const time24 = formatTimeTo24Hour(pickerText);
                            startTimeHidden.value = time24;
                        }
                    }
                    // معالجة وقت الانتهاء
                    if (endTimePicker && endTimeHidden) {
                        const pickerText = endTimePicker.textContent.trim();
                        if (pickerText === 'وقت انتهاء الجلسة' || pickerText === '') {
                            // إذا كان الحقل المخفي يحتوي على قيمة من قبل، احتفظ بها
                            if (!endTimeHidden.value || endTimeHidden.value === 'وقت انتهاء الجلسة') {
                                endTimeHidden.value = '';
                            }
                        } else {
                            // تحويل النص إلى تنسيق 24 ساعة
                            const time24 = formatTimeTo24Hour(pickerText);
                            endTimeHidden.value = time24;
                        }
                    }
                });
            }

            // تهيئة جميع منتقي الوقت عند تحميل الصفحة
            initializeTimePickers();

            // إضافة تدريب جديد
            document.getElementById('add-training-btn').addEventListener('click', function() {
                const container = document.getElementById('trainings-container');
                const newTrainingIndex = nextTrainingIndex;
                const displayNumber = currentTrainingCount + 1; // الرقم المعروض للمستخدم

                const newTraining = document.createElement('div');
                newTraining.className = 'training-section';
                newTraining.setAttribute('data-training-index', newTrainingIndex);
                newTraining.innerHTML = `
            <div class=" border rounded-4 p-3  mt-5">
                <div class="training-details mb-5">
                    <div class="training-section-header">
                        <div class="input-group">
                            <h5 class="">${displayNumber}- عنوان التدريب و المدرب الرئيسي</h5>
                            <div class="sub-label">
                                اذكر عنوان التدريب بالإضافة إلى اسم المدرب المسؤول عن تنفيذ التدريب
                            </div>
                        </div>
                        <button type="button" class="remove-training-btn" style="top: -50px;position: relative;" onclick="removeTraining(${newTrainingIndex})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                                <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="input-group-2col">
                        <div class="input-group">
                            <input type="text" name="program_title[${newTrainingIndex}]" placeholder="أدخل عنوان التدريب">
                            <span class="error-message" id="program-title-error-${newTrainingIndex}" style="display:none;"></span>
                        </div>
                        
                        <div class="input-group">
                            <select name="trainer_id[${newTrainingIndex}]" class="custom-singleselect">
                                <option value="" disabled selected>اختر مدربًا</option>
                                @foreach ($availableTrainers as $trainer)
                                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                                @endforeach
                            </select>
                            <span class="error-message" id="trainer-id-error-${newTrainingIndex}" style="display:none;"></span>
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <label class="switch w-100">
                        <span class="switch-label">سيتم تحديد الجلسات لاحقًا بعد اكتمال عدد المشاركين</span>
                        <input type="checkbox" name="schedules_later" value="1" id="schedules_later_${newTrainingIndex}">
                        <span class="slider"></span>
                    </label>
                </div>
                
                <div class="session-container" id="sessions-container-${newTrainingIndex}">
                    <div class="session-group" style="margin-bottom: 15px;" data-session-index="0">
                        <div class="session-header">
                            <div class="input-group">
                                <h5 class="w-100">تاريخ الجلسة 1 و مدتها <span class="required">*</span></h5>
                                <div class="sub-label">
                                    اختر التاريخ الذي ستُعقد فيه الجلسة و وقت بداية ونهاية الجلسة.
                                </div>
                            </div>
                        </div>
                        
                        <div class="session-details">
                            <div class="input-group-2col inner" style="align-items: flex-start;">
                                <div class="input-group">
                                    <input type="date" name="schedules[0][date]" placeholder="مثال: 15 يونيو 2025" class="session-date-input w-100">
                                    <span class="error-message" id="schedule-date-error-${newTrainingIndex}-0" style="display:none;"></span>
                                </div>
                                
                                <div class="input-group">
                                    <div class="time-picker-container">
                                        <div class="time-picker" data-training-index="${newTrainingIndex}" data-session-index="0" data-type="start">وقت بدء الجلسة</div>
                                        <div class="time-picker-dropdown"></div>
                                        <input type="hidden" name="schedules[0][start_time]" class="time-picker-input" value="">
                                    </div>
                                    <span class="error-message" id="start-time-error-${newTrainingIndex}-0" style="display:none;"></span>
                                </div>
                                
                                <div class="input-group">
                                    <div class="time-picker-container">
                                        <div class="time-picker" data-training-index="${newTrainingIndex}" data-session-index="0" data-type="end">وقت انتهاء الجلسة</div>
                                        <div class="time-picker-dropdown"></div>
                                        <input type="hidden" name="schedules[0][end_time]" class="time-picker-input" value="">
                                    </div>
                                    <span class="error-message" id="end-time-error-${newTrainingIndex}-0" style="display:none;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <button type="button" class="add-more-btn" id="add-session-btn" onclick="addSession(${newTrainingIndex})">
                        <img src="{{ asset('images/icons/plus-main.svg') }}" />
                        <span>أضف جلسة جديدة</span>
                    </button>
                </div>
            </div>
        `;
                container.appendChild(newTraining);

                // تهيئة منتقي الوقت للتدريب الجديد
                initializeTimePickers(newTraining);

                // تهيئة القائمة المنسدلة للمدربين
                const newSelect = newTraining.querySelector('select.custom-singleselect');
                if (typeof initCustomSelect === 'function') {
                    initCustomSelect(newSelect);
                }

                // إضافة مستمع حدث لخيار "تحديد الجلسات لاحقاً"
                const schedulesSwitch = newTraining.querySelector(`#schedules_later_${newTrainingIndex}`);
                const sessionContainer = newTraining.querySelector(
                    `#sessions-container-${newTrainingIndex}`);
                const addSessionBtn = newTraining.querySelector('#add-session-btn');

                schedulesSwitch.addEventListener('change', function() {
                    if (this.checked) {
                        sessionContainer.style.display = 'none';
                        addSessionBtn.style.display = 'none';
                    } else {
                        sessionContainer.style.display = 'block';
                        addSessionBtn.style.display = 'flex';
                        // إذا لم تكن هناك جلسات معروضة، أضف جلسة واحدة
                        if (sessionContainer.querySelectorAll('.session-group').length === 0) {
                            addSession(newTrainingIndex);
                        }
                    }
                });

                // تهيئة عدد الجلسات للتدريب الجديد
                sessionIndices[newTrainingIndex] = 1;
                currentTrainingCount++;
                nextTrainingIndex++;
            });

            // إضافة جلسة جديدة
            window.addSession = function(trainingIndex) {
                const container = document.getElementById(`sessions-container-${trainingIndex}`);
                const sessionIndex = sessionIndices[trainingIndex];
                const newSession = document.createElement('div');
                newSession.className = 'session-group';
                newSession.style.marginBottom = '15px';
                newSession.setAttribute('data-session-index', sessionIndex);
                newSession.innerHTML = `
            <div class="session-header">
                <div class="input-group">
                    <h5 class="w-100">تاريخ الجلسة ${sessionIndex + 1} و مدتها <span class="required">*</span></h5>
                    <div class="sub-label">
                        اختر التاريخ الذي ستُعقد فيه الجلسة و وقت بداية ونهاية الجلسة.
                    </div>
                </div>
                <button type="button" style="position: relative; right: 5px;" class="remove-session-btn" onclick="removeSession(${trainingIndex}, ${sessionIndex})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                        <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                    </svg>
                </button>
            </div>
            
            <div class="session-details">
                <div class="input-group-2col inner" style="align-items: flex-start;">
                    <div class="input-group">
                        <input type="date" name="schedules[${sessionIndex}][date]" placeholder="مثال: 15 يونيو 2025" class="session-date-input w-100">
                        <span class="error-message" id="schedule-date-error-${trainingIndex}-${sessionIndex}" style="display:none;"></span>
                    </div>
                    
                    <div class="input-group">
                        <div class="time-picker-container">
                            <div class="time-picker" data-training-index="${trainingIndex}" data-session-index="${sessionIndex}" data-type="start">وقت بدء الجلسة</div>
                            <div class="time-picker-dropdown"></div>
                            <input type="hidden" name="schedules[${sessionIndex}][start_time]" class="time-picker-input" value="">
                        </div>
                        <span class="error-message" id="start-time-error-${trainingIndex}-${sessionIndex}" style="display:none;"></span>
                    </div>
                    
                    <div class="input-group">
                        <div class="time-picker-container">
                            <div class="time-picker" data-training-index="${trainingIndex}" data-session-index="${sessionIndex}" data-type="end">وقت انتهاء الجلسة</div>
                            <div class="time-picker-dropdown"></div>
                            <input type="hidden" name="schedules[${sessionIndex}][end_time]" class="time-picker-input" value="">
                        </div>
                        <span class="error-message" id="end-time-error-${trainingIndex}-${sessionIndex}" style="display:none;"></span>
                    </div>
                </div>
            </div>
        `;
                container.appendChild(newSession);
                // تهيئة منتقي الوقت للجلسة الجديدة
                initializeTimePickers(newSession);
                // زيادة عدد الجلسات
                sessionIndices[trainingIndex]++;
            };

            // حذف جلسة
            window.removeSession = function(trainingIndex, sessionIndex) {
                const container = document.getElementById(`sessions-container-${trainingIndex}`);
                const sessionElement = container.querySelector(
                    `.session-group[data-session-index="${sessionIndex}"]`);
                if (sessionElement) {
                    sessionElement.remove();

                    // تحديث عناوين الجلسات المتبقية وأزرار الحذف
                    const remainingSessions = container.querySelectorAll('.session-group');
                    remainingSessions.forEach((session, index) => {
                        // تحديث رقم الجلسة في العنوان
                        const header = session.querySelector('.session-header h5');
                        if (header) {
                            header.innerHTML =
                                `تاريخ الجلسة ${index + 1} و مدتها <span class="required">*</span>`;
                        }

                        // تحديث زر الحذف
                        const deleteBtn = session.querySelector('.remove-session-btn');
                        if (deleteBtn) {
                            deleteBtn.setAttribute('onclick',
                                `removeSession(${trainingIndex}, ${index})`);
                        }

                        // تحديث data-session-index
                        session.setAttribute('data-session-index', index);

                        // تحديث حقول الإدخال
                        const dateInput = session.querySelector('input[name$="[date]"]');
                        if (dateInput) {
                            dateInput.setAttribute('name',
                                `schedules[${index}][date]`);
                        }

                        const startTimeInput = session.querySelector(
                            'input[name$="[start_time]"]');
                        if (startTimeInput) {
                            startTimeInput.setAttribute('name',
                                `schedules[${index}][start_time]`
                                );
                        }

                        const endTimeInput = session.querySelector('input[name$="[end_time]"]');
                        if (endTimeInput) {
                            endTimeInput.setAttribute('name',
                                `schedules[${index}][end_time]`);
                        }

                        // تحديث عناصر منتقي الوقت
                        const startTimePicker = session.querySelector(
                        '.time-picker[data-type="start"]');
                        if (startTimePicker) {
                            startTimePicker.setAttribute('data-session-index', index);
                        }

                        const endTimePicker = session.querySelector('.time-picker[data-type="end"]');
                        if (endTimePicker) {
                            endTimePicker.setAttribute('data-session-index', index);
                        }
                    });

                    // تحديث عدد الجلسات
                    sessionIndices[trainingIndex] = remainingSessions.length;
                }
            };

            // حذف تدريب
            window.removeTraining = function(trainingIndex) {
                const container = document.getElementById('trainings-container');
                const trainingElement = container.querySelector(
                    `.training-section[data-training-index="${trainingIndex}"]`);
                if (trainingElement) {
                    trainingElement.remove();
                    currentTrainingCount--;

                    // تحديث عناوين التدريبات المتبقية وأزرار الحذف
                    const remainingTrainings = container.querySelectorAll('.training-section');
                    remainingTrainings.forEach((training, index) => {
                        const currentIndex = parseInt(training.getAttribute('data-training-index'));

                        // تحديث رقم التدريب في العنوان
                        const header = training.querySelector('.training-section-header h5');
                        if (header) {
                            header.textContent = `${index + 1}- عنوان التدريب و المدرب الرئيسي`;
                        }

                        // تحديث زر الحذف
                        const deleteBtn = training.querySelector('.remove-training-btn');
                        if (deleteBtn) {
                            deleteBtn.setAttribute('onclick', `removeTraining(${currentIndex})`);
                        }

                        // تحديث حقول الإدخال
                        const titleInput = training.querySelector('input[name$="[title]"]');
                        if (titleInput) {
                            titleInput.setAttribute('name', `program_title[${currentIndex}]`);
                        }

                        const trainerSelect = training.querySelector('select[name$="[trainer_id]"]');
                        if (trainerSelect) {
                            trainerSelect.setAttribute('name',
                            `trainer_id[${currentIndex}]`);
                        }

                        const schedulesLater = training.querySelector(
                            'input[name$="[schedules_later]"]');
                        if (schedulesLater) {
                            schedulesLater.setAttribute('name',
                                `schedules_later`);
                            schedulesLater.setAttribute('id', `schedules_later_${currentIndex}`);
                        }

                        // تحديث حاوية الجلسات
                        const sessionContainer = training.querySelector('.session-container');
                        if (sessionContainer) {
                            sessionContainer.setAttribute('id', `sessions-container-${currentIndex}`);
                        }

                        // تحديث زر إضافة جلسة
                        const addSessionBtn = training.querySelector('#add-session-btn');
                        if (addSessionBtn) {
                            addSessionBtn.setAttribute('onclick', `addSession(${currentIndex})`);
                        }

                        // تحديث الجلسات داخل التدريب
                        const sessions = training.querySelectorAll('.session-group');
                        sessions.forEach((session, sessionIdx) => {
                            // تحديث أسماء حقول الجلسة
                            const dateInput = session.querySelector(
                                'input[name$="[date]"]');
                            if (dateInput) {
                                dateInput.setAttribute('name',
                                    `schedules[${sessionIdx}][date]`
                                    );
                            }

                            const startTimeInput = session.querySelector(
                                'input[name$="[start_time]"]');
                            if (startTimeInput) {
                                startTimeInput.setAttribute('name',
                                    `schedules[${sessionIdx}][start_time]`
                                    );
                            }

                            const endTimeInput = session.querySelector(
                                'input[name$="[end_time]"]');
                            if (endTimeInput) {
                                endTimeInput.setAttribute('name',
                                    `schedules[${sessionIdx}][end_time]`
                                    );
                            }

                            // تحديث عناصر منتقي الوقت
                            const startTimePicker = session.querySelector(
                                '.time-picker[data-type="start"]');
                            if (startTimePicker) {
                                startTimePicker.setAttribute('data-training-index',
                                    currentIndex);
                                startTimePicker.setAttribute('data-session-index', sessionIdx);
                            }

                            const endTimePicker = session.querySelector(
                                '.time-picker[data-type="end"]');
                            if (endTimePicker) {
                                endTimePicker.setAttribute('data-training-index', currentIndex);
                                endTimePicker.setAttribute('data-session-index', sessionIdx);
                            }

                            // تحديث زر حذف الجلسة
                            const deleteSessionBtn = session.querySelector(
                                '.remove-session-btn');
                            if (deleteSessionBtn) {
                                deleteSessionBtn.setAttribute('onclick',
                                    `removeSession(${currentIndex}, ${sessionIdx})`);
                            }

                            // تحديث data-session-index
                            session.setAttribute('data-session-index', sessionIdx);
                        });
                    });
                }
            };

            // التحكم في خيار "تحديد الجلسات لاحقًا"
            document.querySelectorAll('input[id^="schedules_later_"]').forEach(schedulesSwitch => {
                const trainingIndex = schedulesSwitch.id.split('_')[2];
                const sessionContainer = document.getElementById(`sessions-container-${trainingIndex}`);
                const addSessionBtn = schedulesSwitch.closest('.training-section').querySelector(
                    '#add-session-btn');

                function toggleSessionFields() {
                    if (schedulesSwitch.checked) {
                        sessionContainer.style.display = 'none';
                        if (addSessionBtn) addSessionBtn.style.display = 'none';
                    } else {
                        sessionContainer.style.display = 'block';
                        if (addSessionBtn) addSessionBtn.style.display = 'flex';
                        // إذا لم تكن هناك جلسات معروضة، أضف جلسة واحدة
                        if (sessionContainer.querySelectorAll('.session-group').length === 0) {
                            addSession(parseInt(trainingIndex));
                        }
                    }
                }

                // استدعاء الدالة عند تحميل الصفحة
                toggleSessionFields();
                // استدعاء الدالة عند تغيير قيمة الخانة
                schedulesSwitch.addEventListener('change', toggleSessionFields);
            });

            // إدارة ملفات التدريب
            document.querySelectorAll('.file-upload-wrapper').forEach(wrapper => {
              const trainingFilesWrapper = document.querySelector(".training-files-wrapper[data-multiple='true']");
if (trainingFilesWrapper) {
    const fileInput = trainingFilesWrapper.querySelector(".training-files-input");
    const selectBtn = trainingFilesWrapper.querySelector(".select-training-files");
    const defaultView = trainingFilesWrapper.querySelector(".training-files-default");
    const previewContainer = trainingFilesWrapper.querySelector(".training-files-preview");
    const addMoreBtn = trainingFilesWrapper.querySelector(".add-more-training");
    
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
    
    // معالجة الملفات الموجودة مسبقاً إن وجدت
    toggleView();
}
            });

            // تحديث الحقول المخفية قبل إرسال النموذج
            const form = document.getElementById('publish-training-4-form');
            form.addEventListener('submit', function(e) {
                // تحديث جميع الحقول المخفية قبل الإرسال
                updateHiddenInputsBeforeSubmit();

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