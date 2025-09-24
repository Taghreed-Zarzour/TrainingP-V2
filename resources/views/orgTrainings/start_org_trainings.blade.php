@extends('frontend.layouts.master')


@section('title', 'الرئيسية')

@section('css')
@endsection

@section('content')
        <main>
            <section class="boarding-section" data-current-step="1">
                <div id="boarding-section-top"></div>
                <div class="content">
                    <div class="header">
                        <div class="indicators">
                            <div class="indicator active"></div>
                            <div class="indicator"></div>
                            <div class="indicator"></div>
                        </div>
<a href="{{ route('orgTraining.create') }}" class="piconed pbtn pbtn-main lets-start">
    <span>دعنا نبدأ الآن</span>
    <img src="{{ asset('images/arrow-left.svg') }}" />
</a>
                    </div>
                    <div class="main">
                        <img src="{{ asset('images/boarding/ .svg') }}" />
                        
                        <div class="title">
حوّل برامجك التدريبية إلى رحلة تعلم متكاملة
                        </div>
                        <div class="desc">
المسار التدريبي يمنح مؤسستك فرصة لتقديم رحلة تعلم متكاملة بدل تدريب منفصل. عبر تصميم مسار يضم عدة تدريبات مترابطة، تساعد المتدربين على بناء مهارات أعمق وتزيد من جاذبية عرضك.                        </div>
                    </div>
                    <div class="footer">
                        <a href="#" class="piconed pbtn pbtn-main next">
                            <span>التالي</span>
                            <img src="{{ asset('images/arrow-left.svg') }}" />
                        </a>
                        <a href="#" class="pbtn pbtn-outlined prev">
                            <span>السابق</span>
                            <img src="{{ asset('images/arrow-left.svg') }}" />
                        </a>
                    </div>
                </div>
            </section>
        </main>


@endsection


{{-- تضمين ملفات حافا سكريبت جديدة JS --}}
@section('scripts')
    
        <script>
            const burgerButton = document.getElementById("burger-btn");
            const closeButton = document.getElementById(
                "mobile-menu-close-btn"
            );
            const mobileMenu = document.getElementById("mobile-menu");
            burgerButton.addEventListener("click", () => {
                const isOpened = mobileMenu.classList.contains("opened");
                if (isOpened) {
                    mobileMenu.classList.remove("opened");
                } else {
                    mobileMenu.classList.add("opened");
                }
            });

            mobileMenu.addEventListener("click", () => {
                const isOpened = mobileMenu.classList.contains("opened");
                if (isOpened) {
                    mobileMenu.classList.remove("opened");
                }
            });
        </script>
        <script>
            class Stepper {
                constructor() {
                    this.steps = {
                        1: {
                            title: "حوّل برامجك التدريبية إلى رحلة تعلم متكاملة",
                            desc: "المسار التدريبي يمنح مؤسستك فرصة لتقديم رحلة تعلم متكاملة بدل تدريب منفصل. عبر تصميم مسار يضم عدة تدريبات مترابطة، تساعد المتدربين على بناء مهارات أعمق وتزيد من جاذبية عرضك.",
                            img: "../images/boarding/org-step1.svg",
                        },
                        2: {
                            title: "صمم مسارك التدريبي المباشر",
                            desc: "أدخل معلومات المسار، حدد منهجية التقديم (حضوري أو عن بعد)، وأضف عنوان كل تدريب في مسارك التدريبي واسم مدرّبه. يمكنك إضافة الجلسات والمواعيد، وسيُنشأ تلقائيًا صفحة خاصة لكل تدريب داخل المسار.",
                            img: "../images/boarding/org-step2.svg",
                        },
                        3: {
                            title: "امنح المتدربين صورة أوضح",
                            desc: "بعد نشر المسار يمكنك الدخول لكل تدريب وإضافة تفاصيل إضافية (مستوى التدريب، ووصف التدريب، ومحاور التدريب) لتمكين المتدربين من فهم قيمة المسار واتخاذ قرار بالتسجيل. ",
                            img: "../images/boarding/org-step3.svg",
                        },
                    };
                    this.wrapperEl =
                        document.querySelector(".boarding-section");
                    this.nextButton = document.querySelector(
                        ".boarding-section .footer .next"
                    );
                    this.prevButton = document.querySelector(
                        ".boarding-section .footer .prev"
                    );
                    this.letsStartButton = document.querySelector(
                        ".boarding-section .header .lets-start"
                    );
                }
                currentStep() {
                    return parseInt(this.wrapperEl.dataset.currentStep);
                }
                scrollToTop() {
                    document
                        .getElementById("boarding-section-top")
                        .scrollIntoView({ behavior: "smooth" });
                }
                refresh() {
                    const currentStep = this.currentStep();
                    const step = this.steps[currentStep];

                    if (step) {
                        document.querySelector(
                            ".boarding-section .content .main .title"
                        ).textContent = step.title;
                        document.querySelector(
                            ".boarding-section .content .main .desc"
                        ).textContent = step.desc;
                        document
                            .querySelector(
                                ".boarding-section .content .main img"
                            )
                            .setAttribute("src", step.img);

                        if (currentStep == 1) {
                            this.prevButton.style.display = "none";
                        } else if (currentStep == 3) {
                            this.letsStartButton.style.display = "none";
                            this.nextButton.querySelector("span").textContent =
                                "دعنا نبدأ الآن";

                            this.prevButton.style.display = "block";
                        } else {
                            this.prevButton.style.display = "block";
                            this.letsStartButton.style.display = "block";
                            this.nextButton.querySelector("span").textContent =
                                "التالي";
                        }

                        const indicators = document.querySelectorAll(
                            ".boarding-section .content .header .indicators .indicator"
                        );

                        indicators.forEach((el, i) => {
                            if (i + 1 <= currentStep) {
                                el.classList.add("active");
                            } else {
                                el.classList.remove("active");
                            }
                        });
                    }
                }

                init() {
                    this.nextButton.addEventListener("click", (e) => {
                        e.preventDefault();
                        const currentStep = this.currentStep();
                        const pass =
                            currentStep < Object.keys(this.steps).length;
                        if (pass) {
                            this.wrapperEl.setAttribute(
                                "data-current-step",
                                currentStep + 1
                            );
                            this.refresh();
                            this.scrollToTop();
                        }

                        if (currentStep == Object.keys(this.steps).length) {
                            window.location =
                                this.letsStartButton.getAttribute("href");
                        }
                    });

                    this.prevButton.addEventListener("click", (e) => {
                        e.preventDefault();
                        const currentStep = this.currentStep();
                        const pass = currentStep > 0;
                        if (pass) {
                            this.wrapperEl.setAttribute(
                                "data-current-step",
                                currentStep - 1
                            );
                            this.refresh();
                            this.scrollToTop();
                        }
                    });
                }
            }

            const stepper = new Stepper();

            stepper.init();
            stepper.refresh();
        </script>
@endsection


