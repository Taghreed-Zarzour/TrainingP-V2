@extends('frontend.layouts.master')
@section('title', 'الأهداف ومحتوى التدريب')
@section('content')
    <main>
        <div class="publish-training-page">
            <div class="grid">
                <div class="right-col">
                    <div class="vertical-stepper">
                        <!-- خطوات التقدم -->
                        @include('trainings.partials.stepper', [
                            'currentStep' => 2,
                            'trainingId' => $training->id ?? null,
                            'isEditMode' => true,
                        ])
                    </div>
                </div>
                <div class="left-col">
                    <div class="info-message">
                        <div class="info-badge">
                            <img src="{{ asset('images/icons/hint.svg') }}" alt="" />
                        </div>
                        <div class="info-message-content">
                            ستكون الأوصاف التالية مرئية للجمهور على الصفحة المقصودة للدورة وستؤثر بشكل مباشر في أداء دورتك.
                            كما ستساعد هذه الأوصاف المتعلمين على تحديد ما إذا كانت دورتك مناسبة لهم أم لا.
                        </div>
                    </div>


                      {{-- @if ($errors->any())
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
                    @endif --}}
                    <form action="{{ route('training.store.goals', $training->id) }}" method="POST" id="training-goals-form">
                        @csrf

                        <div class="input-group">
                            <label>ما الذي سيتعلمه المشاركون في هذا التدريب؟ <span class="required">*</span></label>
                            <div class="sub-label">
                                يجب عليك تحديد 4 أهداف أو نتائج للتعلم على الأقل يمكن للمتعلمين تحقيقها بعد إنهاء دورتك.
                            </div>
                            @php
                                $learningOutcomes = old(
                                    'learning_outcomes',
                                    isset($learning_outcomes) ? $learning_outcomes : array_fill(0, 2, ''),
                                );
                                if (is_string($learningOutcomes)) {
                                    $learningOutcomes = json_decode($learningOutcomes, true) ?? [];
                                }
                                $learningOutcomes = array_pad($learningOutcomes, 2, '');
                            @endphp
                            @foreach ($learningOutcomes as $index => $outcome)
                                <div class="{{ $index < 2 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="learning_outcomes[]"
                                        value="{{ is_array($outcome) ? '' : $outcome }}"
                                        placeholder="مثال: تدريب أساسيات برمجة الأردوينو" />
                                    @error('learning_outcomes.' . $index)
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد إلى ردك</span>
                            </button>
                        </div>
                        
                        <div class="input-group">
                            <label>ما المتطلبات أو الشروط اللازمة للالتحاق بتدريبك؟<span class="required">*</span></label>
                            <div class="sub-label">
                                اذكر المهارات أو الخبرة أو الأدوات أو المعدات المطلوبة.
                            </div>
                            @php
                                $requirements = old(
                                    'requirements',
                                    isset($requirements) ? $requirements : array_fill(0, 1, ''),
                                );
                                if (is_string($requirements)) {
                                    $requirements = json_decode($requirements, true) ?? [];
                                }
                                $requirements = array_pad($requirements, 1, '');
                            @endphp
                            @foreach ($requirements as $index => $requirement)
                                <div class="{{ $index == 0 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="requirements[]"
                                        value="{{ is_array($requirement) ? '' : $requirement }}"
                                        placeholder="مثال: لا حاجة لوجود خبرات سابقة" />
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
                        
                        <div class="input-group">
                            <label>من هي الفئة المستهدفة؟<span class="required">*</span></label>
                            <div class="sub-label">
                                اكتب وصفًا واضحًا للمتعلمين المستهدفين في تدريبك.
                            </div>
                            @php
                                $targetAudience = old(
                                    'target_audience',
                                    isset($target_audience) ? $target_audience : array_fill(0, 1, ''),
                                );
                                if (is_string($targetAudience)) {
                                    $targetAudience = json_decode($targetAudience, true) ?? [];
                                }
                                $targetAudience = array_pad($targetAudience, 1, '');
                            @endphp
                            @foreach ($targetAudience as $index => $audience)
                                <div class="{{ $index == 0 ? 'input-without-remove' : 'input-with-remove' }}">
                                    <input type="text" name="target_audience[]"
                                        value="{{ is_array($audience) ? '' : $audience }}"
                                        placeholder="مثال: مطورو البرمجيات" />
                                    @error('target_audience.' . $index)
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="add-more-btn">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>أضف المزيد إلى ردك</span>
                            </button>
                        </div>
                        
                        <div class="input-group">
                            <label>ما هي ميزات التدريب؟</label>
                            <div class="sub-label">
                                اذكر النقاط التي تميز هذا التدريب عن غيره.
                            </div>
                            @php
                                $benefits = old('benefits', isset($benefits) ? $benefits : array_fill(0, 1, ''));
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
                        
                        <div class="input-group-2col mt-4">
                            <div class="input-group">
                                <a href="{{ route('training.basic', $training->id) }}" class="pbtn pbtn-outlined-main">
                                    السابق
                                </a>
                            </div>
                            <div class="input-group">
                                <button type="submit" class="pbtn pbtn-main">
                                    حفظ والمتابعة للفريق
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
            // إضافة حقول جديدة
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
            
            // التحقق من الصحة قبل الإرسال
            document.getElementById('training-goals-form').addEventListener('submit', function(e) {
                let isValid = true;
                
                // التحقق من وجود 4 نتائج تعلم على الأقل
                const learningOutcomes = document.querySelectorAll('input[name^="learning_outcomes"]');
                if (learningOutcomes.length < 2) {
                    isValid = false;
                    alert('يجب إدخال 2 نتائج تعلم على الأقل');
                }
                
                // التحقق من الحقول المطلوبة
                document.querySelectorAll('input[required]').forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.focus();
                        const errorMsg = input.nextElementSibling;
                        if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                            const errorElement = document.createElement('p');
                            errorElement.className = 'error-message';
                            errorElement.textContent = 'هذا الحقل مطلوب';
                            input.parentNode.appendChild(errorElement);
                        }
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection