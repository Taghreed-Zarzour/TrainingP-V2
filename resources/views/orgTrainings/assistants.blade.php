@extends('frontend.layouts.master')
@section('title', 'إدارة المساعدين - التدريب')
@section('css')
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
أضف ميسري المسار أو مساعدي المدربين إن وُجد. تأكد من اختيار الأشخاص المسجلين مسبقًا في المنصة، أو قم بدعوتهم للتسجيل في المنصة وقم بإضافتهم لاحقًا. سيتم عرض أسماء الميسرين في صفحة المسار التدريبي.                        </div>
                    </div>
                    
                    <form id="assistants-form" method="POST" action="{{ route('orgTraining.storeAssistants', $training->id) }}">
                        @csrf
                        
                        <div class="input-group mt-3">
                            <label>الميسر / مساعد المدربين</label>
                            <div class="trainers" name="assistant_ids[]">
                                @foreach ($availableAssistants as $assistant)
                                    @if (in_array($assistant->id, $currentAssistants))
                                        <div class="trainer-main" data-trainer-id="{{ $assistant->id }}">
                                            <button type="button" class="trainer-main-remove" title="حذف">×</button>
                                            @if ($assistant->photo)
                                                <img src="{{ asset('storage/' . $assistant->photo) }}" alt="{{ $assistant->name }}" class="custom-rounded" width="120" height="120">
                                            @else
                                                <img src="{{ asset('images/icons/user.svg') }}" alt="{{ $assistant->name }}" class="custom-rounded" width="120" height="120">
                                            @endif
                                            <div class="trainer-info">
                                                <div class="trainer-name m-0">{{ $assistant->getTranslation('name', 'ar') }} {{ optional($assistant->assistant)->getTranslation('last_name', 'ar') }}</div>
                                                <div class="trainer-email">{{ $assistant->email }}</div>
                                            </div>
                                            <input type="hidden" name="assistant_ids[]" value="{{ $assistant->id }}" />
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="sub-label">اذكر اسم أو أسماء الميسرين أو مساعدي المدربين الذين سيكونوا مسؤولين عن تنظيم المسار وتعزيز التفاعل مع المشاركين.</div>
                            <select class="custom-singleselect-profile" data-input-name="assistant_ids[]" data-placeholder="ابحث عن مستخدم..." data-max-selection="0">
                                <option value="" disabled selected>ابحث عن مستخدم...</option>
                                @foreach ($availableAssistants as $assistant)
                                    @if (!in_array($assistant->id, $currentAssistants))
                                        <option value="{{ $assistant->id }}" data-id="{{ $assistant->id }}" data-name="{{ $assistant->getTranslation('name', 'ar') }} {{ optional($assistant->assistant)->getTranslation('last_name', 'ar') }}" data-email="{{ $assistant->email }}" data-image="{{ $assistant->photo ? asset('storage/' . $assistant->photo) : asset('images/icons/user.svg') }}">
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <button type="button" class="add-more-btn" style="display: none">
                                <img src="{{ asset('images/icons/plus-main.svg') }}" />
                                <span>إضافة المساعد إلى التدريب</span>
                            </button>
                        </div>
                        
                        <div class="input-group-2col mt-4">
                            <div class="input-group">
                                <a href="{{ route('orgTraining.settings', $training->id) }}" class="pbtn pbtn-outlined-main">
                                    السابق
                                </a>
                            </div>
                            <div class="input-group">
                                <button type="submit" class="pbtn pbtn-main">
                                    حفظ المساعدين
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
    <script src="{{ asset('js/singleselect-profile.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // دالة لإعادة تهيئة الـ custom select بعد تحديث خيارات <select>
                  // إعادة تعيين حالة زر الحفظ عند تحميل الصفحة
    window.addEventListener('pageshow', function(event) {
        // إذا كانت الصفحة تُحمّل من ذاكرة التخزين المؤقت (cache)
        if (event.persisted) {
            const form = document.getElementById('assistants-form');
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = 'حفظ المساعدين';
            }
        }
    });
            function initCustomSingleSelectProfile(select) {
                // إزالة المكون السابق إن وُجد
                const next = select.nextElementSibling;
                if (next && next.classList.contains("custom-singleselect-wrapper")) {
                    next.remove();
                }
                // بناء المكون من جديد (نفس فكرة singleselect-profile.js)
                const wrapper = document.createElement("div");
                wrapper.className = "custom-singleselect-wrapper";
                wrapper.tabIndex = 0;
                const input = document.createElement("input");
                input.type = "text";
                input.className = "custom-singleselect-input";
                input.placeholder = select.getAttribute('data-placeholder') || "ابحث أو اختر...";
                input.autocomplete = "off";
                const optionsList = document.createElement("div");
                optionsList.className = "options-list";
                const arrow = document.createElement("span");
                arrow.className = "dropdown-arrow";
                arrow.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000000" viewBox="0 0 256 256"><path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path></svg>`;
                
                // الحصول على الخيارات من select الأصلي
                const options = Array.from(select.options).map((opt) => ({
                    value: opt.value,
                    name: opt.getAttribute("data-name") || opt.text,
                    email: opt.getAttribute("data-email") || "",
                    image: opt.getAttribute("data-image") || "",
                    id: opt.getAttribute("data-id") || "",
                }));
                
                let selected = "";
                
                function renderOptions(filter = "") {
                    optionsList.innerHTML = "";
                    const filtered = options.filter((opt) =>
                        opt.value && (opt.name.includes(filter) || opt.email.includes(filter))
                    );
                    
                    if (filtered.length === 0) {
                        optionsList.innerHTML = `<div class="option-item" style="color:#aaa;cursor:default;">لا يوجد مستخدمون متاحون</div>`;
                        return;
                    }
                    
                    filtered.forEach((opt, index) => {
                        const div = document.createElement("div");
                        div.className = "option-item user-option";
                        
                        // الخيار الأول (placeholder) بدون صورة:
                        if (index === 0 && opt.value === "") {
                            div.innerHTML = `<div style="padding:10px;color:#aaa;">${opt.text}</div>`;
                        } else {
                            // باقي الخيارات بالصورة
                            div.innerHTML = `
                                <img class="user-img" src="${opt.image}" alt="${opt.name}" />
                                <div class="user-info">
                                    <div class="user-name">${opt.name}</div>
                                    <div class="user-email">${opt.email}</div>
                                </div>
                            `;
                        }
                        
                        div.onclick = () => {
                            selected = opt.value;
                            updateSelect();
                            renderSelected();
                            optionsList.style.display = "none";
                            wrapper.classList.remove("open");
                            select.dispatchEvent(new Event("change"));
                        };
                        
                        optionsList.appendChild(div);
                    });
                }
                
                function renderSelected() {
                    const opt = options.find((o) => o.value === selected);
                    if (opt) {
                        input.value = `${opt.name}`;
                        input.setAttribute("data-image", opt.image);
                        input.setAttribute("data-id", opt.id);
                    } else {
                        input.value = "";
                        input.removeAttribute("data-image");
                        input.removeAttribute("data-id");
                    }
                }
                
                function updateSelect() {
                    select.value = selected;
                }
                
                // إظهار الخيارات عند تركيز الإدخال أو النقر عليه
                input.addEventListener("focus", () => {
                    input.value = "";
                    renderOptions("");
                    optionsList.style.display = "block";
                    wrapper.classList.add("open");
                });
                
                input.addEventListener("input", () => {
                    renderOptions(input.value);
                    optionsList.style.display = "block";
                });
                
                input.addEventListener("click", () => {
                    input.value = "";
                    renderOptions("");
                    optionsList.style.display = "block";
                    wrapper.classList.add("open");
                });
                
                // إخفاء القائمة عند النقر خارج العنصر
                document.addEventListener("click", (e) => {
                    if (!wrapper.contains(e.target)) {
                        optionsList.style.display = "none";
                        wrapper.classList.remove("open");
                        renderSelected();
                    }
                });
                
                renderSelected();
                wrapper.appendChild(input);
                wrapper.appendChild(optionsList);
                wrapper.appendChild(arrow);
                select.parentNode.insertBefore(wrapper, select.nextSibling);
                
                // إخفاء select الأصلي
                select.style.display = "none";
            }
            
            // تهيئة كل الـ selects عند تحميل الصفحة
            document.querySelectorAll('select.custom-singleselect-profile').forEach(function(select) {
                initCustomSingleSelectProfile(select);
            });
            
            // وظيفة إضافة مساعد جديد
            document.querySelectorAll('.add-more-btn').forEach(function(addMoreBtn) {
                addMoreBtn.addEventListener('click', function() {
                    const inputGroup = addMoreBtn.closest('.input-group');
                    const select = inputGroup.querySelector('select.custom-singleselect-profile');
                    if (!select) return;
                    
                    const inputName = select.getAttribute('data-input-name');
                    if (!inputName) return;
                    
                    const trainersDiv = inputGroup.querySelector('.trainers');
                    if (!trainersDiv) return;
                    
                    const selectedOption = select.options[select.selectedIndex];
                    if (!selectedOption || !selectedOption.value) return;
                    
                    const id = selectedOption.value;
                    const maxSelection = select.getAttribute('data-max-selection') || 1;
                    
                    // إذا كان هناك حد أقصى للمساعدين
                    if (maxSelection === "1") {
                        // حذف أي مساعد موجود مسبقاً
                        const existingCards = trainersDiv.querySelectorAll('.trainer-main');
                        existingCards.forEach(card => {
                            // أعد الخيار إلى select الأصلي
                            const existingId = card.getAttribute('data-trainer-id');
                            const name = card.querySelector('.trainer-name')?.textContent || '';
                            const email = card.querySelector('.trainer-email')?.textContent || '';
                            const image = card.querySelector('.trainer-img')?.src || '';
                            
                            const option = document.createElement('option');
                            option.value = existingId;
                            option.setAttribute('data-name', name);
                            option.setAttribute('data-email', email);
                            option.setAttribute('data-image', image);
                            option.text = name;
                            select.appendChild(option);
                            card.remove();
                        });
                    }
                    
                    const name = selectedOption.getAttribute('data-name') || selectedOption.text;
                    const email = selectedOption.getAttribute('data-email') || '';
                    const image = selectedOption.getAttribute('data-image') || '';
                    
                    const card = document.createElement('div');
                    card.className = 'trainer-main';
                    card.setAttribute('data-trainer-id', id);
                    card.innerHTML = `
                        <button type="button" class="trainer-main-remove" title="حذف">×</button>
                        <img class="trainer-img" src="${image}" alt="${name}" />
                        <div class="trainer-info">
                            <div class="trainer-name m-0">${name}</div>
                            <div class="trainer-email">${email}</div>
                        </div>
                        <input type="hidden" name="${inputName}" value="${id}" />
                    `;
                    
                    // زر الحذف مع إعادة الخيار للقائمة
                    card.querySelector('.trainer-main-remove').onclick = function() {
                        // أعد الخيار إلى select الأصلي
                        const option = document.createElement('option');
                        option.value = id;
                        option.setAttribute('data-name', name);
                        option.setAttribute('data-email', email);
                        option.setAttribute('data-image', image);
                        option.text = name;
                        select.appendChild(option);
                        
                        // إعادة تهيئة الـ custom select لتحديث الخيارات
                        initCustomSingleSelectProfile(select);
                        card.remove();
                    };
                    
                    trainersDiv.appendChild(card);
                    
                    // حذف الخيار من select الأصلي لمنع التكرار
                    select.removeChild(selectedOption);
                    
                    // إعادة تهيئة الـ custom select لتحديث الخيارات
                    initCustomSingleSelectProfile(select);
                    
                    // إعادة تعيين التحديد بالselect
                    select.value = "";
                });
            });
            
            // دعم إضافة تلقائية عند تغيير اختيار الـ select (custom select يطلق event change)
            document.querySelectorAll('select.custom-singleselect-profile').forEach(function(select) {
                select.addEventListener('change', function() {
                    const addMoreBtn = select.closest('.input-group').querySelector('.add-more-btn');
                    if (addMoreBtn && select.value) {
                        addMoreBtn.click();
                    }
                });
            });
            
            // زر حذف للعناصر المضافة مسبقًا (لو موجودة عند تحميل الصفحة)
            document.querySelectorAll('.trainer-main .trainer-main-remove').forEach(function(removeBtn) {
                removeBtn.addEventListener('click', function() {
                    const card = this.closest('.trainer-main');
                    if (card) {
                        const inputGroup = card.closest('.input-group');
                        const select = inputGroup.querySelector('select.custom-singleselect-profile');
                        if (!select) return;
                        
                        const id = card.getAttribute('data-trainer-id');
                        const name = card.querySelector('.trainer-name')?.textContent || '';
                        const email = card.querySelector('.trainer-email')?.textContent || '';
                        const image = card.querySelector('.trainer-img')?.src || '';
                        
                        // إعادة الخيار إلى select الأصلي
                        const option = document.createElement('option');
                        option.value = id;
                        option.setAttribute('data-name', name);
                        option.setAttribute('data-email', email);
                        option.setAttribute('data-image', image);
                        option.text = name;
                        select.appendChild(option);
                        
                        initCustomSingleSelectProfile(select);
                        card.remove();
                    }
                });
            });
            
            // Show loading indicator during form submission
            const form = document.getElementById('assistants-form');
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
        });
        // إضافة هذا الكود في نهاية قسم JavaScript
// إعادة تعيين النموذج عند تحميل الصفحة
window.addEventListener('load', function() {
    const form = document.getElementById('assistants-form');
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = false;
        submitButton.innerHTML = 'حفظ المساعدين';
    }
});
    </script>
@endsection