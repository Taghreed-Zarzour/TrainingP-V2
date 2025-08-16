<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            direction: rtl;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="file"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>الإعدادات الإضافية</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="trainingForm" action="{{ route('orgTraining.storeSettings', $training->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="cost">التكلفة</label>
        <input type="text" name="cost" value="{{ old('cost') }}">

        <label for="is_free">هل الدورة مجانية؟</label>
        <input type="hidden" name="is_free" value="0"> <!-- Hidden input for unchecked state -->
        <input type="checkbox" name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }}> نعم

        <label for="currency">العملة</label>
        <input type="text" name="currency" value="{{ old('currency') }}" maxlength="10">

        <label for="payment_method">طريقة الدفع</label>
        <input type="text" name="payment_method" value="{{ old('payment_method') }}" maxlength="255">

        <label for="application_deadline">موعد انتهاء التقديم</label>
        <input type="date" name="application_deadline" value="{{ old('application_deadline') }}">

        <label for="max_trainees">عدد المتدربين الأقصى</label>
        <input type="number" name="max_trainees" value="{{ old('max_trainees', 20) }}">

        <label for="application_submission_method">طريقة تقديم الطلب</label>
        <select name="application_submission_method">
            <option value="inside_platform" {{ old('application_submission_method') == 'inside_platform' ? 'selected' : '' }}>داخل المنصة</option>
            <option value="outside_platform" {{ old('application_submission_method') == 'outside_platform' ? 'selected' : '' }}>خارج المنصة</option>
        </select>

        <label for="registration_link">رابط التسجيل</label>
        <input type="text" name="registration_link" value="{{ old('registration_link') }}">

        <label for="requirements">المتطلبات</label>
        <textarea name="requirements">{{ old('requirements') }}</textarea>

        <label for="benefits">الفوائد</label>
        <textarea name="benefits">{{ old('benefits') }}</textarea>

        <label for="training_image">صورة التدريب</label>
        <input type="file" name="training_image">

        <label for="welcome_message">رسالة الترحيب</label>
        <textarea name="welcome_message">{{ old('welcome_message') }}</textarea>

        <button type="submit">حفظ الإعدادات</button>
    </form>
</div>

</body>
</html>