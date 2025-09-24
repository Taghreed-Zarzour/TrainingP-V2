{{-- <!-- resources/views/orgTrainings/tabs/info.blade.php -->
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
              
                @if (isset($OrgProgramDetail->trainingProgram->goals))
                    @php
                        $targetAudienceData = [
                            'education_level_id' => [],
                            // is_array($education_levels)
                            //     ? $education_levels
                            //     : json_decode($education_levels ?? '[]', true),
                            'work_status' => [],
                            'work_sector_id' => [],
                            // is_array($work_sectors)
                            //     ? $work_sectors
                            //     : json_decode($work_sectors ?? '[]', true),
                            'job_position' => [],
                            'country_id' => [],
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
                                        @if (is_object($levelId))
                                            <span
                                                class="audience-tag badge me-1 mb-1 p-2">{{ $levelId->name }}</span>
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
                                        @if (is_object($sectorId))
                                            <span
                                                class="audience-tag badge me-1 mb-1 p-2">{{ $sectorId->name }}</span>
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
                @if (isset($OrgProgramDetail->trainingProgram->registrationRequirements) && $OrgProgramDetail->trainingProgram->registrationRequirements->requirements)
                    @php
                        $requirements = is_array($OrgProgramDetail->trainingProgram->registrationRequirements->requirements)
                            ? $OrgProgramDetail->trainingProgram->registrationRequirements->requirements
                            : json_decode($OrgProgramDetail->trainingProgram->registrationRequirements->requirements ?? '[]', true);
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
                if (isset($OrgProgramDetail->trainingProgram->registrationRequirements) && $OrgProgramDetail->trainingProgram->registrationRequirements->benefits) {
                    $benefits = is_array($OrgProgramDetail->trainingProgram->registrationRequirements->benefits)
                        ? $OrgProgramDetail->trainingProgram->registrationRequirements->benefits
                        : json_decode($OrgProgramDetail->trainingProgram->registrationRequirements->benefits, true);
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
                @if (!empty($OrgProgramDetail->trainingProgram->description))
                    <p>{{ $OrgProgramDetail->trainingProgram->description }}</p>
                @else
                    <div class="empty-state">لم يتم إضافة وصف للتدريب بعد</div>
                @endif
            </div>
            
            <!-- ما الذي سيتعلمه المشاركون -->
            <div class="mb-5">
                <h3 class="section-title">ما الذي سيتعلمه المشاركون في هذا التدريب؟</h3>
                @if (isset($OrgProgramDetail->trainingProgram->registrationRequirements) && $OrgProgramDetail->trainingProgram->registrationRequirements->learning_outcomes)
                    @php
                        $learningOutcomes = is_array($OrgProgramDetail->trainingProgram->registrationRequirements->learning_outcomes)
                            ? $OrgProgramDetail->trainingProgram->registrationRequirements->learning_outcomes
                            : json_decode($OrgProgramDetail->trainingProgram->registrationRequirements->learning_outcomes ?? '[]', true);
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
    @if (isset($OrgProgramDetail->trainingProgram->AdditionalSetting))
        @if (!$OrgProgramDetail->trainingProgram->AdditionalSetting->is_free || $OrgProgramDetail->trainingProgram->AdditionalSetting->cost > 0)
            <!-- عرض آلية الدفع للبرامج المدفوعة -->
            <div class="payment-box mb-5 ">
                <h3 class="section-title">آلية الدفع</h3>
                @if (!empty($OrgProgramDetail->trainingProgram->AdditionalSetting->payment_method))
                    <p>{{ $OrgProgramDetail->trainingProgram->AdditionalSetting->payment_method }}</p>
                @else
                    <div class="empty-state">لم يتم تحديد آلية دفع بعد</div>
                @endif
            </div>
        @endif
        <!-- الرسالة الترحيبية -->
        @if (!empty($OrgProgramDetail->trainingProgram->AdditionalSetting->welcome_message))
            <div class="welcome-box mb-5">
                <h3 class="section-title">رسالة ترحيبية</h3>
                <div class="welcome-message">
                    <p>{{ $OrgProgramDetail->trainingProgram->AdditionalSetting->welcome_message }}</p>
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
                $description = old('description', $OrgProgramDetail->trainingProgram->description ?? '');
                $targetAudienceData = [
                    'education_level_id' =>
                        old('education_level_id') ??
                        (isset($OrgProgramDetail->trainingProgram->goals) && $OrgProgramDetail->trainingProgram->goals->education_level_id
                            ? (is_array($OrgProgramDetail->trainingProgram->goals->education_level_id)
                                ? $OrgProgramDetail->trainingProgram->goals->education_level_id
                                : json_decode($OrgProgramDetail->trainingProgram->goals->education_level_id ?? '[]', true))
                            : []),
                    'work_status' => [],
                    'work_sector_id' =>
                        old('work_sector_id') ??
                        (isset($OrgProgramDetail->trainingProgram->goals) && $OrgProgramDetail->trainingProgram->goals->work_sector_id
                            ? (is_array($OrgProgramDetail->trainingProgram->goals->work_sector_id)
                                ? $OrgProgramDetail->trainingProgram->goals->work_sector_id
                                : json_decode($OrgProgramDetail->trainingProgram->goals->work_sector_id ?? '[]', true))
                            : []),
                    'job_position' => [],
                    'country_id' => [],
                ];
                $requirements =
                    old('requirements') ??
                    (isset($OrgProgramDetail->trainingProgram->goals) && $OrgProgramDetail->trainingProgram->registrationRequirements->requirements
                        ? (is_array($OrgProgramDetail->trainingProgram->registrationRequirements->requirements)
                            ? $OrgProgramDetail->trainingProgram->registrationRequirements->requirements
                            : json_decode($OrgProgramDetail->trainingProgram->registrationRequirements->requirements ?? '[]', true))
                        : []);
                $benefits =
                    old('benefits') ??
                    (isset($OrgProgramDetail->trainingProgram->goals) && $OrgProgramDetail->trainingProgram->goals->benefits
                        ? (is_array($OrgProgramDetail->trainingProgram->goals->benefits)
                            ? $OrgProgramDetail->trainingProgram->goals->benefits
                            : json_decode($OrgProgramDetail->trainingProgram->goals->benefits ?? '[]', true))
                        : []);
                $learningOutcomes =
                    old('learning_outcomes') ??
                    (isset($OrgProgramDetail->trainingProgram->goals) && $OrgProgramDetail->trainingProgram->goals->learning_outcomes
                        ? (is_array($OrgProgramDetail->trainingProgram->goals->learning_outcomes)
                            ? $OrgProgramDetail->trainingProgram->goals->learning_outcomes
                            : json_decode($OrgProgramDetail->trainingProgram->goals->learning_outcomes ?? '[]', true))
                        : []);
                $paymentMethod = old(
                    'payment_method',
                    isset($OrgProgramDetail->trainingProgram->AdditionalSetting) && $OrgProgramDetail->trainingProgram->AdditionalSetting->payment_method
                        ? $OrgProgramDetail->trainingProgram->AdditionalSetting->payment_method
                        : '',
                );
                $welcomeMessage = old(
                    'welcome_message',
                    isset($OrgProgramDetail->trainingProgram->AdditionalSetting) && $OrgProgramDetail->trainingProgram->AdditionalSetting->welcome_message
                        ? $OrgProgramDetail->trainingProgram->AdditionalSetting->welcome_message
                        : 'مرحباً بكم في برنامجنا التدريبي! نحن سعداء بانضمامكم إلينا ونتطلع لتقديم تجربة تعليمية مميزة تلبي توقعاتكم وتساعدكم على تحقيق أهدافكم المهنية.',
                );
                $isFree = old(
                    'is_free',
                    isset($OrgProgramDetail->trainingProgram->AdditionalSetting) ? $OrgProgramDetail->trainingProgram->AdditionalSetting->is_free ?? false : false,
                );
                $educationLevels = \App\Models\EducationLevel::all();
                $workSectors = \App\Models\WorkSector::all();
                $countries = \App\Models\Country::all();
                $jobPositions = \App\Enums\JobPositionEnum::cases();
            @endphp
            
            <form method="POST" action="{{ route('trainingInfo.update', $OrgProgramDetail->trainingProgram->id) }}" id="editTrainingForm">
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
                        <div class="sub-label">حدد الفئة المستهدفة من التدريب</div>
                        
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
                    </div>
                    
                    <div class="input-group">
                        <label>ما المتطلبات أو الشروط اللازمة للالتحاق بتدريبك؟<span class="required">*</span></label>
                        <div class="sub-label">اذكر المهارات أو الخبرة أو الأدوات أو المعدات المطلوبة.</div>
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
                        <div class="sub-label">يجب عليك تحديد 2 أهداف أو نتائج للتعلم على الأقل.</div>
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
                        <div class="sub-label">اذكر النقاط التي تميز هذا التدريب عن غيره.</div>
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
                    
                    @if (isset($OrgProgramDetail->trainingProgram->AdditionalSetting))
                        @if (!$OrgProgramDetail->trainingProgram->AdditionalSetting->is_free || $OrgProgramDetail->trainingProgram->AdditionalSetting->cost > 0)
                            <div class="mb-5">
                                <h3 class="section-title">آلية الدفع</h3>
                                <textarea name="payment_method" class="form-control w-100" rows="3">{{ $paymentMethod }}</textarea>
                                @error('payment_method')
                                    <p class="error-msg">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    @endif
                    
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
                    
                    const oldError = newInputDiv.querySelector('.error-msg');
                    if (oldError) oldError.remove();
                    
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
            
            document.getElementById('editTrainingForm').addEventListener('submit', function(e) {
                const learningOutcomes = document.querySelectorAll('input[name="learning_outcomes[]"]').length;
                if (learningOutcomes < 2) {
                    e.preventDefault();
                    alert('يجب تحديد 2 أهداف أو نتائج للتعلم على الأقل');
                    return;
                }
                
                const requirements = document.querySelectorAll('input[name="requirements[]"]').length;
                if (requirements < 1) {
                    e.preventDefault();
                    alert('يجب تحديد متطلب واحد على الأقل');
                    return;
                }
            });
        });
    </script>
    <script src="{{ asset('js/mutliselect.js') }}"></script>
@endsection --}}