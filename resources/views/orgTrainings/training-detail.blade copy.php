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
        input[type="text"], input[type="file"], input[type="date"], select {
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
        .text-danger {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>تفاصيل التدريب</h1>
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('orgTraining.storeTrainingDetails', $training->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div id="training-titles-container">
            <div class="training-title-group">
                <label for="program_title">عنوان البرنامج</label>
                <input type="text" name="program_title[]" required>
                
                @error('program_title.*')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="trainer_id">اختيار المدرب</label>
                <select name="trainer_id[]" required>
                    <option value="">اختر مدربًا</option>
                    @foreach ($availableTrainers as $trainer)
                        <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                    @endforeach
                </select>

                <div class="schedules-container"></div>
                <button type="button" class="btn btn-success add-schedule-btn" onclick="addSchedule(this)">إضافة توقيت</button>
                <button type="button" class="btn btn-info" onclick="toggleScheduleLater(this)">جدولة الجلسات لاحقًا</button>
            </div>
        </div>

        <button type="button" class="btn btn-success add-title-btn" onclick="addTrainingTitle()">إضافة عنوان آخر</button>

        <label for="file">تحميل الملفات</label>
        <input type="file" name="file">
        @error('file')
        <div class="text-danger">{{ $message }}</div>
        @enderror

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
        <input type="date" name="schedules[][date]" required>
        <label for="start_time">وقت بدء الجلسة</label>
        <select name="schedules[][start_time]" required>
            ${generateTimeOptions()}
        </select>
        <label for="end_time">وقت انتهاء الجلسة</label>
        <select name="schedules[][end_time]" required>
            ${generateTimeOptions()}
        </select>
        <button type="button" class="btn btn-danger" onclick="removeSchedule(this)">إزالة التوقيت</button>
        <div class="text-danger"></div> <!-- Error display for this schedule -->
    `;
    schedulesContainer.appendChild(scheduleGroup);
}

    function generateTimeOptions() {
        let options = '';
        for (let hour = 0; hour < 24; hour++) {
            for (let minute = 0; minute < 60; minute += 15) {
                const formattedHour = hour.toString().padStart(2, '0');
                const formattedMinute = minute.toString().padStart(2, '0');
                options += `<option value="${formattedHour}:${formattedMinute}">${formattedHour}:${formattedMinute}</option>`;
            }
        }
        return options;
    }

    function addTrainingTitle() {
        const container = document.getElementById('training-titles-container');
        const titleGroup = document.createElement('div');
        titleGroup.classList.add('training-title-group');
        titleGroup.innerHTML = `
            <label for="program_title">عنوان البرنامج</label>
            <input type="text" name="program_title[]" required>
            @error('program_title.*')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <label for="trainer_id">اختيار المدرب</label>
            <select name="trainer_id[]" required>
                <option value="">اختر مدربًا</option>
                @foreach ($availableTrainers as $trainer)
                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                @endforeach
            </select>
            <div class="schedules-container"></div>
            <button type="button" class="btn btn-success add-schedule-btn" onclick="addSchedule(this)">إضافة توقيت</button>
            <button type="button" class="btn btn-info" onclick="toggleScheduleLater(this)">جدولة الجلسات لاحقًا</button>
        `;
        container.appendChild(titleGroup);
    }

    function removeSchedule(button) {
        const scheduleGroup = button.parentElement;
        scheduleGroup.remove();
    }

    function toggleScheduleLater(button) {
        const titleGroup = button.parentElement;
        const isChecked = button.classList.toggle('active');
        if (isChecked) {
            button.innerText = 'تم تحديد جدولة الجلسات لاحقًا';
        } else {
            button.innerText = 'جدولة الجلسات لاحقًا';
        }
    }
</script>

</body>
</html>