<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم تعيين كلمة المرور بنجاح</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* الحفاظ على الخطوط الأساسية */
        * {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        /* تنسيقات الصفحة الرئيسية */
        .training-finished-page {
            border-radius: 10px;
            box-shadow: 0px 0px 8px 0px #00000026;
            background: #FFFFFF;
            padding: 50px 25px; /* زيادة الحشو */
            max-width: 700px; /* زيادة عرض الكرت */
            width: 100%;
            margin: 0 auto;
        }
        
        .training-finished-page-content {
            padding: 0 20px; /* زيادة الحشو الداخلي */
        }
        
        .training-finished-page-content h1 {
            font-weight: 500;
            font-size: 30px; /* زيادة حجم الخط */
            line-height: 1.2;
            text-align: center;
            color: #232323;
            margin-bottom: 10px; /* زيادة المسافة */
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px; /* زيادة المسافة بين العناصر */
        }
        
        .training-finished-page-content p {
            font-weight: 500;
            font-size: 18px; /* زيادة حجم الخط */
            line-height: 1.8;
            text-align: center;
            color: #444444;
            margin-bottom: 35px; /* زيادة المسافة */
        }
        
        /* تنسيقات الأزرار */
        .pbtn {
            padding: 12px 28px; /* زيادة الحشو */
            font-weight: 500;
            font-size: 20px; /* زيادة حجم الخط */
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px; /* زيادة المسافة */
            transition: all 0.3s ease;
            border: none;
            width: 100%;
            max-width: 80%;
            margin: 0 auto;
        }
        
        .pbtn.pbtn-main {
            background-color: #003090;
            color: #ffffff;
        }
        
        .pbtn.pbtn-main:hover {
            background-color: #002470;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 48, 144, 0.3);
        }
        
        .pbtn img {
            width: 22px; /* زيادة حجم الصورة */
            height: 22px; /* زيادة حجم الصورة */
            transition: transform 0.3s ease;
        }
        
        .pbtn:hover img {
            transform: translateX(-3px);
        }
        
        /* تنسيقات النصوص الخاصة */
        .text-underlined {
            position: relative;
            margin: 0px 8px; /* زيادة الهوامش الجانبية */
            color: #003090;
            display: inline-block;
        }
        
        .text-underlined::before {
            content: "";
            position: absolute;
            top: 80%;
            left: 0;
            right: 0;
            width: 100%;
            height: 14px; /* زيادة ارتفاع الخط السفلي */
            background-image: url('../images/underline.svg');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
        }
        
        .text-top {
            position: relative;
            padding: 10px 12px 18px 12px; /* زيادة الحشو الجانبي */
        }
        
        .text-top::after {
            content: "";
            position: absolute;
            top: 0;
            left: -10px; /* زيادة المسافة */
            width: 30px; /* زيادة العرض */
            height: 26px; /* زيادة الارتفاع */
            background-image: url('../images/text-top.svg');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
        }
        
        .text-top.right::after {
            left: unset;
            right: -10px; /* زيادة المسافة */
            background-image: url('../images/text-top.svg');
            transform: rotateY(180deg);
        }
        
        /* الصورة الرئيسية */
        .main-image {
            max-width: 350px; /* زيادة حجم الصورة */
            height: auto;
            margin-bottom: 30px; /* زيادة المسافة */
        }
        
        /* استعلامات الوسائط للشاشات المختلفة */
        @media (max-width: 768px) {
            .training-finished-page {
                padding: 35px 20px;
                max-width: 600px; /* تعديل العرض للشاشات المتوسطة */
            }
            
            .training-finished-page-content h1 {
                font-size: 36px;
                line-height: 1.3;
            }
            
            .pbtn {
                font-size: 18px;
                padding: 14px 22px;
            }
        }
        
        @media (max-width: 576px) {
            body {
                padding: 15px;
            }
            
            .training-finished-page {
                padding: 30px 20px;
                max-width: 500px; /* تعديل العرض للشاشات الصغيرة */
            }
            
            .training-finished-page-content h1 {
                font-size: 32px;
                line-height: 1.4;
            }
            
            .training-finished-page-content p {
                font-size: 16px;
                line-height: 1.6;
            }
            
            .pbtn {
                font-size: 16px;
                padding: 12px 20px;
                max-width: 90%;
            }
            
            .text-underlined {
                margin: 0px 5px;
            }
            
            .text-top::after {
                width: 25px;
                height: 22px;
                left: -8px;
            }
            
            .text-top.right::after {
                right: -8px;
            }
        }
        
        @media (max-width: 400px) {
            .training-finished-page {
                max-width: 100%; /* استخدام العرض الكامل للشاشات الصغيرة جداً */
            }
            
            .training-finished-page-content h1 {
                font-size: 28px;
            }
            
            .training-finished-page-content p {
                font-size: 15px;
            }
            
            .pbtn {
                font-size: 15px;
            }
            
            .text-underlined {
                margin: 0px 3px;
            }
        }
        .sub-text{
              padding: 10px 0px 18px 0px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6">
                <div class="training-finished-page">
                    <div class="text-center">
                        <img src="../images/training-finished.svg" alt="تم تعيين كلمة المرور بنجاح" class="main-image">
                    </div>
                    
                    <div class="training-finished-page-content">
                        <h1 class="d-flex justify-content-center align-items-center">
                            <div class="text-underlined text-top">رائــــــع</div>
                            <span class="sub-text">تم تعيين كلمة المرور بنجاح</span>
                        </h1>
                        
                        <p class="mb-4">
                            يمكنك الآن تسجيل الدخول باستخدام كلمة المرور الجديدة.
                        </p>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="pbtn pbtn-main">
                                <span>انتقل لتسجيل الدخول</span>
                                <img src="{{ asset('images/arrow-left.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>