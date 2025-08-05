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
 
