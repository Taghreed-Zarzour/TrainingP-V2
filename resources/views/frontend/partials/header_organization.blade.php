<header>
  <nav>
    <ul>
      <li>
        <div class="logo-wrapper">
          <img class="logo" src="{{ asset('images/logo.svg') }}" />
        </div>
      </li>
      <li class="active"><a href="#">الرئيسية</a></li>
      <li><a href="#">أعلن عن احتياجك</a></li>
      <li><a href="#">المدربون</a></li>
      <li><a href="#">المساعدون</a></li>
      <li><a href="#">موارد معرفية</a></li>
      <li><a href="#">الباقات</a></li>
    </ul>
  </nav>

  <nav class="auth-links">
    <ul>
      @guest
        <li><a href="{{ route('login') }}" class="punderlined">تسجيل الدخول</a></li>
        <li><a href="{{ route('register-org') }}" class="pbtn pbtn-main">إنشاء حساب مجانًا</a></li>
        <li>
          <a href="{{ route('homePage') }}" class="piconed">
            <span>للمدربين والأفراد</span>
            <img src="{{ asset('images/send.svg') }}" />
          </a>
        </li>
      @endguest

      @auth
        <li style="display: flex; align-items: center; gap: 6px;">
          <!-- أيقونة المستخدم -->
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
               viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5.121 17.804A13.937 13.937 0 0112 15c2.489 0 4.824.672 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span>مرحبًا، {{ Auth::user()->getTranslation('name', 'ar') }}</span>
        </li>
        <li>
          <!-- أيقونة لوحة التحكم -->
          <a href="#" class="pbtn pbtn-light" style="display: inline-flex; align-items: center; gap: 4px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3h18v18H3V3z" />
            </svg>
            لوحة التحكم
          </a>
        </li>
        <li>
          <!-- أيقونة الإشعارات -->
          <a href="#" title="الإشعارات"
             style="display: inline-flex; align-items: center; padding: 6px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 17h5l-1.5-1.5a2 2 0 01-.5-1.4V11a6 6 0 00-12 0v3.1a2 2 0 01-.5 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1h6z" />
            </svg>
          </a>
        </li>
        <li>
          <!-- أيقونة تسجيل الخروج -->
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="pbtn pbtn-danger" style="display: inline-flex; align-items: center; gap: 4px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-8V7a3 3 0 00-6 0v1" />
              </svg>
              خروج
            </button>
          </form>
        </li>
      @endauth
    </ul>
  </nav>

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
      <div class="logo-wrapper">
        <img class="logo" src="{{ asset('images/logo.svg') }}" />
      </div>
    </div>

    <div id="mobile-menu" class="mobile-main">
      <ul>
        <li class="active"><a href="#">الرئيسية</a></li>
        <li><a href="#">أعلن عن احتياجك</a></li>
        <li><a href="#">المدربون</a></li>
        <li><a href="#">المساعدون</a></li>
        <li><a href="#">موارد معرفية</a></li>
        <li><a href="#">الباقات</a></li>

        @guest
          <li><a href="{{ route('login') }}" class="punderlined pbtn pbtn-light">تسجيل الدخول</a></li>
          <li><a href="{{ route('register-org') }}" class="pbtn pbtn-light ptext-center">إنشاء حساب مجانًا</a></li>
          <li>
            <a href="{{ route('homePage') }}" class="piconed pbtn pbtn-light">
              <span>للمدربين والأفراد</span>
              <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M18.9993 18.7532C18.9007 18.7535 18.8031 18.7343 18.7121 18.6965C18.6211 18.6587 18.5386 18.6032 18.4693 18.5332L4.46926 4.53319C4.32843 4.39263 4.24921 4.20188 4.24902 4.0029C4.24884 3.80392 4.3277 3.61302 4.46826 3.47219C4.60883 3.33136 4.79958 3.25214 4.99856 3.25195C5.19753 3.25177 5.38843 3.33063 5.52926 3.47119L19.5293 17.4712C19.6687 17.6123 19.747 17.8028 19.747 18.0012C19.747 18.1996 19.6687 18.3901 19.5293 18.5312C19.4601 18.6016 19.3776 18.6575 19.2866 18.6956C19.1956 18.7337 19.0979 18.7533 18.9993 18.7532Z"
                  fill="#003090" />
                <path
                  d="M5 15.02C4.80149 15.0187 4.61149 14.9393 4.47112 14.7989C4.33075 14.6585 4.25131 14.4685 4.25 14.27V4C4.25131 3.80149 4.33075 3.61149 4.47112 3.47112C4.61149 3.33075 4.80149 3.25131 5 3.25H15.27C15.4685 3.25131 15.6585 3.33075 15.7989 3.47112C15.9393 3.61149 16.0187 3.80149 16.02 4C16.0187 4.19851 15.9393 4.38851 15.7989 4.52888C15.6585 4.66925 15.4685 4.74869 
15.27 4.75H5.75V14.27C5.74869 14.4685 5.66925 14.6585 5.52888 14.7989C5.38851 14.9393 5.19851 15.0187 5 15.02Z"
                  fill="#003090" />
              </svg>
            </a>
          </li>
        @endguest

        @auth
          <li style="display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
              viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M5.121 17.804A13.937 13.937 0 0112 15c2.489 0 4.824.672 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span style="font-weight: 500;">مرحبًا، {{ Auth::user()->getTranslation('name', 'ar') }}</span>
          </li>
          <li>
            <a href="#" class="pbtn pbtn-light" style="display: inline-flex; align-items: center; gap: 4px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 3h18v18H3V3z" />
              </svg>
              لوحة التحكم
            </a>
          </li>
          <li>
            <a href="#" title="الإشعارات"
              style="display: inline-flex; align-items: center; padding: 6px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 17h5l-1.5-1.5a2 2 0 01-.5-1.4V11a6 6 0 00-12 0v3.1a2 2 0 01-.5 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1h6z" />
              </svg>
            </a>
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="pbtn pbtn-danger" style="display: inline-flex; align-items: center; gap: 4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-8V7a3 3 0 00-6 0v1" />
                </svg>
                خروج
              </button>
            </form>
          </li>
        @endauth
      </ul>

      <button id="mobile-menu-close-btn" class="mobile-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff" viewBox="0 0 256 256">
          <path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z" />
        </svg>
      </button>
    </div>
  </div>
</header>
 



<a href="https://api.whatsapp.com/send?phone=905314977081"
    target="_blank"
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
    <div class="container" style="max-width: 1350px;">
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
<button class="mobile-close-btn d-lg-none" onclick="document.getElementById('navbarMain').classList.remove('show')">
    ✕
</button>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item {{ request()->is('homePageOrganization') ? 'active' : '' }}">
                        <a class="nav-link pb-0" href="{{ route('homePageOrganization') }}" style="font-size:1.25rem">الرئيسية</a>
                    </li>
                    <li class="nav-item {{ request()->is('trainings*') ? 'active' : '' }}">
                        <a class="nav-link pb-0" href="{{ route('trainings_announcements') }}" style="font-size: 1.25rem">التدريبات</a>
                    </li>
                </ul>

                <!-- الروابط بحسب حالة تسجيل الدخول -->
                @auth
                    <ul class="navbar-nav align-items-center">
                        @if (in_array(auth()->user()->user_type_id, [4]))
                            <li class="nav-item me-2">
                                <a href="{{ route('training.create') }}" class="pbtn pbtn-main d-flex align-items-center">
                                    <img src="{{ asset('images/edit.svg') }}" class="me-1" />
                                    <span>إنشاء تدريب</span>
                                </a>
                            </li>
                        @endif

                        <!-- القائمة المنسدلة للملف الشخصي -->
                        <li class="nav-item dropdown">
<a class="nav-link dropdown-toggle d-flex align-items-center position-relative" href="#" id="navbarProfileDropdown"
    role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/icons/user.svg') }}"
        class="rounded-circle" width="52" height="52" />
    <span class="custom-arrow"></span>
</a>


                        <ul class="dropdown-menu dropdown-menu-end text-end user-menu" aria-labelledby="navbarProfileDropdown">

    <li class="user-menu-header">
        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/icons/user.svg') }}" alt="User Photo">
        <div class="user-info">
            <strong>{{ Auth::user()->getTranslation('name', 'ar') }}</strong>
            <small>{{ Auth::user()->email }}</small>
        </div>
    </li>

    <li><hr class="dropdown-divider"></li>

    @php
        $profileRoute = match(auth()->user()->user_type_id) {
            1 => route('show_trainer_profile'),
            2 => route('show_assistant_profile'),
            3 => route('show_trainee_profile'),
            default => '#'
        };
    @endphp

    <li>
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

    <li><hr class="dropdown-divider"></li>

    <li>
        <form class="p-0" method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
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
                        <li class="nav-item me-2">
                            <a href="{{ route('register') }}" class="pbtn pbtn-main">إنشاء حساب مجانًا</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('homePageOrganization') }}" class="piconed d-flex align-items-center">
                                <span class="me-1">للمؤسسات</span>
                                <img src="{{ asset('images/send.svg') }}" />
                            </a>
                        </li>
                    </ul>
                @endauth
            </div>
        </nav>
    </div>
