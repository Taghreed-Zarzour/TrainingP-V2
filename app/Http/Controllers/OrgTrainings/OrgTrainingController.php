<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Enums\JobPositionEnum;
use App\Models\EducationLevel;
use App\Models\OrgTrainingDetailFile;
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
use App\Models\WorkSector;
use App\Services\TrainingAnnouncementService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Enrollment;
class OrgTrainingController extends Controller
{

  public function showBasicInformationForm($orgTrainingId = null)
  {
    $orgTraining = $orgTrainingId ? OrgTrainingProgram::with('details', 'assistants', 'registrationRequirements', 'goals')
    ->findOrFail($orgTrainingId) : null;

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
      return redirect()->route('orgTraining.goals', $orgTraining->id);
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error('فشل تخزين معلومات التدريب: ' . $e->getMessage());
      return redirect()->back()
        ->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage())
        ->withInput();
    }
  }
  public function updateBasicInformation(StoreBasicInformationRequest $request, $orgTrainingId)
  {
    \Log::info('Request data:', $request->all());
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

    // البحث عن أهداف التدريب أو إنشاء جديد
    $trainingGoal = $orgTraining->goals()->firstOrCreate(
        ['org_training_program_id' => $orgTrainingId],
        [
            'learning_outcomes' => [],
            'education_level_id' => [],
            'work_status' => [],
            'work_sector_id' => [],
            'job_position' => [],
            'country_id' => []
        ]
    );

    $educationLevels = EducationLevel::all();
    $workSectors = WorkSector::all();
    $countries = Country::all();
    $jobPositions = JobPositionEnum::cases();

    return view('orgTrainings.goals', [
        'training' => $orgTraining,
        'trainingGoal' => $trainingGoal, // تمرير كائن trainingGoal بالكامل
        'educationLevels' => $educationLevels, // تصحيح التسمية
        'workSectors' => $workSectors, // تصحيح التسمية
        'countries' => $countries,
        'jobPositions' => $jobPositions // تصحيح التسمية
    ]);
}
public function storeGoals(StoreTrainingGoalsRequest $request, $orgTrainingId)
{
    DB::beginTransaction();
    try {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);

        $trainingGoal = $orgTraining->goals()->updateOrCreate(
            ['org_training_program_id' => $orgTrainingId],
            [
                'learning_outcomes' => $request->learning_outcomes ?? [],
                'education_level_id' => $request->education_level_id ?? [],
                'work_status' => $request->work_status?? [],
                'work_sector_id' => $request->work_sector_id ?? [],
                'job_position' => $request->job_position ?? [],
                'country_id' => $request->country_id ?? [],
            ]
        );

        DB::commit();
        return redirect()->route('orgTraining.trainingDetail', $orgTraining->id);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تخزين أهداف التدريب: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
            ->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
    }
}
  // =======  الخطوة 3: إدارة الفريق و التوقيت و الملفات=======
