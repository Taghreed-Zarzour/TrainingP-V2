<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>إعادة تعيين كلمة المرور | TrainingP</title>
</head>
<body style="margin:0;padding:0;background-color:#f8f9fa;font-family:Tahoma,Arial,sans-serif;direction:rtl;">
  <div style="max-width:600px;margin:0 auto;background-color:#ffffff;box-shadow:0 4px 16px rgba(0,0,0,0.1);">
    
    <!-- Blue Header -->
    <div style="background-color:#003090;background-image:url('https://trainingp.com/images/general/email_verify-bg.png');background-size:cover;background-position:center;color:#ffffff;text-align:center;padding:50px 0;margin-bottom:30px;">
      <h1 style="font-size:28px;margin:0;">إعادة تعيين كلمة المرور</h1>
    </div>
    
    <!-- Content -->
    <div style="padding:30px 20px;text-align:center;">
      
      <!-- Icon -->
      <div style="margin-bottom:20px;">
        <img src="https://trainingp.com/images/general/email_verify_icon.png" alt="Password Reset" style="max-width:200px;">
      </div>
      
      <p style="font-size:20px;line-height:1.6;color:#333333;margin-bottom:25px;">
        مرحبًا {{ $user->name }}،
      </p>
      
      <p style="font-size:16px;line-height:1.6;color:#333333;margin-bottom:25px;">
        لقد طلبت إعادة تعيين كلمة المرور لحسابك. اضغط على الزر التالي لتعيين كلمة مرور جديدة:
      </p>
      
      <!-- Button -->
      <div style="margin:30px 0;">
        <a href="{{ $url }}" style="display:inline-block;font-size:16px;padding:12px 50px;border-radius:12px;background-color:#003090;color:#ffffff;text-decoration:none;">
          إعادة تعيين كلمة المرور
        </a>
      </div>
      
      <p style="font-size:14px;line-height:1.6;color:#666666;margin-top:30px;">
        إذا لم تطلب إعادة تعيين كلمة المرور، يمكنك تجاهل هذه الرسالة.
      </p>
      
      <p style="font-size:14px;line-height:1.6;color:#666666;margin-top:30px;">
        مع تحيات فريق الدعم.
      </p>
    </div>

  </div>
</body>
</html>