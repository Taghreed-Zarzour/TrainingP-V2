<style>
    footer {
        background-color: #fff;
        color: #444;
        padding-top: 60px;
    }

    footer .footer-logo {
        max-height: 50px;
        margin-bottom: 20px;
    }

    footer .footer-title {
        font-weight: 500;
        font-size: 22px;
        margin-bottom: 20px;
        color: #232323;
    }

    footer .footer-links a {
        color: #444444;
        font-weight: 400;
        text-decoration: none;
        font-size: 18px;
        margin-bottom: 10px;
        display: block;
        transition: all 0.3s;
    }

    footer .footer-links a:hover {
        color: #000;
        padding-right: 5px;
    }




    footer .footer-bottom {
        font-size: 16px;
        color: #444;
    }

    footer .footer-bottom a {
        color: #444;
        text-decoration: none;
        margin-left: 30px;
    }

    .scroll-top-btn,
    .contact-modal-btn {
        position: fixed;
        left: 50px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 99;

        transition: all 0.3s;
    }

    .scroll-top-btn {
        bottom: 80px;
    }

    .contact-modal-btn {
        bottom: 20px;
    }

    .scroll-top-btn:hover,
    .contact-modal-btn:hover {
        background-color: #e9ecef;
    }

    /* تحسين المسافات بين الأعمدة */
    footer .footer-col {
        margin-bottom: 30px;
        padding: 0 15px;
    }

    @media (max-width: 991.98px) {
        footer .footer-col {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (max-width: 767.98px) {
        footer .footer-col {
            flex: 0 0 100%;
            max-width: 100%;
        }

        footer .footer-bottom {
            text-align: center !important;
        }

        footer .footer-bottom-links {
            justify-content: center !important;
            margin-top: 15px;
        }


    }


.contact-info-footer {
    text-align: right;
    direction: rtl;
}

.contact-info-footer a {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
    margin-bottom: 10px;
    color: inherit;
    text-decoration: none;
}

.contact-info-footer img {
    width: 20px;
    height: 20px;
}

.text-justify {
    text-align: justify;
}
/* يمكن إضافته في ملف CSS الخاص بك */
#feedbackModal .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

#feedbackModal .modal-body {
    padding: 2.5rem;
}

#feedbackModal textarea {
    border: 1px solid #ddd;
    border-radius: 10px;
    resize: none;
    padding: 15px;
    font-size: 16px;
}

#feedbackModal textarea:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.modal-title {
            font-size: 1.5rem;
            color: #003090;
            text-align: center;
            width: 100%;
        }
/* تنسيق مودال الشكر */
#thankYouModal .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

#thankYouModal .modal-body {
    padding: 2.5rem;
}

#thankYouModal svg[fill="#4e73df"] {
    margin-bottom: 1rem;
    animation: heartbeat 1.5s ease-in-out infinite;
}

@keyframes heartbeat {
    0% { transform: scale(1); }
    25% { transform: scale(1.1); }
    50% { transform: scale(1); }
    75% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

#thankYouModal h4 {
    color: #4e73df;
    margin-top: 1rem;
}

#thankYouModal p {
    font-size: 1.1rem;
    line-height: 1.6;
}
</style>


<!-- Footer Section -->
<footer class="border-top pt-3">
    <div class="container  custom-container pt-3">
        <div class="row g-4 justify-content-between"> <!-- استخدام g-4 لضبط المسافات بين الأعمدة -->
            <!-- Column 1: Logo and Description -->
            <div class="col-lg-3 col-md-6 footer-col">
                <img src="{{ asset('images/footer-logo.svg') }}" alt="TrainingP Logo" />
                <p class="text-muted text-justify">
                    منظومة تدريبية متكاملة تجمع المدربين، المساعدين،
                    المتدربين، والمؤسسات في منصة رقمية واحدة. تتيح
                    الوصول إلى الفرص التدريبية وتسهّل عملية التعاقد
                    والتطوير المهني.
                </p>
            </div>

            <!-- Column 2: Quick Links (Part 1) -->
            <div class="col-lg-2 col-md-6 footer-col">
                <h5 class="footer-title">روابط سريعة</h5>
                <div class="footer-links">
                    <a href="#">الرئيسية</a>
                    <a href="#">أعلن عن احتياجات</a>
                    <a href="#">المناقصات والوظائف</a>
                    <a href="#">المدربون</a>
                    <a href="#">المساعدون</a>
                </div>
            </div>

            <!-- Column 3: Quick Links (Part 2) -->
            <div class="col-lg-2 col-md-6 footer-col">
                <h5 class="footer-title" style="visibility: hidden;">روابط سريعة</h5>
                <div class="footer-links">
                    <a href="#">موارد معرفية</a>
                    <a href="#">الأسئلة الشائعة</a>
                    <a href="#">تسجيل الدخول</a>
                    <a href="#">إنشاء حساب</a>
                </div>
            </div>

            <!-- Column 4: Contact Us -->
