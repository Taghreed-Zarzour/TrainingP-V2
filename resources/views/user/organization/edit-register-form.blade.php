<div class="container mt-5">
    <h2 class="mb-4">تعديل معلومات المنظمة</h2>
    <form action="{{ route('organization.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name in English -->
        <div class="form-group">
            <label for="name_en">الاسم (بالإنجليزية)</label>
            <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $organization->user ? $organization->user->getTranslation('name', 'en') : '') }}">
            @error('name_en')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Name in Arabic -->
        <div class="form-group">
            <label for="name_ar">الاسم (بالعربية)</label>
            <input type="text" name="name_ar" class="form-control"  value="{{ old('name_ar', $organization->user ? $organization->user->getTranslation('name', 'ar') : '') }}">
            @error('name_ar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- City -->
        <div class="form-group">
            <label for="city">المدينة</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $organization->user ? $organization->user->city : '') }}">
            @error('city')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Phone Number -->
        <div class="form-group">
            <label for="phone_number">رقم الهاتف</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $organization->user ? $organization->user->phone_number : '') }}">
            @error('phone_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Website -->
        <div class="form-group">
            <label for="website">الموقع الإلكتروني</label>
            <input type="url" name="website" class="form-control" value="{{ old('website', $organization->website) }}">
            @error('website')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Country -->
        <div class="form-group">
            <label for="country_id">البلد</label>
            <select name="country_id" class="form-control">
                <option value="">اختر البلد</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ $country->id == ($organization->user ? $organization->user->country_id : null) ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            @error('country_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Organization Type -->
        <div class="form-group">
            <label for="organization_type_id">نوع المنظمة</label>
            <select name="organization_type_id" class="form-control">
                <option value="">اختر نوع المنظمة</option>
                @foreach($organization_type as $type)
                    <option value="{{ $type->id }}" {{ $type->id == $organization->type_id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error('organization_type_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Annual Budget -->
        <div class="form-group">
            <label for="annual_budgets_id">الميزانية السنوية</label>
            <select name="annual_budgets_id" class="form-control">
                <option value="">اختر الميزانية السنوية</option>
                @foreach($annual_budget as $budget)
                    <option value="{{ $budget->id }}" {{ $budget->id == $organization->annual_budgets_id ? 'selected' : '' }}>
                        {{ $budget->amount }}
                    </option>
                @endforeach
            </select>
            @error('annual_budgets_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Employee Numbers -->
        <div class="form-group">
            <label for="employee_numbers_id">عدد الموظفين</label>
            <select name="employee_numbers_id" class="form-control">
                <option value="">اختر عدد الموظفين</option>
                @foreach($employee_number as $number)
                    <option value="{{ $number->id }}" {{ $number->id == $organization->employee_numbers_id ? 'selected' : '' }}>
                        {{ $number->count }}
                    </option>
                @endforeach
            </select>
            @error('employee_numbers_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Organization Sectors -->
        <div class="form-group">
            <label for="organization_sectors">قطاعات المنظمة</label>
            <select name="organization_sectors[]" class="form-control" multiple>
                @foreach($organization_sectors as $sector)
                    <option value="{{ $sector->id }}" {{ in_array($sector->id, $organization->organization_sectors) ? 'selected' : '' }}>
                        {{ $sector->name }}
                    </option>
                @endforeach
            </select>
            @error('organization_sectors')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Established Year -->
        <div class="form-group">
            <label for="established_year">سنة التأسيس</label>
            <input type="number" name="established_year" class="form-control" min="1900" max="{{ date('Y') }}" value="{{ old('established_year', $organization->established_year) }}">
            @error('established_year')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Bio -->
        <div class="form-group">
            <label for="bio">السيرة الذاتية</label>
            <textarea name="bio" class="form-control" rows="4">{{ old('bio', $organization->user ? $organization->user->bio : '') }}</textarea>
            @error('bio')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Branch Countries -->
        <div class="form-group">
            <label for="branch_country_id">بلدان الفروع</label>
            <select name="branch_country_id[]" class="form-control" multiple>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ in_array($country->id, old('branch_country_id', [])) ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            @error('branch_country_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!-- City -->
        <div class="form-group">
            <label for="city">المدينة</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $organization->user ? $organization->user->city : '') }}">
            @error('city')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Branch Cities -->
        <div class="form-group">
            <label for="branch_city">مدن الفروع</label>
            <textarea name="branch_city" class="form-control" rows="2">{{ old('branch_city', '') }}</textarea>
            @error('branch_city')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>

<style>
    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .text-danger {
        font-size: 0.875rem;
    }
</style>