// في الدالة showtrainingDetailForm()
public function showtrainingDetailForm($orgTrainingId)
{
    $orgTraining = OrgTrainingProgram::find($orgTrainingId);

    // الحصول على تفاصيل التدريب
    $orgTrainingDetails = OrgTrainingDetail::where('org_training_program_id', $orgTrainingId)->get();

    // الحصول على الجداول الزمنية لكل تدريب
    $trainings = collect();
    $schedulesLater = false;

    // جمع الملفات من جدول org_training_detail_files
    $allTrainingFiles = [];
    $trainingFilesRecord = OrgTrainingDetailFile::where('org_training_program_id', $orgTrainingId)->first();

    if ($trainingFilesRecord && $trainingFilesRecord->training_files) {
        // معالجة البيانات سواء كانت JSON أو array أو string
        if (is_string($trainingFilesRecord->training_files)) {
            // محاولة تحليل JSON
            $decoded = json_decode($trainingFilesRecord->training_files, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $allTrainingFiles = $decoded;
            } else {
                // إذا فشل تحليل JSON، افترض أنه مسار ملف واحد
                $allTrainingFiles = [$trainingFilesRecord->training_files];
            }
        } elseif (is_array($trainingFilesRecord->training_files)) {
            $allTrainingFiles = $trainingFilesRecord->training_files;
        }
    }

    foreach ($orgTrainingDetails as $detail) {
        $schedules = OrgTrainingSchedule::where('org_training_detail_id', $detail->id)->get();
        $scheduleLater = $detail->schedule_later;

        if ($scheduleLater) {
            $schedulesLater = true;
        }

        $trainings->push([
            'id' => $detail->id,
            'title' => $detail->program_title,
            'program_title' => $detail->program_title,
            'trainer_id' => $detail->trainer_id,
            'schedules_later' => $scheduleLater,
            'num_of_session' => $detail->num_of_session,
            'num_of_hours' => $detail->num_of_hours,
            'schedules' => $schedules->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'date' => $schedule->session_date,
                    'start_time' => $schedule->session_start_time,
                    'end_time' => $schedule->session_end_time,
                ];
            })->toArray()
        ]);
    }

    $availableTrainers = User::whereHas('userType', function ($query) {
        $query->where('type', 'مدرب');
    })
    ->whereNotNull('email_verified_at')
    ->get();

    return view('orgTrainings.training-detail', [
        'training' => $orgTraining,
        'trainings' => $trainings,
        'availableTrainers' => $availableTrainers,
        'schedules_later' => $schedulesLater,
        'orgTrainingDetails' => $orgTrainingDetails,
        'trainingFiles' => $allTrainingFiles, // تمرير الملفات للـ view
    ]);
  }

  public function storeTrainingDetails(StoreSchedulingRequest $request, $trainingId)
{
    DB::beginTransaction();
    try {
        $orgTraining = OrgTrainingProgram::findOrFail($trainingId);

        // 1. Retrieve old details
        $oldDetails = OrgTrainingDetail::where('org_training_program_id', $trainingId)->get();

        // 2. Collect old files from all details
        $oldFiles = [];
        foreach ($oldDetails as $detail) {
            // Delete associated schedules
            OrgTrainingSchedule::where('org_training_detail_id', $detail->id)->delete();
            $detail->delete();
        }

        // 3. Process new data
        $programTitles = $request->program_title ?? [];
        $trainerIds = $request->trainer_id ?? [];
        $schedulesLater = $request->schedules_later ?? [];
        $numOfSessions = $request->num_of_session ?? [];
        $numOfHours = $request->num_of_hours ?? [];
        $schedules = $request->schedules ?? [];
        $trainingFileInputs = $request->file('training_files'); // Multiple files input

        // 4. Get list of files to keep
        $filesToKeep = $request->input('existing_training_files', []);

        if (!is_array($programTitles) || !is_array($trainerIds)) {
            throw new \Exception('Invalid input format for program titles or trainer IDs.');
        }

        // 5. Delete old files not kept
        $oldTrainingFiles = OrgTrainingDetailFile::where('org_training_program_id', $trainingId)->get();
        foreach ($oldTrainingFiles as $oldFile) {
            $oldFilePaths = is_string($oldFile->training_files)
                ? json_decode($oldFile->training_files, true)
                : $oldFile->training_files;

            if (is_array($oldFilePaths)) {
                foreach ($oldFilePaths as $oldFilePath) {
                    if (!in_array($oldFilePath, $filesToKeep)) {
                        Storage::disk('public')->delete($oldFilePath);
                    }
                }
            }
            $oldFile->delete();
        }

        // 6. Process new files
        $newFiles = [];

        if ($trainingFileInputs) {
            foreach ($trainingFileInputs as $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();

                // Sanitize and create a unique filename
                $sanitizedFileName = preg_replace('/[^a-zA-Z0-9\s]/', '', $originalName);
                $camelCaseFileName = str_replace(' ', '', ucwords(str_replace('_', ' ', $sanitizedFileName)));

                $timestamp = now()->format('Ymd_His');
                $uniqueFilename = $camelCaseFileName . '_' . $timestamp . '.' . $extension;

                // Store the file and add to newFiles array
                $newFilePath = $file->storeAs('training/files', $uniqueFilename, 'public');
                $newFiles[] = $newFilePath; // Store the path of the new file
            }
        }

        // Merge existing files with newly uploaded files
        $allFiles = array_merge($filesToKeep, $newFiles);

        // Save files to org_training_detail_files table
        if (!empty($allFiles)) {
            // dd($allFiles);
            foreach ($allFiles as $file) {
                $orgTrainingDetailFile =  OrgTrainingDetailFile::create([
                    'org_training_program_id' => $orgTraining->id,
                    'training_files' => $file
                ]);
            }

        }

        // 8. Create new details
        foreach ($programTitles as $trainingIndex => $programTitle) {
            if (empty($programTitle)) continue;

            $orgTrainingDetail = $orgTraining->details()->create([
                'program_title' => $programTitle,
                'trainer_id' => $trainerIds[$trainingIndex] ?? null,
                'schedule_later' => $schedulesLater[$trainingIndex] ?? false,
                'num_of_session' => ($schedulesLater[$trainingIndex] ?? false) ? ($numOfSessions[$trainingIndex] ?? null) : null,
                'num_of_hours' => ($schedulesLater[$trainingIndex] ?? false) ? ($numOfHours[$trainingIndex] ?? null) : null,
            ]);

            // 9. Create schedules if needed
            if (!($schedulesLater[$trainingIndex] ?? false)) {
                $trainingSchedules = $schedules[$trainingIndex] ?? [];

                foreach ($trainingSchedules as $schedule) {
                    if (!empty($schedule['date']) && !empty($schedule['start_time']) && !empty($schedule['end_time'])) {
                        $orgTrainingDetail->trainingSchedules()->create([
                            'session_date' => $schedule['date'],
                            'session_start_time' => $schedule['start_time'],
                            'session_end_time' => $schedule['end_time'],
                        ]);
                    }
                }
            }
        }

        DB::commit();
        return redirect()->route('orgTraining.assistants', $orgTraining->id);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Failed to update training details: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());

        return redirect()->back()
            ->with('error', 'An error occurred during the update: ' . $e->getMessage())
            ->withInput();
    }
}

