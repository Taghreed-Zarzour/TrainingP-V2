<?php
namespace App\Http\Requests\TrainingCreate;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\schedulingTrainingSessions;
use App\Models\TrainingProgram;
use Carbon\Carbon;

class StoreAdditionalSettingsRequest extends FormRequest
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
          'welcome_message' => [
            'nullable',
            'string',
            'max:1000',
        ],
            'is_free' => 'required|boolean',
            'cost' => [
                'nullable',
                'numeric',
                'min:0',
                'required_if:is_free,false',
                function ($attribute, $value, $fail) {
                    if ($this->is_free && !is_null($value)) {
                        $fail('لا يمكن إدخال تكلفة عندما يكون التدريب مجاني.');
                    }
                }
            ],
            'currency' => [
                'nullable',
                'string',
                'max:10',
                'required_if:is_free,false',
                function ($attribute, $value, $fail) {
                    if ($this->is_free && !is_null($value)) {
                        $fail('لا يمكن إدخال عملة عندما يكون التدريب مجاني.');
                    }
                }
            ],
            'payment_method' => [
                'nullable',
                'string',
                'max:255',
                'required_if:is_free,false',
                function ($attribute, $value, $fail) {
                    if ($this->is_free && !is_null($value)) {
                        $fail('لا يمكن إدخال طريقة دفع عندما يكون التدريب مجاني.');
                    }
                }
            ],

