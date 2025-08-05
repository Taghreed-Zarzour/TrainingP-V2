<style>
    .training-type {
        background-color: white;
        color: #003090;
        display: inline-block;
        padding: 3px 10px;
        border-radius: 5px;
        font-weight: bold;
        font-size: 14px;
        margin-left: 8px;
        vertical-align: middle;
    }

    .section-title {
        color: #333333;
        margin-bottom: 15px;
        font-weight: bold;
        font-size: 1.25rem;
    }

    .list-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .list-item img {
        margin-left: 10px;
        margin-top: 3px;
    }

    .payment-box {
        border: 2px solid #EFF0F6;
        border-radius: 32px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .welcome-box {
        border: 2px solid #EFF0F6;
        border-radius: 32px;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .two-columns {
            display: block !important;
        }

        .two-columns>div {
            width: 100% !important;
        }
    }
</style>

<div class="container mt-5">
    <!-- Two Columns Section -->
    <div class="two-columns" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
        <!-- Column 1 -->
        <div style="flex: 1; min-width: 300px;">
            <!-- الفئة المستهدفة -->
            <div class="mb-5">
                <h3 class="section-title">الفئة المستهدفة من التدريب</h3>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20" height="20">
                    <span>المصممون المبتدئون الراغبون في دخول مجال تجربة المستخدم</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>طلبة وخريجو تخصصات التصميم الجرافيكي أو التسويق</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>المهنيون الذين يسعون لتوسيع مهاراتهم في تصميم تجربة المستخدم</span>
                </div>
            </div>

            <!-- المتطلبات -->
            <div class="mb-5">
                <h3 class="section-title">المتطلبات أو الشروط اللازمة للالتحاق بالتدريب</h3>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>قدرة على استخدام الحاسوب والعمل مع الإنترنت</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>اهتمام مسبق بمجال تصميم تجربة المستخدم</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>مهارات في تحليل البيانات وفهم سلوك المستخدمين</span>
                </div>
            </div>

            <!-- ميزات التدريب -->
            <div class="mb-5">
                <h3 class="section-title">ميزات التدريب</h3>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>محتوى تدريبي متكامل يشمل أساسيات ومهارات تصميم تجربة المستخدم</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>تدريبات عملية وتطبيقات واقعية تعزز الفهم والتجربة</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>إمكانية الوصول إلى تسجيلات الجلسات لمراجعة المحتوى في أي وقت</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>شهادة حضور معتمدة عند إتمام التدريب</span>
                </div>
            </div>
        </div>

        <!-- Column 2 -->
        <div style="flex: 1; min-width: 300px;">

            <!-- وصف التدريب -->
            <div class="mb-5">
                <h3 class="section-title">وصف التدريب</h3>
                <p>تمهيد هذه الدورة الطريق لتحويل عالم تصميم تجربة المستخدم من خلال محتوى عملي وسهل. تشمل المبادئ
                    الأساسية وأدوات البحث والتخطيط والتنفيذ. ستعلمك كيفية فهم احتياجات المستخدم، بناء الحلول بناءً على
                    البيانات، وتحويل الأفكار إلى تجارب رقمية. الدورة مصممة للمبتدئين والراغبين بتطوير مهاراتهم في مجال
                    تصميم المنتجات الرقمية.</p>
            </div>

            <!-- ما الذي سيتعلمه المشاركون -->
            <div class="mb-5">
                <h3 class="section-title">ما الذي سيتعلمه المشاركون في هذا التدريب؟</h3>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>فهم أساسيات تجربة المستخدم (UX) ومبادئ التصميم المركز على الإنسان</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>تطبيق تقنيات البحث لفهم احتياجات المستخدمين</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>إنشاء نماذج أولية لتجارب المستخدمين</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>تحليل البيانات للحصول على رؤى قيمة لتحسين التصميم</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>تطوير استراتيجيات التفاعل بين المستخدم والواجهة</span>
                </div>
                <div class="list-item">
                    <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20"
                        height="20">
                    <span>اختبار قابلية الاستخدام لجمع ملاحظات المستخدمين وتحسين المنتج</span>
                </div>
            </div>




        </div>
    </div>


    <!-- آلية الدفع -->
    <div class="payment-box mb-5">
        <h3 class="section-title">آلية الدفع</h3>
        <p>
            آلية الدفع: يتم الدفع خارج المنصة. بعد التسجيل، يرجى تحويل الرسوم إلى:
            <br>
            🔹 تحويل بنكي: مركز التدريب، رقم الحساب: 1234567890 – بنك البلاد
            <br>
            🔹 STC Pay / PayPal: trainer@example.com
            <br>
            📩 أرسل إيصال الدفع على واتساب: 0500000000. سيتم تأكيد التسجيل خلال 24 ساعة.

        </p>

    </div>

    <!-- الرسالة الترحيبية -->
    <div class="welcome-box mb-5">
        <h3 class="section-title">رسالة ترحيبية</h3>
        <p>يسعدنا أن تكون جزءاً من هذا البرنامج التدريبي، ونعدك برحلة تعليمية ممتعة وغنية بالتجارب والتطوير. سيتم مراجعة
            طلبات التسجيل وإعلام المقبولين في أقرب وقت. لذا نرجو متابعة البريد الإلكتروني أو الإشعارات داخل المنصة
            للاطلاع على حالة طلبك.</p>
    </div>
</div>
