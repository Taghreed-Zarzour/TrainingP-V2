@extends('frontend.layouts.master')
@section('title', 'الإعدادات الإضافية')
@section('content')
    <div class="publish-training-page">
        <div class="grid">
            <div class="right-col">
                <div class="vertical-stepper">
                    @include('orgTrainings.partials.stepper', [
                        'currentStep' => 5,
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
                        أضف متطلبات المسار والإعدادات الإضافية الخاصة بالمسار مثل تكلفة المسار، الحد الأقصى للمشاركين،
                        الملفات المرفقة، والصورة التعريفية. تساعد هذه المعلومات في تقديم تجربة واضحة للمشاركين وتنظيم
                        المسار بشكل فعّال.
                    </div>
                </div>
                <form id="trainingForm" method="POST" action="{{ route('orgTraining.storeSettings', $training->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- حقل is_free -->
                    <div class="input-group">
                        <label class="switch">
                            <span class="switch-label">برنامج مجاني</span>
                            <input type="checkbox" name="is_free" id="is_free" value="1" 
                                {{ old('is_free', $settings->is_free ?? false) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>
                    
                    <!-- قسم التكلفة (يظهر فقط إذا كان البرنامج مدفوع) -->
                    <div class="input-group" id="cost-section" style="{{ old('is_free', $settings->is_free ?? false) ? 'display: none;' : '' }}">
                        <label>تكلفة البرنامج<span class="required">*</span></label>
                        <div class="sub-label">
                            حدد الرسوم المطلوبة لحضور البرنامج إن كان البرنامج مأجورًا
                        </div>
                        <div class="input-group-2col" style="align-items: flex-start;">
                            <div style="width: 100%;">
                                <input type="number" step="0.01" name="cost" value="{{ old('cost', $settings->cost ?? '') }}"
                                    placeholder="مثال: 200" class="@error('cost') error-border @enderror" 
                                    @if (!(old('is_free', $settings->is_free ?? false))) required @endif />
                                @error('cost')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div style="width: 100%;">
                                <select class="custom-singleselect @error('currency') error-border @enderror"
                                    name="currency" @if (!(old('is_free', $settings->is_free ?? false))) required @endif>
                                    <option value="">اختر العملة</option>
                                    @foreach (\App\Enums\Currency::cases() as $currency)
                                        <option value="{{ $currency->value }}"
                                            {{ old('currency', $settings->currency ?? '') === $currency->value ? 'selected' : '' }}>
                                            {{ $currency->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="input-group mt-4">
                            <label>آلية الدفع<span class="required">*</span></label>
                            <div class="sub-label">
                                اكتب شرحًا يوضح للمهتمين كيف ستتم آلية دفع رسوم البرنامج
                            </div>
                            <textarea name="payment_method" rows="5" placeholder="اكتب هنا"
                                class="@error('payment_method') error-border @enderror"
                                @if (!(old('is_free', $settings->is_free ?? false))) required @endif>{{ old('payment_method', $settings->payment_method ?? '') }}</textarea>
                            @error('payment_method')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- تاريخ انتهاء التقديم -->
                    <div class="input-group">
                        <label>تاريخ انتهاء التقديم <span class="required">*</span></label>
                        <div class="sub-label">
                            حدد تاريخ انتهاء التقديم على البرنامج
                        </div>
                        <input type="date" name="application_deadline" 
                            value="{{ old('application_deadline', $settings->application_deadline ?? '') }}"
                            min="{{ date('Y-m-d') }}"
                            placeholder="مثال 12/06/2026"
                            class="@error('application_deadline') error-border @enderror" required />
                        @error('application_deadline')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- العدد الأقصى للمتدربين -->
                  <!-- تعديل حقل unlimited_trainees -->
<div class="input-group">
    <div class="d-flex justify-content-between flex-wrap">
        <label>العدد الأقصى للمتدربين<span class="required">*</span></label>
        <label class="switch">
            <input type="checkbox" name="unlimited_trainees" id="unlimited_trainees" value="1"
    {{ old('unlimited_trainees', isset($settings->max_trainees) && $settings->max_trainees == 0 ? true : false) ? 'checked' : '' }}>

    <span class="slider"></span>
            <span class="switch-label">لا يوجد عدد محدد</span>
        </label>
    </div>
    <div class="sub-label">
        حدد الحد الأعلى لعدد المشاركين في التدريب
    </div>
<div id="max-trainees-wrapper"
    style="{{ old('unlimited_trainees', isset($settings->max_trainees) && $settings->max_trainees == 0 ? true : false) ? 'display: none;' : '' }}">
        <input type="number" name="max_trainees" value="{{ old('max_trainees', isset($settings->max_trainees) && $settings->max_trainees == 0 ? '' : $settings->max_trainees) }}"

            placeholder="مثال: 20" class="@error('max_trainees') error-border @enderror" 
            @if (!(old('unlimited_trainees', $settings->max_trainees == 0 ? true : false))) required @endif />
        @error('max_trainees')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>
</div>
                    
                    <!-- طريقة تقديم الطلبات -->
                    <div class="input-group">
                        <label>ما الطريقة التي تفضلها لاستقبال طلبات المشاركة بالبرنامج:<span class="required">*</span></label>
                        <div class="sub-label">
                            توفر عليك المنصة إدارة المتدربين ومتابعتهم وإجراء الاختبارات والتقييمات بعد انتهاء كل تدريب
                        </div>
                        <div class="radio-group">
                            <div class="radio-group-item">
                                <input type="radio" name="application_submission_method" value="inside_platform"
                                    id="inside_platform"
                                    {{ old('application_submission_method', $settings->application_submission_method ?? '') == 'inside_platform' ? 'checked' : '' }}
                                    class="@error('application_submission_method') error-border @enderror" required />
                                <label for="inside_platform">داخل المنصة</label>
                            </div>
                            <div class="radio-group-item">
                                <input type="radio" name="application_submission_method" value="outside_platform"
                                    id="outside_platform"
                                    {{ old('application_submission_method', $settings->application_submission_method ?? '') == 'outside_platform' ? 'checked' : '' }}
                                    class="@error('application_submission_method') error-border @enderror" required />
                                <label for="outside_platform">خارج المنصة</label>
                            </div>
                        </div>
                        @error('application_submission_method')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- رابط التسجيل (يظهر فقط إذا كانت طريقة التقديم خارج المنصة) -->
                    <div class="input-group" id="registration-link-section"
                        style="{{ old('application_submission_method', $settings->application_submission_method ?? '') == 'outside_platform' ? '' : 'display: none;' }}">
                        <label>رابط التسجيل</label>
                        <input type="url" name="registration_link" placeholder="الصق هنا"
                            value="{{ old('registration_link', $settings->registration_link ?? '') }}"
                            class="@error('registration_link') error-border @enderror" />
                        @error('registration_link')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- قسم المتطلبات -->
                    <div class="input-group">
                        <label>ما المتطلبات أو الشروط اللازمة للالتحاق ببرنامجك؟<span class="required">*</span></label>
                        <div class="sub-label">
                            اذكر المهارات أو الخبرة أو الأدوات أو المعدات المطلوبة التي يجب أن يمتلكها المتعلمون قبل الالتحاق بالبرنامج. إذا لم تكن هناك متطلبات، فاستخدم هذه المساحة لتشجيع المبتدئين.
                        </div>
                        @php
                            $requirements = old('requirements', $requirements ?? ['']);
                            if (is_string($requirements)) {
                                $requirements = json_decode($requirements, true) ?? [];
                            }
                            $requirements = array_pad($requirements, 1, '');
                        @endphp
                        @foreach ($requirements as $index => $requirement)
                            <div class="{{ $index == 0 ? 'input-without-remove' : 'input-with-remove' }}">
                                <input type="text" name="requirements[]"
                                    value="{{ is_array($requirement) ? '' : $requirement }}"
                                    placeholder="مثال: لا حاجة لوجود خبرات سابقة لكي تنضم للبرنامج" required />
                                @error('requirements.' . $index)
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                        <button type="button" class="add-more-btn">
                            <img src="{{ asset('images/icons/plus-main.svg') }}" />
                            <span>أضف المزيد إلى ردك</span>
                        </button>
                    </div>
                    
                    <!-- قسم الفوائد -->
                    <div class="input-group">
                        <label>ما هي ميزات البرنامج؟</label>
                        <div class="sub-label">
                            اذكر النقاط التي تميز هذا البرنامج عن غيره. على سبيل المثال: هل يشمل جلسات كوتشينغ أو توجيه؟ حاول أن تكون محددًا ومقنعًا لجذب المشاركين.
                        </div>
                        @php
                            $benefits = old('benefits', $benefits ?? ['']);
                            if (is_string($benefits)) {
                                $benefits = json_decode($benefits, true) ?? [];
                            }
                            $benefits = array_pad($benefits, 1, '');
                        @endphp
                        @foreach ($benefits as $index => $benefit)
                            <div class="{{ $index == 0 ? 'input-without-remove' : 'input-with-remove' }}">
                                <input type="text" name="benefits[]"
                                    value="{{ is_array($benefit) ? '' : $benefit }}"
                                    placeholder="مثال: شهادة معتمدة" />
                                @error('benefits.' . $index)
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                        <button type="button" class="add-more-btn">
                            <img src="{{ asset('images/icons/plus-main.svg') }}" />
                            <span>أضف المزيد إلى ردك</span>
                        </button>
                    </div>
                    
                    <!-- الصورة التعريفية -->
                    <div class="input-group">
                        <label>الصورة التعريفية للبرنامج</label>
                        <div class="sub-label">
                            تنبيه: يُفضل أن تكون الصورة مربعة (بنسبة 1:1) لضمان عرضها بشكل مناسب في جميع أجزاء المنصة.
                        </div>
                        <div class="file-upload-wrapper">
                            <div class="profile-image-wrapper">
                                @if (old('training_image'))
                                    <div class="profile-image-preview">
                                        <img src="{{ asset('storage/' . old('training_image')) }}" alt="صورة التدريب"
                                            class="profile-image-shown image-show" />
                                        <button type="button" class="profile-image-btn change-profile-image">تغيير الصورة</button>
                                    </div>
                                @elseif ($settings->training_image)
                                    <div class="profile-image-preview">
                                        <img src="{{ asset('storage/' . $settings->training_image) }}" alt="صورة التدريب"
                                            class="profile-image-shown image-show" />
                                        <button type="button" class="profile-image-btn change-profile-image">تغيير الصورة</button>
                                    </div>
                                @else
                                    <div class="profile-image-default">
                                        <img src="{{ asset('images/icons/upload.svg') }}" alt="رفع صورة" />
                                        <button type="button" class="profile-image-btn select-profile-image">تصفح الملفات</button>
                                    </div>
                                @endif
                                <input type="file" id="training_image" name="training_image" accept="image/*"
                                    class="visually-hidden @error('training_image') error-border @enderror">
                            </div>
                            @error('training_image')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- رسالة الترحيب -->
                    <div class="input-group">
                        <label>رسالة الترحيب بعد التسجيل<span class="required">*</span></label>
                        <div class="sub-label">
                            هذا النص سيتم إرساله تلقائيًا إلى المشاركين بعد تسجيلهم في البرنامج. يمكنك استخدامه كما هو،
                            أو تعديله بما يتناسب مع طبيعة دورتك ونبرة تواصلك الخاصة مع المشاركين.
                        </div>
                        <textarea name="welcome_message" rows="5" placeholder="اكتب رسالة ترحيبية هنا"
                            class="@error('welcome_message') error-border @enderror" required>{{ old('welcome_message', $settings->welcome_message ?? '') }}</textarea>
                        @error('welcome_message')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- أزرار التنقل -->
                    <div class="input-group-2col mt-4">
                        <div class="input-group">
                            <a href="{{ route('training.schedule', $training->id) }}"
                                class="pbtn pbtn-outlined-main">
                                السابق
                            </a>
                        </div>
                        <div class="input-group">
                            <button type="submit" class="pbtn pbtn-main" id="publish-training-5-submit-btn">
                                حفظ الإعدادات
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/singleselect.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // إظهار/إخفاء قسم التكلفة بناءً على حالة حقل "برنامج مجاني"
            const isFreeCheckbox = document.getElementById('is_free');
            const costSection = document.getElementById('cost-section');
            
            // تعيين الحالة الأولية لقسم التكلفة
            if (isFreeCheckbox.checked) {
                costSection.style.display = 'none';
            } else {
                costSection.style.display = 'block';
            }
            
            isFreeCheckbox.addEventListener('change', function() {
                const costInput = document.querySelector('input[name="cost"]');
                const currencyInput = document.querySelector('select[name="currency"]');
                const paymentMethod = document.querySelector('textarea[name="payment_method"]');
                
                if (this.checked) {
                    costSection.style.display = 'none';
                    costInput.value = '';
                    currencyInput.value = '';
                    paymentMethod.value = '';
                    costInput.removeAttribute('required');
                    currencyInput.removeAttribute('required');
                    paymentMethod.removeAttribute('required');
                } else {
                    costSection.style.display = 'block';
                    costInput.setAttribute('required', 'required');
                    currencyInput.setAttribute('required', 'required');
                    paymentMethod.setAttribute('required', 'required');
                }
            });
            
            // إظهار/إخفاء حقل العدد الأقصى للمتدربين
            const unlimitedCheckbox = document.getElementById('unlimited_trainees');
            const maxTraineesWrapper = document.getElementById('max-trainees-wrapper');
            const maxTraineesInput = document.querySelector('input[name="max_trainees"]');
            
            // تعيين الحالة الأولية لحقل العدد الأقصى
            if (unlimitedCheckbox.checked) {
                maxTraineesWrapper.style.display = 'none';
                maxTraineesInput.removeAttribute('required');
            } else {
                maxTraineesWrapper.style.display = 'block';
                maxTraineesInput.setAttribute('required', 'required');
            }
            
            unlimitedCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    maxTraineesWrapper.style.display = 'none';
                    maxTraineesInput.removeAttribute('required');
                } else {
                    maxTraineesWrapper.style.display = 'block';
                    maxTraineesInput.setAttribute('required', 'required');
                    if (!maxTraineesInput.value) {
                        maxTraineesInput.value = ''; // القيمة الافتراضية
                    }
                }
            });
            
            // إظهار/إخفاء رابط التسجيل
            function updateRegistrationLinkSection() {
                const selectedMethod = document.querySelector(
                    'input[name="application_submission_method"]:checked');
                const registrationLinkSection = document.getElementById('registration-link-section');
                if (selectedMethod && selectedMethod.value === 'outside_platform') {
                    registrationLinkSection.style.display = 'block';
                } else {
                    registrationLinkSection.style.display = 'none';
                }
            }
            
            // استدعاء الدالة عند تحميل الصفحة
            updateRegistrationLinkSection();
            
            // إضافة مستمع للأحداث لأزرار الاختيار
            document.querySelectorAll('input[name="application_submission_method"]').forEach(radio => {
                radio.addEventListener('change', updateRegistrationLinkSection);
            });
            
            // إدارة الصورة التعريفية
            const profileWrapper = document.querySelector(".profile-image-wrapper");
            if (profileWrapper) {
                const fileInput = document.getElementById("training_image");
                const selectBtn = profileWrapper.querySelector(".select-profile-image");
                const changeBtn = profileWrapper.querySelector(".change-profile-image");
                
                if (selectBtn) selectBtn.addEventListener("click", () => fileInput.click());
                if (changeBtn) changeBtn.addEventListener("click", () => fileInput.click());
                
                fileInput.addEventListener("change", function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profileWrapper.innerHTML = `
                                <div class="profile-image-preview">
                                    <img src="${e.target.result}" alt="صورة التدريب" class="profile-image-shown image-show" />
                                    <button type="button" class="profile-image-btn change-profile-image">تغيير الصورة</button>
                                </div>
                            `;
                            const changeNew = profileWrapper.querySelector(".change-profile-image");
                            changeNew.addEventListener("click", () => fileInput.click());
                            profileWrapper.appendChild(fileInput);
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
            
            // إضافة حقول جديدة للمتطلبات والفوائد
            document.querySelectorAll(".add-more-btn").forEach(function(btn) {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();
                    const group = btn.closest(".input-group");
                    // استخدم أول حقل ثابت كقالب دائمًا
                    const templateDiv = group.querySelector(".input-without-remove");
                    if (!templateDiv) return;
                    
                    // نسخ الحقل
                    const newInputDiv = templateDiv.cloneNode(true);
                    // تغيير الكلاس ليكون قابلًا للإزالة
                    newInputDiv.classList.remove("input-without-remove");
                    newInputDiv.classList.add("input-with-remove");
                    // مسح القيم القديمة
                    const newInput = newInputDiv.querySelector('input[type="text"]');
                    newInput.value = "";
                    // إضافة زر الحذف
                    const removeBtn = document.createElement("button");
                    removeBtn.type = "button";
                    removeBtn.className = "remove-input-btn";
                    removeBtn.innerHTML = "&times;";
                    removeBtn.title = "حذف";
                    removeBtn.onclick = function() {
                        newInputDiv.remove();
                    };
                    newInputDiv.appendChild(removeBtn);
                    // إضافة الحقل الجديد قبل زر "أضف المزيد"
                    group.insertBefore(newInputDiv, btn);
                });
            });
            
            // إضافة أزرار الحذف للحقول الموجودة مسبقًا عند تحميل الصفحة
            document.querySelectorAll(".input-group").forEach(function(group) {
                group.querySelectorAll(".input-with-remove").forEach(function(div) {
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
            
            // Show loading indicator during form submission
            const form = document.getElementById('trainingForm');
            form.addEventListener('submit', function() {
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        جاري الحفظ...
                    `;
                }
            });
            // تعديل JavaScript لمعالجة القيمة 0
document.getElementById('unlimited_trainees').addEventListener('change', function() {
    const maxTraineesWrapper = document.getElementById('max-trainees-wrapper');
    const maxTraineesInput = document.querySelector('input[name="max_trainees"]');
    
    if (this.checked) {
        maxTraineesWrapper.style.display = 'none';
        maxTraineesInput.value = '0'; // استخدم القيمة 0 بدلاً من فارغ
        maxTraineesInput.removeAttribute('required');
    } else {
        maxTraineesWrapper.style.display = 'block';
        maxTraineesInput.setAttribute('required', 'required');
        if (maxTraineesInput.value === '0') {
            maxTraineesInput.value = ''; // القيمة الافتراضية
        }
    }
});

// عند تحميل الصفحة، تحقق من حالة الخيار
document.addEventListener('DOMContentLoaded', function() {
    const unlimitedCheckbox = document.getElementById('unlimited_trainees');
    const maxTraineesInput = document.querySelector('input[name="max_trainees"]');
    
    if (unlimitedCheckbox.checked) {
        maxTraineesInput.value = '0';
    }
});
        });
    </script>
@endsection