
    @yield('line')
<footer>

    <div class="grid">
        <div class="col">
            <img src="{{ asset('images/footer-logo.svg') }}" alt="TrainingP Logo" />
            <p>
                منظومة تدريبية متكاملة تجمع المدربين، المساعدين،
                المتدربين، والمؤسسات في منصة رقمية واحدة، تتيح الوصول
                إلى الفرص التدريبية وتسهّل عملية التعاقد والتطوير
                المهني.
            </p>
        </div>
        <div class="col">
            <div class="title">روابط سريعة</div>
            <div class="footer-links">
                <ul>
                    <li>
                        <a href="{{ route('homePage') }}">الرئيسية</a>
                    </li>
                    <li>
                        <a href="#">أعلن عن احتياجك</a>
                    </li>
                    <li>
                        <a href="#">المناقصات والوظائف</a>
                    </li>
                    <li>
                        <a href="#">المدربون</a>
                    </li>
                    <li>
                        <a href="#">المساعدون</a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href="#">موارد معرفية</a>
                    </li>
                    <li>
                        <a href="#">الأسئلة الشائعة</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">تسجيل الدخول</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">إنشاء حساب</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col">
            <div class="title">تواصل معنا</div>
            <ul>
                <li>
                    <a href="mailto:support@trainingp.com">
                        <img src="{{ asset('images/social/sms.svg') }}" alt="Email Icon" />
                        <div>support@trainingp.com</div>
                    </a>
                </li>
                <li>
                    <a href="https://api.whatsapp.com/send?phone=905314977081">
                        <img src="{{ asset('images/social/whatsapp.svg') }}" alt="WhatsApp Icon" />
                        <div>+90 531 497 70 81</div>
                    </a>
                </li>
                <li>
                    <a href="https://facebook.com/FollowTrainingP">
                        <img src="{{ asset('images/social/facebook.svg') }}" alt="Facebook Icon" />
                        <div>@FollowTrainingP</div>
                    </a>
                </li>
                <li>
                    <a href="https://linkedin.com/Training">
                        <img src="{{ asset('images/social/linkedin.svg') }}" alt="LinkedIn Icon" />
                        <div>@TrainingP</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <hr />
    <div class="absolute">
        <div class="copyright">
            © {{ now()->year }} TrainingP. جميع الحقوق محفوظة.
        </div>
        <div class="terms-conditions">
            <a href="#">سياسة الخصوصية</a>
            <a href="#">شروط الاستخدام</a>
        </div>
    </div>
</footer>