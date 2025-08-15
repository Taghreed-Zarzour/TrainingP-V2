<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المساعدين</title>
    <style>
        /* CSS Styles for Assistants */
        /* Same as before */
    </style>
</head>
<body>

<div class="container">
    <h1>المساعدين</h1>
    <form id="trainingForm" action="{{ route('orgTraining.storeAssistants') }}" method="POST">
        @csrf
        <label for="assistant_ids">اختر المساعدين:</label>
        <select name="assistant_ids[]" multiple>
            <option value="1">مساعد 1</option>
            <option value="2">مساعد 2</option>
        </select>
        
        <button type="button" onclick="nextStep('settings')">التالي</button>
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