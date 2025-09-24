@extends('frontend.layouts.master')


@section('title', 'الرئيسية')

@section('css')
@endsection

@section('content')


    <main class="companies">
      <section class="intro-section">
        <div class="grid">
          <div class="content">
            <div class="title">
              <p>
                اعثر على أفضل المدربين والمستشارين بكل سهولة في منصتك المهنية مع
                <span
                  class="text-underlined text-top right"
                  style="color: var(--color-primary)"
                >
                  TrainingP
                </span>
              </p>
            </div>
            <div class="desc">
              منصة TrainingP تتيح للمؤسسات الوصول السريع إلى شبكة واسعة من
              المدربين المحترفين، مع إمكانية نشر المناقصات واحتياجات المدربين
              والميسرين وحتى إعلانات التدريبات - كل ذلك في مكان واحد وبدون عناء
              البحث المتفرق.
            </div>
            <div class="action">
              <a href="{{ route('register-org') }}" class="pbtn pbtn-main">
                سجّل مؤسستك الآن وابدأ برصيد 100$
              </a>
            </div>
          </div>
        </div>
      </section>
      <section class="features-section">
        <div class="grid">
          <div class="title">
            <p>
              لماذا
              <span class="text-underlined" style="color: var(--color-primary)">
                TrainingP؟
              </span>
            </p>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">01</div>
            <div class="pfeature-item-col2">
              <div class="title">نشر الفرص في منصات عامة؟</div>
              <div class="desc">
                أعلن احتياجك واضمن وصوله إلى شبكة واسعة متخصصة من المدربين
                والمستشارين والمرشدين.
              </div>
            </div>
            <div class="pfeature-item-line-horizontal"></div>
            <div class="pfeature-item-line-vertical"></div>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">02</div>
            <div class="pfeature-item-col2">
              <div class="title">كثرة المتقدمين دون ملفات احترافية؟</div>
              <div class="desc">
                ملفات المدربين في TrainingP تعرض الخبرات التدريبية والاستشارية
                والعملية والشهادات باحتراف وتميُّز.
              </div>
            </div>
            <div class="pfeature-item-line-horizontal"></div>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">03</div>
            <div class="pfeature-item-col2">
              <div class="title">صعوبة الوصول إلى خبرات متخصصة؟</div>
              <div class="desc">
                تصفّح المدربين والمستشارين حسب الموضوعات الدقيقة والتخصصات
                النادرة بسهولة.
              </div>
            </div>
            <div class="pfeature-item-line-vertical center"></div>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">04</div>
            <div class="pfeature-item-col2">
              <div class="title">لا وقت للانتظار؟</div>
              <div class="desc">
                ابحث فورًا في بنك المدربين واختر من بين أفضل الكفاءات دون إعلان
                مسبق.
              </div>
            </div>
            <div class="pfeature-item-line-vertical top"></div>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">05</div>
            <div class="pfeature-item-col2">
              <div class="title">وعود منمقة ومعلومات مضللة؟</div>
              <div class="desc">
                تقدّم TrainingP ملفات موثقة ومؤشرات واضحة لخبرات المدرب، تساعدكم
                على التحقق قبل اتخاذ القرار.
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="pfeatured small">
        <div class="pfeatured-content">
          <div class="title">
            في منصتكم TrainingP، نوفر لكم الوقت، ونرفع جودة الاختيار، ونسهّل
            الوصول إلى الكفاءات التي يصعب العثور عليها
          </div>
        </div>
      </div>
      <section class="companies-features-section">
        <div class="title">
          <p>
            ماذا تقدم TrainingP
            <span class="text-underlined" style="color: var(--color-primary)">
              للمؤسسات؟
            </span>
          </p>
        </div>
        <div class="grid">
          <div class="company-feature-item">
            <img src="../images/company-features/1.svg" />
            <div class="desc">بروفايلات مدربين احترافية مع تفاصيل كاملة</div>
          </div>
          <div class="company-feature-item">
            <img src="../images/company-features/2.svg" />
            <div class="desc">بحث متقدم بأكثر من 20 معيار</div>
          </div>
          <div class="company-feature-item">
            <img src="../images/company-features/3.svg" />
            <div class="desc" style="text-align: right; line-height: 30px">
              <p>إمكانية نشر:</p>
              <ul>
                <li>وظائف مدربين وميسرين</li>
                <li>مناقصات تدريبية</li>
                <li>إعلانات تدريبات مفتوحة للمتدربين</li>
              </ul>
            </div>
          </div>
          <div class="company-feature-item">
            <img src="../images/company-features/4.svg" />
            <div class="desc">
              رصيد مجاني بقيمة 50$ لاستخدامه في الاشتراك ونشر الإعلانات
            </div>
          </div>
        </div>
      </section>
      <section class="start-section">
        <div class="title">
          <p>
            كيف
            <span class="text-underlined" style="color: var(--color-primary)">
              تبدأ؟
            </span>
          </p>
        </div>
        <div class="grid">
          <div class="start-item">
            <img src="../images/how-to-start/1.svg" />
            <div class="title">سجّل مؤسستك مجانًا خلال دقيقتين</div>
            <div class="index">01</div>
          </div>
          <div class="start-item">
            <img src="../images/how-to-start/2.svg" />
            <div class="title">
              ابدأ بنشر الوظائف والمناقصات التدريبية أو ابدأ البحث عن المدربين
            </div>
            <div class="index">02</div>
          </div>
          <div class="start-item">
            <img src="../images/how-to-start/3.svg" />
            <div class="title">
              تواصل مع الكفاءات المناسبة مباشرة عبر وسائل الاتصال.
            </div>
            <div class="index">03</div>
          </div>
        </div>
      </section>
      <section class="reviews-section" style="display: none;">
        <div class="title-wrapper">
          <div class="title">
            شهادات
            <div class="text-underlined" style="color: var(--color-primary)">
              مبكرة
            </div>
          </div>
          <div class="swiper-actions">
            <button class="prev pbtn pbtn-outlined">
              <img src="../images/reviews/prev.svg" />
            </button>
            <button class="next pbtn pbtn-main">
              <img src="../images/reviews/next.svg" />
            </button>
          </div>
        </div>
        <div class="reviews-wrapper swiper">
          <div class="swiper-content">
            <div class="swiper-slide">
              <div class="review-item">
                <div class="review-item-top">
                  <div class="review-item-person">
                    <img src="../images/reviews/1.jpg" />
                    <div class="review-item-person-content">
                      <div class="review-item-person-name">
                        أحمد راشد الحافظ
                      </div>
                      <div class="review-item-person-position">مدرب</div>
                    </div>
                  </div>
                  <div class="review-item-icon">
                    <img src="../images/reviews/icon.svg" />
                  </div>
                </div>
                <div class="review-item-bottom">
                  أخيرًا منصة تحترم وقتي كمدرب وتفتح لي أبواب جديدة بدون تعقيد.
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="review-item">
                <div class="review-item-top">
                  <div class="review-item-person">
                    <img src="../images/reviews/2.jpg" />
                    <div class="review-item-person-content">
                      <div class="review-item-person-name">
                        أحمد راشد الحافظ
                      </div>
                      <div class="review-item-person-position">مدرب</div>
                    </div>
                  </div>
                  <div class="review-item-icon">
                    <img src="../images/reviews/icon.svg" />
                  </div>
                </div>
                <div class="review-item-bottom">
                  أخيرًا منصة تحترم وقتي كمدرب وتفتح لي أبواب جديدة بدون تعقيد.
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="review-item">
                <div class="review-item-top">
                  <div class="review-item-person">
                    <img src="../images/reviews/2.jpg" />
                    <div class="review-item-person-content">
                      <div class="review-item-person-name">
                        أحمد راشد الحافظ
                      </div>
                      <div class="review-item-person-position">مدرب</div>
                    </div>
                  </div>
                  <div class="review-item-icon">
                    <img src="../images/reviews/icon.svg" />
                  </div>
                </div>
                <div class="review-item-bottom">
                  أخيرًا منصة تحترم وقتي كمدرب وتفتح لي أبواب جديدة بدون تعقيد.
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="review-item">
                <div class="review-item-top">
                  <div class="review-item-person">
                    <img src="../images/reviews/1.jpg" />
                    <div class="review-item-person-content">
                      <div class="review-item-person-name">
                        أحمد راشد الحافظ
                      </div>
                      <div class="review-item-person-position">مدرب</div>
                    </div>
                  </div>
                  <div class="review-item-icon">
                    <img src="../images/reviews/icon.svg" />
                  </div>
                </div>
                <div class="review-item-bottom">
                  أخيرًا منصة تحترم وقتي كمدرب وتفتح لي أبواب جديدة بدون تعقيد.
                </div>
              </div>
            </div>
          </div>

          <div class="swiper-bullets">
            <div class="bullet active"></div>
            <div class="bullet"></div>
          </div>
        </div>

      </section>

          <div class="pfeatured style2 mb-5">
                    <div class="pfeatured-content">
                        <div class="grid">
                            <div class="col">
                                <img src="./images/featured-box-right.svg" />
                            </div>
                            <div class="col">
                                <div class="subtitle">
                                    سجّل مؤسستك اليوم
                                </div>
                                <div class="title">
                                    وابدأ رحلتك نحو نجاح تدريبي أسرع وأكثر
                  احترافية.
                                </div>
                                <a href="{{ route('register-org') }}" class="pbtn pbtn-light top-white">
                                    تسجيل المؤسسة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
    </main>


@endsection


{{-- تضمين ملفات حافا سكريبت جديدة JS --}}
@section('scripts')
    <script src="{{ asset('js/main.js') }} "></script>

@endsection