/**
 * معالجة ملفات التدريب
 */
protected function processTrainingFiles($request, $settings)
{
    $trainingFiles = [];

    // الحفاظ على الملفات الموجودة إذا لم يتم تحميل ملفات جديدة
    if ($settings->training_files) {
        $trainingFiles = is_string($settings->training_files)
            ? json_decode($settings->training_files, true)
            : $settings->training_files;
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

    // تخزين الملفات في قاعدة البيانات
    $storedFiles = implode("\n", $trainingFiles); // كل مسار في سطر منفصل

    // تحديث إعدادات قاعدة البيانات
    $settings->training_files = $storedFiles; // تأكد من أن لديك الحقل المناسب
    $settings->save(); // حفظ التغييرات في قاعدة البيانات

    return $trainingFiles;
}

/**
 * التأكد من وجود مفتاح المصفوفة
 *
 * @param array $array
 * @param string|int $key
 * @param mixed $defaultValue
 * @return mixed
 */
private function ensureArrayKeyExists(&$array, $key, $defaultValue = [])
{
    if (!isset($array[$key])) {
        $array[$key] = $defaultValue;
    }
    return $array[$key];
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
    DB::beginTransaction();
    try {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);

        // حذف جميع المساعدين الحاليين
        $orgTraining->assistants()->delete();

        // الحصول على جميع معرفات المساعدين الجدد
        $allAssistantIds = array_merge($request->input('assistant_ids', []), $request->input('additional_assistant_ids', []));

        // إضافة المساعدين الجدد
        foreach ($allAssistantIds as $assistantId) {
            $orgTraining->assistants()->create([
                'org_training_program_id' => $orgTraining->id,
                'assistant_id' => $assistantId,
            ]);
        }

        DB::commit();
        return redirect()->route('orgTraining.settings', $orgTraining->id);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تحديث المساعدين: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'حدث خطأ أثناء تحديث المساعدين: ' . $e->getMessage())
            ->withInput();
    }
}

  // ======= الخطوة 5: الإعدادات الإضافية =======
