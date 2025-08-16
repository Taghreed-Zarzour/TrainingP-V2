<?php

namespace App\Http\Requests\OrganizationRequests;

use Illuminate\Foundation\Http\FormRequest;

class updateOrganizationProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone_code' => ['required', 'regex:/^\+\d{1,4}$/'],
            'phone_number' => ['required', 'regex:/^\d{6,15}$/'],
            'website' => 'required|url',
            'country_id' => 'required|exists:countries,id',
            'organization_type_id' => 'required|exists:organization_types,id',
            'annual_budgets_id' => 'required|exists:annual_budgets,id',
            'employee_numbers_id' => 'required|exists:employee_numbers,id',
            'organization_sectors' => 'required|array',
            'organization_sectors.*' => 'exists:organization_sectors,id',
            'established_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'bio' => 'required|string|min:50|max:500',
            'branch_country_id' => 'nullable|array',
            'branch_country_id.*' => 'required|exists:countries,id',
            'branch_city' => 'nullable|array',
            'branch_city.*' => 'required|string|max:255',
            'photo' => 'sometimes|image|mimes:jpg,jpeg,png|max:5120',
        ];
    }
    public function messages(): array
    {
        return [
            'name_ar.required' => 'اسم المؤسسة بالعربية مطلوب',

            'city.required' => 'المدينة مطلوبة',

            'phone_code.required' => 'حقل رمز الدولة مطلوب.',
            'phone_code.regex' => 'يجب أن يكون رمز الدولة مكونًا من علامة + متبوعة بـ 1 إلى 4 أرقام.',

            'phone_number.required' => 'حقل رقم الجوال مطلوب.',
            'phone_number.regex' => 'يجب أن يكون رقم الجوال مكونًا من 6 إلى 15 رقماً دون أحرف أو رموز أخرى.',

            'website.required' => 'الموقع الإلكتروني مطلوب',
            'website.url' => 'يجب أن يكون الموقع الإلكتروني رابطًا صالحًا',

            'country_id.required' => 'الدولة مطلوبة',

            'organization_type_id.required' => 'نوع المؤسسة مطلوب',

            'annual_budgets_id.required' => 'الميزانية السنوية مطلوبة',
            'annual_budgets_id.exists' => 'الميزانية غير صالحة',

            'employee_numbers_id.required' => 'عدد الموظفين مطلوب',
            'employee_numbers_id.exists' => 'عدد الموظفين غير صالح',

            'organization_sectors.required' => 'القطاعات مطلوبة',
            'organization_sectors.*.exists' => 'القطاع المحدد غير صالح',

            'established_year.required' => 'سنة التأسيس مطلوبة',
            'established_year.digits' => 'سنة التأسيس يجب أن تكون من 4 أرقام',
            'established_year.integer' => 'سنة التأسيس يجب أن تكون رقمًا صحيحًا',
            'established_year.min' => 'سنة التأسيس غير صحيحة',
            'established_year.max' => 'سنة التأسيس غير صحيحة',


            'bio.required' => 'النبذة مطلوبة',
            'bio.min' => 'يجب ألا تقل النبذة عن 50 أحرف',
            'bio.max' => 'يجب ألا تزيد النبذة عن 500 حرف',

            'branch_country_id.array' => 'يجب أن تكون الدول في صيغة مصفوفة.',
            'branch_country_id.*.required' => 'يرجى اختيار الدولة لكل فرع.',
            'branch_country_id.*.exists' => 'الدولة المحددة لأحد الفروع غير موجودة.',

            'branch_city.array' => 'يجب أن تكون المدن في صيغة مصفوفة.',
            'branch_city.*.required' => 'يرجى إدخال اسم المدينة لكل فرع.',
            'branch_city.*.string' => 'يجب أن يكون اسم المدينة نصًا.',
            'branch_city.*.max' => 'يجب ألا يزيد اسم المدينة عن 255 حرفًا.',

            'photo.image' => 'الملف المرفق يجب أن يكون صورة.',
            'photo.mimes' => 'يجب أن تكون الصورة بصيغة JPG أو PNG.',
            'photo.max' => 'يجب ألا يتجاوز حجم الصورة 5 ميغابايت.',

        ];

    }
}
