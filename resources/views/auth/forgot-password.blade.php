<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>استعادة كلمة المرور</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body dir="rtl">
    <div class="container mt-5">
        <h2 class="mb-4">استعادة كلمة المرور</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني:</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">إرسال رابط إعادة التعيين</button>
        </form>
    </div>
</body>
</html>