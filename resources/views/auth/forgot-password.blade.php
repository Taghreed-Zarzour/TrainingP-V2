<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعادة كلمة المرور</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/individual-register.css') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logos/logo.svg') }}">
</head>
<body class="login-container">
    <div class="registration-container">
        <div class="registration-card">
<div class="logo">
    <a href="{{ route('index') }}">
        <img src="{{ asset('images/logos/logo-without-text.svg') }}" alt="Logo"/>
    </a>
</div>

            <h1 class="title mb-4">استعادة كلمة المرور</h1>
            <p class="reset-sub-text mb-5">أدخل بريدك الإلكتروني المرتبط بحسابك، وسنرسل لك رابط لإعادة تعيين كلمة المرور.</p>
            <!-- Session Status -->
            @if(session('status'))
                <div class="alert alert-success mb-4 text-center">
                    {{ session('status') }}
                </div>
            @endif
            <!-- General Error Messages -->
            @if(session('error'))
                <div class="alert alert-danger mb-4 text-center">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 text-center">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <!-- Email Address -->
                <div class="form-group mb-5">
                    <label class="form-label">البريد الإلكتروني</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 21.25H7C3.35 21.25 1.25 19.15 1.25 15.5V8.5C1.25 4.85 3.35 2.75 7 2.75H17C20.65 2.75 22.75 4.85 22.75 8.5V15.5C22.75 19.15 20.65 21.25 17 21.25ZM7 4.25C4.14 4.25 2.75 5.64 2.75 8.5V15.5C2.75 18.36 4.14 19.75 7 19.75H17C19.86 19.75 21.25 18.36 21.25 15.5V8.5C21.25 5.64 19.86 4.25 17 4.25H7Z" fill="#666666"/>
                                <path d="M12.0003 12.8698C11.1531 12.8809 10.3275 12.6021 9.66034 12.0798L6.53034 9.5798C6.37519 9.45647 6.27539 9.27656 6.25288 9.07965C6.23038 8.88274 6.28702 8.68495 6.41034 8.5298C6.53367 8.37464 6.71358 8.27484 6.91049 8.25233C7.10741 8.22983 7.30519 8.28647 7.46034 8.4098L10.5903 10.9098C10.9985 11.2071 11.4904 11.3673 11.9953 11.3673C12.5003 11.3673 12.9922 11.2071 13.4003 10.9098L16.5303 8.4098C16.6067 8.34754 16.6947 8.30119 16.7892 8.27347C16.8837 8.24576 16.9828 8.23724 17.0806 8.24843C17.1785 8.25961 17.2731 8.29027 17.3589 8.33859C17.4448 8.38691 17.52 8.45193 17.5803 8.5298C17.6426 8.60611 17.689 8.69412 17.7167 8.78863C17.7444 8.88314 17.7529 8.98224 17.7417 9.0801C17.7305 9.17795 17.6999 9.27257 17.6516 9.35839C17.6032 9.44421 17.5382 9.51949 17.4603 9.5798L14.3303 12.0798C13.6677 12.6034 12.8448 12.8824 12.0003 12.8698Z" fill="#666666"/>
                            </svg>
                        </span>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="مثال: example@gmail.com">
                    </div>
                    @error('email')
                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <button type="submit" class="btn btn-primary">
                        إرسال رابط إعادة التعيين
                    </button>
                </div>
            </form>
            
            <div class="login-link">
                <a href="{{ route('login') }}">العودة لتسجيل الدخول</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/eye-password.js') }}"></script>
</body>
</html>