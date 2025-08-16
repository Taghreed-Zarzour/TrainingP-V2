<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Enums\programType;
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
    $orgTraining = $orgTrainingId ? OrgTrainingProgram::with('detail', 'assistants', 'registrationRequirements', 'goals')->findOrFail($orgTrainingId) : null;
    return view('orgTrainings.basic-information', [
        'programType' => programType::cases(),
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
            'org_training_classification_id' =>(array) $validatedData['org_training_classification_id'] ?? [],
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
public function updateBasicInformation(updateBasicInformationRequest $request, $orgTrainingId)
{
    DB::beginTransaction();
    try {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);
        
        $validatedData = $request->validated();
        $orgTraining->fill([
            'title' => $validatedData,
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
    // Get training program details
    $orgTrainingDetail = OrgTrainingDetail::where('org_training_program_id', $orgTrainingId)->first();

    // Prepare data for the schedule part
    $schedulesLater = $orgTrainingDetail ? ($orgTrainingDetail->schedule_later ? 1 : 0) : 0;
    $sessions = $orgTrainingDetail ? ($orgTrainingDetail->sessions ?? collect()) : collect(); // Ensure it's a collection even if null

    // Get organization training program for detail part
    $orgTraining = OrgTrainingProgram::find($orgTrainingId); // Simplified lookup

   // Prepare available trainers
    $availableTrainers = User::whereHas('userType', function ($query) {
        $query->where('type', 'مدرب');
    })->get();

   // Get current trainers and assistants
    $currentTeam = $orgTraining ? $orgTraining->assistants()->get() : collect();
    $currentTrainers = $currentTeam->whereNotNull('trainer_id')->pluck('trainer_id')->toArray();

    return view('orgTrainings.training-detail', [
        'training' => $orgTraining,
        'sessions' => $sessions,
        'schedules_later' => $schedulesLater,
        'availableTrainers' => $availableTrainers,
        'currentTrainers' => $currentTrainers,
        'orgTrainingDetail' => $orgTrainingDetail, // Pass the detail to the view
    ]); 
}

public function storeTrainingDetails(StoreSchedulingRequest $request, $trainingId)
{
    DB::beginTransaction();
    try {
        // Retrieve the training program
        $orgTraining = OrgTrainingProgram::findOrFail($trainingId);
        
        // Update schedules_later
        $orgTrainingDetail = $orgTraining->details()->first(); // Get the first detail entry
        if ($orgTrainingDetail) {
            $orgTrainingDetail->schedules_later = $request->boolean('schedules_later');
            $orgTrainingDetail->save();
        } else {
            // Handle case where there are no existing details
            $orgTrainingDetail = new OrgTrainingDetail();
            $orgTrainingDetail->org_training_program_id = $orgTraining->id;
            $orgTrainingDetail->schedules_later = $request->boolean('schedules_later');
        }

        // Prepare data for a single entry
        $data = [
            'org_training_program_id' => $orgTraining->id,
            'program_title' => $request->program_title,
            'training_files' => null, // Initialize file path
            'sessions' => $request->schedules ?? [], // Initialize sessions
            'trainer_ids' => $request->trainer_id ?? [], // Initialize trainer IDs
        ];

        // Handle schedules
        if (!$orgTrainingDetail->schedules_later && $request->filled('schedules')) {
            foreach ($request->schedules as $schedule) {
                // Collect session data
                $data['sessions'][] = [
                    'date' => $schedule['date'] ?? null,
                    'start_time' => $schedule['start_time'] ?? null,
                    'end_time' => $schedule['end_time'] ?? null,
                ];
            }
        }

        // Handle trainers
        if ($request->filled('trainer_id')) {
            foreach ($request->trainer_id as $trainerId) {
                $data['trainer_ids'][] = $trainerId;
            }
        }

        // Handle file upload if present
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $data['training_files'] = $file->storeAs('orgTrainingProgram', $originalName, 'public');
        }
        // Create a single entry in OrgTrainingDetail
        OrgTrainingDetail::create([
            'org_training_program_id' => $data['org_training_program_id'],
            'program_title' => $data['program_title'],
            'training_files' => $data['training_files'],
            'session_start_time' => $data['sessions']['start_time'],
            'session_end_time' => $data['sessions']['end_time'],
            'session_date' => $data['sessions']['date'], // Store sessions as array
            'trainer_ids' => $data['trainer_ids'], // Store trainer IDs as array
        ]);

        DB::commit();
        return redirect()->route('orgTraining.settings', $orgTraining->id);
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

    // Clear existing assistants
    $orgTraining->assistants()->delete();

    // Store new assistants with org_training_program_id
    foreach ($request->assistant_ids as $assistantId) {
        $orgTraining->assistants()->create([
            'org_training_program_id' => $orgTraining->id, // Store the training program ID
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
        $settings = $orgTraining->additionalSetting()->firstOrCreate([
            'org_training_program_id' => $orgTrainingId,
        ], [
            'is_free' => 0, // Default value
            'application_deadline' => now()->addDays(30),
            'application_submission_method' => 'inside_platform',
            'max_trainees' => 20,
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
            // Store the uploaded image
            $path = $request->file('training_image')->store('training/training_image', 'public');
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
            'is_free' => $data['is_free'],
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

}
