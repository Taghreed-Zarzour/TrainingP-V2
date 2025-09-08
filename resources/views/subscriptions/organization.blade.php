@extends('frontend.layouts.master')
@section('title', 'باقات المؤسسات')
@section('content')

<!-- Blue Header Section -->
<div class="blue-header full-width-header mt-4">
    <div class="container d-flex justify-content-center">
        <div class="col-12 col-lg-7 text-center">
            <div class="title-wrapper">
                <h1 class="d-inline-block lh-base">
                    الباقات
                </h1>
            </div>
            <div class="mb-4">
                الرئيسية / الباقات
            </div>
        </div>
    </div>
</div>
<!-- Trust Bar Section -->
<div class="container">
    <div class="baqat-trust-container">
        <div class="baqat-trust-images">
            <img src="{{ asset('images/icons/user.svg') }}" class="baqat-trainer-img" style="z-index: 4; right: 0px;">
            <img src="{{ asset('images/icons/user.svg') }}" class="baqat-trainer-img" style="z-index: 3; right: 20px;">
            <img src="{{ asset('images/icons/user.svg') }}" class="baqat-trainer-img" style="z-index: 2; right: 40px;">
            <img src="{{ asset('images/icons/user.svg') }}" class="baqat-trainer-img" style="z-index: 1; right: 60px;">
        </div>
        <div class="baqat-trust-bubble">
            <div class="baqat-trust-text">
                موثوق به من قبل أكثر من 700 مدرب و مؤسسة تدريبية
            </div>
        </div>
    </div>
</div>
<!-- Pricing Section -->
<div class="container pb-5 ">
    <div class="row justify-content-center">
        
        <!-- الخطة المجانية -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card baqat-pricing-card baqat-card-free">
                <div class="baqat-card-header-custom">
                    <h3 class="baqat-plan-title">الخطة المجانية</h3>
                    <p class="baqat-plan-description">للمؤسسات غير التدريبية
                      <br>
                      استخدم الأدوات الأساسية في إدارة برامجك التدريبية.
                </div>
                
                <div class="baqat-price-section">
                    <!-- مساحة فارغة لتحقيق المحاذاة -->
                    <div style="height: 100px;"></div>
                </div>
                
                <div class="baqat-btn-container">
                    <button class="baqat-btn-plan baqat-btn-free">خطتك الحالية</button>
                </div>
                
                <div class="baqat-features-container">
                    <ul class="list-unstyled">
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-free.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">نشر عدد غير محدود من التدريبات المدفوعة والمجانية</span>
                        </li>
                                                <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-free.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">نشر عدد غير محدود من المسارات التدريبية المدفوعة والمجانية</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-free.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">لوحة تحكم سهلة الاستخدام</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-free.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">تسجيل حضور المتدربين في كل جلسة</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-free.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">استخدام ميزة التسجيل في التدريب داخل المنصة</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-free.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">استخراج بيانات المتدربين في جدول اكسل</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- خطة الإعلانات -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card baqat-pricing-card baqat-card-ads">
                <div class="baqat-card-header-custom">
                    <h3 class="baqat-plan-title">خطة الإعلانات</h3>
                    <p class="baqat-plan-description">للمؤسسات التدريبية الراغبية في الوصول إلى أكبر عدد من المتدربين وزيادة فرص الظهور.</p>
                </div>
                
                <div class="baqat-price-section">
                    <div class="baqat-original-price">
                        <span class="baqat-strikethrough">50 دولار</span> أمريكي
                    </div>
                    <div class="baqat-discount-price">19.99 دولار أمريكي</div>
                    <div class="baqat-price-details">
                        <div class="baqat-per-training">/تدريب</div>
                        <div class="baqat-discount-badge">خصم 100٪ للتدريب الخامس</div>
                    </div>
                </div>
                
                <div class="baqat-btn-container">
                    <button class="baqat-btn-plan baqat-btn-ads" data-bs-toggle="modal" data-bs-target="#interestModal">
                        <img src="{{ asset('images/icons/Premium.svg') }}" alt="Premium Icon" class="baqat-premium-icon me-2" />
                        أنا مهتم
                    </button>
                </div>
                
                <div class="baqat-features-container">
                    <ul class="list-unstyled">
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan1.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">إرسال إشعارات بريدية للمهتمين عند نشر إعلانك.</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan1.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">أولوية ظهور الإعلانات في قسم "التدريبات الموصى بها".</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan1.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">إمكانية تتبع أداء الإعلان (عدد المشاهدات والنقرات).</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan1.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">دعم فني مخصص لحملات الإعلانات.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- الخطة المدفوعة -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card baqat-pricing-card baqat-card-paid">
                <div class="baqat-card-header-custom">
                    <h3 class="baqat-plan-title">الخطة المدفوعة</h3>
                    <p class="baqat-plan-description">افتح كل الإمكانيات المتقدمة للمنصة
                      <br>
                      استمتع بكامل الأدوات الاحترافية لإدارة تدريبك بكفاءة عالية</p>
                </div>
                 
                <div class="baqat-price-section">
                    <div class="baqat-original-price">
                        <span class="baqat-strikethrough">100 دولار</span> أمريكي
                    </div>
                    <div class="baqat-discount-price">34.99 دولار أمريكي</div>
                    <div class="baqat-price-details">
                        <div class="baqat-per-training">/تدريب</div>
                        <div class="baqat-discount-badge">خصم 100٪ للتدريب الخامس</div>
                    </div>
                </div>
                
                <div class="baqat-btn-container">
                    <button class="baqat-btn-plan baqat-btn-paid" data-bs-toggle="modal" data-bs-target="#interestModal">
                        <img src="{{ asset('images/icons/Premium.svg') }}" alt="Premium Icon" class="baqat-premium-icon me-2" />
                        أنا مهتم
                    </button> 
                </div>
                
                <div class="baqat-features-container">
                    <ul class="list-unstyled">
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan2.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">الوصول إلى إحصائيات ورؤى حول المتدربين تدعم اتخاذ القرار</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan2.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">تفعيل الرسائل التلقائية (تذكيرات قبل كل جلسة)</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan2.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">ربط Zoom أو Google Meet وإنشاء الجلسات مباشرة.</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan2.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">توليد الاختبارات والأجندة والتقرير مع تعديل يدوي.</span>
                        </li>
                        <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan2.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">الوصول إلى قاعدة بيانات المدربين.
                              </span>
                        </li>
                              <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan2.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">الوصول إلى قاعدة بيانات الميسرين/مساعدي المدربين.</span>
                        </li>
                                                <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan2.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">دعم فني 24/7.</span>
                        </li>
                                                          <li class="baqat-feature-item">
                            <img src="{{ asset('images/icons/done-plan2.svg') }}" alt="" class="baqat-check-icon" />
                            <span class="baqat-feature-text">والمزيد...</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal اهتمام بالباقة -->
<div class="modal fade" id="interestModal" tabindex="-1" aria-labelledby="interestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header border-0 position-relative justify-content-end pb-3">
                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <img src="{{ asset('/images/general/subscribe.svg') }}" />
                <h5 class="modal-title fw-bold mb-3" id="interestModalLabel">شكرًا لاختيارك هذه الباقة!</h5>
                <p class="text-muted mb-4">
                    لا تتوفر هذه الباقة الآن، لكن قمنا الآن بتسجيل طلب اهتمامك، وسنراسلك من أجل التعرف أكثر على تطلعاتك حول الميزات التي تتضمنها الباقة.
                </p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <button type="button" class="custom-btn w-100" data-bs-dismiss="modal">حسنا</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- No hover effects - static cards -->
@endsection