<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المساعدين</title>
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
        select {
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
    </style>
</head>
<body>

<div class="container">
    <h1>اختر المساعدين</h1>
    <form id="trainingForm" action="{{ route('orgTraining.storeAssistants', $training->id) }}" method="POST">
        @csrf
        
        <label for="assistant_ids">اختر المساعدين:</label>
        <select name="assistant_ids[]" id="assistant_ids" multiple required>
            @foreach ($availableAssistants as $assistant)
                <option value="{{ $assistant->id }}" 
                    {{ in_array($assistant->id, $currentAssistants) ? 'selected' : '' }}>
                    {{ $assistant->name }}
                </option>
            @endforeach
        </select>
        
        <button type="button" class="btn btn-secondary" id="addAssistantBtn">اختيار مساعد آخر</button>
        
        <div id="additionalAssistantContainer" style="display: none; margin-top: 20px;">
            <label for="additional_assistant_ids">اختر مساعد آخر:</label>
            <select name="additional_assistant_ids[]" id="additional_assistant_ids" multiple>
                @foreach ($availableAssistants as $assistant)
                    <option value="{{ $assistant->id }}">{{ $assistant->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-actions" style="margin-top: 20px;">
            <button type="submit">حفظ المساعدين</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('addAssistantBtn').addEventListener('click', function() {
        const additionalAssistantContainer = document.getElementById('additionalAssistantContainer');
        additionalAssistantContainer.style.display = additionalAssistantContainer.style.display === 'none' ? 'block' : 'none';
    });
</script>

</body>
</html>