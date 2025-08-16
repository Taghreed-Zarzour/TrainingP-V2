<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مراجعة البرنامج التدريبي</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        h1 {
            margin-top: 20px;
            color: #333;
        }
        h2 {
            color: #007bff;
        }
        .list-group-item {
            border: none;
        }
        .welcome-message {
            font-size: 1.1em;
            color: #555;
            margin-top: 20px;
        }
        .training-file {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">مراجعة البرنامج التدريبي</h1>

        <div class="card">
            <div class="card-header">
                <h2>{{ $training->title }}</h2>
            </div>
            <div class="card-body">
                <p><strong>الوصف:</strong> {{ $training->program_description }}</p>
                <p><strong>اللغة:</strong> {{ $training->language->name }}</p>
                <p><strong>البلد:</strong> {{ $training->country->name }}</p>
                <p><strong>المستوى:</strong> {{ $training->trainingLevel->name }}</p>
                <p><strong>تصنيف البرنامج:</strong> {{ $training->trainingClassification->name }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>المساعدون</h2>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($assistants as $assistant)
                    <li class="list-group-item">{{ $assistant->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>متطلبات التسجيل</h2>
            </div>
            <div class="card-body">
                <p><strong>التكلفة:</strong> {{ $registrationRequirements->cost ?? 'غير متوفر' }}</p>
                <p><strong>العملة:</strong> {{ $registrationRequirements->currency ?? 'غير متوفر' }}</p>
                <p><strong>المتطلبات:</strong> {{ implode(', ', $requirements) ?? 'غير متوفر' }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>أهداف التدريب</h2>
            </div>
            <div class="card-body">
                <p><strong>نتائج التعلم:</strong> {{ implode(', ', $learning_outcomes) ?? 'غير متوفر' }}</p>
                <p><strong>الجمهور المستهدف:</strong> {{ implode(', ', $target_audience) ?? 'غير متوفر' }}</p>
                <p><strong>الفوائد:</strong> {{ implode(', ', $benefits) ?? 'غير متوفر' }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>ملفات التدريب</h2>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($training_files as $file)
                    <li class="list-group-item training-file">
                        <a href="{{ Storage::url($file) }}">{{ basename($file) }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="welcome-message">
            <p><strong>رسالة ترحيبية:</strong> {{ $welcome_message }}</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>