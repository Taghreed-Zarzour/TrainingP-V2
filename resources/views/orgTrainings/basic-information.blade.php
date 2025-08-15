<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المعلومات الأساسية</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 { text-align: center; }
        label { display: block; margin: 10px 0 5px; }
        input[type="text"],
        textarea,
        select {
            width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;
        }
        button { width: 100%; padding: 10px; background: #5cb85c; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
@if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <h1>إعدادات المعلومات الأساسية</h1>
    <form action="{{ $isEditMode ? route('orgTraining.updateBasicInformation', $training->id) : route('orgTraining.storeBasicInformation') }}" method="POST">
        @csrf
        @if($isEditMode)
            @method('PUT')
        @endif
        
        <label for="title">العنوان</label>
        <input type="text" name="title" value="{{ old('title', $training->title ?? '') }}" required>
        
        <label for="language_id">اللغة</label>
        <select name="language_id" required>
            <option value="">اختر اللغة</option>
            @foreach($languages as $language)
                <option value="{{ $language->id }}" {{ (old('language_id', $training->language_id ?? '') == $language->id) ? 'selected' : '' }}>
                    {{ $language->name }}
                </option>
            @endforeach
        </select>
        
        <label for="country_id">الدولة</label>
        <select name="country_id" required>
            <option value="">اختر الدولة</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ (old('country_id', $training->country_id ?? '') == $country->id) ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
        
        <label for="city">المدينة</label>
        <input type="text" name="city" value="{{ old('city', $training->city ?? '') }}" required>
        
        <label for="address_in_detail">العنوان التفصيلي</label>
        <textarea name="address_in_detail" required>{{ old('address_in_detail', $training->address_in_detail ?? '') }}</textarea>
        
        <label for="program_type">نوع البرنامج</label>
        <select name="program_type" required>
            <option value="">اختر نوع البرنامج</option>
            @foreach($programType as $type)
                <option value="{{ $type->value }}" {{ (old('program_type', $training->program_type ?? '') == $type->value) ? 'selected' : '' }}>
                    {{ $type->value }}
                </option>
            @endforeach
        </select>
        
        <label for="training_level_id">مستوى التدريب</label>
        <select name="training_level_id" required>
            <option value="">اختر المستوى</option>
            @foreach($levels as $level)
                <option value="{{ $level->id }}" {{ (old('training_level_id', $training->training_level_id ?? '') == $level->id) ? 'selected' : '' }}>
                    {{ $level->name }}
                </option>
            @endforeach
        </select>
        
        <label for="program_presentation_method">طريقة تقديم البرنامج</label>
        <select name="program_presentation_method" required>
            <option value="">اختر طريقة التقديم</option>
            @foreach($programPresentationMethod as $method)
                <option value="{{ $method->value }}" {{ (old('program_presentation_method', $training->program_presentation_method ?? '') == $method->value) ? 'selected' : '' }}>
                    {{ $method->value }}
                </option>
            @endforeach
        </select>
        
        
        <label>تصنيف البرنامج</label>
        <div>
            @foreach($classifications as $classification)
                <div>
                    <input type="checkbox" 
                        name="org_training_classification_id[]" 
                        id="classification_{{ $classification->id }}" 
                        value="{{ $classification->id }}" 
                        {{ (in_array($classification->id, old('org_training_classification_id', explode(',', $training->org_training_classification_id ?? '')))) ? 'checked' : '' }}>
                    <label for="classification_{{ $classification->id }}">{{ $classification->name }}</label>
                </div>
            @endforeach
        </div>

        @if ($errors->has('org_training_classification_id'))
            <div class="error">{{ $errors->first('org_training_classification_id') }}</div>
        @endif
        
        <label for="program_description">وصف البرنامج</label>
        <textarea name="program_description" required>{{ old('program_description', $training->program_description ?? '') }}</textarea>
        
        <button type="submit">{{ $isEditMode ? 'تحديث المعلومات' : 'حفظ المعلومات الأساسية' }}</button>
    </form>
</div>

</body>
</html>