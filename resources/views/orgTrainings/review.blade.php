<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مراجعة التدريب</title>
    <style>
        /* CSS Styles for Review */
        /* Same as before */
    </style>
</head>
<body>

<div class="container">
    <h1>مراجعة التدريب</h1>
    <form action="{{ route('orgTraining.storeReview') }}" method="POST">
        @csrf
        <label for="feedback">ملاحظاتك</label>
        <textarea name="feedback" required></textarea>
        
        <button type="submit">إرسال المراجعة</button>
    </form>
</div>

</body>
</html>