public function showSettingsForm($orgTrainingId)
{
    $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);
    $settings = $orgTraining->registrationRequirements()->firstOrNew([
        'org_training_program_id' => $orgTrainingId,
    ]);

    // تحويل المتطلبات والفوائد من JSON إلى مصفوفة
    $requirements = [''];
    if ($settings->requirements) {
        $decoded = is_string($settings->requirements)
            ? json_decode($settings->requirements, true)
            : $settings->requirements;
        $requirements = is_array($decoded) ? $decoded : [$decoded];
    }

    $benefits = [''];
    if ($settings->benefits) {
        $decoded = is_string($settings->benefits)
            ? json_decode($settings->benefits, true)
            : $settings->benefits;
        $benefits = is_array($decoded) ? $decoded : [$decoded];
    }

    // التأكد من أن application_submission_method هي قيمة نصية
    $submissionMethod = $settings->application_submission_method;
    if (is_object($submissionMethod)) {
        $submissionMethod = $submissionMethod->value;
    }

    if (!$settings->welcome_message) {
        $settings->welcome_message = "شكرًا لتسجيلك في المسار. يسعدنا أن تكون/ي جزءًا من هذا المسار، ونتطلع إلى رحلة مليئة بالتعلّم  والتطوير.
سيتم مراجعة طلبك وإشعارك بالقبول أو الاعتذار في أقرب وقت، لذا تأكد/ي من متابعة بريدك الإلكتروني أو الإشعارات داخل المنصة.";
    }

    return view('orgTrainings.settings', [
        'training' => $orgTraining,
        'settings' => $settings,
        'countries' => Country::all(),
        'training_files' => $training_image ?? [],
        'submissionMethod' => $submissionMethod,
        'requirements' => $requirements,
        'benefits' => $benefits,
    ]);
}

public function storeSettings(StoreAdditionalSettingsRequest $request, $orgTrainingId)
{
    DB::beginTransaction();
    try {
        $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);
        $settings = $orgTraining->registrationRequirements()->firstOrCreate([
            'org_training_program_id' => $orgTrainingId,
        ], [
            'is_free' => 0,
            'application_deadline' => now()->addDays(30),
            'application_submission_method' => 'inside_platform',
            'max_trainees' => 20,
            'requirements' => "Student",
            'benefits' => 'learning',
            'welcome_message' => "شكرًا لتسجيلك في التدريب...",
        ]);

        // Get validated data
        $data = $request->validated();

        // معالجة حقل is_free
        $data['is_free'] = $request->has('is_free') ? 1 : 0;

        // معالجة حقل unlimited_trainees
        $unlimitedTrainees = $request->has('unlimited_trainees') ? 1 : 0;

        // إذا كان unlimited_trainees true، استخدم قيمة افتراضية لـ max_trainees
        if ($unlimitedTrainees) {
            $data['max_trainees'] = 0; // استخدم 0 للدلالة على عدم وجود حد أقصى
        }

        // Clear cost-related fields if training is free
        if ($data['is_free']) {
            $data['cost'] = 0; // استخدم 0 بدلاً من null
            $data['currency'] = null;
            $data['payment_method'] = null;
        }

        // Handle the training image upload
        if ($request->hasFile('training_image')) {
            $originalName = $request->file('training_image')->getClientOriginalName();
            $path = 'training/training_image/' . $originalName;
            $request->file('training_image')->storeAs('training/training_image', $originalName, 'public');
            $data['training_image'] = $path;

            if ($settings->training_image) {
                Storage::disk('public')->delete($settings->training_image);
            }
        }

        // تحويل مصفوفة المتطلبات والفوائد إلى JSON
        if (isset($data['requirements']) && is_array($data['requirements'])) {
            $data['requirements'] = json_encode(array_filter($data['requirements']));
        }
        if (isset($data['benefits']) && is_array($data['benefits'])) {
            $data['benefits'] = json_encode(array_filter($data['benefits']));
        }

        // Fill all attributes
        $settings->fill([
            'org_training_program_id' => $orgTrainingId,
            'cost' => $data['cost'] ?? 0,
            'is_free' => $data['is_free'],
            'currency' => $data['currency'] ?? null,
            'payment_method' => $data['payment_method'] ?? null,
            'application_deadline' => $data['application_deadline'],
            'max_trainees' => $data['max_trainees'] ?? 20,
            'application_submission_method' => $data['application_submission_method'],
            'registration_link' => $data['registration_link'] ?? null,
            'requirements' => $data['requirements'] ?? '[]',
            'benefits' => $data['benefits'] ?? '[]',
            'training_image' => $data['training_image'] ?? $settings->training_image,
            'welcome_message' => $data['welcome_message'],
        ]);

        $settings->save();
        DB::commit();
        return redirect()->route('orgTraining.review', $orgTraining->id);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('فشل تخزين إعدادات التدريب: ' . $e->getMessage());
        return redirect()->back()->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
    }
}

