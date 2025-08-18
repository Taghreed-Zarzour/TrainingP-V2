<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أهداف التدريب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .add-button {
            margin-top: 20px;
            background-color: #28a745;
        }
        .add-button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .outcomes, .audiences {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>أهداف التدريب</h1>
    
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form id="trainingForm" action="{{ route('orgTraining.storeGoals', $training->id) }}" method="POST">
        @csrf
        
        <div class="outcomes">
            <label for="learning_outcomes">نتائج التعلم</label>
            <div id="learningOutcomesContainer">
                <textarea name="learning_outcomes[]" required></textarea>
                <textarea name="learning_outcomes[]" required></textarea>
                <textarea name="learning_outcomes[]" required></textarea>
                <textarea name="learning_outcomes[]" required></textarea>
            </div>
            <button type="button" class="button add-button" onclick="addLearningOutcome()">إضافة نتيجة تعلم</button>
        </div>
        
        <div class="audiences">
            <label for="target_audience">الجمهور المستهدف</label>
            <div id="targetAudienceContainer">
                <textarea name="target_audience[]" required></textarea>
            </div>
            <button type="button" class="button add-button" onclick="addTargetAudience()">إضافة جمهور مستهدف</button>
        </div>

        <button type="submit" class="button">التالي</button>
    </form>
</div>

<script>
    function nextStep(page) {
        document.getElementById('trainingForm').action = `{{ url('/org-training/') }}/${page}`;
        document.getElementById('trainingForm').submit();
    }

    function addLearningOutcome() {
        const container = document.getElementById('learningOutcomesContainer');
        const newTextarea = document.createElement('textarea');
        newTextarea.name = 'learning_outcomes[]';
        newTextarea.required = true;
        container.appendChild(newTextarea);
    }

    function addTargetAudience() {
        const container = document.getElementById('targetAudienceContainer');
        const newTextarea = document.createElement('textarea');
        newTextarea.name = 'target_audience[]';
        newTextarea.required = true;
        container.appendChild(newTextarea);
    }
</script>

</body>
</html>