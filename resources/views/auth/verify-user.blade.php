<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>تحقق من بريدك الإلكتروني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email-verify.css') }}">
</head>

<body>
    <div class="verify-bg">
        <div class="verify-card">
            @isset($user)
                <img src="{{ asset('images/general/email-verify.svg') }}" alt="Email Verify" />
                <h5>تحقق من بريدك الإلكتروني!</h5>
                <p>لقد أرسلنا رسالة إلى بريدك الإلكتروني</p>
                <p class="email">{{ $user->email }}</p>
                <p>تحتوي على رابط للتفعيل. الرجاء التحقق من بريدك والضغط على الرابط لإكمال عملية التسجيل</p>

                <div class="border-top mt-4 pt-3">
                    <p class="timer">
                        لم يصلك البريد؟ <span id="timer">60</span> ثانية
                    </p>

                    <form method="POST" action="{{ route('resend-verification-email', ['id' => $user->id]) }}">
                        @csrf
                        <button id="resendBtn" class="btn resend-btn" disabled>إعادة الإرسال</button>
                    </form>
                </div>
                  <p class="mt-4">
                      إذا لم تجد الرسالة، تحقق من مجلد الرسائل غير المرغوب بها (Spam)
                    </p>

            @else
                <p class="text-danger">المستخدم غير موجود أو لم يتم تمرير البيانات بشكل صحيح.</p>
            @endisset
            @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->has('error'))
    <div class="alert alert-danger">
        {{ $errors->first('error') }}
    </div>
@endif

        </div>
    </div>

    <script>
        let timeLeft = 60;
        const timerEl = document.getElementById('timer');
        const resendBtn = document.getElementById('resendBtn');

        const countdown = setInterval(() => {
            timeLeft--;
            timerEl.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                resendBtn.disabled = false;
                resendBtn.textContent = "إعادة الإرسال";
            }
        }, 1000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