public function showReviewForm($orgTrainingId)
{
    // التأكد من أن $orgTrainingId هو رقم وليس كائنًا
    if (is_object($orgTrainingId)) {
        $orgTrainingId = $orgTrainingId->id;
    }

    $orgTraining = OrgTrainingProgram::with([
        'details',
        'programType',
        'assistants',
        'files' // إضافة العلاقة مع ملفات التدريب
    ])->findOrFail($orgTrainingId);

    // الحصول على إعدادات التسجيل
    $settings = $orgTraining->registrationRequirements()->firstOrNew([
        'org_training_program_id' => $orgTrainingId,
    ]);

    // تحويل المتطلبات والفوائد من JSON إلى مصفوفة
    $requirements = [''];
    if ($settings->requirements) {
        $decoded = is_string($settings->requirements)
            ? json_decode($settings->requirements, true)
            : $settings->requirements;
        $requirements = is_array($decoded) ? $decoded : [$decoded];
    }

    $benefits = [''];
    if ($settings->benefits) {
        $decoded = is_string($settings->benefits)
            ? json_decode($settings->benefits, true)
            : $settings->benefits;
        $benefits = is_array($decoded) ? $decoded : [$decoded];
    }

    // التأكد من أن application_submission_method هي قيمة نصية
    $submissionMethod = $settings->application_submission_method;
    if (is_object($submissionMethod)) {
        $submissionMethod = $submissionMethod->value;
    }

    // معالجة الصورة
    $training_image = [];
    if ($settings->training_image) {
        $training_image = is_string($settings->training_image)
            ? json_decode($settings->training_image, true)
            : $settings->training_image;
    }

  // الحصول على ملفات التدريب من الجدول الجديد
$training_files = [];
if ($orgTraining->files && $orgTraining->files->count() > 0) {
    foreach ($orgTraining->files as $file) {
        // تحقق من وجود خاصية training_files في كل ملف
        if (isset($file->training_files)) {
            $filesData = $file->training_files;

            // معالجة البيانات سواء كانت JSON أو array أو string
            if (is_string($filesData)) {
                // محاولة تحليل JSON
                $decoded = json_decode($filesData, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    if (is_array($decoded)) {
                        foreach ($decoded as $item) {
                            if (is_array($item) && isset($item['path'])) {
                                $training_files[] = $item;
                            } elseif (is_string($item)) {
                                $training_files[] = [
                                    'path' => $item,
                                    'name' => basename($item)
                                ];
                            }
                        }
                    } else {
                        $training_files[] = [
                            'path' => $decoded,
                            'name' => basename($decoded)
                        ];
                    }
                } else {
                    // إذا فشل تحليل JSON، افترض أنه مسار ملف واحد
                    $training_files[] = [
                        'path' => $filesData,
                        'name' => basename($filesData)
                    ];
                }
            } elseif (is_array($filesData)) {
                foreach ($filesData as $item) {
                    if (is_array($item) && isset($item['path'])) {
                        $training_files[] = $item;
                    } elseif (is_string($item)) {
                        $training_files[] = [
                            'path' => $item,
                            'name' => basename($item)
                        ];
                    }
                }
            }
        }
        // بديل: إذا كان الملف يحتوي على خاصية path مباشرة
        elseif (isset($file->path)) {
            $training_files[] = [
                'path' => $file->path,
                'name' => $file->name ?? basename($file->path)
            ];
        }
    }
}

    // رسالة ترحيب افتراضية
    if (!$settings->welcome_message) {
        $settings->welcome_message = "شكرًا لتسجيلك في البرنامج. يسعدنا أن تكون/ي جزءًا من هذا البرنامج، ونتطلع إلى رحلة مليئة بالتعلّم  والتطوير.
سيتم مراجعة طلبك وإشعارك بالقبول أو الاعتذار في أقرب وقت، لذا تأكد/ي من متابعة بريدك الإلكتروني أو الإشعارات داخل المنصة.";
    }

    return view('orgTrainings.review', [
        'training' => $orgTraining,
        'settings' => $settings,
        'countries' => Country::all(),
        'training_image' => $training_image,
        'training_files' => $training_files, // تمرير ملفات التدريب
        'submissionMethod' => $submissionMethod,
        'requirements' => $requirements,
        'benefits' => $benefits,
    ]);
}
  public function publishTraining($orgTrainingId)
  {

        try {
      $orgTraining = OrgTrainingProgram::findOrFail($orgTrainingId);

      $orgTraining->update(['status' => 'online']);

      return redirect()->route('orgTrainings.completed', $orgTraining->id)
        ->with('success', 'تم نشر البرنامج التدريبي بنجاح');
    } catch (\Exception $e) {
      \Log::error('فشل نشر التدريب: ' . $e->getMessage());
      return redirect()->back()->with('error', 'حدث خطأ أثناء النشر: ' . $e->getMessage());
    }
  }
  // ======= صفحة الإكمال =======
  public function showCompletionPage($orgTrainingId)
  {
    $training = OrgTrainingProgram::findOrFail($orgTrainingId);
    return view('orgTrainings.completed', compact('training'));
  }


