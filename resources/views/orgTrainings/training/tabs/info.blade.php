<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <div class="edit-btn">
            <button style="background: transparent;" type="button" data-bs-toggle="modal" data-bs-target="#editTrainingModal" title="تعديل">
                <img src="{{ asset('images/cources/edit.svg') }}">
            </button>
        </div>
    </div>
    
    <div class="two-columns" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
        <!-- العمود الأول -->
        <div style="flex: 1; min-width: 300px;">
            <!-- عنوان التدريب -->
            <div class="mb-5">
                <h3 class="section-title">عنوان التدريب</h3>
                <div class="info-value-container">
                    <p class="info-value">{{ $OrgProgramDetail->program_title }}</p>
                    <div class="info-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTitleModal">
                            <img src="{{ asset('images/cources/edit.svg') }}" width="16" height="16">
                        </button>
                        <form action="{{ route('training-detail.clear', $OrgProgramDetail->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="program_title" value="1">
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف عنوان التدريب؟')">
                                <img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- نوع التدريب -->
            <div class="mb-5">
                <h3 class="section-title">نوع التدريب</h3>
                <div class="info-value-container">
                    <p class="info-value">{{ $OrgProgramDetail->program_type }}</p>
                    <div class="info-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTypeModal">
                            <img src="{{ asset('images/cources/edit.svg') }}" width="16" height="16">
                        </button>
                        <form action="{{ route('training-detail.clear', $OrgProgramDetail->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="program_type" value="1">
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف نوع التدريب؟')">
                                <img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- لغة التدريب -->
            <div class="mb-5">
                <h3 class="section-title">لغة التدريب</h3>
                <div class="info-value-container">
                    <p class="info-value">{{ $OrgProgramDetail->language->name ?? 'غير محدد' }}</p>
                    <div class="info-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editLanguageModal">
                            <img src="{{ asset('images/cources/edit.svg') }}" width="16" height="16">
                        </button>
                        <form action="{{ route('training-detail.clear', $OrgProgramDetail->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="language_id" value="1">
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف لغة التدريب؟')">
                                <img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- تصنيف التدريب -->
            <div class="mb-5">
                <h3 class="section-title">تصنيف التدريب</h3>
                <div class="info-value-container">
                    <p class="info-value">{{ $orgTrainingClassification->implode(', ') }}</p>
                    <div class="info-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editClassificationModal">
                            <img src="{{ asset('images/cources/edit.svg') }}" width="16" height="16">
                        </button>
                        <form action="{{ route('training-detail.clear', $OrgProgramDetail->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="classification" value="1">
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف تصنيف التدريب؟')">
                                <img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- طريقة تقديم التدريب -->
            <div class="mb-5">
                <h3 class="section-title">طريقة تقديم التدريب</h3>
                <div class="info-value-container">
                    <p class="info-value">{{ $OrgProgramDetail->program_presentation_method }}</p>
                    <div class="info-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPresentationMethodModal">
                            <img src="{{ asset('images/cources/edit.svg') }}" width="16" height="16">
                        </button>
                        <form action="{{ route('training-detail.clear', $OrgProgramDetail->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="program_presentation_method" value="1">
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف طريقة تقديم التدريب؟')">
                                <img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- العمود الثاني -->
        <div style="flex: 1; min-width: 300px;">
            <!-- وصف التدريب -->
            <div class="mb-5">
                <h3 class="section-title">وصف التدريب</h3>
                <div class="info-value-container">
                    <p class="info-value">{{ $OrgProgramDetail->program_description ?: 'لم يتم إضافة وصف للتدريب بعد' }}</p>
                    <div class="info-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDescriptionModal">
                            <img src="{{ asset('images/cources/edit.svg') }}" width="16" height="16">
                        </button>
                        @if ($OrgProgramDetail->program_description)
                            <form action="{{ route('training-detail.clear', $OrgProgramDetail->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="program_description" value="1">
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف وصف التدريب؟')">
                                    <img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- ما الذي سيتعلمه المشاركون -->
            <div class="mb-5">
                <h3 class="section-title">ما الذي سيتعلمه المشاركون في هذا التدريب؟</h3>
                <div class="info-value-container">
                    @if (isset($OrgProgramDetail->learning_outcomes) && !empty($OrgProgramDetail->learning_outcomes))
                        @php
                            $learningOutcomes = is_array($OrgProgramDetail->learning_outcomes)
                                ? $OrgProgramDetail->learning_outcomes
                                : json_decode($OrgProgramDetail->learning_outcomes ?? '[]', true);
                        @endphp
                        <ul class="learning-outcomes-list">
                            @foreach ($learningOutcomes as $learning_outcome)
                                <li>{{ $learning_outcome }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="info-value">لم يتم تحديد أهداف التعلم بعد</p>
                    @endif
                    <div class="info-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editLearningOutcomesModal">
                            <img src="{{ asset('images/cources/edit.svg') }}" width="16" height="16">
                        </button>
                        @if (isset($OrgProgramDetail->learning_outcomes) && !empty($OrgProgramDetail->learning_outcomes))
                            <form action="{{ route('training-detail.clear', $OrgProgramDetail->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="learning_outcomes" value="1">
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف أهداف التعلم؟')">
                                    <img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل عنوان التدريب -->
<div class="modal fade" id="editTitleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('training-detail.update', $OrgProgramDetail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="program_title" class="form-label">عنوان التدريب</label>
                        <input type="text" class="form-control" id="program_title" name="program_title" value="{{ $OrgProgramDetail->program_title }}" required>
                        @error('program_title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل وصف التدريب -->
<div class="modal fade" id="editDescriptionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('training-detail.update', $OrgProgramDetail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="program_description" class="form-label">وصف التدريب</label>
                        <textarea class="form-control" id="program_description" name="program_description" rows="5">{{ $OrgProgramDetail->program_description }}</textarea>
                        @error('program_description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل أهداف التعلم -->
<div class="modal fade" id="editLearningOutcomesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('training-detail.update', $OrgProgramDetail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="learning_outcomes" class="form-label">ما الذي سيتعلمه المشاركون في هذا التدريب؟</label>
                        <div id="learning-outcomes-container">
                            @php
                                $learningOutcomes = old('learning_outcomes') ?? 
        (isset($OrgProgramDetail->learning_outcomes) ? 
            (is_array($OrgProgramDetail->learning_outcomes) ? 
                $OrgProgramDetail->learning_outcomes : 
                json_decode($OrgProgramDetail->learning_outcomes ?? '[]', true)
            ) : 
            [] // Default to empty array if not set
        );
                            @endphp
                             @foreach ((array) $learningOutcomes as $index => $outcome)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="learning_outcomes[]" value="{{ $outcome }}" required>
                                    @if ($index > 1)
                                        <button type="button" class="btn btn-outline-danger remove-learning-outcome">
                                            <img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-learning-outcome" class="btn btn-sm btn-outline-primary">
                            <img src="{{ asset('images/cources/plus.svg') }}" width="16" height="16"> إضافة هدف تعلم جديد
                        </button>
                        @error('learning_outcomes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل نوع التدريب -->
<div class="modal fade" id="editTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('training-detail.update', $OrgProgramDetail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="program_type" class="form-label">نوع التدريب</label>
                        <select class="form-select" id="program_type" name="program_type" required>
                            <option value="">اختر نوع التدريب</option>
                            <option value="تدريب عملي" {{ $OrgProgramDetail->program_type == 'تدريب عملي' ? 'selected' : '' }}>تدريب عملي</option>
                            <option value="تدريب نظري" {{ $OrgProgramDetail->program_type == 'تدريب نظري' ? 'selected' : '' }}>تدريب نظري</option>
                            <option value="تدريب مختلط" {{ $OrgProgramDetail->program_type == 'تدريب مختلط' ? 'selected' : '' }}>تدريب مختلط</option>
                        </select>
                        @error('program_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل لغة التدريب -->
<div class="modal fade" id="editLanguageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('training-detail.update', $OrgProgramDetail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="language_id" class="form-label">لغة التدريب</label>
                        <select class="form-select" id="language_id" name="language_id" required>
                            <option value="">اختر لغة التدريب</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}" {{ $OrgProgramDetail->language_id == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                            @endforeach
                        </select>
                        @error('language_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل تصنيف التدريب -->
<div class="modal fade" id="editClassificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('training-detail.update', $OrgProgramDetail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="classification" class="form-label">تصنيف التدريب</label>
                        <select class="form-select" id="classification" name="classification[]" multiple required>
                            @foreach ($classifications as $classification)
                                <option value="{{ $classification->id }}" {{ in_array($classification->id, json_decode($OrgProgramDetail->classification ?? '[]', true)) ? 'selected' : '' }}>{{ $classification->name }}</option>
                            @endforeach
                        </select>
                        @error('classification')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل طريقة تقديم التدريب -->
<div class="modal fade" id="editPresentationMethodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('training-detail.update', $OrgProgramDetail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="program_presentation_method" class="form-label">طريقة تقديم التدريب</label>
                        <select class="form-select" id="program_presentation_method" name="program_presentation_method" required>
                            <option value="">اختر طريقة التقديم</option>
                            <option value="حضوري" {{ $OrgProgramDetail->program_presentation_method == 'حضوري' ? 'selected' : '' }}>حضوري</option>
                            <option value="عن بعد" {{ $OrgProgramDetail->program_presentation_method == 'عن بعد' ? 'selected' : '' }}>عن بعد</option>
                            <option value="مختلط" {{ $OrgProgramDetail->program_presentation_method == 'مختلط' ? 'selected' : '' }}>مختلط</option>
                        </select>
                        @error('program_presentation_method')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // إضافة هدف تعلم جديد
        document.getElementById('add-learning-outcome').addEventListener('click', function() {
            const container = document.getElementById('learning-outcomes-container');
            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';
            
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.name = 'learning_outcomes[]';
            input.required = true;
            
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-outline-danger remove-learning-outcome';
            button.innerHTML = '<img src="{{ asset('images/cources/delete.svg') }}" width="16" height="16">';
            
            inputGroup.appendChild(input);
            inputGroup.appendChild(button);
            container.appendChild(inputGroup);
        });
        
        // حذف هدف تعلم
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-learning-outcome')) {
                e.target.closest('.input-group').remove();
            }
        });
    });
</script>

<style>
    .info-value-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    
    .info-value {
        flex: 1;
        margin: 0;
        padding: 8px 12px;
        background-color: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #e9ecef;
    }
    
    .info-actions {
        display: flex;
        gap: 5px;
        margin-right: 10px;
    }
    
    .learning-outcomes-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    
    .learning-outcomes-list li {
        padding: 5px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .learning-outcomes-list li:last-child {
        border-bottom: none;
    }
</style>