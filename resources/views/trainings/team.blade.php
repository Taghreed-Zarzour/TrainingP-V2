@extends('frontend.layouts.master')
@section('title', 'جدولة الجلسات التدريبية')
@section('css')
<style>
    /* قوائم الوقت المنسدلة المحسنة */
    .time-picker-container {
        position: relative;
        width: 100%;
        border: 1px solid #a5a5a5;
        border-radius: 6px;
        padding: 14px 24px;
        font-size: 1rem;
        background: #ffffff;
        outline: none;
        transition: border 0.2s;
        box-sizing: border-box;
    }
    .time-picker {
        width: 100%;
        padding: 10px 40px 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        cursor: pointer;
        position: relative;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        height: 42px;
    }
    .time-picker::after {
        content: '';
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 22px;
        height: 24px;
        background-image: url("data:image/svg+xml,%3Csvg width='22' height='24' viewBox='0 0 22 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M10.974 16.803C10.6462 16.8032 10.3217 16.7326 10.0189 16.5953C9.71614 16.458 9.4411 16.2567 9.20953 16.003L3.24878 9.48004C3.13015 9.33739 3.0663 9.15024 3.07051 8.95746C3.07471 8.76467 3.14665 8.58106 3.27137 8.44477C3.39609 8.30847 3.56402 8.22997 3.74027 8.22555C3.91652 8.22113 4.08756 8.29114 4.21786 8.42104L10.1804 14.94C10.3915 15.1706 10.6775 15.3001 10.9758 15.3001C11.2741 15.3001 11.5602 15.1706 11.7712 14.94L17.7319 8.42004C17.8619 8.28756 18.0338 8.21544 18.2115 8.21887C18.3891 8.2223 18.5586 8.30101 18.6842 8.43842C18.8098 8.57583 18.8818 8.76122 18.8849 8.95552C18.8881 9.14982 18.8221 9.33787 18.701 9.48004L12.7403 16.003C12.5085 16.257 12.2331 16.4584 11.93 16.5957C11.6269 16.7329 11.302 16.8034 10.974 16.803Z' fill='%23444444'/%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        transition: transform 0.3s ease;
    }
    .time-picker-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 100;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }
    .time-picker-option {
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .time-picker-option:hover {
        background-color: #f5f5f5;
    }
    .time-picker-option.selected {
        background-color: #e9f5ff;
        font-weight: bold;
    }
    .time-picker-input {
        display: none;
    }
    /* للتجاوب مع الشاشات الصغيرة */
    @media (max-width: 768px) {
        .time-picker-dropdown {
            max-height: 150px;
        }
    }
    /* تنسيق أقسام التدريب */
    .training-section {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #fff;
    }
    .training-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .training-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
    }
    .remove-training-btn {
        background: none;
        border: none;
        color: #e00000;
        cursor: pointer;
        font-size: 1.2rem;
    }
    .training-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }
    .session-container {
        margin-top: 15px;
    }
    .session-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .session-title {
        font-weight: 600;
        color: #444;
    }
    .session-details {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
        margin-bottom: 10px;
    }
    .training-files {
        margin-top: 20px;
    }
    .file-upload-wrapper {
        border: 1px dashed #ddd;
        border-radius: 6px;
        padding: 15px;
        text-align: center;
        margin-top: 10px;
    }
    .add-training-btn, .add-session-btn, .add-file-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #3b82f6;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: background 0.3s;
    }
    .add-training-btn:hover, .add-session-btn:hover, .add-file-btn:hover {
        background-color: #2563eb;
    }
    .info-message {
        background-color: #f0f7ff;
        border-right: 4px solid #3b82f6;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .info-badge {
        flex-shrink: 0;
    }
    .info-message-content {
        flex-grow: 1;
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
        margin-right: 10px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #3b82f6;
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    .switch-label {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
</style>
@endsection
@section('content')
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        <!-- خطوات التقدم -->
                        @include('orgTrainings.partials.stepper', [
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
                            أضف تفاصيل كل جلسة تدريبية على حدة ضمن البرنامج التدريبي. يساعد ذلك في تتبع حضور المتدربين لكل جلسة بدقة. تأكّد من تحديد التاريخ والتوقيت ومدة كل جلسة بوضوح. يمكنك إضافة عدد غير محدود من الجلسات حسب خطة التدريب.
                        </div>
                    </div>
                    
                    <form id="publish-training-4-form" method="POST" action="{{ route('training.store.schedule', $training->id) }}">
                        @csrf
                        <div id="form-errors-container" class="error-container" style="display: none;"></div>
                        
                        <div id="trainings-container">
                            @php
                                // إذا لم يتم تحديد "تحديد الجلسات لاحقاً"، فأضف تدريب واحد على الأقل
                                if (!$schedules_later) {
                                    $safeTrainings = $training->trainings ?? collect(); // ضمان أن trainings ليست null
                                    $trainings = old(
                                        'trainings',
                                        $safeTrainings->count() > 0
                                            ? $safeTrainings->toArray()
                                            : [
                                                [
                                                    'title' => '',
                                                    'trainer_id' => '',
                                                    'sessions' => [
                                                        [
                                                            'session_date' => '',
                                                            'session_start_time' => '',
                                                            'session_end_time' => '',
                                                        ]
                                                    ]
                                                ],
                                            ],
                                    );
                                } else {
                                    $trainings = [];
                                }
                            @endphp
                            
                            @foreach ($trainings as $trainingIndex => $trainingItem)
                                <div class="training-section">
                                    <div class="training-section-header">
                                        <h3 class="training-title">التدريب {{ $trainingIndex + 1 }}</h3>
                                        @if ($trainingIndex > 0)
                                            <button type="button" class="remove-training-btn" onclick="removeTraining({{ $trainingIndex }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                                                    <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    
                                    <div class="training-details">
                                        <div class="input-group">
                                            <label>عنوان التدريب <span class="required">*</span></label>
                                            <input type="text" name="trainings[{{ $trainingIndex }}][title]" 
                                                value="{{ is_array($trainingItem) ? $trainingItem['title'] ?? '' : $trainingItem->title }}" 
                                                placeholder="أدخل عنوان التدريب" 
                                                class="@error('trainings.' . $trainingIndex . '.title') error-border @enderror">
                                            @error("trainings.$trainingIndex.title")
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="input-group">
                                            <label>المدرب الرئيسي <span class="required">*</span></label>
                                            <select name="trainings[{{ $trainingIndex }}][trainer_id]" 
                                                class="custom-singleselect @error('trainings.' . $trainingIndex . '.trainer_id') error-border @enderror">
                                                <option value="" disabled selected>اختر مدربًا</option>
                                                @foreach ($availableTrainers as $trainer)
                                                    <option value="{{ $trainer->id }}" 
                                                        {{ (is_array($trainingItem) ? ($trainingItem['trainer_id'] ?? '') : $trainingItem->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                                        {{ $trainer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("trainings.$trainingIndex.trainer_id")
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="input-group">
                                        <label class="switch">
                                            <span class="switch-label">سيتم تحديد الجلسات لاحقًا بعد اكتمال عدد المشاركين</span>
                                            <input type="checkbox" name="trainings[{{ $trainingIndex }}][schedules_later]" value="1" 
                                                id="schedules_later_{{ $trainingIndex }}"
                                                {{ old('trainings.' . $trainingIndex . '.schedules_later', is_array($trainingItem) ? ($trainingItem['schedules_later'] ?? false) : $trainingItem->schedules_later) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    
                                    <div class="session-container" id="sessions-container-{{ $trainingIndex }}">
                                        @php
                                            // إذا لم يتم تحديد "تحديد الجلسات لاحقاً"، فأضف جلسة واحدة على الأقل
                                            if (!(is_array($trainingItem) ? ($trainingItem['schedules_later'] ?? false) : $trainingItem->schedules_later)) {
                                                $safeSessions = is_array($trainingItem) ? ($trainingItem['sessions'] ?? []) : ($trainingItem->sessions ?? []);
                                                $sessions = old(
                                                    'trainings.' . $trainingIndex . '.sessions',
                                                    count($safeSessions) > 0
                                                        ? $safeSessions
                                                        : [
                                                            [
                                                                'session_date' => '',
                                                                'session_start_time' => '',
                                                                'session_end_time' => '',
                                                            ],
                                                        ],
                                                );
                                            } else {
                                                $sessions = [];
                                            }
                                        @endphp
                                        
                                        @foreach ($sessions as $sessionIndex => $session)
                                            <div class="session-group" style="margin-bottom: 15px;">
                                                <div class="session-header">
                                                    <h4 class="session-title">الجلسة {{ $sessionIndex + 1 }}</h4>
                                                    @if ($sessionIndex > 0)
                                                        <button type="button" class="remove-session-btn" onclick="removeSession({{ $trainingIndex }}, {{ $sessionIndex }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                                                                <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                <div class="session-details">
                                                    <div class="input-group">
                                                        <label>تاريخ الجلسة <span class="required">*</span></label>
                                                        <input type="date" 
                                                            name="trainings[{{ $trainingIndex }}][sessions][{{ $sessionIndex }}][session_date]"
                                                            value="{{ is_array($session) ? $session['session_date'] ?? '' : $session->session_date }}"
                                                            placeholder="مثال: 15 يونيو 2025"
                                                            class="session-date-input w-100 @error('trainings.' . $trainingIndex . '.sessions.' . $sessionIndex . '.session_date') error-border @enderror">
                                                        @error("trainings.$trainingIndex.sessions.$sessionIndex.session_date")
                                                            <span class="error-message">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="input-group">
                                                        <label>وقت البدء <span class="required">*</span></label>
                                                        <div class="time-picker-container">
                                                            <div class="time-picker" data-training-index="{{ $trainingIndex }}" data-session-index="{{ $sessionIndex }}" data-type="start">
                                                                {{ is_array($session) ? ($session['session_start_time'] ? \Carbon\Carbon::parse($session['session_start_time'])->format('g:i A') : 'وقت بدء الجلسة') : ($session->session_start_time ? \Carbon\Carbon::parse($session->session_start_time)->format('g:i A') : 'وقت بدء الجلسة') }}
                                                            </div>
                                                            <div class="time-picker-dropdown"></div>
                                                            <input type="hidden"
                                                                name="trainings[{{ $trainingIndex }}][sessions][{{ $sessionIndex }}][session_start_time]"
                                                                value="{{ is_array($session) ? $session['session_start_time'] ?? '' : $session->session_start_time }}"
                                                                class="time-picker-input @error('trainings.' . $trainingIndex . '.sessions.' . $sessionIndex . '.session_start_time') error-border @enderror">
                                                        </div>
                                                        @error("trainings.$trainingIndex.sessions.$sessionIndex.session_start_time")
                                                            <span class="error-message">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="input-group">
                                                        <label>وقت الانتهاء <span class="required">*</span></label>
                                                        <div class="time-picker-container">
                                                            <div class="time-picker" data-training-index="{{ $trainingIndex }}" data-session-index="{{ $sessionIndex }}" data-type="end">
                                                                {{ is_array($session) ? ($session['session_end_time'] ? \Carbon\Carbon::parse($session['session_end_time'])->format('g:i A') : 'وقت انتهاء الجلسة') : ($session->session_end_time ? \Carbon\Carbon::parse($session->session_end_time)->format('g:i A') : 'وقت انتهاء الجلسة') }}
                                                            </div>
                                                            <div class="time-picker-dropdown"></div>
                                                            <input type="hidden"
                                                                name="trainings[{{ $trainingIndex }}][sessions][{{ $sessionIndex }}][session_end_time]"
                                                                value="{{ is_array($session) ? $session['session_end_time'] ?? '' : $session->session_end_time }}"
                                                                class="time-picker-input @error('trainings.' . $trainingIndex . '.sessions.' . $sessionIndex . '.session_end_time') error-border @enderror">
                                                        </div>
                                                        @error("trainings.$trainingIndex.sessions.$sessionIndex.session_end_time")
                                                            <span class="error-message">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="input-group">
                                        <button type="button" class="add-session-btn" onclick="addSession({{ $trainingIndex }})">
                                            <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                            <span>أضف جلسة جديدة</span>
                                        </button>
                                    </div>
                                    
                                    <div class="training-files">
                                        <label>ملفات التدريب (اختياري)</label>
                                        <div class="sub-label">قم بإرفاق أي ملفات تعريفية أو مرفقات ترغب بعرضها مسبقًا</div>
                                        <div class="file-upload-wrapper">
                                            <div class="file-upload-default">
                                                <img src="{{ asset('images/icons/upload.svg') }}" />
                                                <button type="button" class="add-file-btn">تصفح الملفات</button>
                                                <input type="file" name="trainings[{{ $trainingIndex }}][files][]" multiple class="hidden-file-input">
                                            </div>
                                            <div class="file-preview" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="input-group">
                            <button type="button" class="add-training-btn" id="add-training-btn">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>إضافة تدريب جديد</span>
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
    <script src="{{ asset('js/mutliselect.js') }}"></script>
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // عدد التدريبات الحالية من السيرفر
            let trainingIndex = {{ count($trainings) }};
            
            // عدد الجلسات لكل تدريب
            let sessionIndices = {};
            @foreach ($trainings as $trainingIndex => $trainingItem)
                sessionIndices[{{ $trainingIndex }}] = {{ count(is_array($trainingItem) ? ($trainingItem['sessions'] ?? []) : ($trainingItem->sessions ?? [])) }};
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
                    if (currentValue && currentValue !== 'وقت بدء الجلسة' && currentValue !== 'وقت انتهاء الجلسة') {
                        // تحويل القيمة من 24 ساعة إلى 12 ساعة للعرض
                        picker.textContent = formatTimeTo12Hour(currentValue);
                        
                        // التأكد من أن القيمة في الحقل المخفي بتنسيق 24 ساعة
                        hiddenInput.value = currentValue;
                    } else {
                        // تعيين النص الافتراضي إذا لم تكن هناك قيمة
                        const defaultText = picker.dataset.type === 'start' ? 'وقت بدء الجلسة' : 'وقت انتهاء الجلسة';
                        picker.textContent = defaultText;
                        // لا تقم بتعيين الحقل المخفي كفارغ إذا كان هناك قيمة صالحة من قبل
                        if (!currentValue || currentValue === 'وقت بدء الجلسة' || currentValue === 'وقت انتهاء الجلسة') {
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
                            dropdown.querySelectorAll('.time-picker-option').forEach(opt => {
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
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
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
                        const errorElement = sessionGroup.querySelector('#end-time-error-' + timePicker.dataset.sessionIndex);
                        if (errorElement) {
                            errorElement.textContent = 'وقت النهاية يجب أن يكون بعد وقت البداية';
                            errorElement.style.display = 'block';
                            endTimeInput.classList.add('error-border');
                        }
                    } else {
                        // إزالة رسالة الخطأ
                        const errorElement = sessionGroup.querySelector('#end-time-error-' + timePicker.dataset.sessionIndex);
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
                document.querySelectorAll('.session-group').forEach((sessionGroup) => {
                    const startTimePicker = sessionGroup.querySelector('.time-picker[data-type="start"]');
                    const endTimePicker = sessionGroup.querySelector('.time-picker[data-type="end"]');
                    const startTimeHidden = sessionGroup.querySelector('input[name$="[session_start_time]"]');
                    const endTimeHidden = sessionGroup.querySelector('input[name$="[session_end_time]"]');
                    
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
                const newTraining = document.createElement('div');
                newTraining.className = 'training-section';
                newTraining.innerHTML = `
                    <div class="training-section-header">
                        <h3 class="training-title">التدريب ${trainingIndex + 1}</h3>
                        <button type="button" class="remove-training-btn" onclick="removeTraining(${trainingIndex})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                                <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="training-details">
                        <div class="input-group">
                            <label>عنوان التدريب <span class="required">*</span></label>
                            <input type="text" name="trainings[${trainingIndex}][title]" placeholder="أدخل عنوان التدريب">
                            <span class="error-message" id="training-title-error-${trainingIndex}" style="display:none;"></span>
                        </div>
                        
                        <div class="input-group">
                            <label>المدرب الرئيسي <span class="required">*</span></label>
                            <select name="trainings[${trainingIndex}][trainer_id]" class="custom-singleselect">
                                <option value="" disabled selected>اختر مدربًا</option>
                                @foreach ($availableTrainers as $trainer)
                                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                                @endforeach
                            </select>
                            <span class="error-message" id="trainer-id-error-${trainingIndex}" style="display:none;"></span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label class="switch">
                            <span class="switch-label">سيتم تحديد الجلسات لاحقًا بعد اكتمال عدد المشاركين</span>
                            <input type="checkbox" name="trainings[${trainingIndex}][schedules_later]" value="1" id="schedules_later_${trainingIndex}">
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <div class="session-container" id="sessions-container-${trainingIndex}">
                        <div class="session-group" style="margin-bottom: 15px;">
                            <div class="session-header">
                                <h4 class="session-title">الجلسة 1</h4>
                            </div>
                            
                            <div class="session-details">
                                <div class="input-group">
                                    <label>تاريخ الجلسة <span class="required">*</span></label>
                                    <input type="date" name="trainings[${trainingIndex}][sessions][0][session_date]" placeholder="مثال: 15 يونيو 2025" class="session-date-input w-100">
                                    <span class="error-message" id="session-date-error-${trainingIndex}-0" style="display:none;"></span>
                                </div>
                                
                                <div class="input-group">
                                    <label>وقت البدء <span class="required">*</span></label>
                                    <div class="time-picker-container">
                                        <div class="time-picker" data-training-index="${trainingIndex}" data-session-index="0" data-type="start">وقت بدء الجلسة</div>
                                        <div class="time-picker-dropdown"></div>
                                        <input type="hidden" name="trainings[${trainingIndex}][sessions][0][session_start_time]" class="time-picker-input" value="">
                                    </div>
                                    <span class="error-message" id="start-time-error-${trainingIndex}-0" style="display:none;"></span>
                                </div>
                                
                                <div class="input-group">
                                    <label>وقت الانتهاء <span class="required">*</span></label>
                                    <div class="time-picker-container">
                                        <div class="time-picker" data-training-index="${trainingIndex}" data-session-index="0" data-type="end">وقت انتهاء الجلسة</div>
                                        <div class="time-picker-dropdown"></div>
                                        <input type="hidden" name="trainings[${trainingIndex}][sessions][0][session_end_time]" class="time-picker-input" value="">
                                    </div>
                                    <span class="error-message" id="end-time-error-${trainingIndex}-0" style="display:none;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <button type="button" class="add-session-btn" onclick="addSession(${trainingIndex})">
                            <img src="{{ asset('images/icons/plus-main.svg') }}" />
                            <span>أضف جلسة جديدة</span>
                        </button>
                    </div>
                    
                    <div class="training-files">
                        <label>ملفات التدريب (اختياري)</label>
                        <div class="sub-label">قم بإرفاق أي ملفات تعريفية أو مرفقات ترغب بعرضها مسبقًا</div>
                        <div class="file-upload-wrapper">
                            <div class="file-upload-default">
                                <img src="{{ asset('images/icons/upload.svg') }}" />
                                <button type="button" class="add-file-btn">تصفح الملفات</button>
                                <input type="file" name="trainings[${trainingIndex}][files][]" multiple class="hidden-file-input">
                            </div>
                            <div class="file-preview" style="display: none;"></div>
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
                const schedulesSwitch = newTraining.querySelector(`#schedules_later_${trainingIndex}`);
                const sessionContainer = newTraining.querySelector(`#sessions-container-${trainingIndex}`);
                const addSessionBtn = newTraining.querySelector('.add-session-btn');
                
                schedulesSwitch.addEventListener('change', function() {
                    if (this.checked) {
                        sessionContainer.style.display = 'none';
                        addSessionBtn.style.display = 'none';
                    } else {
                        sessionContainer.style.display = 'block';
                        addSessionBtn.style.display = 'inline-flex';
                        
                        // إذا لم تكن هناك جلسات معروضة، أضف جلسة واحدة
                        if (sessionContainer.querySelectorAll('.session-group').length === 0) {
                            addSession(trainingIndex);
                        }
                    }
                });
                
                // إضافة مستمعي الأحداث لرفع الملفات
                const fileInput = newTraining.querySelector('.hidden-file-input');
                const fileButton = newTraining.querySelector('.add-file-btn');
                const filePreview = newTraining.querySelector('.file-preview');
                const fileDefault = newTraining.querySelector('.file-upload-default');
                
                fileButton.addEventListener('click', function() {
                    fileInput.click();
                });
                
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        filePreview.innerHTML = '';
                        for (let i = 0; i < this.files.length; i++) {
                            const fileDiv = document.createElement('div');
                            fileDiv.className = 'file-item';
                            fileDiv.innerHTML = `
                                <span>${this.files[i].name}</span>
                                <button type="button" class="remove-file-btn">&times;</button>
                            `;
                            filePreview.appendChild(fileDiv);
                        }
                        filePreview.style.display = 'block';
                        fileDefault.style.display = 'none';
                    }
                });
                
                // تهيئة عدد الجلسات للتدريب الجديد
                sessionIndices[trainingIndex] = 1;
                
                trainingIndex++;
            });
            
            // إضافة جلسة جديدة
            window.addSession = function(trainingIndex) {
                const container = document.getElementById(`sessions-container-${trainingIndex}`);
                const sessionIndex = sessionIndices[trainingIndex];
                const newSession = document.createElement('div');
                newSession.className = 'session-group';
                newSession.style.marginBottom = '15px';
                newSession.innerHTML = `
                    <div class="session-header">
                        <h4 class="session-title">الجلسة ${sessionIndex + 1}</h4>
                        <button type="button" class="remove-session-btn" onclick="removeSession(${trainingIndex}, ${sessionIndex})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e00000" viewBox="0 0 256 256">
                                <path d="M216,48H180V36A28,28,0,0,0,152,8H104A28,28,0,0,0,76,36V48H40a12,12,0,0,0,0,24h4V208a20,20,0,0,0,20,20H192a20,20,0,0,0,20-20V72h4a12,12,0,0,0,0-24ZM100,36a4,4,0,0,1,4-4h48a4,4,0,0,1,4,4V48H100Zm88,168H68V72H188ZM116,104v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Zm48,0v64a12,12,0,0,1-24,0V104a12,12,0,0,1,24,0Z"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="session-details">
                        <div class="input-group">
                            <label>تاريخ الجلسة <span class="required">*</span></label>
                            <input type="date" name="trainings[${trainingIndex}][sessions][${sessionIndex}][session_date]" placeholder="مثال: 15 يونيو 2025" class="session-date-input w-100">
                            <span class="error-message" id="session-date-error-${trainingIndex}-${sessionIndex}" style="display:none;"></span>
                        </div>
                        
                        <div class="input-group">
                            <label>وقت البدء <span class="required">*</span></label>
                            <div class="time-picker-container">
                                <div class="time-picker" data-training-index="${trainingIndex}" data-session-index="${sessionIndex}" data-type="start">وقت بدء الجلسة</div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden" name="trainings[${trainingIndex}][sessions][${sessionIndex}][session_start_time]" class="time-picker-input" value="">
                            </div>
                            <span class="error-message" id="start-time-error-${trainingIndex}-${sessionIndex}" style="display:none;"></span>
                        </div>
                        
                        <div class="input-group">
                            <label>وقت الانتهاء <span class="required">*</span></label>
                            <div class="time-picker-container">
                                <div class="time-picker" data-training-index="${trainingIndex}" data-session-index="${sessionIndex}" data-type="end">وقت انتهاء الجلسة</div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden" name="trainings[${trainingIndex}][sessions][${sessionIndex}][session_end_time]" class="time-picker-input" value="">
                            </div>
                            <span class="error-message" id="end-time-error-${trainingIndex}-${sessionIndex}" style="display:none;"></span>
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
                const sessionGroup = document.querySelector(`#sessions-container-${trainingIndex} .session-group:nth-child(${sessionIndex + 1})`);
                if (sessionGroup) {
                    sessionGroup.remove();
                }
            };
            
            // حذف تدريب
            window.removeTraining = function(trainingIndex) {
                const trainingSection = document.querySelector(`#trainings-container .training-section:nth-child(${trainingIndex + 1})`);
                if (trainingSection) {
                    trainingSection.remove();
                }
            };
            
            // التحكم في خيار "تحديد الجلسات لاحقًا"
            document.querySelectorAll('input[id^="schedules_later_"]').forEach(schedulesSwitch => {
                const trainingIndex = schedulesSwitch.id.split('_')[2];
                const sessionContainer = document.getElementById(`sessions-container-${trainingIndex}`);
                const addSessionBtn = schedulesSwitch.closest('.training-section').querySelector('.add-session-btn');
                
                function toggleSessionFields() {
                    if (schedulesSwitch.checked) {
                        sessionContainer.style.display = 'none';
                        addSessionBtn.style.display = 'none';
                    } else {
                        sessionContainer.style.display = 'block';
                        addSessionBtn.style.display = 'inline-flex';
                        
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
                const fileInput = wrapper.querySelector('.hidden-file-input');
                const fileButton = wrapper.querySelector('.add-file-btn');
                const filePreview = wrapper.querySelector('.file-preview');
                const fileDefault = wrapper.querySelector('.file-upload-default');
                
                fileButton.addEventListener('click', function() {
                    fileInput.click();
                });
                
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        filePreview.innerHTML = '';
                        for (let i = 0; i < this.files.length; i++) {
                            const fileDiv = document.createElement('div');
                            fileDiv.className = 'file-item';
                            fileDiv.innerHTML = `
                                <span>${this.files[i].name}</span>
                                <button type="button" class="remove-file-btn">&times;</button>
                            `;
                            filePreview.appendChild(fileDiv);
                        }
                        filePreview.style.display = 'block';
                        fileDefault.style.display = 'none';
                    }
                });
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