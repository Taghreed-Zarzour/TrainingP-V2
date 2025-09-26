@extends('frontend.layouts.master')


@section('title', 'إنشاء تدريب - مدرب')

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
                    <a href="{{ route('training.create') }}" class="piconed pbtn pbtn-main lets-start">
                        <span>دعنا نبدأ الآن</span>
                        <img src="{{ asset('images/arrow-left.svg') }}" />
                    </a>
                </div>
                <div class="main">
                    <img src="{{ asset('images/boarding/step1.svg') }}" />

                    <div class="title">
                        أطلق تدريبك المباشر بسهولة واحترافية
                    </div>
                    <div class="desc">
                        من خلال منصتنا، يمكنك بناء حضور قوي لتدريبك المباشر (حضوري أو عن بعد) عبر واجهة مبسّطة وآمنة،
                        والوصول إلى متدربين مهتمين بتدريبك. </div>
                  
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
                        title: "أطلق تدريبك المباشر بسهولة واحترافية",
                        desc: "من خلال منصتنا، يمكنك بناء حضور قوي لتدريبك المباشر (حضوري أو عن بعد) عبر واجهة مبسّطة وآمنة، والوصول إلى متدربين مهتمين بتدريبك.",
                        img: "../images/boarding/training-org-step1.svg",
                    },
                    2: {
                        title: "قدّم معلومات واضحة وجذّابة",
                        desc: "احرص على كتابة عنوان تدريب دقيق، مع وصف قصير يوضح الفائدة العملية للمتدربين. وأضف محاور التدريب والفئة المستهدفة بدقة، فهذا يساعد على جذب المشاركين المناسبين.",
                        img: "../images/boarding/training-org-step2.svg",
                    },
                    3: {
                        title: "اعتمد أفضل الممارسات للإعلان الناجح",
                        desc: "استخدم صورة تعكس موضوع التدريب، وحدّد مواعيد الجلسات بدقة. لا تنسَ تحديد المتطلبات الأساسية (إن وجدت) لتجعل التجربة أكثر وضوحًا واحترافية، مما يزيد من فرص انضمام المتدربين.",
                        img: "../images/boarding/training-org-step3.svg",
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
                    .scrollIntoView({
                        behavior: "smooth"
                    });
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
