<!-- الشريط العلوي للتنبيه -->
<a href="https://api.whatsapp.com/send?phone=905314977081" target="_blank"
    style="
    background: var(--Tertiary, #D9E6FF);
    border-top: 8px solid #003090;
    font-weight: 400;
    text-align: center;
    color: #003090;
    direction: rtl;
    padding: 10px 30px;
    margin-bottom: 0px;
    display: block;
    width: 100%;
">
    هذا هو الإصدار التجريبي للمنصة، وما زال العمل جارٍ على تطوير المنصة وتحسينها. يسعدنا استقبال آرائكم وملاحظاتكم
    للمساهمة في بناء تجربة أفضل للجميع.
</a>


<header class="bg-white shadow-sm">
    <div class="container custom-container">
        <nav class="navbar navbar-expand-lg navbar-light py-3">
            <!-- الشعار -->
            <a class="navbar-brand me-auto" href="{{ route('homePage') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="logo" />
            </a>

            <!-- زر القائمة في الموبايل -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- عناصر القائمة -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <!-- داخل #navbarMain -->
                <button class="mobile-close-btn d-lg-none"
                    onclick="document.getElementById('navbarMain').classList.remove('show')">
                    ✕
                </button>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">
@php
    // تحديد إذا المستخدم مؤسسة
    if (auth()->check()) {
        $isOrg = auth()->user()->user_type_id == 4;
    } else {
        // قراءة من الـ type في الرابط إذا ما في تسجيل دخول
        $isOrg = request('type') === 'organization';
    }

    $homeRoute = $isOrg ? 'homePageOrganization' : 'homePage';
@endphp

<li class="nav-item {{ request()->routeIs($homeRoute) ? 'active' : '' }}">
    <a class="nav-link nav-font va pb-0" 
       href="{{ route($homeRoute) }}{{ !$isOrg && !auth()->check() ? '?type=individual' : ($isOrg && !auth()->check() ? '?type=organization' : '') }}">
        الرئيسية
    </a>
</li>




                    <li class="nav-item {{ request()->is('trainings*') ? 'active' : '' }}">
                        <a class="nav-link nav-font pb-0" href="{{ route('trainings_announcements') }}">التدريبات</a>
                    </li>
                </ul>

                <!-- الروابط بحسب حالة تسجيل الدخول -->
                @auth
                    <ul class="navbar-nav align-items-center">
                        @if (in_array(auth()->user()->user_type_id, [1]))
                            <li class="nav-item me-2">
                                <a href="{{ auth()->user()->trainingPrograms()->exists() ? route('training.create') : route('startCreateTraining') }}"
                                    class="pbtn pbtn-main d-flex align-items-center">
                                    <img src="{{ asset('images/edit.svg') }}" class="me-1" />
                                    <span>إنشاء تدريب</span>
                                </a>
                            </li>
                        @endif
                        @if (in_array(auth()->user()->user_type_id, [4]))
                  <li class="nav-item me-2">
    <a href="#" class="pbtn pbtn-main d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#announceTrainingModal">
        <img src="{{ asset('images/edit.svg') }}" class="me-1" />
        <span>أعلن عن برامجك التدريبية</span>
    </a>
</li>
                        @endif
                        <!-- القائمة المنسدلة للملف الشخصي -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center position-relative" href="#"
                                id="navbarProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/icons/user.svg') }}"
                                    class="rounded-circle" width="52" height="52" />
                                <span class="custom-arrow"></span>
                            </a>


                            <ul class="dropdown-menu dropdown-menu-end text-end user-menu"
                                aria-labelledby="navbarProfileDropdown">

                                <li class="user-menu-header">
                                    <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/icons/user.svg') }}"
                                        alt="User Photo">
                                    <div class="user-info">
                                        <strong>{{ Auth::user()->getTranslation('name', 'ar') }}</strong>
                                        <small>{{ Auth::user()->email }}</small>
                                    </div>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

@php
    $profileRoute = match (auth()->user()->user_type_id) {
        1 => route('show_trainer_profile', ['user' => auth()->user()->profile_slug ?? auth()->user()->id]),
        2 => route('show_assistant_profile', ['user' => auth()->user()->profile_slug ?? auth()->user()->id]),
        3 => route('show_trainee_profile', ['user' => auth()->user()->profile_slug ?? auth()->user()->id]),
        4 => route('show_organization_profile', ['user' => auth()->user()->profile_slug ?? auth()->user()->id]),
        default => '#',
    };
@endphp                      <li>
                                    <a class="dropdown-item" href="{{ $profileRoute }}">
                                        <img src="{{ asset('images/profile-menu/user.svg') }}" />
                                        الملف الشخصي
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="#">
                                        <img src="{{ asset('images/profile-menu/notification.svg') }}" />
                                        الإشعارات
                                    </a>
                                </li>

                                @if (auth()->user()->user_type_id == 1)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('trainings.index') }}">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            إدارة التدريبات
                                        </a>
                                    </li>
                                @elseif(auth()->user()->user_type_id == 3)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('trainings_announcements') }}">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            التدريبات
                                        </a>
                                    </li>
                                @elseif(auth()->user()->user_type_id == 4)
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            إدارة البرامج التدريبية
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <form class="p-0" method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            <img src="{{ asset('images/profile-menu/sign-out.svg') }}" />
                                            تسجيل الخروج
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <ul class="navbar-nav align-items-center gap-3">
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="punderlined ">تسجيل الدخول</a>
                                </li>
@php
    $type = request()->query('type'); // بيرجع 'individual' أو 'organization'
    // تحديد الرابط حسب النوع
    $registerRoute = match($type) {
        'organization' => route('register-org'), // صفحة تسجيل المؤسسات
        'individual' => route('register'), // صفحة تسجيل الأفراد
        default => route('register'), // افتراضي: الأفراد
    };
