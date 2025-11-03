@extends('frontend.layouts.master')
@section('title', 'جدولة الجلسات التدريبية')
@section('css')

@endsection

<style>

</style>
@section('content')
<main>
    <div class="publish-training-page">
        <div class="grid">
            <div class="right-col">
                <div class="vertical-stepper">
                    <!-- خطوات التقدم -->
                    @include('trainings.partials.stepper', [
                    'currentStep' => 4,
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
                        أضف تفاصيل كل جلسة تدريبية على حدة ضمن البرنامج التدريبي. يساعد ذلك في تتبع حضور المتدربين لكل
                        جلسة بدقة. تأكّد من تحديد التاريخ والتوقيت ومدة كل جلسة بوضوح. يمكنك إضافة عدد غير محدود من
                        الجلسات حسب خطة التدريب.
                    </div>
                </div>

                <form id="publish-training-4-form" method="POST"
                    action="{{ route('training.store.schedule', $training->id) }}">
                    @csrf

                    <div id="form-errors-container" class="error-container" style="display: none;"></div>

                    <!-- <div class="input-group">
                            <label class="switch">
                                <span class="switch-label">سيتم تحديد الجلسات لاحقًا بعد اكتمال عدد المشاركين</span>
                                <input type="checkbox" name="schedules_later" value="1" id="schedules_later"
                                    {{ old('schedules_later', $schedules_later) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div> -->
                    <!-- إضافة قسم لعدد الساعات والجلسات -->
                    <div class="session-details-container" id="session-details">
                        <div class="input-group-2col">
                            <!-- <div class="input-group">
                                <label>عدد الجلسات</label>
                                <input type="number" name="num_of_session" min="1"
                                    placeholder="مثال: 5"
                                    value="{{ old('num_of_session', $num_of_session ?? '') }}">
                                @error('num_of_session')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div> -->
                            <div class="input-group">
                                <label>عدد الساعات</label>
                                <input type="number" name="num_of_hours" min="1" step="1"
                                    placeholder="مثال: 10"
                                    value="{{ old('num_of_hours', isset($num_of_hours) ? number_format($num_of_hours, 0, '.', '') : '') }}">
                                @error('num_of_hours')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="session-fields-container">
                        @php
                        // جلب الجلسات الموجودة أو البيانات القديمة
                        $safeSchedules = $training->sessions ?? collect(); // ضمان أن sessions ليست null
                        $schedules = old(
                            'schedules',
                            $safeSchedules->count() > 0
                                ? $safeSchedules->toArray()
                                : []
                        );
                        @endphp

                        @foreach ($schedules as $index => $schedule)
                        <div class="input-group-2col session-group"
                            style="align-items: flex-start; position: relative; @if ($index > 0) margin-top: 20px; @endif">
                            <div class="input-group">
                                <div class="session-input-container">
                                    <label class="w-100">تاريخ الجلسة و مدتها <span
                                            class="required">*</span></label>
                                    <div class="sub-label">
                                        اختر التاريخ الذي ستُعقد فيه الجلسة و وقت بداية ونهاية الجلسة.
                                    </div>
                                    <div class="input-group-2col inner" style="align-items: flex-start;">
                                        <div style="width: 100%;">
                                            <input type="date"
                                                name="schedules[{{ $index }}][session_date]"
                                                value="{{ is_array($schedule) ? $schedule['session_date'] ?? '' : $schedule->session_date }}"
                                                placeholder="مثال: 15 يونيو 2025"
                                                class="session-date-input w-100 @error('schedules.' . $index . '.session_date') error-border @enderror">
                                            @error("schedules.$index.session_date")
                                            <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div style="width: 100%;">
                                            <div class="time-picker-container">
                                                <div class="time-picker" data-index="{{ $index }}"
                                                    data-type="start">
                                                    {{ is_array($schedule) ? ($schedule['session_start_time'] ? \Carbon\Carbon::parse($schedule['session_start_time'])->format('g:i A') : 'وقت بدء الجلسة') : ($schedule->session_start_time ? \Carbon\Carbon::parse($schedule->session_start_time)->format('g:i A') : 'وقت بدء الجلسة') }}
                                                </div>
                                                <div class="time-picker-dropdown"></div>
                                                <input type="hidden"
                                                    name="schedules[{{ $index }}][session_start_time]"
                                                    value="{{ is_array($schedule) ? $schedule['session_start_time'] ?? '' : $schedule->session_start_time }}"
                                                    class="time-picker-input @error('schedules.' . $index . '.session_start_time') error-border @enderror">

                                                <div class="time-picker-dropdown"></div>

                                            </div>
                                            @error("schedules.$index.session_start_time")
                                            <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div style="width: 100%;">
                                            <div class="time-picker-container">
                                                <div class="time-picker" data-index="{{ $index }}"
                                                    data-type="end">
                                                    {{ is_array($schedule) ? ($schedule['session_end_time'] ? \Carbon\Carbon::parse($schedule['session_end_time'])->format('g:i A') : 'وقت انتهاء الجلسة') : ($schedule->session_end_time ? \Carbon\Carbon::parse($schedule->session_end_time)->format('g:i A') : 'وقت انتهاء الجلسة') }}
                                                </div>
                                                <div class="time-picker-dropdown"></div>
                                                <input type="hidden"
                                                    name="schedules[{{ $index }}][session_end_time]"
                                                    value="{{ is_array($schedule) ? $schedule['session_end_time'] ?? '' : $schedule->session_end_time }}"
                                                    class="time-picker-input @error('schedules.' . $index . '.session_end_time') error-border @enderror">
                                            </div>
                                            @error("schedules.$index.session_end_time")
                                            <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($index > 0)
                            <button type="button" class="remove-session-btn"
                                onclick="this.closest('.session-group').remove()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="#e00000" viewBox="0 0 256 256">
                                    <path
                                        d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z">
                                    </path>
                                </svg>
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="input-group">
                        <button type="button" class="add-more-btn" id="add-session-btn">
                            <img src="{{ asset('images/icons/plus-main.svg') }}" />
                            <span>أضف جلسة جديدة</span>
                        </button>
                    </div>

                    <div class="input-group-2col mt-4">
                        <div class="input-group">
                            <a href="{{ route('training.team', $training->id) }}" class="pbtn pbtn-outlined-main">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // عدد الجلسات الحالية من السيرفر
        let sessionIndex = {{count($schedules)}};

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

            // أضف مستمع حدث لتغيير التاريخ
            container.querySelectorAll('.session-date-input').forEach(dateInput => {
                dateInput.addEventListener('change', function() {
                    const sessionGroup = this.closest('.session-group');
                    updateHiddenTimeInputs(sessionGroup);
                });
            });
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
            const startTimeInput = sessionGroup.querySelector('input[name$="[session_start_time]"]');
            const endTimeInput = sessionGroup.querySelector('input[name$="[session_end_time]"]');

            if (startTimeInput.value && endTimeInput.value) {
                const startTime = startTimeInput.value;
                const endTime = endTimeInput.value;

                if (startTime >= endTime) {
                    // إضافة رسالة خطأ
                    const errorElement = sessionGroup.querySelector('#end-time-error-' + timePicker.dataset
                        .index);
                    if (errorElement) {
                        errorElement.textContent = 'وقت النهاية يجب أن يكون بعد وقت البداية';
                        errorElement.style.display = 'block';
                        endTimeInput.classList.add('error-border');
                    }
                } else {
                    // إزالة رسالة الخطأ
                    const errorElement = sessionGroup.querySelector('#end-time-error-' + timePicker.dataset
                        .index);
                    if (errorElement) {
                        errorElement.style.display = 'none';
                        endTimeInput.classList.remove('error-border');
                    }
                }
            }
        }

        // دالة جديدة لتحديث الحقول المخفية للوقت
        function updateHiddenTimeInputs(sessionGroup) {
            const startTimePicker = sessionGroup.querySelector('.time-picker[data-type="start"]');
            const endTimePicker = sessionGroup.querySelector('.time-picker[data-type="end"]');
            const startTimeHidden = sessionGroup.querySelector('input[name$="[session_start_time]"]');
            const endTimeHidden = sessionGroup.querySelector('input[name$="[session_end_time]"]');

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
            document.querySelectorAll('.session-group').forEach((sessionGroup, index) => {
                const startTimePicker = sessionGroup.querySelector('.time-picker[data-type="start"]');
                const endTimePicker = sessionGroup.querySelector('.time-picker[data-type="end"]');
                const startTimeHidden = sessionGroup.querySelector(
                    'input[name$="[session_start_time"]');
                const endTimeHidden = sessionGroup.querySelector('input[name$="[session_end_time"]');

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

        // دالة لتحديث الحقول المخفية عند تغيير أي حقل في النموذج
        function updateHiddenInputsOnChange() {
            // تحديث الحقول عند تغيير التاريخ
            document.querySelectorAll('.session-date-input').forEach(dateInput => {
                dateInput.addEventListener('change', function() {
                    const sessionGroup = this.closest('.session-group');
                    const startTimePicker = sessionGroup.querySelector(
                        '.time-picker[data-type="start"]');
                    const endTimePicker = sessionGroup.querySelector(
                        '.time-picker[data-type="end"]');
                    const startTimeHidden = sessionGroup.querySelector(
                        'input[name$="[session_start_time"]');
                    const endTimeHidden = sessionGroup.querySelector(
                        'input[name$="[session_end_time"]');

                    // معالجة وقت البداية
                    if (startTimePicker && startTimeHidden) {
                        const pickerText = startTimePicker.textContent.trim();
                        if (pickerText !== 'وقت بدء الجلسة' && pickerText !== '') {
                            const time24 = formatTimeTo24Hour(pickerText);
                            startTimeHidden.value = time24;
                        }
                    }

                    // معالجة وقت الانتهاء
                    if (endTimePicker && endTimeHidden) {
                        const pickerText = endTimePicker.textContent.trim();
                        if (pickerText !== 'وقت انتهاء الجلسة' && pickerText !== '') {
                            const time24 = formatTimeTo24Hour(pickerText);
                            endTimeHidden.value = time24;
                        }
                    }
                });
            });

            // تحديث الحقول عند تغيير أي حقل آخر في النموذج
            document.querySelectorAll('input, select, textarea').forEach(input => {
                if (!input.classList.contains('time-picker-input')) {
                    input.addEventListener('change', function() {
                        updateHiddenInputsBeforeSubmit();
                    });
                }
            });
        }

        // تهيئة جميع منتقي الوقت عند تحميل الصفحة
        initializeTimePickers();

        // إضافة مستمعي الأحداث لتغيير الحقول
        updateHiddenInputsOnChange();

        // إضافة جلسة جديدة
        document.getElementById('add-session-btn').addEventListener('click', function() {
            const container = document.querySelector('.session-fields-container');
            const newSession = document.createElement('div');
            newSession.className = 'input-group-2col session-group';
            newSession.style.alignItems = 'flex-start';
            newSession.style.position = 'relative';
            newSession.style.marginTop = '20px';
            newSession.innerHTML = `
            <div class="input-group">
                <div class="session-input-container">
                    <label class="w-100">تاريخ الجلسة و مدتها <span class="required">*</span></label>
                    <div class="sub-label">
                        اختر التاريخ الذي ستُعقد فيه الجلسة و وقت بداية ونهاية الجلسة.
                    </div>
                    <div class="input-group-2col inner" style="align-items: flex-start;">
                        <div style="width: 100%;">
                            <input type="date" name="schedules[${sessionIndex}][session_date]"
                                placeholder="مثال: 15 يونيو 2025" class="session-date-input w-100">
                            <span class="error-message" id="session-date-error-${sessionIndex}" style="display:none;"></span>
                        </div>
                        <div style="width: 100%;">
                            <div class="time-picker-container">
                                <div class="time-picker" data-index="${sessionIndex}" data-type="start">وقت بدء الجلسة</div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden" name="schedules[${sessionIndex}][session_start_time]" class="time-picker-input" value="">
                            </div>
                            <span class="error-message" id="start-time-error-${sessionIndex}" style="display:none;"></span>
                        </div>
                        <div style="width: 100%;">
                            <div class="time-picker-container">
                                <div class="time-picker" data-index="${sessionIndex}" data-type="end">وقت انتهاء الجلسة</div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden" name="schedules[${sessionIndex}][session_end_time]" class="time-picker-input" value="">
                            </div>
                            <span class="error-message" id="end-time-error-${sessionIndex}" style="display:none;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="remove-session-btn" 
                    onclick="this.closest('.session-group').remove()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                    <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                </svg>
            </button>
        `;
            container.appendChild(newSession);
            sessionIndex++;

            // تهيئة منتقي الوقت للجلسة الجديدة
            initializeTimePickers(newSession);
        });

        // التحكم في خيار "تحديد الجلسات لاحقًا"
        // التحكم في خيار "تحديد الجلسات لاحقًا"
        const schedulesSwitch = document.getElementById('schedules_later');
        const sessionContainer = document.querySelector('.session-fields-container');
        const addSessionBtn = document.getElementById('add-session-btn');
        const sessionDetailsContainer = document.getElementById('session-details'); // إضافة هذا السطر
        const form = document.getElementById('publish-training-4-form');



        function toggleSessionFields() {
            if (schedulesSwitch.checked) {
                sessionContainer.style.display = 'none';
                addSessionBtn.style.display = 'none';
                sessionDetailsContainer.style.display = 'block'; // إظهار حقول عدد الساعات والجلسات
            } else {
                sessionContainer.style.display = 'block';
                addSessionBtn.style.display = 'inline-flex';
                sessionDetailsContainer.style.display = 'none'; // إخفاء حقول عدد الساعات والجلسات
                // إذا لم تكن هناك جلسات معروضة، أضف جلسة واحدة
                if (sessionContainer.querySelectorAll('.session-group').length === 0) {
                    document.getElementById('add-session-btn').click();
                }
            }
        }

        // استدعاء الدالة عند تحميل الصفحة
        toggleSessionFields();

        // استدعاء الدالة عند تغيير قيمة الخانة
        schedulesSwitch.addEventListener('change', toggleSessionFields);


        // تحديث الحقول المخفية قبل إرسال النموذج
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