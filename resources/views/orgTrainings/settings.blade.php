<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات</title>
    <style>
        /* CSS Styles for Settings */
        /* Same as before */
    </style>
</head>
<body>

<div class="container">
    <h1>الإعدادات الإضافية</h1>
    <form id="trainingForm" action="{{ route('orgTraining.storeSettings') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="cost">التكلفة</label>
        <input type="text" name="cost">
        
        <label for="is_free">هل الدورة مجانية؟</label>
        <input type="checkbox" name="is_free" value="1"> نعم
        
        <label for="application_deadline">موعد انتهاء التقديم</label>
        <input type="date" name="application_deadline">
        
        <label for="training_image">صورة التدريب</label>
        <input type="file" name="training_image">
        
        <button type="button" onclick="nextStep('review')">التالي</button>
    </form>
</div>

<script>
    function nextStep(page) {
        document.getElementById('trainingForm').action = `{{ url('/org-training/') }}/${page}`;
        document.getElementById('trainingForm').submit();
    }
</script>

</body>
</html>