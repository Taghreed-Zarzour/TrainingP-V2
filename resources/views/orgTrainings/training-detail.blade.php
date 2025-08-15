<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل التدريب</title>
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
        input[type="text"], input[type="file"] {
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
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .schedule-group {
            margin-top: 15px;
            padding: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .add-schedule-btn, .add-title-btn {
            background-color: #28a745;
        }
        .add-schedule-btn:hover, .add-title-btn:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>تفاصيل التدريب</h1>
    <form action="{{ route('orgTraining.storeTrainingDetails', $training->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div id="training-titles-container">
            <div class="training-title-group">
                <label for="program_title">عنوان البرنامج</label>
                <input type="text" name="program_title[]" required>
                <div class="schedules-container"></div>
                <button type="button" class="btn btn-success add-schedule-btn" onclick="addSchedule(this)">إضافة توقيت</button>
            </div>
        </div>

        <button type="button" class="btn btn-success add-title-btn" onclick="addTrainingTitle()">إضافة عنوان آخر</button>

        <label for="file">تحميل الملفات</label>
        <input type="file" name="file">

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>
    </form>
</div>

<script>
    function addSchedule(button) {
        const schedulesContainer = button.previousElementSibling;
        const scheduleGroup = document.createElement('div');
        scheduleGroup.classList.add('schedule-group');
        scheduleGroup.innerHTML = `
            <label>أوقات الجلسات</label>
            <input type="text" name="schedules[][date]" placeholder="تاريخ الجلسة" required>
            <input type="text" name="schedules[][start_time]" placeholder="وقت بدء الجلسة" required>
            <input type="text" name="schedules[][end_time]" placeholder="وقت انتهاء الجلسة" required>
        `;
        schedulesContainer.appendChild(scheduleGroup);
    }

    function addTrainingTitle() {
        const container = document.getElementById('training-titles-container');
        const titleGroup = document.createElement('div');
        titleGroup.classList.add('training-title-group');
        titleGroup.innerHTML = `
            <label for="program_title">عنوان البرنامج</label>
            <input type="text" name="program_title[]" required>
            <div class="schedules-container"></div>
            <button type="button" class="btn btn-success add-schedule-btn" onclick="addSchedule(this)">إضافة توقيت</button>
        `;
        container.appendChild(titleGroup);
    }
</script>

</body>
</html>