@endphp

<li class="nav-item me-2">
    <a href="{{ $registerRoute }}" class="pbtn pbtn-main">إنشاء حساب مجانًا</a>
</li>

                                @php
                                    $type = request()->query('type'); // بيرجع 'individual' أو 'organization'
                                @endphp

                                @if ($type === 'organization')
                                    <li>
                                        <a href="{{ route('homePage', ['type' => 'individual']) }}" class="piconed">
                                            <span>للمدربين والأفراد</span>
                                            <img src="{{ asset('images/send.svg') }}" />
                                        </a>
                                    </li>
                                @elseif($type === 'individual')
                                    <li>
                                        <a href="{{ route('homePageOrganization', ['type' => 'organization']) }}"
                                            class="piconed">
                                            <span>للمؤسسات</span>
                                            <img src="{{ asset('images/send.svg') }}" />
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('homePageOrganization', ['type' => 'organization']) }}"
                                            class="piconed">
                                            <span>للمؤسسات</span>
                                            <img src="{{ asset('images/send.svg') }}" />
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endauth
            </div>
        </nav>
    </div>
</header>
<script>
    document.querySelectorAll('#navbarMain .nav-link, #navbarMain .dropdown-item').forEach(link => {
        link.addEventListener('click', () => {
            const navbar = document.getElementById('navbarMain');
            if (navbar.classList.contains('show')) {
                navbar.classList.remove('show');
            }
        });
    });
</script>



<div class="modal fade" id="announceTrainingModal" tabindex="-1" aria-labelledby="announceTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title px-5 mt-2" id="announceTrainingModalLabel">اختر ماذا تود أن تُعلن عنه؟</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form class="p-0" id="announceTrainingForm">
                    <div class="training-options-container row g-4 px-5">
                        <!-- خيار البرنامج التدريبي (عدة تدريبات) -->
                        <div class="col-md-6">
                            <div class="training-option-card h-100">
                                <input type="radio" name="training_type" id="training_program" value="program" class="option-radio">
                                <label for="training_program" class="option-label h-100">
                                  
                                        <!-- سيتم استبدال هذا بمكان الصورة -->
                                          <img src="{{ asset('images/org/multi-program.svg') }}"/>
                              
                                    <div class="option-title">برنامج تدريبي (عدة تدريبات)</div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- خيار التدريب الواحد -->
                        <div class="col-md-6">
                            <div class="training-option-card h-100">
                                <input type="radio" name="training_type" id="single_training" value="single" class="option-radio">
                                <label for="single_training" class="option-label h-100">
                                
                                        <!-- سيتم استبدال هذا بمكان الصورة -->
                                        <img src="{{ asset('images/org/one-program.svg') }}"/>
                                
                                    <div class="option-title">تدريب واحد فقط</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer px-5 mb-3">
                <button type="button" class="custom-btn flex-fill" id="continueAnnouncementBtn" disabled>
                    التالي   
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* تنسيقات المودال */
    #announceTrainingModal .modal-dialog {
        max-width: 800px;
    }
    #announceTrainingModal .btn-close{
      margin-bottom: 22px;
    }
    #announceTrainingModal .modal-header {
        border-bottom: none;
        padding-bottom: 0;
        padding-top: 2rem;
    }
    
    #announceTrainingModal .modal-title {
      color: #000000;
        font-weight: 500;
        font-size: 1.5rem;
        text-align: right;
        width: 100%;
    }
    
    #announceTrainingModal .modal-body {
        padding: 1rem 2rem 2rem;
    }
    
    /* تنسيقات خيارات التدريب */

    .training-option-card {
        position: relative;
        height: 100%;
    }
    
    .option-radio {
        position: absolute;
        opacity: 0;
    }
    
    .option-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        border-radius: 15px;
        padding: 0.5rem 0.3rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .option-radio:checked + .option-label {
        border-color: #858383;
        background-color: #dfebff;
    }
    
    .option-image {
        width: 140px;
        height: 140px;
        margin: 0 auto 1.5rem;
        background-color: #f5f5f5;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .image-placeholder {
        width: 100%;
        height: 100%;
        background-color: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
    }
    
    .option-title {
      padding-top: 25px;
        font-weight: 500;
        font-size: 1.2rem;
        color: #000000;
    }
    
    /* زر التالي */
    #continueAnnouncementBtn {
        font-size: 1.1rem;
      
    }
    
    #continueAnnouncementBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    /* التجاوب مع الشاشات الصغيرة */
    @media (max-width: 768px) {
        .training-options-container {
            flex-direction: column;
        }
        
        .option-image {
            width: 120px;
            height: 120px;
        }
    }
    
    @media (max-width: 576px) {
  
        
        .option-image {
            width: 100px;
            height: 100px;
        }
        
        .option-title {
            font-size: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // تفعيل/تعطيل زر التالي بناءً على اختيار المستخدم
        const radioButtons = document.querySelectorAll('.option-radio');
        const continueBtn = document.getElementById('continueAnnouncementBtn');
        
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                continueBtn.disabled = false;
            });
        });
        
        // معالجة النقر على زر التالي
continueBtn.addEventListener('click', function() {
    const selectedOption = document.querySelector('input[name="training_type"]:checked');
    if (selectedOption) {
        if (selectedOption.value === 'program') {
            // توجيه المستخدم لإنشاء برنامج تدريبي
            window.location.href = "";
        } else {
            // توجيه المستخدم لإنشاء تدريب واحد
            window.location.href = "{{ auth()->check() ? (auth()->user()->trainingPrograms()->exists() ? route('training.create') : route('startCreateTraining')) : route('login') }}";
        }
    }
});

    });
</script>

<div class="site-container">
