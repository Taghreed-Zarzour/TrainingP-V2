<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إعادة تعيين كلمة المرور</title>
</head>
<body dir="rtl">
    <h2>مرحبًا {{ $user->name }}،</h2>
    <p>لقد طلبت إعادة تعيين كلمة المرور لحسابك.</p>
    <p>اضغطي على الزر التالي لتعيين كلمة مرور جديدة:</p>
    <a href="{{ $url }}" style="padding: 10px 20px; background-color: #3490dc; color: white; text-decoration: none;">إعادة تعيين كلمة المرور</a>
    <p>إذا لم تطلبي هذا، يمكنك تجاهل هذه الرسالة.</p>
    <br>
    <p>مع تحيات فريق الدعم.</p>
</body>
</html>