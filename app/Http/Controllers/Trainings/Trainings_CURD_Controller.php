<?php
namespace App\Http\Controllers\Trainings;
use App\Enums\JobPositionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingCreate\StoreAdditionalSettingsRequest;
use App\Http\Requests\TrainingCreate\StoreBasicInformationRequest;
use App\Http\Requests\TrainingCreate\StoreSchedulingRequest;
use App\Http\Requests\TrainingCreate\StoreTrainingAssistantRequest;
use App\Http\Requests\TrainingCreate\StoreTrainingGoalsRequest;
use App\Models\AdditionalSetting;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\Language;
use App\Models\programType;
use App\Models\schedulingTrainingSessions;
use App\Models\TrainingAssistantManagement;
use App\Models\TrainingClassification;
use App\Models\TrainingDetail;
use App\Models\trainingLevel;
use App\Models\TrainingProgram;
use App\Models\User;
use App\Enums\TrainingAttendanceType;
use App\Models\WorkSector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class Trainings_CURD_Controller extends Controller
{
  // ======= الخطوة 1: معلومات التدريب الأساسية =======
  public function showBasicInformationForm($trainingId = null)
  {
    $training = $trainingId ? TrainingProgram::with('detail', 'assistants', 'sessions', 'AdditionalSetting')->findOrFail($trainingId) : null;
    return view('trainings.basic-information', [
      'types' => programType::all(),
      'levels' => trainingLevel::all(),
      'languages' => Language::all(),
      'classifications' => TrainingClassification::all(),
      'training' => $training,
      'isEditMode' => (bool) $trainingId,
    ]);
  }
public function storeBasicInformation(StoreBasicInformationRequest $request, $trainingId = null)
{
    DB::beginTransaction();
    try {
        $isEditMode = (bool) $trainingId;
        $training = $trainingId
            ? TrainingProgram::findOrFail($trainingId)
            : new TrainingProgram();
            
        $training->fill([
            'title' => $request->title,
            'description' => $request->description,
            'program_type_id' => $request->program_type_id,
            'language_type_id' => $request->language_type_id,
            'training_classification_id' => $request->training_classification_id,
            'training_level_id' => $request->training_level_id,
            'program_presentation_method_id' => $request->program_presentation_method_id,
            'user_id' => Auth::id(),
            'schedules_later' => false,
        ]);
        
        $training->save();
        
        DB::commit();
        
        // رسالة نجاح مختلفة للإنشاء والتحديث

        return redirect()->route('training.goals', $training->id);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تخزين معلومات التدريب: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage())
            ->withInput();
    }
}
public function updateBasicInformation(StoreBasicInformationRequest $request, $trainingId)
{
    DB::beginTransaction();
    try {
        $training = TrainingProgram::findOrFail($trainingId);
        
        $training->fill([
            'title' => $request->title,
            'description' => $request->description,
            'program_type_id' => $request->program_type_id,
            'language_type_id' => $request->language_type_id,
            'training_classification_id' => $request->training_classification_id,
            'training_level_id' => $request->training_level_id,
            'program_presentation_method_id' => $request->program_presentation_method_id,
        ]);
        
        $training->save();
        
        DB::commit();
        return redirect()->route('training.goals', $training->id)
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
public function showGoalsForm($trainingId)
{
    $training = TrainingProgram::findOrFail($trainingId);
    $trainingDetail = $training->detail()->firstOrNew();
    $educationLevels = EducationLevel::all();
    $workSectors = WorkSector::all();
    $countries = Country::all();
    $jobPositions = JobPositionEnum::cases();

    // تحضير بيانات الفئة المستهدفة
    $targetAudienceData = [
        'education_level_id' => json_decode($trainingDetail->education_level_id ?? '[]', true),
        'work_status' => json_decode($trainingDetail->work_status ?? '[]', true),
        'work_sector_id' => json_decode($trainingDetail->work_sector_id ?? '[]', true),
        'job_position' => json_decode($trainingDetail->job_position ?? '[]', true),
        'country_id' => json_decode($trainingDetail->country_id ?? '[]', true),
    ];

    return view('trainings.goals', [
        'training' => $training,
        'trainingDetail' => $trainingDetail,
        'learning_outcomes' => json_decode($trainingDetail->learning_outcomes ?? '[]', true),
        'requirements' => json_decode($trainingDetail->requirements ?? '[]', true),
        'benefits' => json_decode($trainingDetail->benefits ?? '[]', true),
        'educationLevels' => $educationLevels, 
        'workSectors' => $workSectors, 
        'countries' => $countries,
        'jobPositions' => $jobPositions,
        'targetAudienceData' => $targetAudienceData
    ]);
}
  public function storeGoals(StoreTrainingGoalsRequest $request, $trainingId)
  {
    DB::beginTransaction();
    try {
      $training = TrainingProgram::findOrFail($trainingId);

      // إنشاء أو تحديث سجل التفاصيل
      $trainingDetail = $training->detail()->firstOrNew([
        'training_program_id' => $trainingId,
      ]);

      $trainingDetail->fill([
        'learning_outcomes' => json_encode($request->learning_outcomes ?? []),
        'requirements' => json_encode($request->requirements ?? []),
        'benefits' => json_encode($request->benefits ?? []),
        
        'education_level_id' => json_encode($request->education_level_id ?? []),
        'work_sector_id' => json_encode($request->work_sector_id ?? []),
        'job_position' => json_encode($request->job_position ?? []),
        'country_id' => json_encode($request->country_id ?? []),
        'work_status' => json_encode($request->work_status ?? []),
    ]);
    
      $trainingDetail->save();

      DB::commit();
      return redirect()->route('training.team', $training->id);
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error('فشل تخزين أهداف التدريب: ' . $e->getMessage());
      return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
    }
  }

  // ======= الخطوة 3: إدارة الفريق =======
public function showTeamForm($trainingId)
{
    $training = TrainingProgram::findOrFail($trainingId);
    $availableTrainers = User::whereHas('userType', function ($query) {
        $query->where('type', 'مدرب');
    })->get();
    $availableAssistants = User::whereHas('userType', function ($query) {
        $query->where('type', 'مساعد');
    })->get();
    
    // الحصول على المدربين والمساعدين الحاليين
    $teamManagement = $training->assistants()->first();
    
    $currentTrainers = [];
    $currentAssistants = [];
    
    if ($teamManagement) {
        $currentTrainers = $teamManagement->getAllTrainers();
        $currentAssistants = $teamManagement->getAllAssistants();
    }
    
    return view('trainings.team', [
        'training' => $training,
        'availableTrainers' => $availableTrainers,
        'availableAssistants' => $availableAssistants,
        'currentTrainers' => $currentTrainers,
        'currentAssistants' => $currentAssistants,
    ]);
}

public function storeTeam(StoreTrainingAssistantRequest $request, $trainingId)
{
    DB::beginTransaction();
    try {
        $training = TrainingProgram::findOrFail($trainingId);
        $userType = auth()->user()->userType?->type;
        
        // البحث عن سجل الفريق الحالي أو إنشاء سجل جديد
        $teamManagement = $training->assistants()->first();
        
        if (!$teamManagement) {
            $teamManagement = new trainingAssistantManagement();
            $teamManagement->training_program_id = $training->id;
        }
        
        // التحقق من نوع المستخدم
        if ($userType !== 'مؤسسة') {
            // للمدرب: يمكن اختيار مدرب مشارك واحد ومساعد واحد فقط
            $teamManagement->trainer_id = !empty($request->trainer_ids) ? $request->trainer_ids[0] : null;
            $teamManagement->assistant_id = !empty($request->assistant_ids) ? $request->assistant_ids[0] : null;
            $teamManagement->trainer_ids = null;
            $teamManagement->assistant_ids = null;
        } else {
            // للمؤسسة: يمكن اختيار مجموعة من المدربين والمساعدين
            $teamManagement->trainer_id = null;
            $teamManagement->assistant_id = null;
            $teamManagement->trainer_ids = !empty($request->trainer_ids) ? $request->trainer_ids : null;
            $teamManagement->assistant_ids = !empty($request->assistant_ids) ? $request->assistant_ids : null;
        }
        
        $teamManagement->save();
        
        DB::commit();
        return redirect()->route('training.schedule', $training->id);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تخزين فريق التدريب: ' . $e->getMessage());
        return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
    }
}


  // ======= الخطوة 4: جدولة الجلسات =======
public function showScheduleForm($trainingId)
{
    $training = TrainingProgram::findOrFail($trainingId);
    // تحويل قيمة schedules_later إلى قيمة يمكن استخدامها في النموذج
    $schedulesLater = $training->schedules_later ? 1 : 0;
    
    return view('trainings.schedule', [
        'training' => $training,
        'sessions' => $training->sessions ?? collect(), // تأكد من أنه مجموعة حتى لو كان null
        'schedules_later' => $schedulesLater, // تمرير القيمة المحولة
        'num_of_session' => $training->num_of_session, // تمرير عدد الجلسات
        'num_of_hours' => $training->num_of_hours, // تمرير عدد الساعات
    ]);
}
public function storeSchedule(StoreSchedulingRequest $request, $trainingId)
{
    DB::beginTransaction();
    try {
        $training = TrainingProgram::findOrFail($trainingId);
        
        // تحديث قيمة schedules_later
        $training->schedules_later = $request->boolean('schedules_later');
        
        // تحديث عدد الساعات والجلسات إذا تم تحديد الجلسات لاحقًا
        if ($training->schedules_later) {
            $training->num_of_session = $request->num_of_session;
            $training->num_of_hours = $request->num_of_hours;
        }
        
        $training->save();
        
        // حذف الجدول القديم دائماً (إلا إذا تم اختيار تحديد لاحق)
        if (!$training->schedules_later) {
            $training->sessions()->delete();
            
            // إضافة الجدول الجديد إذا كانت هناك جلسات
            if ($request->filled('schedules')) {
                foreach ($request->schedules as $schedule) {
                    schedulingTrainingSessions::create([
                        'training_program_id' => $training->id,
                        'session_date' => $schedule['session_date'],
                        'session_start_time' => $schedule['session_start_time'],
                        'session_end_time' => $schedule['session_end_time'],
                    ]);
                }
            }
        }
        
        DB::commit();
        return redirect()->route('training.settings', $training->id);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تخزين جدولة التدريب: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage())
            ->withInput();
    }
}
  // ======= الخطوة 5: الإعدادات الإضافية =======
  public function showSettingsForm($trainingId)
  {
    $training = TrainingProgram::findOrFail($trainingId);

    // استخدام firstOrNew بدلاً من firstOrCreate
    // هذا لا ينشئ سجلاً في قاعدة البيانات، فقط يعد كائن للعرض
    $settings = $training->AdditionalSetting()->firstOrNew([
      'training_program_id' => $trainingId,
    ]);

    // تحويل ملفات التدريب إلى مصفوفة إذا كانت موجودة
    $trainingFiles = [];
    if ($settings->training_files) {
      $trainingFiles = is_string($settings->training_files)
        ? json_decode($settings->training_files, true)
        : $settings->training_files;
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


    return view('trainings.settings', [
      'training' => $training,
      'settings' => $settings,
      'countries' => Country::all(),
      'training_files' => $trainingFiles,
      'submissionMethod' => $submissionMethod,  
      ]);
  }

public function storeSettings(StoreAdditionalSettingsRequest $request, $trainingId)
{
    DB::beginTransaction();
    try {
        $training = TrainingProgram::findOrFail($trainingId);
        
        $settings = $training->AdditionalSetting()->firstOrCreate([
            'training_program_id' => $trainingId,
        ], [
            'is_free' => 1,
            'application_deadline' => now()->addDays(30),
            'application_submission_method' => 'inside_platform',
            'max_trainees' => 20,
            'training_files' => json_encode([]),
            'welcome_message' => "شكرًا لتسجيلك في التدريب. يسعدنا أن تكون/ي جزءًا من هذا البرنامج، ونتطلع إلى رحلة مليئة بالتعلّم  والتطوير.
سيتم مراجعة طلبك وإشعارك بالقبول أو الاعتذار في أقرب وقت، لذا تأكد/ي من متابعة بريدك الإلكتروني أو الإشعارات داخل المنصة.",
        ]);
        
        $data = $request->validated();
        
        // إذا كانت الدورة مجانية، فامسح حقول التكلفة
        if ($data['is_free']) {
            $data['cost'] = null;
            $data['currency'] = null;
            $data['payment_method'] = null;
        }
        
        // التأكد من وجود قيمة لطريقة التقديم
        if (!isset($data['application_submission_method'])) {
            $data['application_submission_method'] = 'inside_platform';
        }
        
        // التأكد من أن القيمة نصية وليست كائن
        if (is_object($data['application_submission_method'])) {
            $data['application_submission_method'] = $data['application_submission_method']->value;
        }
        
        // معالجة صورة الملف الشخصي
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('training/profile_images', 'public');
            $data['profile_image'] = $path;
            
            // حذف الصورة القديمة إذا وجدت
            if ($settings->profile_image) {
                Storage::disk('public')->delete($settings->profile_image);
            }
        }
        
        // معالجة ملفات التدريب
        $trainingFiles = $this->processTrainingFiles($request, $settings);
        $data['training_files'] = json_encode($trainingFiles);
        
        $settings->fill($data);
        $settings->save();
        
        DB::commit();
        return redirect()->route('training.review', $training->id);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تخزين إعدادات التدريب: ' . $e->getMessage());
        return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
    }
}
protected function processTrainingFiles($request, $settings)
{
    $trainingFiles = [];
    
    // الحصول على الملفات الحالية
    if ($settings->training_files) {
        $trainingFiles = is_string($settings->training_files)
            ? json_decode($settings->training_files, true)
            : $settings->training_files;
    }
    
    // حذف الملفات المحددة
    if ($request->has('files_to_delete')) {
        $filesToDelete = $request->files_to_delete;
        
        foreach ($filesToDelete as $fileToDelete) {
            // البحث عن الملف في المصفوفة الحالية
            $key = array_search($fileToDelete, $trainingFiles);
            
            if ($key !== false) {
                // حذف الملف من التخزين
                Storage::disk('public')->delete($trainingFiles[$key]);
                
                // حذف الملف من المصفوفة
                unset($trainingFiles[$key]);
            }
        }
        
        // إعادة فهرسة المصفوفة
        $trainingFiles = array_values($trainingFiles);
    }
    
    // إضافة الملفات الجديدة
    if ($request->hasFile('training_files')) {
        foreach ($request->file('training_files') as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $timestamp = now()->format('Ymd_His');
            $uniqueFilename = $filename . '_' . $timestamp . '.' . $extension;
            $path = $file->storeAs('training/files', $uniqueFilename, 'public');
            $trainingFiles[] = $path;
        }
    }
    
    return $trainingFiles;
}

  // ======= الخطوة 6: المراجعة النهائية =======
public function showReviewForm($trainingId)
{
    $training = TrainingProgram::with([
        'detail',
        'assistants.trainer',
        'assistants.assistant',
        'sessions',
        'AdditionalSetting.country',
        'programType',
        'trainingClassification',
        'trainingLevel',
        'language'
    ])->findOrFail($trainingId);
    
    // تجهيز البيانات للعرض
    $applicationSubmissionMethodLabel = null;
    if (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->application_submission_method)) {
        if (is_object($training->AdditionalSetting->application_submission_method)) {
            $applicationSubmissionMethodLabel = $training->AdditionalSetting->application_submission_method->label();
        } else {
            try {
                $applicationSubmissionMethodLabel = \App\Enums\ApplicationSubmissionMethod::from($training->AdditionalSetting->application_submission_method)->label();
            } catch (\ValueError $e) {
                $applicationSubmissionMethodLabel = 'غير محدد';
            }
        }
    }
    
    // تجهيز ملفات التدريب مع التحقق من وجود الإعدادات
    $trainingFiles = [];
    if (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->training_files)) {
        $trainingFiles = is_string($training->AdditionalSetting->training_files)
            ? json_decode($training->AdditionalSetting->training_files, true) 
            : $training->AdditionalSetting->training_files;
    }
    
    // تجهيز بيانات التفاصيل مع التحقق من وجودها
    $learningOutcomes = [];
    if (!empty($training->detail) && !empty($training->detail->learning_outcomes)) {
        $learningOutcomes = json_decode($training->detail->learning_outcomes ?? '[]', true);
    }
    
    $requirements = [];
    if (!empty($training->detail) && !empty($training->detail->requirements)) {
        $requirements = json_decode($training->detail->requirements ?? '[]', true);
    }
    
    $targetAudience = [];
    if (!empty($training->detail) && !empty($training->detail->target_audience)) {
        $targetAudience = json_decode($training->detail->target_audience ?? '[]', true);
    }
    
    $benefits = [];
    if (!empty($training->detail) && !empty($training->detail->benefits)) {
        $benefits = json_decode($training->detail->benefits ?? '[]', true);
    }
    
    // تجهيز الرسالة الترحيبية
    $welcomeMessage = 'مرحباً بكم في برنامجنا التدريبي! نحن سعداء بانضمامكم إلينا ونتطلع لتقديم تجربة تعليمية مميزة تلبي توقعاتكم وتساعدكم على تحقيق أهدافكم المهنية.';
    if (!empty($training->AdditionalSetting) && !empty($training->AdditionalSetting->welcome_message)) {
        $welcomeMessage = $training->AdditionalSetting->welcome_message;
    }
    
    return view('trainings.review', [
        'training' => $training,
        'learning_outcomes' => $learningOutcomes,
        'requirements' => $requirements,
        'target_audience' => $targetAudience,
        'benefits' => $benefits,
        'training_files' => $trainingFiles,
        'application_submission_method_label' => $applicationSubmissionMethodLabel,
        'welcome_message' => $welcomeMessage,
    ]);
}
public function publishTraining($trainingId)
  {
    try {
      $training = TrainingProgram::findOrFail($trainingId);
            //يجب فحص حقل مطلوب من كل خطوة بعدها جعل التدريب منشور للتاكد انه مر على الخطوات
      $training->update(['status' => 'online']);

      return redirect()->route('training.completed', $training->id)
        ->with('success', 'تم نشر البرنامج التدريبي بنجاح');
    } catch (\Exception $e) {
      \Log::error('فشل نشر التدريب: ' . $e->getMessage());
      return redirect()->back()->with('error', 'حدث خطأ أثناء النشر: ' . $e->getMessage());
    }
  }

  // ======= صفحة الإكمال =======
  public function showCompletionPage($trainingId)
  {
    $training = TrainingProgram::findOrFail($trainingId);
    return view('trainings.completed', compact('training'));
  }
}