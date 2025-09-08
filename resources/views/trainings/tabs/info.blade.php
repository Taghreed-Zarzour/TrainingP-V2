<style>
    .training-type {
        background-color: white;
        color: #003090;
        display: inline-block;
        padding: 3px 10px;
        border-radius: 5px;
        font-weight: bold;
        font-size: 14px;
        margin-left: 8px;
        vertical-align: middle;
    }

    .list-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .list-item img {
        margin-left: 10px;
        margin-top: 3px;
    }

    .payment-box {
        border: 2px solid #EFF0F6;
        border-radius: 32px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .free-training-badge {
        background-color: #28a745;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
        margin-right: 10px;
    }

    @media (max-width: 768px) {
        .two-columns {
            display: block !important;
        }

        .two-columns>div {
            width: 100% !important;
        }
    }

    .empty-state {
        text-align: center;
        padding: 20px;
        color: #6c757d;
        font-style: italic;
    }
</style>
<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <div class="edit-btn">
            <button style="background: transparent;" type="button" data-bs-toggle="modal"
                data-bs-target="#editTrainingModal" title="تعديل">
                <img src="{{ asset('images/cources/edit.svg') }}">
            </button>
        </div>
    </div>
    <div class="two-columns" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">

        <!-- العمود الأول -->
        <div style="flex: 1; min-width: 300px;">

            <!-- الفئة المستهدفة -->
            <div class="mb-5">
                <h3 class="section-title">الفئة المستهدفة من التدريب</h3>
                @if (isset($program->detail))
                    @php
                        $targetAudienceData = [
                            'education_level_id' => is_array($program->detail->education_level_id)
                                ? $program->detail->education_level_id
                                : json_decode($program->detail->education_level_id ?? '[]', true),
                            'work_status' => is_array($program->detail->work_status)
                                ? $program->detail->work_status
                                : json_decode($program->detail->work_status ?? '[]', true),
                            'work_sector_id' => is_array($program->detail->work_sector_id)
                                ? $program->detail->work_sector_id
                                : json_decode($program->detail->work_sector_id ?? '[]', true),
                            'job_position' => is_array($program->detail->job_position)
                                ? $program->detail->job_position
                                : json_decode($program->detail->job_position ?? '[]', true),
                            'country_id' => is_array($program->detail->country_id)
                                ? $program->detail->country_id
                                : json_decode($program->detail->country_id ?? '[]', true),
                        ];
                    @endphp

                    @if (
                        !empty($targetAudienceData) &&
                            (count($targetAudienceData['education_level_id'] ?? []) > 0 ||
                                count($targetAudienceData['work_status'] ?? []) > 0 ||
                                count($targetAudienceData['work_sector_id'] ?? []) > 0 ||
                                count($targetAudienceData['job_position'] ?? []) > 0 ||
                                count($targetAudienceData['country_id'] ?? []) > 0))
                        @if (
                            !empty($targetAudienceData['education_level_id']) &&
                                is_array($targetAudienceData['education_level_id']) &&
                                count($targetAudienceData['education_level_id']) > 0)
                            <div class="audience-question mb-3">
                                <div class="audience-question-title d-flex align-items-center mb-2">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2"
                                        alt="check" width="20" height="20">
                                    <strong>المستوى العلمي</strong>
                                </div>
                                <div class="audience-tags">
                                    @foreach ($targetAudienceData['education_level_id'] as $levelId)
                                        @php
                                            $level = \App\Models\EducationLevel::find($levelId);
                                        @endphp
                                        @if ($level)
                                            <span
                                                class="audience-tag badge me-1 mb-1 p-2">{{ $level->name }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (
                            !empty($targetAudienceData['work_status']) &&
                                is_array($targetAudienceData['work_status']) &&
                                count($targetAudienceData['work_status']) > 0)
                            <div class="audience-question mb-3">
                                <div class="audience-question-title d-flex align-items-center mb-2">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2"
                                        alt="check" width="20" height="20">
                                    <strong>الحالة الوظيفية</strong>
                                </div>
                                <div class="audience-tags">
                                    @foreach ($targetAudienceData['work_status'] as $work_status)
                                        @if ($work_status)
                                            <span class="audience-tag badge me-1 mb-1 p-2">
                                                @if ($work_status === 'working')
                                                    يعمل
                                                @elseif ($work_status === 'not_working')
                                                    لا يعمل
                                                @endif
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (
                            !empty($targetAudienceData['work_sector_id']) &&
                                is_array($targetAudienceData['work_sector_id']) &&
                                count($targetAudienceData['work_sector_id']) > 0)
                            <div class="audience-question mb-3">
                                <div class="audience-question-title d-flex align-items-center mb-2">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2"
                                        alt="check" width="20" height="20">
                                    <strong>قطاع العمل</strong>
                                </div>
                                <div class="audience-tags">
                                    @foreach ($targetAudienceData['work_sector_id'] as $sectorId)
                                        @php
                                            $sector = \App\Models\WorkSector::find($sectorId);
                                        @endphp
                                        @if ($sector)
                                            <span
                                                class="audience-tag badge me-1 mb-1 p-2">{{ $sector->name }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (
                            !empty($targetAudienceData['job_position']) &&
                                is_array($targetAudienceData['job_position']) &&
                                count($targetAudienceData['job_position']) > 0)
                            <div class="audience-question mb-3">
                                <div class="audience-question-title d-flex align-items-center mb-2">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2"
                                        alt="check" width="20" height="20">
                                    <strong>المستوى الوظيفي</strong>
                                </div>
                                <div class="audience-tags">
                                    @foreach ($targetAudienceData['job_position'] as $position)
                                        <span
                                            class="audience-tag badge me-1 mb-1 p-2">{{ $position }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (
                            !empty($targetAudienceData['country_id']) &&
                                is_array($targetAudienceData['country_id']) &&
                                count($targetAudienceData['country_id']) > 0)
                            <div class="audience-question mb-3">
                                <div class="audience-question-title d-flex align-items-center mb-2">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2"
                                        alt="check" width="20" height="20">
                                    <strong>الجنسية/ المنطقة</strong>
                                </div>
                                <div class="audience-tags">
                                    @foreach ($targetAudienceData['country_id'] as $countryId)
                                        @php
                                            $country = \App\Models\Country::find($countryId);
                                        @endphp
                                        @if ($country)
                                            <span
                                                class="audience-tag badge me-1 mb-1 p-2">{{ $country->name }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">لم يتم تحديد فئة مستهدفة بعد</div>
                    @endif
                @else
                    <div class="empty-state">لم يتم تحديد فئة مستهدفة بعد</div>
                @endif
            </div>
            <!-- المتطلبات -->
            <div class="mb-5">
                <h3 class="section-title">المتطلبات أو الشروط اللازمة للالتحاق بالتدريب</h3>
                @if (isset($program->detail) && $program->detail->requirements)
                    @php
                        $requirements = is_array($program->detail->requirements)
                            ? $program->detail->requirements
                            : json_decode($program->detail->requirements ?? '[]', true);
                    @endphp
                    @if (is_array($requirements) && count($requirements) > 0)
                        @foreach ($requirements as $requirement)
                            <div class="list-item">
                                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                                    height="20">
                                <span>{{ $requirement }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">لا توجد متطلبات محددة</div>
                    @endif
                @else
                    <div class="empty-state">لا توجد متطلبات محددة</div>
                @endif
            </div>
            <!-- ميزات التدريب -->
            @php
                $benefits = [];

                if (isset($program->detail) && $program->detail->benefits) {
                    $benefits = is_array($program->detail->benefits)
                        ? $program->detail->benefits
                        : json_decode($program->detail->benefits, true);

                    // إزالة العناصر الفارغة أو التي تحتوي فقط على فراغات
                    $benefits = array_filter($benefits, function ($b) {
                        return trim($b) !== '';
                    });
                }
            @endphp

            @if (!empty($benefits))
                <div class="mb-5">
                    <h3 class="section-title">ميزات التدريب</h3>
                    @foreach ($benefits as $benefit)
                        <div class="list-item">
                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                                height="20">
                            <span>{{ $benefit }}</span>
                        </div>
                    @endforeach
                </div>
            @endif


        </div>
        <!-- العمود الثاني -->
        <div style="flex: 1; min-width: 300px;">
            <!-- وصف التدريب -->
            <div class="mb-5">
                <h3 class="section-title">وصف التدريب</h3>
                @if (!empty($program->description))
                    <p>{{ $program->description }}</p>
                @else
                    <div class="empty-state">لم يتم إضافة وصف للتدريب بعد</div>
                @endif
            </div>
            <!-- ما الذي سيتعلمه المشاركون -->
            <div class="mb-5">
                <h3 class="section-title">ما الذي سيتعلمه المشاركون في هذا التدريب؟</h3>
                @if (isset($program->detail) && $program->detail->learning_outcomes)
                    @php
                        $learningOutcomes = is_array($program->detail->learning_outcomes)
                            ? $program->detail->learning_outcomes
                            : json_decode($program->detail->learning_outcomes ?? '[]', true);
                    @endphp
                    @if (is_array($learningOutcomes) && count($learningOutcomes) > 0)
                        @foreach ($learningOutcomes as $learning_outcome)
                            <div class="list-item">
                                <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                                    height="20">
                                <span>{{ $learning_outcome }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">لم يتم تحديد أهداف التعلم بعد</div>
                    @endif
                @else
                    <div class="empty-state">لم يتم تحديد أهداف التعلم بعد</div>
                @endif
            </div>
        </div>
    </div>
    <!-- آلية الدفع والرسالة الترحيبية -->
    @if (isset($program->AdditionalSetting))
        @if (!$program->AdditionalSetting->is_free || $program->AdditionalSetting->cost > 0)
            <!-- عرض آلية الدفع للبرامج المدفوعة -->
            <div class="payment-box mb-5 ">
                <h3 class="section-title">آلية الدفع</h3>
                @if (!empty($program->AdditionalSetting->payment_method))
                    <p>{{ $program->AdditionalSetting->payment_method }}</p>
                @else
                    <div class="empty-state">لم يتم تحديد آلية دفع بعد</div>
                @endif
            </div>
        @endif

        <!-- الرسالة الترحيبية -->
        @if (!empty($program->AdditionalSetting->welcome_message))
            <div class="welcome-box mb-5">
                <h3 class="section-title">رسالة ترحيبية</h3>
                <div class="welcome-message">
                    <p>{{ $program->AdditionalSetting->welcome_message }}</p>
                </div>
            </div>
        @endif
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="editTrainingModal" tabindex="-1" aria-labelledby="editTrainingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            @php
                $description = old('description', $program->description ?? '');

                $targetAudienceData = [
                    'education_level_id' =>
                        old('education_level_id') ??
                        (isset($program->detail) && $program->detail->education_level_id
                            ? (is_array($program->detail->education_level_id)
                                ? $program->detail->education_level_id
                                : json_decode($program->detail->education_level_id ?? '[]', true))
                            : []),
                    'work_status' =>
                        old('work_status') ??
                        (isset($program->detail) && $program->detail->work_status
                            ? (is_array($program->detail->work_status)
                                ? $program->detail->work_status
                                : json_decode($program->detail->work_status ?? '[]', true))
                            : []),
                    'work_sector_id' =>
                        old('work_sector_id') ??
                        (isset($program->detail) && $program->detail->work_sector_id
                            ? (is_array($program->detail->work_sector_id)
                                ? $program->detail->work_sector_id
                                : json_decode($program->detail->work_sector_id ?? '[]', true))
                            : []),
                    'job_position' =>
                        old('job_position') ??
                        (isset($program->detail) && $program->detail->job_position
                            ? (is_array($program->detail->job_position)
                                ? $program->detail->job_position
                                : json_decode($program->detail->job_position ?? '[]', true))
                            : []),
                    'country_id' =>
                        old('country_id') ??
                        (isset($program->detail) && $program->detail->country_id
                            ? (is_array($program->detail->country_id)
                                ? $program->detail->country_id
                                : json_decode($program->detail->country_id ?? '[]', true))
                            : []),
                ];

                $requirements =
                    old('requirements') ??
                    (isset($program->detail) && $program->detail->requirements
                        ? (is_array($program->detail->requirements)
                            ? $program->detail->requirements
                            : json_decode($program->detail->requirements ?? '[]', true))
                        : []);

                $benefits =
                    old('benefits') ??
                    (isset($program->detail) && $program->detail->benefits
                        ? (is_array($program->detail->benefits)
                            ? $program->detail->benefits
                            : json_decode($program->detail->benefits ?? '[]', true))
                        : []);

                $learningOutcomes =
                    old('learning_outcomes') ??
                    (isset($program->detail) && $program->detail->learning_outcomes
                        ? (is_array($program->detail->learning_outcomes)
                            ? $program->detail->learning_outcomes
                            : json_decode($program->detail->learning_outcomes ?? '[]', true))
                        : []);

                $paymentMethod = old(
                    'payment_method',
                    isset($program->AdditionalSetting) && $program->AdditionalSetting->payment_method
                        ? $program->AdditionalSetting->payment_method
                        : '',
                );

                $welcomeMessage = old(
                    'welcome_message',
                    isset($program->AdditionalSetting) && $program->AdditionalSetting->welcome_message
                        ? $program->AdditionalSetting->welcome_message
                        : 'مرحباً بكم في برنامجنا التدريبي! نحن سعداء بانضمامكم إلينا ونتطلع لتقديم تجربة تعليمية مميزة تلبي توقعاتكم وتساعدكم على تحقيق أهدافكم المهنية.',
                );

                $isFree = old(
                    'is_free',
                    isset($program->AdditionalSetting) ? $program->AdditionalSetting->is_free ?? false : false,
                );

                $educationLevels = \App\Models\EducationLevel::all();
                $workSectors = \App\Models\WorkSector::all();
                $countries = \App\Models\Country::all();
                $jobPositions = \App\Enums\JobPositionEnum::cases();
            @endphp
            <form method="POST" action="{{ route('trainingInfo.update', $program->id) }}" id="editTrainingForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTrainingModalLabel">تعديل معلومات التدريب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-4 w-100">
                        <label>وصف التدريب:</label>
                        <textarea class="form-control w-100" name="description" rows="5">{{ $description }}</textarea>
                        @error('description')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="input-group mb-4">
                        <label>من هي الفئة المستهدفة؟<span class="required">*</span></label>
                        <div class="sub-label">
                            حدد الفئة المستهدفة من التدريب
                        </div>

                        <!-- المستوى العلمي -->
                        <div class="input-group">
                            <label class="form-label">المستوى العلمي</label>
                            <select class="custom-multiselect" name="education_level_id[]" multiple>
                                @foreach ($educationLevels as $level)
                                    <option value="{{ $level->id }}"
                                        @if (in_array($level->id, $targetAudienceData['education_level_id'])) selected @endif>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- الحالة الوظيفية -->
                        <div class="input-group">
                            <label class="form-label">الحالة الوظيفية</label>
                                <div class="custom-select-container">
                                    <select name="work_status[]"
                                        class="custom-multiselect" multiple>
                                        <option value="working"
                                            {{ in_array(
                                                'working',
                                                old(
                                                    'work_status',
                                                    is_array($targetAudienceData['work_status'])
                                                        ? $targetAudienceData['work_status']
                                                        : json_decode($targetAudienceData['work_status'] ?? '[]', true),
                                                ),
                                            )
                                                ? 'selected'
                                                : '' }}>
                                            يعمل
                                        </option>
                                        <option value="not_working"
                                            {{ in_array(
                                                'not_working',
                                                old(
                                                    'work_status',
                                                    is_array($targetAudienceData['work_status'])
                                                        ? $targetAudienceData['work_status']
                                                        : json_decode($targetAudienceData['work_status'] ?? '[]', true),
                                                ),
                                            )
                                                ? 'selected'
                                                : '' }}>
                                            لا يعمل
                                        </option>
                                    </select>
                                </div>


                            </div>

                            <!-- قطاع العمل -->
                            <div class="input-group">
                                <label class="form-label">قطاع العمل</label>
                                <select class="custom-multiselect" name="work_sector_id[]" multiple>
                                    @foreach ($workSectors as $sector)
                                        <option value="{{ $sector->id }}"
                                            @if (in_array($sector->id, $targetAudienceData['work_sector_id'])) selected @endif>
                                            {{ $sector->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- المستوى الوظيفي -->
                            <div class="input-group">
                                <label class="form-label">المستوى الوظيفي</label>
                                <select class="custom-multiselect" name="job_position[]" multiple>
                                    @foreach ($jobPositions as $position)
                                        <option value="{{ $position->value }}"
                                            @if (in_array($position->value, $targetAudienceData['job_position'])) selected @endif>
                                            {{ $position }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- الجنسية/المنطقة -->
                            <div class="input-group">
                                <label class="form-label">الجنسية/المنطقة</label>
                                <select class="custom-multiselect" name="country_id[]" multiple>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            @if (in_array($country->id, $targetAudienceData['country_id'])) selected @endif>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>ما المتطلبات أو الشروط اللازمة للالتحاق بتدريبك؟<span
                                    class="required">*</span></label>
                            <div class="sub-label">
                                اذكر المهارات أو الخبرة أو الأدوات أو المعدات المطلوبة.
                            </div>
                            @foreach ($requirements as $index => $requirement)
                                <div class="{{ $index == 0 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="requirements[]"
                                        value="{{ is_array($requirement) ? '' : $requirement }}"
                                        placeholder="مثال: امتلاك جهاز حاسوب مع اتصال إنترنت مستقر." />
                                    @error('requirements.' . $index)
                                        <p class="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد</span>
                            </button>
                        </div>

                        <div class="input-group">
                            <label>ما الذي سيتعلمه المشاركون في هذا التدريب؟ <span class="required">*</span></label>
                            <div class="sub-label">
                                يجب عليك تحديد 2 أهداف أو نتائج للتعلم على الأقل.
                            </div>
                            @foreach ($learningOutcomes as $index => $outcome)
                                <div class="{{ $index < 2 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="learning_outcomes[]"
                                        value="{{ is_array($outcome) ? '' : $outcome }}"
                                        placeholder="مثال: سيتمكّن المشاركون من تطوير خارطة طريق لمنتج رقمي بناءً على تحليل احتياجات السوق والمستخدمين." />
                                    @error('learning_outcomes.' . $index)
                                        <p class="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد</span>
                            </button>
                        </div>

                        <div class="input-group">
                            <label>ما هي ميزات التدريب؟</label>
                            <div class="sub-label">
                                اذكر النقاط التي تميز هذا التدريب عن غيره.
                            </div>
                            @foreach ($benefits as $index => $benefit)
                                <div class="{{ $index == 0 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="benefits[]"
                                        value="{{ is_array($benefit) ? '' : $benefit }}"
                                        placeholder="مثال: شهادة معتمدة" />
                                    @error('benefits.' . $index)
                                        <p class="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد</span>
                            </button>
                        </div>

                        @if (isset($program->AdditionalSetting))
                            @if (!$program->AdditionalSetting->is_free || $program->AdditionalSetting->cost > 0)
                                <!-- عرض آلية الدفع للبرامج المدفوعة -->
                                <div class="mb-5">
                                    <h3 class="section-title">آلية الدفع</h3>
                                    <textarea name="payment_method" class="form-control w-100" rows="3">{{ $paymentMethod }}</textarea>
                                    @error('payment_method')
                                        <p class="error-msg">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        @endif

                        <!-- الرسالة الترحيبية -->
                        <div class="input-group w-100">
                            <label>رسالة ترحيبية:</label>
                            <textarea name="welcome_message" class="form-control w-100" rows="4"
                                placeholder="اكتب رسالة ترحيبية للمتدربين...">{{ $welcomeMessage }}</textarea>
                            @error('welcome_message')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pbtn pbtn-outlined-main" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="pbtn pbtn-main">حفظ التعديلات</button>
                    </div>
            </form>
        </div>
    </div>
</div>


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {


            // إضافة حقول جديدة
            document.querySelectorAll("#editTrainingModal .add-more-btn").forEach(function(btn) {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();
                    const group = btn.closest(".input-group");
                    const templateDiv = group.querySelector(".input-without-remove") ||
                        group.querySelector(".input-with-remove");
                    if (!templateDiv) return;
                    const newInputDiv = templateDiv.cloneNode(true);
                    newInputDiv.classList.remove("input-without-remove");
                    newInputDiv.classList.add("input-with-remove");
                    const newInput = newInputDiv.querySelector('input[type="text"]');
                    newInput.value = "";
                    // إزالة رسائل الخطأ القديمة
                    const oldError = newInputDiv.querySelector('.error-msg');
                    if (oldError) oldError.remove();
                    // إضافة زر الحذف
                    if (!newInputDiv.querySelector(".remove-input-btn")) {
                        const removeBtn = document.createElement("button");
                        removeBtn.type = "button";
                        removeBtn.className = "remove-input-btn";
                        removeBtn.innerHTML = "&times;";
                        removeBtn.title = "حذف";
                        removeBtn.onclick = function() {
                            newInputDiv.remove();
                        };
                        newInputDiv.appendChild(removeBtn);
                    }
                    group.insertBefore(newInputDiv, btn);
                });
            });

            // إضافة أزرار الحذف للحقول الموجودة عند فتح المودال
            document.getElementById('editTrainingModal').addEventListener('shown.bs.modal', function() {
                document.querySelectorAll("#editTrainingModal .input-with-remove").forEach(function(div) {
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

            // التحقق من الصحة قبل الإرسال
            document.getElementById('editTrainingForm').addEventListener('submit', function(e) {
                // التحقق من وجود أهداف تعلم
                const learningOutcomes = document.querySelectorAll('input[name="learning_outcomes[]"]')
                    .length;
                if (learningOutcomes < 2) {
                    e.preventDefault();
                    alert('يجب تحديد 2 أهداف أو نتائج للتعلم على الأقل');
                    return;
                }

                // التحقق من وجود متطلبات
                const requirements = document.querySelectorAll('input[name="requirements[]"]').length;
                if (requirements < 1) {
                    e.preventDefault();
                    alert('يجب تحديد متطلب واحد على الأقل');
                    return;
                }

                // التحقق من وجود فئة مستهدفة


                // التحقق من آلية الدفع إذا كان التدريب مدفوع
                if (!freeRadio.checked) {
                    const paymentMethod = document.querySelector('textarea[name="payment_method"]').value
                        .trim();
                    if (!paymentMethod) {
                        e.preventDefault();
                        alert('يجب تحديد آلية دفع للتدريب المدفوع');
                        return;
                    }
                }
            });
        });
    </script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
@endsection
