<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>إكمال الملف الشخصي | TrainingP</title>
  <style>
    :root {
      --color-primary: #003090;
      --color-primary-dark: #0A1938;
      --color-secondary: #005FDC;
      --color-accent: #e74c3c;
      --color-warning: #FFC62A;
      --color-danger: #F55157;
      --color-success: #00AF6C;
      --color-info: #5196F3;

      --color-text-dark: #333333;
      --color-text-medium: #666666;
      --color-text-light: #6c757d;
      --color-heading: #333;

      --color-bg-light: #f8f9fa;
      --color-bg-white: #ffffff;

      --primary-color: #0D6EFD;
      --secondary-color: #6C757D;
      --font-family: 'IBM Plex Sans Arabic', sans-serif;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-family);
      background-color: var(--color-bg-light);
      direction: rtl;
      margin: 0;
      padding: 20px;
    }

    .email-wrapper {
      max-width: 600px;
      margin: 40px auto;
      background-color: var(--color-bg-white);
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      padding: 30px 25px;
    }

    .email-wrapper h1 {
      font-size: 24px;
      color: var(--color-primary);
      margin-bottom: 20px;
      text-align: center;
    }

    .email-wrapper p {
      color: var(--color-text-dark);
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 20px;
      text-align: center;
    }

    .email-wrapper a.confirm-button {
      display: inline-block;
      background-color: var(--primary-color);
      color: #fff;
      text-decoration: none;
      padding: 12px 30px;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
      text-align: center;
    }

    .email-wrapper a.confirm-button:hover {
      background-color: var(--color-primary-dark);
    }

    .footer-text {
      text-align: center;
      color: var(--color-text-light);
      font-size: 14px;
      margin-top: 25px;
    }

    @media (max-width: 480px) {
      .email-wrapper {
        padding: 20px 15px;
      }

      .email-wrapper h1 {
        font-size: 20px;
      }

      .email-wrapper p {
        font-size: 14px;
      }

      .email-wrapper a.confirm-button {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <h1>مرحباً بك في TrainingP!</h1>
    <p>شكرًا لتسجيلك. يرجى إكمال ملفك الشخصي بالنقر على الزر التالي:</p>
    <div style="text-align: center;">
    <a href="{{ $link }}"
   style="display:inline-block; background-color:#0D6EFD; color:#fff; text-decoration:none; padding:12px 30px; border-radius:8px; font-weight:bold; text-align:center;">
   تأكيد البريد الإلكتروني
</a>

    </div>
    <p class="footer-text">
      إذا لم تقم بإنشاء هذا الحساب، يمكنك تجاهل هذه الرسالة.
    </p>
  </div>
</body>
</html>
