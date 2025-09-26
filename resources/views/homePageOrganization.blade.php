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
اعثر على أفضل المدربين… وأدِر برامجك التدريبية باحترافية مع                <span
                  class="text-underlined text-top right"
                  style="color: var(--color-primary)"
                >
                  TrainingP
                </span>
              </p>
            </div>
            <div class="desc">

مع Training P، لا تحتاج لإجراءات معقدة أو أدوات متفرقة. منصتنا تتيح لك إنشاء تدريبات منفصلة أو مسارات تدريبية متكاملة، مع أتمتة كاملة لعملية التسجيل والحضور، وصفحات تعريف احترافية تسهّل على المشاركين معرفة كل التفاصيل. كل ذلك في واجهة استخدام سلسة وبسيطة مصممة لتجعل التدريب أكثر فعالية وأقل عبئًا.            </div>
            <div class="action">
              <a href="{{ route('register-org') }}" class="pbtn pbtn-main">
                سجل كمؤسسة مجانًا، وابدأ الآن
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
              <div class="title">أتمتة كاملة للتسجيل</div>
              <div class="desc">
استقبل طلبات المشاركة تلقائيًا دون الحاجة لاستمارات منفصلة أو متابعة يدوية.
              </div>
            </div>
            <div class="pfeature-item-line-horizontal"></div>
            <div class="pfeature-item-line-vertical"></div>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">02</div>
            <div class="pfeature-item-col2">
              <div class="title">تسجيل حضور المتدربين بسهولة</div>
              <div class="desc">
تابع حضور المشاركين بدقة عبر المنصة دون الحاجة للورقيات أو الجداول المبعثرة.
              </div>
            </div>
            <div class="pfeature-item-line-horizontal"></div>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">03</div>
            <div class="pfeature-item-col2">
              <div class="title">صفحات تعريف احترافية للبرامج التدريبية
</div>
              <div class="desc">
لكل تدريب أو مسار تدريبي صفحة خاصة تضم جميع المعلومات التي يحتاجها المشاركون قبل الانضمام.              </div>
            </div>
            <div class="pfeature-item-line-vertical center"></div>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">04</div>
            <div class="pfeature-item-col2">
              <div class="title">واجهة استخدام سلسة</div>
              <div class="desc">
بنية مصممة بتجربة مستخدم بسيطة وسريعة، تضمن لك وفريقك سهولة في إدارة البرامج التدريبية.
              </div>
            </div>
            <div class="pfeature-item-line-vertical top"></div>
          </div>
          <div class="pfeature-item">
            <div class="pfeature-item-col1">05</div>
            <div class="pfeature-item-col2">
              <div class="title">معرفة الاحتياجات التدريبية مسبقًا</div>
              <div class="desc">
عبر لوحة معلومات تفاعلية، يمكنك التعرف على مجالات الاهتمام والتطوير المهني لدى المتدربين في المنصة.
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="pfeatured small">
        <div class="pfeatured-content">
          <div class="title">
ودّع العمل اليدوي والفوضى، وابدأ إدارة تدريبية مؤتمتة واحترافية.
          </div>
        </div>
      </div>
      <section class="companies-features-section">
        <div class="title mt-5">
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
            <div class="desc">إنشاء وإدارة تدريبات منفصلة أو مسارات تدريبية متكاملة.</div>
          </div>
          <div class="company-feature-item">
            <img src="../images/company-features/2.svg" />
            <div class="desc">أتمتة التسجيل والمتابعة دون جهد إداري إضافي.</div>
          </div>
          <div class="company-feature-item">
            <img src="../images/company-features/3.svg" />
            <div class="desc" style="text-align: right; line-height: 30px">
              <p>صفحات تعريف جاهزة تعكس احترافية برامجك التدريبية.</p>
              
            </div>
          </div>
          <div class="company-feature-item">
            <img src="../images/company-features/4.svg" />
            <div class="desc">
قاعدة بيانات لأفضل المدربين المحترفين في المنطقة العربية.            </div>
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
            <div class="title">سجّل مؤسستك مجانًا خلال دقيقتين.</div>
            <div class="index">01</div>
          </div>
          <div class="start-item">
            <img src="../images/how-to-start/2.svg" />
            <div class="title">
أنشئ تدريبًا أو مسارًا تدريبيًا وحدد تفاصيله.</div>
            <div class="index">02</div>
          </div>
          <div class="start-item">
            <img src="../images/how-to-start/3.svg" />
            <div class="title">
دع المنصة تهتم بالتسجيل والمتابعة بينما تركز أنت على جودة التدريب.
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
                                    وحوّل فوضى التدريبات إلى تجربة سلسة ومؤتمتة بالكامل.

                                </div>
                                <a href="{{ route('register-org') }}" class="pbtn pbtn-light top-white">
                                    ابدأ الآن مجانًا
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