public function show($id){
    $OrgProgram = OrgTrainingProgram::with(
        'details',
        'goals',
        'registrationRequirements',
        'assistants'
    )->where('status', 'online')->findOrFail($id);

    $eduaction_levels_ids =  $OrgProgram->goals->first()->education_level_id;
    $education_levels = EducationLevel::whereIn('id',$eduaction_levels_ids)->pluck('name');

    $work_sector_ids =  $OrgProgram->goals->first()->work_sector_id;
    $work_sectors = WorkSector::whereIn('id',$work_sector_ids)->pluck('name');

    //   المشاهدات
    $OrgProgram->increment('views');

    $grandTotalMinutes = 0;
    foreach ($OrgProgram->details as $program) {
        foreach ($program->trainingSchedules as $session) {
            $grandTotalMinutes += \Carbon\Carbon::parse($session->session_start_time)
                ->diffInMinutes(\Carbon\Carbon::parse($session->session_end_time));
        }
    }

              // حساب حالة التسجيل
        $deadline = $OrgProgram->registrationRequirements->application_deadline ?? null;
        $registrationStatus = $this->calculateRegistrationStatus($deadline);
        $remainingText = $registrationStatus['text'];

            // تحديد ما إذا انتهى موعد التسجيل
    $training_has_ended = false;
    if ($deadline) {
        $training_has_ended = now() > Carbon::parse($deadline);
    }
    $participants = Enrollment::where('org_training_programs_id', $OrgProgram->id)->get();

  // التحقق من تسجيل المستخدم
        $has_enrolled = false;
        $enrollment = null;
        if (auth()->check()) {
            $has_enrolled = Enrollment::where('trainee_id', auth()->id())
                ->where('org_training_programs_id', $id)
                ->exists();

            $enrollment = Enrollment::where('trainee_id', auth()->id())
                ->where('org_training_programs_id', $id)
                ->first();
        }

    return view('orgTrainings.show',compact('OrgProgram','education_levels','work_sectors','grandTotalMinutes','training_has_ended',
        'remainingText','participants','has_enrolled','enrollment'));

}

public function showProgram($id)
{
    $program = OrgTrainingDetail::findOrFail($id)->load('Trainer', 'trainingSchedules','trainingProgram');

    $orgProgram = OrgTrainingProgram::where('id', $program->org_training_program_id)->first();

    $grandTotalMinutes = 0;
    foreach ($orgProgram->details as $detail) {
        foreach ($detail->trainingSchedules as $session) {
            $grandTotalMinutes += \Carbon\Carbon::parse($session->session_start_time)
                ->diffInMinutes(\Carbon\Carbon::parse($session->session_end_time));
        }
    }

      // حساب تقييم المدرب
        $averageTrainerRating = 0;
        if ($program->Trainer && $program->Trainer->trainer && $program->Trainer->trainer->ratings) {
            $ratings = $program->Trainer->trainer->ratings;
            $criteria = ['clarity', 'interaction', 'organization'];
            $totalRatings = 0;
            $totalSum = 0;

            foreach ($ratings as $rating) {
                foreach ($criteria as $criterion) {
                    if (isset($rating->$criterion)) {
                        $score = $rating->$criterion;
                        $totalSum += $score;
                        $totalRatings++;
                    }
                }
            }

            $averageTrainerRating = $totalRatings > 0 ? round($totalSum / $totalRatings, 1) : 0;
        }


    return view('orgTrainings.show-program', compact('program','orgProgram','grandTotalMinutes','averageTrainerRating'));
}