<div class="col-lg-3 col-md-6 footer-col">
    <h5 class="footer-title">تواصل معنا</h5>
    <div class="contact-info-footer">
        <a href="mailto:support@trainingp.com">
            <img src="{{ asset('images/social/sms.svg') }}" alt="Email Icon" />
            <span  dir="ltr">support@trainingp.com</span>
        </a>
        <a href="https://api.whatsapp.com/send?phone=905314977081">
            <img src="{{ asset('images/social/whatsapp.svg') }}" alt="WhatsApp Icon" />
            <span  dir="ltr">+90 531 497 70 81</span>
        </a>
        <a href="https://facebook.com/followtrainingp">
            <img src="{{ asset('images/social/facebook.svg') }}" alt="Facebook Icon" />
            <span  dir="ltr">@TrainingP</span>
        </a>
        <a href="https://linkedin.com/Training">
            <img src="{{ asset('images/social/linkedin.svg') }}" alt="LinkedIn Icon" />
            <span  dir="ltr">@TrainingP</span>
        </a>
    </div>
</div>




            </div>
        </div>


        <div class="row align-items-center border-top pt-3 w-100">
            <div class="col-md-6 text-md-start footer-bottom">
                جميع الحقوق محفوظة. TrainingP 2025 ©
            </div>
            <div class="col-md-6 text-center text-md-end footer-bottom">
                <div class="d-flex justify-content-end footer-bottom-links footer-links">
                    <a href="#" class="ms-3">سياسة الخصوصية</a>
                    <a href="#">شروط الاستخدام</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Contact Modal Button -->
<div class="contact-modal-btn" data-bs-toggle="modal" data-bs-target="#contactModal">
    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="40" height="40" rx="20" fill="#003090" />
        <path
            d="M25.98 18.79V22.79C25.98 23.05 25.97 23.3 25.94 23.54C25.71 26.24 24.12 27.58 21.19 27.58H20.79C20.54 27.58 20.3 27.7 20.15 27.9L18.95 29.5C18.42 30.21 17.56 30.21 17.03 29.5L15.83 27.9C15.7 27.73 15.41 27.58 15.19 27.58H14.79C11.6 27.58 10 26.79 10 22.79V18.79C10 15.86 11.35 14.27 14.04 14.04C14.28 14.01 14.53 14 14.79 14H21.19C24.38 14 25.98 15.6 25.98 18.79Z"
            stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
        <path opacity="0.4"
            d="M29.9791 14.79V18.79C29.9791 21.73 28.6291 23.31 25.9391 23.54C25.9691 23.3 25.9791 23.05 25.9791 22.79V18.79C25.9791 15.6 24.3791 14 21.1891 14H14.7891C14.5291 14 14.2791 14.01 14.0391 14.04C14.2691 11.35 15.8591 10 18.7891 10H25.1891C28.3791 10 29.9791 11.6 29.9791 14.79Z"
            stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
        <path opacity="0.4" d="M21.4955 21.25H21.5045" stroke="white" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        <path opacity="0.4" d="M17.9955 21.25H18.0045" stroke="white" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        <path opacity="0.4" d="M14.4955 21.25H14.5045" stroke="white" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
    </svg>

</div>
<!-- Scroll to Top Button -->
<div class="scroll-top-btn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M20 0C16.0444 0 12.1776 1.17298 8.8886 3.37061C5.59962 5.56823 3.03617 8.69181 1.52242 12.3463C0.00866568 16.0009 -0.387401 20.0222 0.384303 23.9018C1.15601 27.7814 3.06082 31.3451 5.85787 34.1421C8.65492 36.9392 12.2186 38.844 16.0982 39.6157C19.9778 40.3874 23.9992 39.9913 27.6537 38.4776C31.3082 36.9638 34.4318 34.4004 36.6294 31.1114C38.827 27.8224 40 23.9556 40 20C39.9915 14.6983 37.8817 9.6161 34.1328 5.86721C30.3839 2.11832 25.3017 0.00846247 20 0ZM28.12 23.58C27.981 23.7196 27.8158 23.8303 27.6339 23.9059C27.452 23.9814 27.257 24.0203 27.06 24.0203C26.863 24.0203 26.668 23.9814 26.4861 23.9059C26.3042 23.8303 26.139 23.7196 26 23.58L20 17.58L14 23.58C13.7157 23.845 13.3396 23.9892 12.951 23.9823C12.5624 23.9755 12.1916 23.8181 11.9168 23.5432C11.6419 23.2684 11.4845 22.8976 11.4777 22.509C11.4708 22.1204 11.615 21.7443 11.88 21.46L18.94 14.4C19.2223 14.121 19.6031 13.9646 20 13.9646C20.3969 13.9646 20.7777 14.121 21.06 14.4L28.12 21.46C28.399 21.7423 28.5554 22.1231 28.5554 22.52C28.5554 22.9169 28.399 23.2977 28.12 23.58Z" fill="#003090"/>
</svg>


