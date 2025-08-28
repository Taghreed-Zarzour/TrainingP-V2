@extends('frontend.layouts.master')
@section('title', 'سياسة الخصوصية')
@section('content')
<style>
    .content .header-top {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #003090;
    }
    
    /* العناوين داخل المحتوى */
    .content .header {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 25px;
        margin-bottom: 10px;
        color: #003090;
    }
    /* النصوص العادية */
    .content p {
        font-size: 1.3rem;
        text-align: justify;
        direction: rtl;
        margin-bottom: 15px;
        color: #000;
    }
    /* دعم النص الإنجليزي داخل العربي */
    .content p,
    .content .header {
        unicode-bidi: plaintext;
    }
    /* التعداد النقطي */
    .content ul {
        text-align: right;
        direction: rtl;
        padding-right: 20px;
        list-style-type: none;
    }
    .content ul li {
        position: relative;
        padding-right: 25px;
        margin-bottom: 10px;
        font-size: 1.3rem;
        text-align: justify;
        color: #000;
    }
    .content ul li:before {
        content: "•";
        color: #000;
        font-size: 1.5rem;
        position: absolute;
        right: 0;
        top: 0;
    }
    /* تحسين العرض على الشاشات الصغيرة */
    @media (max-width: 768px) {
        .content .header {
            font-size: 1.1rem;
        }
        .content p, .content ul li {
            font-size: 0.95rem;
        }
    }
</style>
<!-- Blue Header Section -->
<div class="blue-header full-width-header mt-4">
    <div class="container d-flex justify-content-center">
        <div class="col-12 col-lg-7 text-center">
            <div class="title-wrapper">
                <h1 class="d-inline-block lh-base">
                    سياسة الخصوصية
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mb-5">
    <!-- المحتوى -->
    <div class="row">
        <div class="col-12 content text-end">
          
            <p class="header">1. المقدمة</p>
            <p>نحن في Training P ملتزمون بحماية خصوصية مستخدمينا وضمان أمان بياناتهم الشخصية. تعتمد هذه السياسة على أحكام اللائحة العامة لحماية البيانات (GDPR) وتوضح كيفية جمع ومعالجة وتخزين واستخدام المعلومات الخاصة بك عند استخدامك منصتنا.</p>
            
            <p class="header">2. البيانات التي نجمعها</p>
            <p>قد نقوم بجمع ومعالجة الأنواع التالية من البيانات:</p>
            <ul>
                <li>معلومات الحساب: البريد الإلكتروني، كلمة المرور.</li>
                <li>معلومات الملف الشخصي: الاسم، التعريف، رقم الهاتف، العنوان، ملخص الخبرات، الاهتمامات، السيرة الذاتية.</li>
                <li>بيانات الاستخدام: تفاعلك مع المنصة، التدريبات التي تنضم إليها.</li>
                <li>المعاملات: تفاصيل الدفع عند الاشتراك في الخدمات المدفوعة.</li>
            </ul>
            
            <p class="header">3. كيفية استخدام البيانات</p>
            <p>نستخدم بياناتك الشخصية للأغراض التالية:</p>
            <ul>
                <li>إنشاء حسابك وإدارة وصولك للمنصة.</li>
                <li>تسهيل تواصلك مع المدربين، المتدربين، المساعدين، أو المؤسسات.</li>
                <li>تحسين خدماتنا وتطوير تجربة المستخدم.</li>
                <li>إرسال إشعارات أو تحديثات تتعلق بخدماتنا.</li>
                <li>الامتثال للالتزامات القانونية والتنظيمية.</li>
            </ul>
            
            <p class="header">4. الأساس القانوني للمعالجة</p>
            <p>نقوم بمعالجة بياناتك استنادًا إلى:</p>
            <ul>
                <li>موافقتك الصريحة (عند التسجيل أو الاشتراك).</li>
                <li>تنفيذ العقد (تقديم الخدمات التي طلبتها).</li>
                <li>المصلحة المشروعة (تحسين خدماتنا، منع الاحتيال).</li>
                <li>الالتزامات القانونية (الامتثال للقوانين المعمول بها).</li>
            </ul>
            
            <p class="header">5. مشاركة البيانات</p>
            <p>قد نشارك بياناتك مع:</p>
            <ul>
                <li>مقدمي خدمات تقنيين (الاستضافة، الدفع).</li>
                <li>شركاء موثوقين لتحسين خدماتنا.</li>
                <li>السلطات القانونية عند الضرورة والالتزام بالقانون.</li>
            </ul>
            <p>لن نقوم ببيع بياناتك الشخصية لأي طرف ثالث.</p>
            
            <p class="header">6. الاحتفاظ بالبيانات</p>
            <p>نحتفظ ببياناتك فقط للمدة اللازمة لتحقيق الأغراض الموضحة في هذه السياسة أو للامتثال للالتزامات القانونية. عند انتهاء الغرض، نقوم بحذف بياناتك أو إخفاء هويتها بشكل آمن.</p>
            
            <p class="header">7. حقوقك</p>
            <p>وفقًا لسياسة الخصوصية، لك الحقوق التالية:</p>
            <ul>
                <li>الوصول إلى بياناتك الشخصية.</li>
                <li>تصحيح بيانات غير دقيقة أو غير مكتملة.</li>
                <li>طلب حذف بياناتك ("الحق في النسيان").</li>
                <li>سحب موافقتك في أي وقت دون التأثير على قانونية المعالجة السابقة.</li>
            </ul>
            <p>يمكنك ممارسة حقوقك عبر التواصل معنا على: support@trainingp.com</p>
            
            <p class="header">8. أمن البيانات</p>
            <p>نستخدم تدابير تقنية وإدارية مناسبة لحماية بياناتك من الوصول غير المصرح به أو الفقدان أو التغيير أو الكشف.</p>
            
            <p class="header">9. ملفات تعريف الارتباط (Cookies)</p>
            <p>قد نستخدم ملفات تعريف الارتباط لتحسين تجربتك، تحليل الاستخدام، وتخصيص المحتوى. يمكنك إدارة إعدادات ملفات تعريف الارتباط من متصفحك.</p>
            
            <p class="header">10. جهات الاتصال</p>
            <p>لأي استفسار أو طلب متعلق بالخصوصية وحماية البيانات، يرجى التواصل معنا عبر:</p>
            <p style="text-align:right;">support@trainingp.com  📧</p>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection