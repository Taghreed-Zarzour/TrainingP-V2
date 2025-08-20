<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Models\OrgTrainingSchedule;
use App\Models\programType;
use App\Enums\TrainingAttendanceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\orgTrainingProgram\StoreAdditionalSettingsRequest;
use App\Http\Requests\orgTrainingProgram\StoreAssistantsRequest;
use App\Http\Requests\orgTrainingProgram\StoreBasicInformationRequest;
use App\Http\Requests\orgTrainingProgram\StoreSchedulingRequest;
use App\Http\Requests\orgTrainingProgram\StoreTrainingGoalsRequest;
use App\Http\Requests\orgTrainingProgram\updateBasicInformationRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\OrgTrainingClassification;
use App\Models\OrgTrainingDetail;
use App\Models\OrgTrainingProgram;
use App\Models\TrainingClassification;
use App\Models\trainingLevel;
use App\Models\TrainingProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrgTrainingController extends Controller
{
    public function showBasicInformationForm($orgTrainingId = null)
    {
    $orgTraining = $orgTrainingId ? OrgTrainingProgram::with('details', 'assistants', 'registrationRequirements', 'goals')->findOrFail($orgTrainingId) : null;

    return view('orgTrainings.basic-information', [
        'programType' => programType::all(),
        'programPresentationMethod' => TrainingAttendanceType::cases(),
        'levels' => trainingLevel::all(),
        'countries' => Country::all(),
        'languages' => Language::all(),
        'classifications' => TrainingClassification::all(),
        'training' => $orgTraining,
        'isEditMode' => (bool) $orgTrainingId,
    ]);
    }
public function storeBasicInformation(StoreBasicInformationRequest $request, $orgTrainingId = null)
{
    DB::beginTransaction();
    try {
        $isEditMode = (bool) $orgTrainingId;
        $orgTraining = $orgTrainingId
            ? OrgTrainingProgram::findOrFail($orgTrainingId)
            : new OrgTrainingProgram();
        
        $validatedData = $request->validated();

        $orgTraining->fill([
            'title' => $validatedData['title'],
            'language_id' => $validatedData['language_id'],
            'country_id' => $validatedData['country_id'],
            'city' => $validatedData['city'],
            'address_in_detail' => $validatedData['address_in_detail'],
            'program_type' => $validatedData['program_type'],
            'training_level_id' => $validatedData['training_level_id'],
            'program_presentation_method' => $validatedData['program_presentation_method'],
            'program_description' => $validatedData['program_description'],
        'org_training_classification_id' => (array) $validatedData['org_training_classification_id'] ?? [],
            'organization_id' => Auth::id(),
        ]);
        $orgTraining->save();
        
        DB::commit();
        
        // رسالة نجاح مختلفة للإنشاء والتحديث
        $message = $isEditMode ? 'تم تحديث المعلومات الأساسية بنجاح' : 'تم حفظ المعلومات الأساسية بنجاح';
        return redirect()->route('orgTraining.goals', $orgTraining->id)->with('success', $message);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تخزين معلومات التدريب: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage())
            ->withInput();
    }
}
public function updateBasicInformation(StoreBasicInformationRequest $request, $orgTrainingId)
{  \Log::info('Request data:', $request->all());
    DB::beginTransaction();
    try {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);
        
        $validatedData = $request->validated();
        $orgTraining->fill([
            'title' => $validatedData['title'],
            'language_id' => $validatedData['language_id'],
            'country_id' => $validatedData['country_id'],
            'city' => $validatedData['city'],
            'address_in_detail' => $validatedData['address_in_detail'],
            'program_type' => $validatedData['program_type'],
            'training_level_id' => $validatedData['training_level_id'],
            'program_presentation_method' => $validatedData['program_presentation_method'],
            'org_training_classification_id' => $validatedData['org_training_classification_id'],
            'program_description' => $validatedData['program_description'],
        ]);
        
        $orgTraining->save();
        
        DB::commit();
        return redirect()->route('orgTraining.goals', $orgTraining->id)
            ->with('success', 'تم تحديث المعلومات الأساسية بنجاح');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تحديث معلومات التدريب: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage())
            ->withInput();
    }
}

 // ======= الخطوة 2: أهداف التدريب =======
    public function showGoalsForm($orgTrainingId)
    {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);
        $trainingGoal = $orgTraining->goals()->firstOrNew();

        return view('orgTrainings.goals', [
            'training' => $orgTraining,
            'learning_outcomes' => $trainingGoal->learning_outcomes ?? [],
            'target_audience' => $trainingGoal->target_audience ?? [],
        ]);
    }
    public function storeGoals(StoreTrainingGoalsRequest $request, $orgTrainingId)
    {
        DB::beginTransaction();
        try {
            $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);

            // إنشاء أو تحديث سجل التفاصيل
            $trainingGoal = $orgTraining->goals()->firstOrNew([
            'org_training_program_id' => $orgTrainingId,
            ]);

            $trainingGoal->fill([
            'learning_outcomes' => $request->learning_outcomes ?? [],
            'target_audience' => $request->target_audience ?? [],
            ]);
            $trainingGoal->save();

            DB::commit();
            return redirect()->route('orgTraining.trainingDetail', $orgTraining->id);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('فشل تخزين أهداف التدريب: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
        }
    }

    // =======  الخطوة 3: إدارة الفريق و التوقيت و الملفات=======
    public function showtrainingDetailForm($orgTrainingId)
    {
        $orgTrainingDetails = OrgTrainingDetail::where('org_training_program_id', $orgTrainingId)->get();

        $trainingSchedules = [];
        $schedulesLater = 0;

        foreach ($orgTrainingDetails as $orgTrainingDetail) {
            $schedules = OrgTrainingSchedule::where('org_training_detail_id', $orgTrainingDetail->id)->get();
            $trainingSchedules[] = [
                'detail' => $orgTrainingDetail,
                'schedules' => $schedules,
                'schedule_later' => $schedules->contains('schedule_later', true) ? 1 : 0, 
            ];
        }
        $orgTraining = OrgTrainingProgram::find($orgTrainingId);

        $availableTrainers = User::whereHas('userType', function ($query) {
            $query->where('type', 'مدرب');
        })
        ->whereNotNull('email_verified_at') 
        ->get();

        $currentTeam = $orgTraining ? $orgTraining->assistants()->get() : collect();
        $currentTrainers = $currentTeam->whereNotNull('trainer_id')->pluck('trainer_id')->toArray();

        return view('orgTrainings.training-detail', [
            'training' => $orgTraining,
            'trainingSchedules' => $trainingSchedules, 
            'availableTrainers' => $availableTrainers,
            'currentTrainers' => $currentTrainers,
        ]);
    }

    public function storeTrainingDetails(StoreSchedulingRequest $request, $trainingId)
    {
        DB::beginTransaction();
        try {
            $orgTraining = OrgTrainingProgram::findOrFail($trainingId);

            // Process program titles and trainer IDs
            $programTitles = $request->program_title;
            $trainerIds = $request->trainer_id;

            if (!is_array($programTitles) || !is_array($trainerIds)) {
                throw new \Exception('Invalid input format for program titles or trainer IDs.');
            }

            // Create details for each program title
            foreach ($programTitles as $programTitle) {
                $orgTrainingDetail = $orgTraining->details()->create([
                    'program_title' => $programTitle,
                    'trainer_ids' => $trainerIds, // Assuming this can accept multiple IDs
                ]);

                // Process schedules
                if ($request->filled('schedules')) {
                    foreach ($request->schedules as $schedule) {
                        $orgTrainingDetail->trainingSchedules()->create([
                            'session_date' => $schedule['date'] ?? null,
                            'session_start_time' => $schedule['start_time'] ?? null,
                            'session_end_time' => $schedule['end_time'] ?? null,
                            'schedule_later' => $schedule['schedules_later'] ?? false, // Get schedules_later from each schedule
                            'num_of_session' => $schedule['num_of_session'] ?? null,
                            'num_of_hours' => $schedule['num_of_hours'] ?? null,
                        ]);
                    }
                }
            }

            // Handle training files
            if ($request->hasFile('training_files')) {
                $file = $request->file('training_files');
                $originalName = $file->getClientOriginalName();
                $orgTrainingDetail->training_files = $file->storeAs(
                    'orgTrainingProgram', 
                    $originalName, 
                    'public'
                );
            }

            DB::commit();
            return redirect()->route('orgTraining.assistants', $orgTraining->id);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('فشل تخزين تفاصيل التدريب: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function showAssistantForm($orgTrainingId)
    {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);

        $availableAssistants = User::whereHas('userType', function ($query) {
            $query->where('type', 'مساعد');
        })->get();

        // الحصول على المساعدين الحاليين
        $currentTeam = $orgTraining->assistants()->get();
        $currentAssistants = $currentTeam->whereNotNull('assistant_id')->pluck('assistant_id')->toArray();
        return view('orgTrainings.assistants', [
            'training' => $orgTraining,
            'availableAssistants' => $availableAssistants,
            'currentAssistants' => $currentAssistants,
        ]);
    }
    public function storeAssistants(StoreAssistantsRequest $request, $orgTrainingId)
    {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);
        $allAssistantIds = array_merge($request->input('assistant_ids', []), $request->input('additional_assistant_ids', []));
    
        foreach ($allAssistantIds as $assistantId) {
            $orgTraining->assistants()->create([
                'org_training_program_id' => $orgTraining->id,
                'assistant_id' => $assistantId,
            ]);
        }
    
        return redirect()->route('orgTraining.settings', $orgTraining->id)
            ->with('success', 'تم إضافة المساعدين بنجاح.');
    }

// ======= الخطوة 5: الإعدادات الإضافية =======
    public function showSettingsForm($orgTrainingId)
    {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);

        // استخدام firstOrNew بدلاً من firstOrCreate
        // هذا لا ينشئ سجلاً في قاعدة البيانات، فقط يعد كائن للعرض
        $settings = $orgTraining->registrationRequirements()->firstOrNew([
            'org_training_program_id' => $orgTrainingId,
        ]);

        // تحويل صور التدريب إلى مصفوفة إذا كانت موجودة
        $training_image = [];
        if ($settings->training_image) {
            $training_image = is_string($settings->training_image)
                ? json_decode($settings->training_image, true)
                : $settings->training_image;
        }

        // التأكد من أن application_submission_method هي قيمة نصية
        $submissionMethod = $settings->application_submission_method;
        if (is_object($submissionMethod)) {
            $submissionMethod = $submissionMethod->value;
        }

        if (!$settings->welcome_message) {
            $settings->welcome_message = "شكرًا لتسجيلك في التدريب. يسعدنا أن تكون/ي جزءًا من هذا البرنامج، ونتطلع إلى رحلة مليئة بالتعلّم  والتطوير.
            سيتم مراجعة طلبك وإشعارك بالقبول أو الاعتذار في أقرب وقت، لذا تأكد/ي من متابعة بريدك الإلكتروني أو الإشعارات داخل المنصة.";
        }


        return view('orgTrainings.settings', [
            'training' => $orgTraining,
            'settings' => $settings,
            'countries' => Country::all(),
            'training_files' => $training_image,
            'submissionMethod' => $submissionMethod,  
        ]);
    }

public function storeSettings(StoreAdditionalSettingsRequest $request, $orgTrainingId)
{
    DB::beginTransaction();
    try {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);
        
        // Use firstOrCreate to either find or create the settings
        $settings = $orgTraining->registrationRequirements()->firstOrCreate([
            'org_training_program_id' => $orgTrainingId,
        ], [
            'is_free' => 0, // Default value
            'application_deadline' => now()->addDays(30),
            'application_submission_method' => 'inside_platform',
            'max_trainees' => 20,
            'requirements' => "Student",
            'benefits' => 'learning',
            'welcome_message' => "شكرًا لتسجيلك في التدريب. يسعدنا أن تكون/ي جزءًا من هذا البرنامج، ونتطلع إلى رحلة مليئة بالتعلم والتطوير.",
        ]);
        
        // Get validated data
        $data = $request->validated();

        // Clear cost-related fields if training is free
        if ($data['is_free']) {
            $data['cost'] = null;
            $data['currency'] = null;
            $data['payment_method'] = null;
        }

        // Ensure application submission method has a default value
        if (!isset($data['application_submission_method'])) {
            $data['application_submission_method'] = 'inside_platform';
        }

        // Handle the training image upload
        if ($request->hasFile('training_image')) {
            // Get the original file name
            $originalName = $request->file('training_image')->getClientOriginalName();
            
            // Define the path where you want to store the image
            $path = 'training/training_image/' . $originalName;
        
            // Store the uploaded image
            $request->file('training_image')->storeAs('training/training_image', $originalName, 'public');
            $data['training_image'] = $path;
        
            // Delete old image if exists
            if ($settings->training_image) {
                Storage::disk('public')->delete($settings->training_image);
            }
        }

        // Fill all attributes
        $settings->fill([
            'org_training_program_id' => $orgTrainingId,
            'cost' => $data['cost'],
            'is_free' => $data['is_free'] ,
            'currency' => $data['currency'],
            'payment_method' => $data['payment_method'],
            'application_deadline' => $data['application_deadline'],
            'max_trainees' => $data['max_trainees'],
            'application_submission_method' => $data['application_submission_method'],
            'registration_link' => $data['registration_link'] ?? null,
            'requirements' => $data['requirements'] ?? null,
            'benefits' => $data['benefits'] ?? null,
            'training_image' => $data['training_image'] ?? null,
            'welcome_message' => $data['welcome_message'] ?? $settings->welcome_message, // Preserve old message if not updated
        ]);
        
        $settings->save();
        
        DB::commit();
        return redirect()->route('orgTraining.review', $orgTraining->id)
            ->with('success', 'تم حفظ الإعدادات بنجاح.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تخزين إعدادات التدريب: ' . $e->getMessage());
        return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
    }
}

public function showReviewForm($orgTrainingId)
{
    // Retrieve the training program and related data
    $orgTraining = OrgTrainingProgram::with([
        'details',
        'assistants',
        'registrationRequirements',
        'goals',
        'language',
        'trainingClassification',
        'trainingLevel'
    ])->findOrFail($orgTrainingId);
    
    // Prepare submission method label
    $applicationSubmissionMethodLabel = null;
    if (!empty($orgTraining->registrationRequirements) && !empty($orgTraining->registrationRequirements->application_submission_method)) {
        if (is_object($orgTraining->registrationRequirements->application_submission_method)) {
            $applicationSubmissionMethodLabel = $orgTraining->registrationRequirements->application_submission_method->label();
        } else {
            try {
                $applicationSubmissionMethodLabel = \App\Enums\ApplicationSubmissionMethod::from($orgTraining->registrationRequirements->application_submission_method)->label();
            } catch (\ValueError $e) {
                $applicationSubmissionMethodLabel = 'غير محدد';
            }
        }
    }
    
    // Prepare training files
    $trainingFiles = [];
    if (!empty($orgTraining->registrationRequirements) && !empty($orgTraining->registrationRequirements->training_image)) {
        $trainingFiles = is_string($orgTraining->registrationRequirements->training_image)
            ? json_decode($orgTraining->registrationRequirements->training_image, true) 
            : $orgTraining->registrationRequirements->training_image;
    }
    
    // Prepare learning outcomes
    $learningOutcomes = [];
    if (!empty($orgTraining->goals) && !empty($orgTraining->goals->learning_outcomes)) {
        $learningOutcomes = json_decode($orgTraining->goals->learning_outcomes ?? '[]', true);
    }
    
    // Prepare requirements
    $requirements = [];
    if (!empty($orgTraining->registrationRequirements) && !empty($orgTraining->registrationRequirements->requirements)) {
        $requirements = json_decode($orgTraining->registrationRequirements->requirements ?? '[]', true);
    }
    
    // Prepare target audience
    $targetAudience = [];
    if (!empty($orgTraining->goals) && !empty($orgTraining->goals->target_audience)) {
        $targetAudience = json_decode($orgTraining->goals->target_audience ?? '[]', true);
    }
    
    // Prepare benefits
    $benefits = [];
    if (!empty($orgTraining->registrationRequirements) && !empty($orgTraining->registrationRequirements->benefits)) {
        $benefits = json_decode($orgTraining->registrationRequirements->benefits ?? '[]', true);
    }
    
    // Prepare welcome message
    $welcomeMessage = 'مرحباً بكم في برنامجنا التدريبي! نحن سعداء بانضمامكم إلينا ونتطلع لتقديم تجربة تعليمية مميزة تلبي توقعاتكم وتساعدكم على تحقيق أهدافكم المهنية.';
    if (!empty($orgTraining->registrationRequirements) && !empty($orgTraining->registrationRequirements->welcome_message)) {
        $welcomeMessage = $orgTraining->registrationRequirements->welcome_message;
    }
    
    return view('orgTrainings.review', [
        'training' => $orgTraining,
        'learning_outcomes' => $learningOutcomes,
        'requirements' => $requirements,
        'target_audience' => $targetAudience,
        'benefits' => $benefits,
        'training_files' => $trainingFiles,
        'application_submission_method_label' => $applicationSubmissionMethodLabel,
        'welcome_message' => $welcomeMessage,
    ]);
}

}
