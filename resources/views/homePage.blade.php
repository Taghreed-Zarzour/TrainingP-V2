@extends('frontend.layouts.master')


@section('title', 'الرئيسية')

@section('css')
@endsection

@section('content')

        <main>

                                <!-- زر فتح المودال -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
    أرسل مراجعتك
</button>

<!-- مودال إرسال مراجعة -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('feedback.store') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="reviewModalLabel">أرسل مراجعتك</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
          </div>
          <div class="modal-body">
            <textarea name="content" class="form-control" rows="4" placeholder="اكتب رأيك هنا..." required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="submit" class="btn btn-success">إرسال</button>
          </div>
        </form>
      </div>
    </div>
  </div> --}}

            <section class="intro-section">
                <div class="grid">
                    <div class="content">
                        <div class="title">
                            طوّر مسيرتك التدريبية ووسّع
                            <div class="text-top me-3">فرصك</div>
                            
                            المهنية مع
                            <div
                                class="text-underlined"
                                style="color: var(--color-primary)"
                            >
                                TrainingP
                            </div>
                        </div>

                        <div class="desc">
                            منظومة متكاملة تجمع المدربين، والمتدربين، والمساعدين
                            والمؤسسات في منصة احترافية واحدة — انطلق اليوم نحو
                            فرص أفضل ودخل أكبر.
                        </div>
                    </div>
                    <div class="advertisement">
                        <div class="grid">
                            <div class="pcard register-ex-screen">
                                <div class="register-ex-screen-header">
                                    <div class="title">سجل مجانًا الآن</div>
                                    <div>
                                        <svg
                                            width="39"
                                            height="12"
                                            viewBox="0 0 39 12"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <circle
                                                cx="5.6078"
                                                cy="5.20833"
                                                r="5"
                                                transform="rotate(2.44 5.6078 5.20833)"
                                                fill="#F55157"
                                            />
                                            <circle
                                                cx="19.5951"
                                                cy="5.80452"
                                                r="5"
                                                transform="rotate(2.44 19.5951 5.80452)"
                                                fill="#FFC62A"
                                            />
                                            <circle
                                                cx="33.5824"
                                                cy="6.40023"
                                                r="5"
                                                transform="rotate(2.44 33.5824 6.40023)"
                                                fill="#00AF6C"
                                            />
                                        </svg>
                                    </div>
                                </div>
                                <div class="links">
                                    <a class="pbtn pbtn-main" href="{{ route('register') }}?user_type=3"
                                        >انضم كمتدرب</a
                                    >
                                    <a class="pbtn pbtn-success" href="{{ route('register') }}?user_type=2"
                                        >انضم كخبير دعم</a
                                    >
                                </div>
                            </div>
                            <div class="offer-wrapper">
                                <div class="offer pcard">
                                    <div class="title">
                                        ابدأ الآن… وأعلن عن تدريبك خلال دقائق.
                                    </div>
                                    <div>
                                        <a class="pbtn pbtn-secondary" href="{{ route('register') }}?user_type=1"
                                            >سجّل كمدرب</a
                                        >
                                    </div>
                                </div>
                                <div class="change-future pcard">
                                    <div class="title">
                                        ضاعف دخلك اليوم مع
                                    </div>
                                    <div>
                                        <img src={{ url('images/logos/logo.svg') }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="why-us-section">
                <div class="title">
                    لماذا
                    <div
                        class="text-underlined"
                        style="color: var(--color-primary)"
                    >
                        TrainingP؟
                    </div>
                </div>
                <div class="grid">
                    <div class="why-item">
                        <div class="why-item-top">

                            <img  src="./images/why-items/1.svg" />
                        </div>
                        <div class="why-item-content">
                            <div class="title">
                                أفكارك كثيرة ولا تعرف من أين تبدأ؟
                            </div>
                            <div class="desc">منصتنا مخصصة للتدريب، ترتب لك أفكارك وتساعدك على البدء بإعلان تدريبك خلال دقائق.</div>
                        </div>
                    </div>
                    <div class="why-item reverse">
                        <div class="why-item-content">
                            <div class="title">
                                تبحث عن مصادر دخل إضافية؟
                            </div>
                            <div class="desc">
                                أنشئ تدريبك في المنصة وابدأ بتحقيق دخل إضافي مستقل.
                            </div>
                        </div>
                        <div class="why-item-top">
                            <img src="./images/why-items/2.svg" />
                        </div>
                    </div>
                    <div class="why-item">
                        <div class="why-item-top">
                            <img src="./images/why-items/3.svg" />
                        </div>
                        <div class="why-item-content">
                            <div class="title">ترهقك الطلبات الإدارية كالتقارير وغيرها؟</div>
                            <div class="desc">
                                المنصة توفر لك أدوات ذكية تريحك من العبء الإداري وتختصر وقتك.
                            </div>
                        </div>
                    </div>
                    <div class="why-item reverse">
                        <div class="why-item-content">
                            <div class="title">تجد صعوبة في الوصول لمتدربين مهتمين؟</div>
                            <div class="desc">
                                نظام ذكي يطابق مواضيع التدريب مع اهتمامات المتدربين وأوقاتهم المناسبة ويعرض إعلانك لهم مباشرة.
                            </div>
                        </div>
                        <div class="why-item-top">
                            <img src="./images/why-items/4.svg" />
                        </div>
                    </div>
                </div>
                <div class="pfeatured">
                    <div class="pfeatured-content">
                        <div class="title">
                            مع TrainingP، نمنحك الأدوات اللازمة للتركيز على عملك
                            الحقيقي
                        </div>
                        <div class="desc">
                            <span class="text-top text-top-white">التدريب</span>
                        </div>
                        <img src="./images/featured-box-right.svg" />
                    </div>
                </div>
            </section>
            <section class="features-section">
                <div class="grid">
                    <div class="title">
                        ماذا ستحصل عليه عند
                        <div
                            class="text-underlined"
                            style="color: var(--color-primary)"
                        >
                            تسجيلك؟
                        </div>
                    </div>
                    <div class="pfeature-item">
                        <div class="pfeature-item-col1">01</div>
                        <div class="pfeature-item-col2">
ملف مدرب يُظهر معلوماتك، وخدماتك، وتدريباتك المنشورة                        </div>
                        <div class="pfeature-item-line-horizontal"></div>
                        <div class="pfeature-item-line-vertical"></div>
                    </div>
                    <div class="pfeature-item">
                        <div class="pfeature-item-col1">02</div>
                        <div class="pfeature-item-col2">
 فرصة لنشر تدريباتك المدفوعة والوصول لمتدربين جدد                        </div>
                        <div class="pfeature-item-line-horizontal"></div>
                    </div>
                    <div class="pfeature-item">
                        <div class="pfeature-item-col1">03</div>
                        <div class="pfeature-item-col2">
                            لوحة تحكم لإدارة جلسات التدريب، والمتدربين، والحضور، وتفاصيل التدريب بسهولة
                        </div>
                        <div class="pfeature-item-line-vertical center"></div>
                    </div>
                    <div class="pfeature-item">
                        <div class="pfeature-item-col1">04</div>
                        <div class="pfeature-item-col2">
نظام تقييمات من المتدربين يُعرض في ملفك التدريبي لتعزيز مصداقيتك                        </div>
                        <div class="pfeature-item-line-vertical top"></div>
                    </div>
                    <div class="pfeature-item">
                        <div class="pfeature-item-col1">05</div>
                        <div class="pfeature-item-col2">
أدوات تولّد لك جداول الحضور، والأجندة، وتقرير التدريب                        </div>
                    </div>
                </div>
            </section>
            <section class="steps-section">
                <div class="title">
                    خطوات بسيطة
                    <div
                        class="text-underlined"
                        style="color: var(--color-primary)"
                    >
                        للانطلاق
                    </div>
                </div>
                <div class="grid">
                    <div class="steps-wrapper">
                        <div class="step-item">
                            <div class="step-item-top">
                                <div class="step-item-icon">
                                    <img src="./images/steps/1.svg" />
                                </div>
                                <div class="step-item-text">01</div>
                            </div>
                            <div class="step-item-bottom">
                                سجّل حسابك مجانًا
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-item-top">
                                <div class="step-item-icon">
                                    <img src="./images/steps/2.svg" />
                                </div>
                                <div class="step-item-text">02</div>
                            </div>
                            <div class="step-item-bottom">
                                أنشئ ملفك التدريبي.
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-item-top">
                                <div class="step-item-icon">
                                    <img src="./images/steps/3.svg" />
                                </div>
                                <div class="step-item-text">03</div>
                            </div>
                            <div class="step-item-bottom">
                                أنشئ تدريباتك الخاصة وابدأ بتحقيق دخل إضافي
                            </div>
                        </div>
                    </div>
                    <div class="steps-icons">
                        <div class="steps-icon">
                            <img src="./images/steps/icons/1.svg" />
                        </div>
                        <div class="steps-icon">
                            <img src="./images/steps/icons/2.svg" />
                        </div>
                    </div>
                </div>
            </section>
            <section class="reviews-section" style="display: none;">
                <div class="title-wrapper">
                    <div class="title">
                        شهادات
                        <div
                            class="text-underlined"
                            style="color: var(--color-primary)"
                        >
                            مبكرة
                        </div>
                    </div>
                    <div class="swiper-actions">
                        <button class="prev pbtn pbtn-outlined">
                            <img src="./images/reviews/prev.svg" />
                        </button>
                        <button class="next pbtn pbtn-main">
                            <img src="./images/reviews/next.svg" />
                        </button>
                    </div>
                </div>
                <div class="reviews-wrapper swiper">
                    <div class="swiper-content">
                        <div class="swiper-slide">
                            <div class="review-item">
                                <div class="review-item-top">
                                    <div class="review-item-person">
                                        <img src="./images/reviews/1.jpg" />
                                        <div class="review-item-person-content">
                                            <div
                                                class="review-item-person-name"
                                            >
                                                أحمد راشد الحافظ
                                            </div>
                                            <div
                                                class="review-item-person-position"
                                            >
                                                مدرب
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-item-icon">
                                        <img src="./images/reviews/icon.svg" />
                                    </div>
                                </div>
                                <div class="review-item-bottom">
                                    أخيرًا منصة تحترم وقتي كمدرب وتفتح لي أبواب
                                    جديدة بدون تعقيد.
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="review-item">
                                <div class="review-item-top">
                                    <div class="review-item-person">
                                        <img src="./images/reviews/2.jpg" />
                                        <div class="review-item-person-content">
                                            <div
                                                class="review-item-person-name"
                                            >
                                                أحمد راشد الحافظ
                                            </div>
                                            <div
                                                class="review-item-person-position"
                                            >
                                                مدرب
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-item-icon">
                                        <img src="./images/reviews/icon.svg" />
                                    </div>
                                </div>
                                <div class="review-item-bottom">
                                    أخيرًا منصة تحترم وقتي كمدرب وتفتح لي أبواب
                                    جديدة بدون تعقيد.
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="review-item">
                                <div class="review-item-top">
                                    <div class="review-item-person">
                                        <img src="./images/reviews/2.jpg" />
                                        <div class="review-item-person-content">
                                            <div
                                                class="review-item-person-name"
                                            >
                                                أحمد راشد الحافظ
                                            </div>
                                            <div
                                                class="review-item-person-position"
                                            >
                                                مدرب
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-item-icon">
                                        <img src="./images/reviews/icon.svg" />
                                    </div>
                                </div>
                                <div class="review-item-bottom">
                                    أخيرًا منصة تحترم وقتي كمدرب وتفتح لي أبواب
                                    جديدة بدون تعقيد.
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="review-item">
                                <div class="review-item-top">
                                    <div class="review-item-person">
                                        <img src="./images/reviews/1.jpg" />
                                        <div class="review-item-person-content">
                                            <div
                                                class="review-item-person-name"
                                            >
                                                أحمد راشد الحافظ
                                            </div>
                                            <div
                                                class="review-item-person-position"
                                            >
                                                مدرب
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-item-icon">
                                        <img src="./images/reviews/icon.svg" />
                                    </div>
                                </div>
                                <div class="review-item-bottom">
                                    أخيرًا منصة تحترم وقتي كمدرب وتفتح لي أبواب
                                    جديدة بدون تعقيد.
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
                                    مستقبلك التدريبي يبدأ هنا.
                                </div>
                                <div class="title">
                                    فرص أكثر، ظهور أكبر، تواصل أسرع وكل ذلك عبر
                                    TrainingP.
                                </div>
                                <a href="{{ route('register') }}" class="pbtn pbtn-light top-white">
                                    سجّل الآن مجانًا
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



