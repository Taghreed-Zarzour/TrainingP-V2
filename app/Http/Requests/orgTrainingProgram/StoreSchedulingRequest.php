<?php
namespace App\Http\Requests\orgTrainingProgram;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreSchedulingRequest extends FormRequest
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
    public function rules()
    {
        return [
            'program_title' => 'required|array',
            'program_title.*' => 'required|string|max:255',
            'trainer_id' => 'required|array',
            'trainer_id.*' => 'required|exists:users,id',
            'schedules_later' => 'nullable|array',
            'schedules_later.*' => 'boolean',
            'num_of_session' => 'nullable|array',
            'num_of_session.*' => 'nullable|integer|min:1',
            'num_of_hours' => 'nullable|array',
            'num_of_hours.*' => 'nullable|numeric|min:0.5',
            'schedules' => 'nullable|array',
            'training_files' => 'nullable|array',
            'training_files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,jpg,jpeg,png,bmp,gif,svg,webp,mp4,mov,avi,mp3,wav,zip,rar|max:20480',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // التحقق من وجود البيانات قبل استخدامها
            $schedulesLater = $this->schedules_later ?? [];
            $schedules = $this->schedules ?? [];
            $numOfSessions = $this->num_of_session ?? [];
            $numOfHours = $this->num_of_hours ?? [];

            // التأكد من أن البيانات مصفوفات
            if (!is_array($schedulesLater)) {
                $schedulesLater = [];
            }

            if (!is_array($schedules)) {
                $schedules = [];
            }

            if (!is_array($numOfSessions)) {
                $numOfSessions = [];
            }

            if (!is_array($numOfHours)) {
                $numOfHours = [];
            }

            // التحقق من الجداول فقط إذا لم يتم تحديد "الجلسات لاحقاً"
            foreach ($schedulesLater as $trainingIndex => $scheduleLater) {
                if (!$scheduleLater) {
                    // التحقق من وجود جداول لهذا التدريب
                    if (!isset($schedules[$trainingIndex]) || empty($schedules[$trainingIndex])) {
                        $validator->errors()->add("schedules.$trainingIndex", 'يجب إضافة جدول واحد على الأقل لهذا التدريب');
                        continue;
                    }

                    // التحقق من كل جدول في التدريب
                    foreach ($schedules[$trainingIndex] as $sessionIndex => $schedule) {
                        // التحقق من التاريخ
                        if (empty($schedule['date'])) {
                            $validator->errors()->add("schedules.$trainingIndex.$sessionIndex.date", 'تاريخ الجلسة مطلوب');
                        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $schedule['date'])) {
                            $validator->errors()->add("schedules.$trainingIndex.$sessionIndex.date", 'تاريخ الجلسة يجب أن يكون بتنسيق Y-m-d');
                        }

                        // التحقق من وقت البدء
                        if (empty($schedule['start_time'])) {
                            $validator->errors()->add("schedules.$trainingIndex.$sessionIndex.start_time", 'وقت بدء الجلسة مطلوب');
                        } elseif (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $schedule['start_time'])) {
                            $validator->errors()->add("schedules.$trainingIndex.$sessionIndex.start_time", 'وقت بدء الجلسة يجب أن يكون بتنسيق H:i');
                        }

                        // التحقق من وقت الانتهاء
                        if (empty($schedule['end_time'])) {
                            $validator->errors()->add("schedules.$trainingIndex.$sessionIndex.end_time", 'وقت انتهاء الجلسة مطلوب');
                        } elseif (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $schedule['end_time'])) {
                            $validator->errors()->add("schedules.$trainingIndex.$sessionIndex.end_time", 'وقت انتهاء الجلسة يجب أن يكون بتنسيق H:i');
                        }

                        // التحقق من أن وقت الانتهاء بعد وقت البدء
                        if (!empty($schedule['start_time']) && !empty($schedule['end_time'])) {
                            if ($schedule['start_time'] >= $schedule['end_time']) {
                                $validator->errors()->add("schedules.$trainingIndex.$sessionIndex.end_time", 'وقت الانتهاء يجب أن يكون بعد وقت البداية');
                            }
                        }
                    }
                } else {
                    // التحقق من عدد الجلسات والساعات عند تحديد "الجلسات لاحقاً"
                    if (empty($numOfSessions[$trainingIndex])) {
                        $validator->errors()->add("num_of_session.$trainingIndex", 'عدد الجلسات مطلوب عند تحديد الجلسات لاحقاً');
                    }

                    if (empty($numOfHours[$trainingIndex])) {
                        $validator->errors()->add("num_of_hours.$trainingIndex", 'عدد الساعات مطلوب عند تحديد الجلسات لاحقاً');
                    }
                }
            }
        });
    }

    public function messages()
    {
        return [
            'program_title.required' => 'عنوان البرنامج مطلوب.',
            'program_title.array' => 'يجب أن يكون عنوان البرنامج مصفوفة.',
            'program_title.*.required' => 'كل عنوان برنامج مطلوب.',
            'program_title.*.string' => 'يجب أن يكون عنوان البرنامج نصًا.',
            'program_title.*.max' => 'عنوان البرنامج لا يمكن أن يتجاوز 255 حرفًا.',

            'trainer_id.required' => 'معرف المدرب مطلوب.',
            'trainer_id.array' => 'يجب أن تكون معرفات المدربين مصفوفة.',
            'trainer_id.*.required' => 'كل معرف مدرب مطلوب.',
            'trainer_id.*.exists' => 'معرف المدرب غير موجود.',

            'schedules_later.required' => 'خيار تحديد الجدول لاحقاً مطلوب.',
            'schedules_later.array' => 'يجب أن يكون خيار تحديد الجدول لاحقاً مصفوفة.',
            'schedules_later.*.boolean' => 'يجب أن تكون قيمة تحديد الجدول لاحقاً إما true أو false.',

            'num_of_session.*.integer' => 'عدد الجلسات يجب أن يكون رقمًا صحيحًا.',
            'num_of_session.*.min' => 'عدد الجلسات يجب أن يكون على الأقل 1.',

            'num_of_hours.*.numeric' => 'عدد الساعات يجب أن يكون رقمًا.',
            'num_of_hours.*.min' => 'عدد الساعات يجب أن يكون على الأقل 0.5.',

            'training_files.*.file' => 'كل ملف يجب أن يكون من نوع ملف صالح.',
            'training_files.*.mimes' => 'الملفات المسموحة هي: pdf, doc, docx, ppt, pptx, xls, xlsx, txt, jpg, jpeg, png, bmp, gif, svg, webp, mp4, mov, avi, mp3, wav, zip, rar.',
            'training_files.*.max' => 'كل ملف يجب ألا يتجاوز حجمه 20 ميغابايت.',
        ];
    }
}