</div>




<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="p-0" id="feedbackForm" method="POST" action="{{ route('feedback.store') }}">
                @csrf
                <button type="button" class="btn-close align-self-end pt-4 pe-4" data-bs-dismiss="modal" aria-label="إغلاق"></button>

                <div class="modal-body text-center px-5 pt-0">
                    <!-- الصورة في الأعلى -->
                    <img src="{{ asset('images/general/feedback.svg') }}" alt="Feedback Icon" />
                    
                    <!-- العنوان -->
                    <h4 class="modal-title mb-3 fw-bold">شاركنا رأيك لتحسن تجربتك</h4>
                    
                    <!-- النص التوضيحي -->
                    <p class="mb-4 text-muted">
                        نعمل باستمرار على تحسين خدماتنا، ورأيك يساعدنا في الوصول لتجربة أفضل.
                        شاركنا انطباعك في 30 ثانية
                    </p>
                    
                    <!-- حقل إدخال الملاحظات -->
                    <div class="form-group mb-4">
                        <textarea name="content" class="form-control" rows="4" placeholder="هل لديك ملاحظات أو اقتراحات؟" required></textarea>
                        @error('content')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- الأزرار -->
                    <div class="d-flex flex-column gap-3">
                        <!-- زر الإرسال -->
                        <button type="submit" class="custom-btn d-flex align-items-center justify-content-center gap-2 py-2">
                            <span>إرسال</span>
                            <img src="{{ asset('images/arrow-left.svg') }}" alt="" />
                        </button>
                        
                        <!-- زر واتساب --> 
                        <a href="https://wa.me/905314977081?text={{ urlencode('لدي ملاحظة حول الموقع:') }}" 
                           target="_blank"
                           class="feedback-btn d-flex align-items-center justify-content-center gap-2 py-2 text-decoration-none">
                            <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- SVG code remains the same -->
                            </svg>
                            <span>تقديم المراجعة عبر WhatsApp</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Thank You Modal -->
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
                <button type="button" class="btn-close align-self-end pt-4 pe-4" data-bs-dismiss="modal" aria-label="إغلاق"></button>

            <div class="modal-body text-center p-5">

                <!-- نفس الصورة المستخدمة في المودال الأول -->
                <img src="{{ asset('images/general/feedback-thanks.svg') }}" alt="Thank You" class="mb-4">
                
                <!-- رسالة الشكر -->
                <h4 class="mb-3 fw-bold">شكراً لوقتك!</h4>
                <p class="text-muted">
نحن نطوّر المنتج خطوة بخطوة، ووجود مستخدمين مثلك يساعدنا نختصر الطريق. شكرًا من القلب 💙                </p>
                
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const feedbackForm = document.getElementById('feedbackForm');

    feedbackForm.addEventListener('submit', function (e) {
        e.preventDefault(); // منع الإرسال التقليدي

        const formData = new FormData(feedbackForm);

        fetch(feedbackForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (response.ok) {
                // إغلاق مودال الملاحظات
                const feedbackModal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
                feedbackModal.hide();

                // فتح مودال الشكر
                const thankYouModal = new bootstrap.Modal(document.getElementById('thankYouModal'));
                thankYouModal.show();

                // إعادة تعيين النموذج
                feedbackForm.reset();
            } else {
                return response.json().then(data => {
                    // عرض رسالة الخطأ إذا كانت موجودة
                    if (data.errors && data.errors.content) {
                        alert(data.errors.content[0]);
                    } else {
                        alert('حدث خطأ غير متوقع، حاول مرة أخرى.');
                    }
                });
            }
        })
        .catch(error => {
            console.error('خطأ في الإرسال:', error);
            alert('فشل الاتصال بالخادم. تأكد من الاتصال بالإنترنت.');
        });
    });
});
</script>
