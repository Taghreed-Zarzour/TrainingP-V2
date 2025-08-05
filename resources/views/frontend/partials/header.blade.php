<!-- تنبيه بعرض الشاشة بالكامل ومتجاوب -->
<p
    style="
    background: var(--Tertiary, #D9E6FF);
    border-top: 8px solid #003090;

  
    text-align: center;
    color: #003090;
    direction: rtl;
    padding: 10px 30px;
    margin-bottom: 0px
">
    هذا هو الإصدار التجريبي للمنصة، وما زال العمل جارٍ على تطوير المنصة وتحسينها. يسعدنا استقبال آرائكم وملاحظاتكم
    للمساهمة في بناء تجربة أفضل للجميع.
</p>

<div class="site-container">
    <header>

        <nav>
            <ul>
                <li>
                    <div class="logo-wrapper">
                        <img class="logo" src="{{ asset('images/logo.svg') }}" />
                    </div>
                </li>
                <li class="{{ request()->is('homePage') ? 'active' : '' }} ">
                    <a href="{{ route('homePage') }}">الرئيسية</a>
                </li>
                <li class="{{ request()->is('trainings*') ? 'active' : '' }}">
                    <a href="{{ route('trainings_announcements') }}">التدريبات</a>
                </li>
            </ul>
        </nav>

        @auth
            <nav class="auth-links">
                <ul>
                    @if (in_array(auth()->user()->user_type_id, [1, 4]))
                        <li>
                            {{-- <a href="{{ route('create.training') }}" class="pbtn pbtn-main piconed">
                            <img src="{{ asset('images/edit.svg') }}" />
                            <span>إنشاء تدريب</span>
                        </a> --}}

                            <a href="{{ route('training.create') }}" class="pbtn pbtn-main piconed">
                                <img src="{{ asset('images/edit.svg') }}" />
                                <span>إنشاء تدريب</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <div class="profile-wrapper">
                            <div class="profile-image">
                                <img
                                    src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/icons/user.svg') }}" />
                                <button class="profile-toggle">
                                    <img src="{{ asset('images/caret-down-white.svg') }}" />
                                </button>
                            </div>
                            <ul class="profile-menu">
                                <li class="profile-info">
                                    <div class="profile-box">

                                        <div class="profile-image">
                                            <img
                                                src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/icons/user.svg') }}" />
                                        </div>
                                        <div class="profile-text">
                                            <div class="profile-name">{{ Auth::user()->getTranslation('name', 'ar') }}
                                            </div>
                                            <div class="profile-email">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>
                                </li>

                                @if (auth()->user()->user_type_id == 1)
                                    <li>
                                        <a href="{{ route('show_trainer_profile') }}">
                                            <img src="{{ asset('images/profile-menu/user.svg') }}" />
                                            <span>الملف الشخصي</span>
                                        </a>
                                    </li>
                                @elseif(auth()->user()->user_type_id == 2)
                                    <li>
                                        <a href="{{ route('show_assistant_profile') }}">
                                            <img src="{{ asset('images/profile-menu/user.svg') }}" />
                                            <span>الملف الشخصي</span>
                                        </a>
                                    </li>
                                @elseif(auth()->user()->user_type_id == 3)
                                    <li>
                                        <a href="{{ route('show_trainee_profile') }}">
                                            <img src="{{ asset('images/profile-menu/user.svg') }}" />
                                            <span>الملف الشخصي</span>
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <a href="#">
                                        {{-- bell.svg --}}
                                        <img src="{{ asset('images/profile-menu/user.svg') }}" />
                                        <span>الإشعارات</span>
                                    </a>
                                </li>

                                @if (auth()->user()->user_type_id == 1)
                                    <li>
                                        <a href="{{ route('trainings.index') }}">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            <span>إدارة التدريبات</span>
                                        </a>
                                    </li>
                                @elseif(auth()->user()->user_type_id == 3)
                                    <li>
                                        <a href="{{ request()->is('trainings*') ? 'active' : '' }}">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            <span>التدريبات</span>
                                        </a>
                                    </li>
                                @elseif(auth()->user()->user_type_id == 4)
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            <span>إدارة البرامج التدريبية</span>
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <img src="{{ asset('images/profile-menu/sign-out.svg') }}" />
                                            <span>تسجيل الخروج</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        @else
            <nav class="auth-links">
                <ul>
                    <li><a href="{{ route('login') }}" class="punderlined">تسجيل الدخول</a></li>
                    <li><a href="{{ route('register') }}" class="pbtn pbtn-main">إنشاء حساب مجانًا</a></li>
                    <li>
                        <a href="{{ route('homePageOrganization') }}" class="piconed">
                            <span>للمؤسسات</span>
                            <img src="{{ asset('images/send.svg') }}" />
                        </a>
                    </li>
                </ul>
            </nav>
        @endauth

        <div class="mobile">
            <div class="mobile-header">
                <button id="burger-btn" class="burger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                        viewBox="0 0 256 256">
                        <path
                            d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,72H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,184H40a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Z">
                        </path>
                    </svg>
                </button>
                @auth
                    <div class="leftside-wrapper">
                        <div class="profile-wrapper">
                            <div class="profile-image">
                                <img
                                    src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/icons/user.svg') }}" />
                                <button>
                                    <img src="{{ asset('images/caret-down-white.svg') }}" />
                                </button>
                            </div>
                            <ul class="profile-menu">
                                <li class="profile-info">
                                    <div class="profile-box">

                                        <div class="profile-image">
                                            <img
                                                src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/icons/user.svg') }}" />
                                        </div>
                                        <div class="profile-text">
                                            <div class="profile-name">{{ Auth::user()->getTranslation('name', 'ar') }}
                                            </div>
                                            <div class="profile-email">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <a href="{{ route('show_trainer_profile') }}">
                                        <img src="{{ asset('images/profile-menu/user.svg') }}" />
                                        <span>الملف الشخصي</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        {{-- bell.svg --}}
                                        <img src="{{ asset('images/profile-menu/user.svg') }}" />
                                        <span>الإشعارات</span>
                                    </a>
                                </li>

                                @if (auth()->user()->user_type_id == 1)
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            <span>إدارة التدريبات</span>
                                        </a>
                                    </li>
                                @elseif(auth()->user()->user_type_id == 3)
                                    <li>
                                        <a href="{{ request()->is('trainings*') ? 'active' : '' }}">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            <span>التدريبات</span>
                                        </a>
                                    </li>
                                @elseif(auth()->user()->user_type_id == 4)
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('images/profile-menu/files.svg') }}" />
                                            <span>إدارة البرامج التدريبية</span>
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <img src="{{ asset('images/profile-menu/sign-out.svg') }}" />
                                            <span>تسجيل الخروج</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-wrapper">
                            <img class="logo" src="{{ asset('images/logo.svg') }}" />
                        </div>
                    </div>
                @else
                    <div class="logo-wrapper">
                        <img class="logo" src="{{ asset('images/logo.svg') }}" />
                    </div>
                @endauth
            </div>

            <div id="mobile-menu" class="mobile-main">
                <ul>
                    <li><a href="{{ route('homePage') }}">الرئيسية</a></li>
                    <li><a href="{{ route('trainings_announcements') }}">التدريبات</a></li>

                    @auth
                        @if (in_array(auth()->user()->user_type_id, [1, 2]))
                            <li>
                                {{-- <a href="{{ route('create.training') }}" class="pbtn pbtn-main piconed">
                                <img src="{{ asset('images/edit.svg') }}" />
                                <span>إنشاء تدريب</span>
                            </a> --}}

                                <a href="{{ route('training.create') }}" class="pbtn pbtn-main piconed">
                                    <img src="{{ asset('images/edit.svg') }}" />
                                    <span>إنشاء تدريب</span>
                                </a>
                            </li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="punderlined pbtn pbtn-light">تسجيل الدخول</a></li>
                        <li><a href="{{ route('register') }}" class="pbtn pbtn-light ptext-center">إنشاء حساب مجانًا</a>
                        </li>
                        <li>
                            <a href="{{ route('homePageOrganization') }}" class="piconed pbtn pbtn-light">
                                <span>للمؤسسات</span>
                                <img src="{{ asset('images/send.svg') }}" />
                            </a>
                        </li>
                    @endauth
                </ul>

                <button id="mobile-menu-close-btn" class="mobile-close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff"
                        viewBox="0 0 256 256">
                        <path
                            d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </header>