private function calculateRegistrationStatus($deadline)
{
    $now = Carbon::now();

    if (!$deadline) {
        return [
            'text' => 'تاريخ انتهاء التسجيل غير محدد',
            'status' => 'unknown'
        ];
    }

    $deadline = Carbon::parse($deadline);

    if ($deadline->isFuture()) {
        // الوقت المتبقي
$diffInSeconds = $now->diffInSeconds($deadline);
        $days = (int) floor($diffInSeconds / (60 * 60 * 24));
        $hours = (int) floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60));

        if ($days > 0) {
            $daysText = $this->arabicPlural($days, 'يوم');
            $hoursText = $this->arabicPlural($hours, 'ساعة');
            return [
                'text' => "متبقي {$days} {$daysText} و{$hours} {$hoursText} على انتهاء التسجيل",
                'status' => 'active'
            ];
        } else {
            $hoursText = $this->arabicPlural($hours, 'ساعة');
            return [
                'text' => "متبقي {$hours} {$hoursText} على انتهاء التسجيل",
                'status' => 'ending_soon'
            ];
        }
    } else {
        // الوقت المنقضي
        $daysAgo = (int) abs($now->diffInDays($deadline));

        if ($daysAgo === 0) {
            return [
                'text' => "انتهت فترة التسجيل اليوم",
                'status' => 'expired'
            ];
        } elseif ($daysAgo === 1) {
            return [
                'text' => "انتهت فترة التسجيل أمس",
                'status' => 'expired'
            ];
        } elseif ($daysAgo <= 7) {
            $daysText = $this->arabicPlural($daysAgo, 'يوم');
            return [
                'text' => "انتهت فترة التسجيل منذ {$daysAgo} {$daysText}",
                'status' => 'expired'
            ];
        } elseif ($daysAgo <= 30) {
            $weeksAgo = (int) floor($daysAgo / 7);
            $weeksText = $this->arabicPlural($weeksAgo, 'أسبوع');
            return [
                'text' => "انتهت فترة التسجيل منذ {$weeksAgo} {$weeksText}",
                'status' => 'expired'
            ];
      } else {
    $monthsAgo = (int) abs($now->diffInMonths($deadline));

    if ($monthsAgo >= 12) {
        $yearsAgo = floor($monthsAgo / 12);
        $remainingMonths = $monthsAgo % 12;

        $yearsText = $this->arabicPlural($yearsAgo, 'سنة');

        if ($remainingMonths > 0) {
            $monthsText = $this->arabicPlural($remainingMonths, 'شهر');
            return [
                'text' => "انتهت فترة التسجيل منذ {$yearsAgo} {$yearsText} و{$remainingMonths} {$monthsText}",
                'status' => 'expired'
            ];
        } else {
            return [
                'text' => "انتهت فترة التسجيل منذ {$yearsAgo} {$yearsText}",
                'status' => 'expired'
            ];
        }
    } else {
        $monthsText = $this->arabicPlural($monthsAgo, 'شهر');
        return [
            'text' => "انتهت فترة التسجيل منذ {$monthsAgo} {$monthsText}",
            'status' => 'expired'
        ];
    }
}

    }
}
    private function arabicPlural($number, $word)
{
    $forms = [
        'يوم'   => ['يوم', 'يومين', 'أيام'],
        'ساعة'  => ['ساعة', 'ساعتين', 'ساعات'],
        'دقيقة' => ['دقيقة', 'دقيقتين', 'دقائق'],
        'أسبوع' => ['أسبوع', 'أسبوعين', 'أسابيع'],
        'شهر'   => ['شهر', 'شهرين', 'أشهر'],
    ];

    if (!isset($forms[$word])) {
        return $word; // في حال ما وجدنا الكلمة
    }

    if ($number == 1) {
        return $forms[$word][0];
    } elseif ($number == 2) {
        return $forms[$word][1];
    } elseif ($number > 2 && $number <= 10) {
        return $forms[$word][2];
    } else {
        return $forms[$word][0];
    }
}
}


