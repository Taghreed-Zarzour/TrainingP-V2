@extends('frontend.layouts.master')
@section('title', 'معلومات البرنامج الأساسية')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/singleselect.css') }}">
    <link rel="stylesheet" href="{{ asset('css/validation-styles.css') }}">
@endsection
@section('content')
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        <!-- خطوات التقدم -->
                        @include('trainings.partials.stepper', [
                            'currentStep' => 1,
                            'trainingId' => $training->id ?? null,
                            'isEditMode' => $isEditMode ?? false,
                        ])
                    </div>
                </div>
                <div class="left-col">
                    @if ($errors->any())
                        <div class="alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
<form action="{{ $isEditMode ? route('training.update.basic', $training->id) : route('training.store.basic') }}" method="POST" id="training-basic-form">
                        @csrf
                         @if($isEditMode)
        @method('PUT')
    @endif
                        <div class="input-group">
                            <label>عنوان التدريب <span class="required">*</span></label>
                            <input type="text" name="title" 
                                   value="{{ old('title', $training->title ?? '') }}"
                                   placeholder="مثال: إدارة المنتجات الرقمية" 
                                   class="validate @error('title') error-border @enderror" />
                            @error('title')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="input-group-2col">
                            <div class="input-group">
                                <label>لغة التدريب<span class="required">*</span></label>
                                <select name="language_type_id" class="custom-singleselect validate @error('language_type_id') error-border @enderror" required>
                                    
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang->id }}"
                                            @selected(old('language_type_id', $training->language_type_id ?? '') == $lang->id)>
                                            {{ $lang->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('language_type_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <label>نوع البرنامج<span class="required">*</span></label>
                                <select name="program_type_id" class="custom-singleselect validate @error('program_type_id') error-border @enderror" required>
                                    
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            @selected(old('program_type_id', $training->program_type_id ?? '') == $type->id)>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('program_type_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label>تصنيف التدريب<span class="required">*</span></label>
                            <select name="training_classification_id" class="custom-singleselect validate @error('training_classification_id') error-border @enderror" required>
                              
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->id }}"
                                        @selected(old('training_classification_id', $training->training_classification_id ?? '') == $classification->id)>
                                        {{ $classification->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('training_classification_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="input-group-2col">
                            <div class="input-group">
                                <label>مستوى التدريب<span class="required">*</span></label>
                                <select name="training_level_id" class="custom-singleselect validate @error('training_level_id') error-border @enderror" required>
                                
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}"
                                            @selected(old('training_level_id', $training->training_level_id ?? '') == $level->id)>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('training_level_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <label>طريقة تقديم التدريب<span class="required">*</span></label>
                                <select name="program_presentation_method_id" class="custom-singleselect validate @error('program_presentation_method_id') error-border @enderror" required>
                                    @foreach (\App\Enums\TrainingAttendanceType::cases() as $method)
                                        <option value="{{ $method->value }}"
                                            {{ old('program_presentation_method_id', $training->program_presentation_method_id ?? '') == $method->value ? 'selected' : '' }}>
                                            {{ $method->value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('program_presentation_method_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
<div class="input-group position-relative">
    <label>وصف التدريب<span class="required">*</span></label>
    <textarea name="description" placeholder="اكتب نبذة مختصرة عن التدريب" rows="5" 
              class="validate @error('description') error-border @enderror" 
              required minlength="10" maxlength="500"
              id="training-description">{{ old('description', $training->description ?? '') }}</textarea>
    <div class="char-counter-badge" id="description-counter">500</div>
    @error('description')
        <span class="error-message">{{ $message }}</span>
    @enderror
</div>
                        
                        <div class="input-group-2col mt-4">
                            <div class="input-group">
                                @if($isEditMode ?? false)
                                    <a href="{{ route('training.review', $training->id) }}" class="pbtn pbtn-outlined-main">
                                        حفظ والعودة للمراجعة
                                    </a>
                                @else
                                    <a href="{{ route('homePage') }}" class="pbtn pbtn-outlined-main">
                                        إلغاء والعودة للرئيسية
                                    </a>
                                @endif
                            </div>
                            <div class="input-group">
                                <button type="submit" class="pbtn pbtn-main" id="submit-btn">
                                    @if($isEditMode ?? false)
                                        تحديث والمتابعة للأهداف
                                    @else
                                        حفظ والمتابعة للأهداف
                                    @endif
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
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/localization/messages_ar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize custom select elements
            document.querySelectorAll('.custom-singleselect').forEach(select => {
                initCustomSelect(select);
            });
            
            // Form validation with jQuery
            $('#training-basic-form').validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 200
                    },
                    language_type_id: {
                        required: true
                    },
                    program_type_id: {
                        required: true
                    },
                    training_classification_id: {
                        required: true
                    },
                    training_level_id: {
                        required: true
                    },
                    program_presentation_method_id: {
                        required: true
                    },
                    description: {
                        required: true,
                        minlength: 10,
                        maxlength: 500
                    }
                },
                messages: {
                    title: {
                        required: "يرجى إدخال عنوان التدريب",
                        minlength: "عنوان التدريب يجب أن يحتوي على 3 أحرف على الأقل",
                        maxlength: "عنوان التدريب يجب ألا يتجاوز 200 حرف"
                    },
                    language_type_id: {
                        required: "يرجى اختيار لغة التدريب"
                    },
                    program_type_id: {
                        required: "يرجى اختيار نوع البرنامج"
                    },
                    training_classification_id: {
                        required: "يرجى اختيار تصنيف التدريب"
                    },
                    training_level_id: {
                        required: "يرجى اختيار مستوى التدريب"
                    },
                    program_presentation_method_id: {
                        required: "يرجى اختيار طريقة تقديم التدريب"
                    },
                    description: {
                        required: "يرجى إدخال وصف التدريب",
                        minlength: "وصف التدريب يجب أن يحتوي على 10 أحرف على الأقل",
                        maxlength: "وصف التدريب يجب ألا يتجاوز 500 حرف"
                    }
                },
                errorElement: 'span',
                errorClass: 'error-message',
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('error-border').removeClass('valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('error-border').addClass('valid');
                },
                submitHandler: function(form) {
                    const submitButton = $(form).find('button[type="submit"]');
                    submitButton.prop('disabled', true);
                    submitButton.html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        جاري الحفظ...
                    `);
                    form.submit();
                }
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const descriptionTextarea = document.getElementById('training-description');
        const charCounter = document.getElementById('description-counter');
        const maxLength = 500;
        const minLength = 10;

        // تحديث العداد عند الكتابة
        descriptionTextarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            // تحديث العداد
            charCounter.textContent = remaining;
            
            // تغيير مظهر العداد حسب الحالة
            if (currentLength > maxLength) {
                charCounter.classList.add('char-counter-danger');
                charCounter.classList.remove('char-counter-warning');
            } 
            else if (remaining < 50) {
                charCounter.classList.add('char-counter-warning');
                charCounter.classList.remove('char-counter-danger');
            }
            else {
                charCounter.classList.remove('char-counter-danger', 'char-counter-warning');
            }
        });

        // التحقق الأولي عند تحميل الصفحة
        if (descriptionTextarea.value) {
            descriptionTextarea.dispatchEvent(new Event('input'));
        }
    });
</script>
@endsection