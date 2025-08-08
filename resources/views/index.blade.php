<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TrainingP</title>

    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/svg+xml" href="{{ asset('images/logos/logo.svg') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/intro.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<body class="min-vh-100 d-flex align-items-center">
    <div class="container-fluid intro-bg-container">
        <main class="main-content-container">
            <header class="d-flex justify-content-center mt-5 mt-md-0">
                <img src="{{ asset('images/TrainingP-Word-logo.png') }}" alt="TrainingP Logo" class="intro-logo-img" />
            </header>
            <section class="intro-content-section d-flex flex-column align-items-center justify-content-center">
                <h1 class="intro-slogan mb-3">
                    منصة تربط المدربين والمؤسسات لتصنع
                    <span class="intro-highlighted-text">
                        تأثيراً حقيقياً
                        <img src="{{ asset('images/cots-style.svg') }}" class="cots-style-img" alt="" />
                    </span>
                </h1>
                <p class="intro-description mb-5">
                    توفّر بيئة احترافية تجمع المدربين، المتدربين، المساعدين، والمؤسسات التدريبية
                    في مكان واحد. اختر المسار الذي يناسبك للانطلاق في رحلتك معنا.
                </p>
                <div class="btn-a d-flex flex-column flex-sm-row justify-content-center gap-4 mb-5">
                  <style>
.btn-a a{
  text-decoration:none;
  text-align: center
}
</style>
<a href="{{ route('homePage') }}?type=individual" 
   class="intro-btn-custom animate-btn-1 mx-auto mx-sm-2" 
   aria-label="أنا فرد">
   أنا فرد
</a>

<a href="{{ route('homePageOrganization') }}?type=organization" 
   class="intro-btn-custom intro-btn-custom-2 animate-btn-2 mx-auto mx-sm-2" 
   aria-label="أنا مؤسسة">
   أنا مؤسسة
</a>
                  </div>
            </section>

            <!-- Decorative and Hero Section -->
            <div class="design-wrapper d-none d-md-block">
                <!-- Text Prompt -->
                <div class="position-absolute text-center animate-bounce-in animate-delay-3 d-none d-lg-block" 
                    style="z-index: 100; left: 35%; bottom: -65px; font-weight: 500;">
                    اختر المسار الذي يمثلك لتبدأ رحلتك معنا
                </div>  
                <!-- Profile SVG -->
                <div class="circle profile-circle animate-swim">
                    <img src="{{ asset('images/person1.svg') }}" alt="Person" />
                </div>
                <!-- Rectangle with Word -->
                <img src="{{ asset('images/rectanglemainword.png') }}" alt="Main Word" class="rectangle-img animate-bounce-in animate-delay-2">
            </div>
            <!-- Discovery Banner -->
            <div class="position-absolute animate-slide-left animate-delay-1 d-none d-lg-block" style="left:10%; top:10%">
                <div class="position-relative d-flex align-items-center justify-content-center">
                    <div style="z-index:1000; font-weight:600;">اكتشف فرصك</div>
                    <img src="{{ asset('images/mainpage-rectangle.png') }}" class="mainpage-rectangle-img position-absolute">
                </div>
            </div>
            <!-- Discovery Banner -->
            <div class="position-absolute animate-slide-right animate-delay-2 d-none d-lg-block" style="right:10%; bottom:5%">
                <div class="position-relative d-flex align-items-center justify-content-center">
                    <div style="z-index:1000; font-weight:600;">سجّل وابدأ رحلة التطوّر </div>
                    <img src="{{ asset('images/rectangle-main-text2.png') }}" class="mainpage-rectangle-img position-absolute">
                </div>
            </div>
            <!-- Discovery Banner -->
            <div class="position-absolute animate-slide-right animate-delay-3 d-none d-lg-block" style="right:10%; top:10%">
                <div class="position-relative d-flex align-items-center justify-content-center">
                <div class="animate-float" style="top:-150%; right:-70%; position:absolute;z-index:120;">
                    <img src="{{ asset('images/person2.svg') }}" alt="Person" />
                </div>
                    <div style="z-index:100; font-weight:600;">ابدأ من هنا... </div>
                    <img src="{{ asset('images/rectangle-main-text2.png') }}" class="mainpage-rectangle-img2 position-absolute">
                </div>
            </div>
            <!-- Decorative Circles (left side) -->
            <div class="position-absolute d-none d-md-block animate-fade-in animate-delay-4" style="left:-60px">
                <div class="bg-wrapper">
                    <div class="circle circle-lg animate-rotate"></div>
                    <div class="circle circle-md animate-pulse"></div>
                    <div class="circle circle-sm animate-wiggle"></div>
                </div>
            </div>
            <!-- Dots & Circle Cluster -->
            <div class="position-absolute d-none d-md-block animate-fade-in animate-delay-2" style="left:7%; top:40%">
                <div class="d-flex position-relative" style="width:100px">
                    <!-- Big Green Circle -->
                    <div class="position-absolute animate-pulse" style="width:35px; height:35px; background-color:#00AF6C; border-radius:50%; left:60px; top:10%;z-index:1"></div>
                    <!-- Dotted Grid -->
                    <div class="dot-grid">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="dot-row">
                                @for ($j = 0; $j < 6; $j++)
                                    <div class="dot"></div>
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <!-- Dots & Circle Cluster -->
            <div class="position-absolute d-none d-md-block animate-fade-in animate-delay-3" style="right:0%; bottom:30%">
                <div class="d-flex position-relative" style="width:100px">
                    <!-- Big Green Circle -->
                    <div class="position-absolute animate-pulse" style="width:20px; height:20px; background-color:var(--color-warning); border-radius:50%; right:55px; top:30%;z-index:1"></div>
                    <!-- Dotted Grid -->
                    <div class="dot-grid2">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="dot-row2">
                                @for ($j = 0; $j < 6; $j++)
                                    <div class="dot2"></div>
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="circle-container position-absolute d-none d-md-block animate-fade-in animate-delay-1" style="left:20%; top:5%">
  <div class="outer-circle">
    <div class="inner-circle"style="background-color:var(--color-danger);"></div>
  </div>
</div>
<div class="circle-container position-absolute d-none d-md-block animate-fade-in animate-delay-4" style="bottom:5%; left:8%">
  <div class="outer-circle">
    <div class="inner-circle"style="background-color:var(--color-success);"></div>
  </div>
</div>
<div class="position-absolute d-none d-md-block animate-swim" style="width:50px; height:50px; background-color:var(--color-danger); border-radius:50%; right:-2%; top:10%"></div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
</body>

</html>