</header>
<style>

  @media (max-width: 991.98px) {
    .navbar-nav .dropdown:hover .dropdown-menu {
        display: block !important;
        position: static;
        float: none;
    }

    .navbar-nav .dropdown-menu {
        border: none;
        box-shadow: none;
    }
}
@media (max-width: 991.98px) {
  /* اجعل القائمة المنسدلة تأخذ الشاشة كاملة */
  #navbarMain {
    background-color: white;
    position: fixed;
    top: 0;
    right: 0;
    width: 70%;
    height: 100vh;
    overflow-y: auto;
    padding: 1rem;
    z-index: 1050;
    transition: transform 0.3s ease-in-out;
  }

  .navbar-collapse.collapsing,
  .navbar-collapse.show {
    display: block !important;
  }

  .navbar-toggler {
    border: none;
  }

  /* إغلاق القائمة بزر */
  .mobile-close-btn {
    display: block;
    text-align: left;
    margin-bottom: 1rem;
    font-size: 1.2rem;
    font-weight: bold;
    color: #003090;
    background: none;
    border: none;
  }

  /* عناصر القائمة داخل الهاتف */
  #navbarMain .nav-link,
  #navbarMain .dropdown-item {
    font-size: 1.5rem !important;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #eee;
  }
  /* الأزرار مثل "إنشاء حساب" */
  #navbarMain .btn {
    width: 100%;
    margin: 0.5rem 0;
  }

  /* القائمة المنسدلة داخل الجوال */
  .navbar-nav .dropdown-menu {
    background-color: transparent;
    box-shadow: none;
    padding: 0;
  }

  .navbar-nav .dropdown-item {
    display: flex;
    align-items: center;
  }

  /* تصغير الشعار ليبدو أوضح في الجوال */
  .navbar-brand img {
    max-height: 40px;
  }
}
@media (max-width: 991.98px) {
  /* اجعل القائمة المنسدلة للملف الشخصي مفتوحة دائمًا */
  .navbar-nav .dropdown-menu {
    display: block !important; /* تظهر دائمًا */
    position: static !important; /* تجعلها ضمن التدفق الطبيعي */
    box-shadow: none !important;
    border: none !important;
    background: transparent !important;
    padding-left: 0 !important;
  }

  /* اجعل رابط الصورة الشخصية غير قابل للنقر (تعطيل الـ toggle) */
  .navbar-nav .dropdown-toggle {
    pointer-events: none;
  }

  /* ترتيب عناصر القائمة بشكل عمودي واضح */
  .navbar-nav .dropdown-item {
    padding: 0.5rem 1rem;
    border-bottom: 1px solid #eee;
  }
}

/* Header */

header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

header nav {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 80px;
}

header nav>ul {
    display: flex;
    flex-direction: row;
    list-style: none;
    gap: 48px;
    padding-inline-start: 0px;
    align-items: center;
}

header nav.auth-links>ul {
    gap: 24px;
}

header nav ul li {
    position: relative;
}

header nav ul>li.active::before {
    content: "";
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-image: url('data:image/svg+xml,<svg width="59" height="4" viewBox="0 0 59 5" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 3.99999C12.581 -0.435593 28.6857 0.46061 58 4" stroke="%23003090" stroke-width="2" stroke-linecap="round"/></svg>');
    background-repeat: no-repeat;
    background-size: contain;
    height: 10px;
    width: 100%;
}

header nav ul>li.active a {
    color: #003090;
}
@media (max-width: 991.98px) {
  header nav ul>li.active {
    position: relative; /* مهم جداً لتفعيل ::before */
  }

  header nav ul>li.active::before {
    content: "";
    position: absolute;
    bottom: -8px; /* بدل top: 100% لتظهر تحت النص */
    left: 0;
    right: 0;
    color: #003090;
    background-image: none;
    background-repeat: no-repeat;
    background-size: 59px 5px; /* الحجم المناسب */
    height: 5px;
    width: 59px;
    margin: 0 auto;
    left: 50%;
    transform: translateX(-50%);
  }

  header nav ul>li.active a {
    color: #003090;
    font-weight: 600;
  }


}

header nav img.logo {
    height: 33px;
    width: 23px;
    object-fit: contain;
    object-position: center;
}