'country_id' => [
    'nullable',
    'exists:countries,id',
    // احذف الدالة الشرطية من هنا
],
            'city' => [
                'nullable',
                'string',
                'max:255',
                'required_with:country_id',
                
            ],
            'residential_address' => [
                'nullable',
                'string',
                'max:500',
                'required_with:city',
                  
            ],
          'application_deadline' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    // الحصول على معرف التدريب من المسار
                    $trainingId = $this->route('trainingId');
                    
                    // التحقق من حالة التدريب (هل هو معلن أم لا)
                    $isAnnounced = false;
                    if ($trainingId) {
                        $program = TrainingProgram::with(['detail', 'AdditionalSetting', 'sessions'])
                            ->find($trainingId);
                            
                        if ($program) {
                            // حساب نسبة الإكمال
                            $completionPercentage = $this->calculateTrainingCompletion($program);
                            
                            // التحقق إذا كان التدريب معلن
                            if ($completionPercentage === 100) {
                                $hasSessions = $program->sessions && $program->sessions->count() > 0;
                                
                                // إذا لم تكن هناك جلسات أو تم اختيار تحديد الجلسات لاحقاً، فهو معلن
                                if (!$hasSessions || ($program->AdditionalSetting && $program->AdditionalSetting->schedule_later)) {
                                    $isAnnounced = true;
                                } else {
                                    // إذا كانت هناك جلسات، تحقق من تاريخ أول جلسة
                                    $firstSession = $program->sessions->sortBy('session_date')->first();
                                    if ($firstSession) {
                                        $startTime = Carbon::parse($firstSession->session_date . ' ' . $firstSession->session_start_time);
                                        if ($startTime->isFuture()) {
                                            $isAnnounced = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    // إذا لم يكن التدريب معلن، تحقق من أن التاريخ ليس قبل اليوم
                    if (!$isAnnounced && strtotime($value) < strtotime(date('Y-m-d'))) {
                        $fail('لا يمكن أن يكون آخر موعد للتقديم قبل اليوم.');
                    }
                    
                    // التحقق من أن التاريخ ليس بعد سنة من الآن
                    if (now()->diffInDays($value) > 365) {
                        $fail('لا يمكن أن يكون آخر موعد للتقديم بعد سنة من الآن.');
                    }
                    
                    if ($trainingId) {
                        // البحث عن أول جلسة مرتبطة بالتدريب
                        $firstSession = schedulingTrainingSessions::where('training_program_id', $trainingId)
                            ->orderBy('session_date', 'asc')
                            ->first();
                            
                        if ($firstSession) {
                            $firstSessionDate = $firstSession->session_date;
                            
                            // التحقق من أن تاريخ الانتهاء قبل تاريخ الجلسة الأولى
                            if (strtotime($value) >= strtotime($firstSessionDate)) {
                                $fail('تاريخ الانتهاء يجب أن يكون قبل تاريخ الجلسة الأولى (' . date('Y-m-d', strtotime($firstSessionDate)) . ')');
                            }
                        }
                    }
                }
            ],
            
            'max_trainees' => 'required|integer|min:1|max:1000',
            'application_submission_method' => 'required|in:inside_platform,outside_platform',
            'registration_link' => [
                'nullable',
                'url',
                'required_if:application_submission_method,outside_platform',
                'starts_with:https',
                function ($attribute, $value, $fail) {
                    if ($this->application_submission_method === 'outside_platform' && empty($value)) {
                        $fail('رابط التسجيل مطلوب عند اختيار طريقة التقديم خارج المنصة.');
                    }
                }
            ],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100',
'training_files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,jpg,jpeg,png,bmp,gif,svg,webp,mp4,mov,avi,mp3,wav,zip,rar|max:20480',
        ];
        
    }

    public function messages(): array
    {
        return [
            'is_free.required' => 'حقل "هل التدريب مجاني" مطلوب.',
            'is_free.boolean' => 'قيمة حقل "هل التدريب مجاني" يجب أن تكون صحيحة أو خاطئة.',

            'cost.required_if' => 'التكلفة مطلوبة عندما يكون التدريب غير مجاني.',
            'cost.numeric' => 'قيمة التكلفة يجب أن تكون رقمية.',
            'cost.min' => 'التكلفة يجب أن تكون قيمة موجبة أو صفر.',

            'currency.required_if' => 'العملة مطلوبة عندما يكون التدريب غير مجاني.',
            'currency.string' => 'العملة يجب أن تكون نصاً.',
            'currency.max' => 'العملة يجب ألا تتجاوز 10 أحرف.',

            'payment_method.required_if' => 'طريقة الدفع مطلوبة عندما يكون التدريب غير مجاني.',
            'payment_method.string' => 'طريقة الدفع يجب أن تكون نصاً.',
            'payment_method.max' => 'طريقة الدفع يجب ألا تتجاوز 255 حرفاً.',

            'country_id.exists' => 'الدولة المحددة غير موجودة.',
            
            'city.required_with' => 'المدينة مطلوبة عند اختيار الدولة.',
            'city.string' => 'اسم المدينة يجب أن يكون نصاً.',
            'city.max' => 'اسم المدينة يجب ألا يتجاوز 255 حرفاً.',
            
            'residential_address.required_with' => 'العنوان التفصيلي مطلوب عند إدخال المدينة.',
            'residential_address.string' => 'العنوان التفصيلي يجب أن يكون نصاً.',
            'residential_address.max' => 'العنوان التفصيلي يجب ألا يتجاوز 500 حرف.',

            'application_deadline.required' => 'يرجى تحديد آخر موعد للتقديم.',
            'application_deadline.date' => 'تنسيق تاريخ آخر موعد غير صالح.',
            'application_deadline.after_or_equal' => 'لا يمكن أن يكون آخر موعد للتقديم قبل اليوم.',

            'max_trainees.required' => 'يرجى تحديد العدد الأقصى للمتدربين.',
            'max_trainees.integer' => 'يجب أن يكون العدد الأقصى رقماً صحيحاً.',
            'max_trainees.min' => 'يجب ألا يقل العدد الأقصى للمتدربين عن 1.',
            'max_trainees.max' => 'يجب ألا يزيد العدد الأقصى للمتدربين عن 1000.',

            'application_submission_method.required' => 'يرجى تحديد طريقة استقبال الطلبات.',
            'application_submission_method.in' => 'طريقة استقبال الطلبات غير صالحة.',

            'registration_link.required_if' => 'رابط التسجيل مطلوب عند اختيار طريقة التقديم خارج المنصة.',
            'registration_link.url' => 'رابط التسجيل غير صالح.',
            'registration_link.starts_with' => 'رابط التسجيل يجب أن يبدأ بـ https.',

            'profile_image.image' => 'يجب أن تكون الصورة التعريفية من نوع صورة.',
            // 'profile_image.required' => 'الصورة التعريفية مطلوبة.',
            'profile_image.mimes' => 'يجب أن تكون الصورة من الأنواع: jpeg, png, jpg, gif.',
            'profile_image.max' => 'الحد الأقصى لحجم الصورة هو 2 ميغابايت.',
            'profile_image.dimensions' => 'أبعاد الصورة يجب أن تكون على الأقل 100x100 بكسل.',

            'training_files.*.file' => 'كل ملف يجب أن يكون من نوع ملف صالح.',
'training_files.*.mimes' => 'الملفات المسموحة هي: pdf, doc, docx, ppt, pptx, xls, xlsx, txt, jpg, jpeg, png, bmp, gif, svg, webp, mp4, mov, avi, mp3, wav, zip, rar.',
            'training_files.*.max' => 'كل ملف يجب ألا يتجاوز حجمه 5 ميغابايت.',
      
       'welcome_message.string' => 'الرسالة الترحيبية يجب أن تكون نصاً.',
        'welcome_message.max' => 'الرسالة الترحيبية يجب ألا تتجاوز 1000 حرف.',
        
          ];
    }

  protected function prepareForValidation()
{
    $this->merge([
        'is_free' => $this->boolean('is_free')
    ]);

    if ($this->is_free) {
        $this->merge([
            'cost' => null,
            'currency' => null,
            'payment_method' => null,
        ]);
    }
    
    if ($this->application_submission_method === 'inside_platform') {
        $this->merge([
            'registration_link' => null,
        ]);
    }
}
   public function withValidator($validator)
    {     
        $validator->after(function ($validator) {
            $trainingId = $this->route('trainingId');
            
            if ($trainingId) {
                // الحصول على طريقة عرض التدريب من الخطوة الأولى (التصحيح هنا)
                $step1 = session('step1_data', []);
                $program_presentation_method_id = $step1['program_presentation_method_id'] ?? null;
                
                // التحقق من حقول الموقع للتدريب الحضوري
                if ($program_presentation_method_id === 'حضوري') {
                    if (!$this->input('country_id')) {
                        $validator->errors()->add('country_id', 'الدولة مطلوبة للتدريب الحضوري');
                    }
                    if (!$this->input('city')) {
                        $validator->errors()->add('city', 'المدينة مطلوبة للتدريب الحضوري');
                    }
                    if (!$this->input('residential_address')) {
                        $validator->errors()->add('residential_address', 'العنوان التفصيلي مطلوب للتدريب الحضوري');
                    }
                }
                
                // التحقق من تاريخ الانتهاء مقابل تاريخ الجلسة الأولى
                $firstSession = schedulingTrainingSessions::where('training_program_id', $trainingId)
                    ->orderBy('session_date', 'asc')
                    ->first();
                    
                if ($firstSession) {
                    $firstSessionDate = $firstSession->session_date;
                    $applicationDeadline = $this->input('application_deadline');
                    
                    if (strtotime($applicationDeadline) >= strtotime($firstSessionDate)) {
                        $validator->errors()->add('application_deadline', 
                            'تاريخ الانتهاء يجب أن يكون قبل تاريخ الجلسة الأولى (' . date('Y-m-d', strtotime($firstSessionDate)) . ')');
                    }
                }
            }
        });
    }
    
    /**
     * حساب نسبة اكتمال التدريب
     */
    private function calculateTrainingCompletion(TrainingProgram $program)
    {
        // تعريف أوزان لكل خطوة من خطوات إنشاء التدريب (مجموعها = 100)
        $weights = [
            'basic_info' => 25,   // المعلومات الأساسية
            'details' => 25,      // التفاصيل
            'settings' => 25,     // الإعدادات
            'additional_check' => 25, // أي خطوة إضافية أو اختيارية
        ];

        $totalWeight = array_sum($weights);
        $completedWeight = 0;

        // 1. المعلومات الأساسية (سؤال واحد)
        $basicCompleted = !empty($program->title) ? 1 : 0;
        $completedWeight += ($basicCompleted / 1) * $weights['basic_info'];

        // 2. التفاصيل (سؤال واحد)
        $detailCompleted = ($program->detail && !empty($program->detail->learning_outcomes)) ? 1 : 0;
        $completedWeight += ($detailCompleted / 1) * $weights['details'];

        // 3. الإعدادات (سؤال واحد فقط)
        $settingCompleted = ($program->AdditionalSetting && !empty($program->AdditionalSetting->application_deadline)) ? 1 : 0;
        $completedWeight += ($settingCompleted / 1) * $weights['settings'];

        // 4. خطوة إضافية اختيارية (مثلاً أي شيء آخر تريد التحقق منه، هنا نفترض 1 سؤال)
        // إذا ما فيه شيء إضافي يمكن تجاهلها أو اعطاءها صفر
        $additionalCompleted = 1; // نفترض مكتمل لتبسيط، أو يمكن تعديل حسب الحاجة
        $completedWeight += ($additionalCompleted / 1) * $weights['additional_check'];

        // النسبة الإجمالية، مع التأكد أنها لا تتجاوز 100
        $overallPercentage = min(($completedWeight / $totalWeight) * 100, 100);

        return intval($overallPercentage);
    }
}