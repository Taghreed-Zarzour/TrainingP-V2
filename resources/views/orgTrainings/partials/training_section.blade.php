<div class="training-section border rounded-4 p-3 " data-training-index="{{ $trainingIndex }}">
    <div class="training-details mb-5">
        <div class="training-section-header">
            <div class="input-group">
                <h5 class="">{{ $displayNumber }}- عنوان التدريب و المدرب الرئيسي</h5>
                <div class="sub-label">
                    اذكر عنوان التدريب بالإضافة إلى اسم المدرب المسؤول عن تنفيذ التدريب
                </div>
            </div>
            @if ($canRemove)
                <button type="button" class="remove-training-btn"
                    style="top: -50px;position: relative; display: block;"
                    data-training-index="{{ $trainingIndex }}">
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
            <div class="input-group">
                @php
                    $titleValue = '';
                    if (is_array($trainingItem)) {
                        $titleValue = $trainingItem['title'] ?? $trainingItem['program_title'] ?? '';
                    } elseif (is_object($trainingItem)) {
                        $titleValue = $trainingItem->title ?? $trainingItem->program_title ?? '';
                    }
                @endphp
                <input type="text" name="program_title[{{ $trainingIndex }}]"
                    value="{{ $titleValue }}"
                    placeholder="مثال : التفكير التصميمي"
                    class="@error('program_title.' . $trainingIndex) error-border @enderror">
                @error("program_title.$trainingIndex")
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                @php
                    $trainerIdValue = '';
                    if (is_array($trainingItem)) {
                        $trainerIdValue = $trainingItem['trainer_id'] ?? '';
                    } elseif (is_object($trainingItem)) {
                        $trainerIdValue = $trainingItem->trainer_id ?? '';
                    }
                @endphp
                <select name="trainer_id[{{ $trainingIndex }}]"
                    class="custom-singleselect @error('trainer_id.' . $trainingIndex) error-border @enderror">
                    <option value="" disabled selected  style="color: silver !important;">مثال : عبد الله المصري</option>
                    @foreach ($availableTrainers as $trainer)
                        <option value="{{ $trainer->id }}"
                            {{ $trainerIdValue == $trainer->id ? 'selected' : '' }}>
                            {{ $trainer->getTranslation('name', 'ar') }}
                              {{ $trainer->trainer?->getTranslation('last_name', 'ar') }}
                        </option>
                    @endforeach
                </select>
                @error("trainer_id.$trainingIndex")
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="input-group">
        @php
            $scheduleLaterValue = false;
            if (is_array($trainingItem)) {
                $scheduleLaterValue = $trainingItem['schedules_later'] ?? false;
            } elseif (is_object($trainingItem)) {
                $scheduleLaterValue = $trainingItem->schedules_later ?? false;
            }
        @endphp
        <label class="switch w-100">
            <span class="switch-label">سيتم تحديد الجلسات لاحقًا بعد اكتمال عدد المشاركين</span>
            <input type="checkbox"
                name="schedules_later[{{ $trainingIndex }}]" value="1"
                id="schedules_later_{{ $trainingIndex }}"
                {{ old('schedules_later', $scheduleLaterValue) ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
    
    <!-- حقول عدد الجلسات والساعات عند تحديد الجلسات لاحقاً -->
    <div class="session-details-container" id="session-details-{{ $trainingIndex }}" style="display: {{ $scheduleLaterValue ? 'block' : 'none' }};">
        <div class="input-group-2col">
            <div class="input-group">
                <label>عدد الجلسات</label>
                @php
                    $numOfSessionValue = '';
                    if (is_array($trainingItem)) {
                        $numOfSessionValue = $trainingItem['num_of_session'] ?? '';
                    } elseif (is_object($trainingItem)) {
                        $numOfSessionValue = $trainingItem->num_of_session ?? '';
                    }
                @endphp
                <input type="number" name="num_of_session[{{ $trainingIndex }}]" min="1" 
                    value="{{ $numOfSessionValue }}" placeholder="مثال: 5"
                    class="@error('num_of_session.' . $trainingIndex) error-border @enderror">
                @error("num_of_session.$trainingIndex")
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label>عدد الساعات</label>
                @php
                    $numOfHoursValue = '';
                    if (is_array($trainingItem)) {
                        $numOfHoursValue = $trainingItem['num_of_hours'] ?? '';
                    } elseif (is_object($trainingItem)) {
                        $numOfHoursValue = $trainingItem->num_of_hours ?? '';
                    }
                @endphp
                <input type="number" name="num_of_hours[{{ $trainingIndex }}]" min="0.5" step="0.5" 
                    value="{{ $numOfHoursValue }}" placeholder="مثال: 10"
                    class="@error('num_of_hours.' . $trainingIndex) error-border @enderror">
                @error("num_of_hours.$trainingIndex")
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="session-container" id="sessions-container-{{ $trainingIndex }}" style="display: {{ $scheduleLaterValue ? 'none' : 'block' }};">
        @php
            // إذا لم يتم تحديد "تحديد الجلسات لاحقاً"، فأضف جلسة واحدة على الأقل
            if (!$scheduleLaterValue) {
                $safeSchedules = [];
                if (is_array($trainingItem)) {
                    $safeSchedules = $trainingItem['schedules'] ?? [];
                } elseif (is_object($trainingItem)) {
                    $safeSchedules = $trainingItem->schedules ?? [];
                }
                
                // إذا لم تكن هناك جلسات من قاعدة البيانات ولا توجد بيانات قديمة من النموذج، أضف جلسة افتراضية
                if (empty($safeSchedules) && !old('schedules.' . $trainingIndex)) {
                    $safeSchedules = [
                        [
                            'date' => '',
                            'start_time' => '',
                            'end_time' => '',
                        ],
                    ];
                }
                
                $schedules = old(
                    'schedules.' . $trainingIndex,
                    $safeSchedules
                );
            } else {
                $schedules = [];
            }
        @endphp
        @foreach ($schedules as $scheduleIndex => $schedule)
            <div class="session-group" style="margin-bottom: 15px;"
                data-training-index="{{ $trainingIndex }}" data-session-index="{{ $scheduleIndex }}">
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
                            style="position: relative; right: 5px; display: block;"
                            data-training-index="{{ $trainingIndex }}" data-session-index="{{ $scheduleIndex }}">
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
                            @php
                                $dateValue = '';
                                if (is_array($schedule)) {
                                    $dateValue = $schedule['date'] ?? '';
                                } elseif (is_object($schedule)) {
                                    $dateValue = $schedule->date ?? '';
                                }
                            @endphp
                            <input type="date"
                                name="schedules[{{ $trainingIndex }}][{{ $scheduleIndex }}][date]"
                                value="{{ $dateValue }}"
                                placeholder="مثال: 15 يونيو 2025"
                                class="session-date-input w-100 @error('schedules.' . $trainingIndex . '.' . $scheduleIndex . '.date') error-border @enderror">
                            @error("schedules.$trainingIndex.$scheduleIndex.date")
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-group">
                            @php
                                $startTimeValue = '';
                                if (is_array($schedule)) {
                                    $startTimeValue = $schedule['start_time'] ?? '';
                                } elseif (is_object($schedule)) {
                                    $startTimeValue = $schedule->start_time ?? '';
                                }
                                $startTimeDisplay = $startTimeValue ? \Carbon\Carbon::parse($startTimeValue)->format('g:i A') : 'وقت بدء الجلسة';
                            @endphp
                            <div class="time-picker-container">
                                <div class="time-picker"
                                    data-training-index="{{ $trainingIndex }}"
                                    data-session-index="{{ $scheduleIndex }}"
                                    data-type="start">
                                    {{ $startTimeDisplay }}
                                </div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden"
                                    name="schedules[{{ $trainingIndex }}][{{ $scheduleIndex }}][start_time]"
                                    value="{{ $startTimeValue }}"
                                    class="time-picker-input @error('schedules.' . $trainingIndex . '.' . $scheduleIndex . '.start_time') error-border @enderror">
                            </div>
                            @error("schedules.$trainingIndex.$scheduleIndex.start_time")
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-group">
                            @php
                                $endTimeValue = '';
                                if (is_array($schedule)) {
                                    $endTimeValue = $schedule['end_time'] ?? '';
                                } elseif (is_object($schedule)) {
                                    $endTimeValue = $schedule->end_time ?? '';
                                }
                                $endTimeDisplay = $endTimeValue ? \Carbon\Carbon::parse($endTimeValue)->format('g:i A') : 'وقت انتهاء الجلسة';
                            @endphp
                            <div class="time-picker-container">
                                <div class="time-picker"
                                    data-training-index="{{ $trainingIndex }}"
                                    data-session-index="{{ $scheduleIndex }}"
                                    data-type="end">
                                    {{ $endTimeDisplay }}
                                </div>
                                <div class="time-picker-dropdown"></div>
                                <input type="hidden"
                                    name="schedules[{{ $trainingIndex }}][{{ $scheduleIndex }}][end_time]"
                                    value="{{ $endTimeValue }}"
                                    class="time-picker-input @error('schedules.' . $trainingIndex . '.' . $scheduleIndex . '.end_time') error-border @enderror">
                            </div>
                            @error("schedules.$trainingIndex.$scheduleIndex.end_time")
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="input-group">
        <button type="button" class="add-more-btn add-session-btn" data-training-index="{{ $trainingIndex }}">
            <img src="{{ asset('images/icons/plus-main.svg') }}" />
            <span>أضف جلسة جديدة</span>
        </button>
    </div>
</div>