header nav ul li a {
    font-family: IBM Plex Sans Arabic;
    font-weight: 400;
    font-size: 20px;
    line-height: 40px;
    letter-spacing: 0%;
    text-decoration: none;
    color: #333333;
    position: relative;
    word-wrap: break-word;
}

header nav ul li.menu>a::after {
    content: "";
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="%23000000" viewBox="0 0 256 256"><path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path></svg>');
    display: inline-block;
    width: 20px;
    height: 20px;
    background-size: contain;
    background-position: bottom;
    background-repeat: no-repeat;
    position: absolute;
    left: -24px;
    bottom: 5px;
    transition: all 0.2s ease-in-out;
}

header nav ul li.menu:hover>a::after {
    transform: rotate(180deg);
}

header nav ul li.menu ul.submenu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    width: 150px;
    box-shadow: 0px 10px 20px 0px #00000012;
    border-radius: 10px;
}

header nav ul li.menu ul.submenu li {
    border-bottom: 1px solid #00000012;
    padding: 0.5rem 1rem;
}

header nav ul li.menu:hover>ul.submenu {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

@media only screen and (max-width: 1200px) {
    header nav {
        display: none;
    }
}

@media only screen and (min-width: 1200px) {
    header div.mobile {
        display: none;
    }
}

header div.mobile {
    width: 100%;
}

header div.mobile .mobile-main {
    position: fixed;
    right: 0;
    top: 0;
    bottom: 0;
    width: 50%;
    background-color: #003090;
    padding: 24px;
    transform: translateX(100%);
    transition: all 0.2s ease-in-out;
    z-index: 999;
    box-sizing: border-box;
}

@media only screen and (max-width: 600px) {
    header div.mobile .mobile-main {
        width: 100%;
    }
}

header div.mobile div.mobile-main.opened {
    transform: translateX(0);
}

header div.mobile button.burger {
    background-color: #ffffff;
    border-color: #00000012;
    border-radius: 4px;
    cursor: pointer;
    vertical-align: middle;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0.5rem;
}

header div.mobile .mobile-header {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

header div.mobile .mobile-header .logo {
    width: 33px;
    height: 43px;
}

header div.mobile .mobile-header .leftside-wrapper {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 1rem;
}

header div.mobile .mobile-main ul {
    display: flex;
    flex-direction: column;
    align-items: start;
    gap: 24px;
    list-style: none;
    padding-inline-start: 0px;
}

header div.mobile .mobile-main ul li a {
    color: #ffffff;
}

header div.mobile ul li ul.submenu {
    margin-top: 1rem;
    padding-right: 1rem;
    gap: 12px;
}

header div.mobile ul>li {
    position: relative;
    width: 100%;
}

header div.mobile .mobile-main button.mobile-close {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: transparent;
    border: none;
    cursor: pointer;
}
.custom-arrow {
  position: absolute;
  bottom: 15px;              /* أسفل الصورة */
  left: 15px;                /* يسار الصورة */
  transform: translate(-30%, 50%); /* ضبط دقيق للموقع */
  width: 24px;
  height: 24px;
  background-color: #003090; /* أزرق */
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.dropdown-toggle::after{
    content: none;
}
.custom-arrow::before {
  content: '';
  display: block;
  width: 8px;
  height: 8px;
  border-right: 2px solid white;
  border-bottom: 2px solid white;
  transform: rotate(45deg);
}


/* تحسين شكل القائمة المنسدلة لصورة المستخدم */
.dropdown-menu.user-menu {
  padding: 0;
  min-width: 280px;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}

.user-menu-header {
  background-color: #D9E6FF;
  padding: 12px 16px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-menu-header img {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
}

.user-menu-header .user-info {
  display: flex;
  flex-direction: column;
}

.user-menu-header .user-info strong {
  font-size: 16px;
  color: #000000;
  text-align: right
}

.user-menu-header .user-info small {
  color: #666;
  font-size: 13px;
}

/* عناصر القائمة */
.user-menu .dropdown-item {
  font-size: 1rem;

  color: #333;
  display: flex;
  align-items: center;
  gap: 8px;
}

.user-menu .dropdown-item img {
  width: 18px;
  height: 18px;
}

/* خط الفاصل */
.user-menu .dropdown-divider {
  margin: 0;
}

/* تسجيل الخروج */
.user-menu .dropdown-item.text-danger {

  font-size: 13px;
  font-weight: 500;
}

</style>
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
<div class="site-container">