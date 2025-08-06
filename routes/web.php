<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Trainings\TrainingsController;
use App\Http\Controllers\User\Organization\OrganizationProfileController;
use App\Http\Controllers\User\partnershipController;
use App\Http\Controllers\User\CompletionData\SkillController;
use App\Http\Controllers\User\CompletionData\UserCertificateController;
use App\Http\Controllers\User\Assistant\AssistantController;
use App\Http\Controllers\User\Assistant\AssistantProfileController;
use App\Http\Controllers\User\CompletionData\EducationController;
use App\Http\Controllers\User\Organization\OrganizationController;
use App\Http\Controllers\User\CompletionData\PortfolioController;
use App\Http\Controllers\User\CompletionData\PreviousTrainingController;
use App\Http\Controllers\User\CompletionData\ServiceController;
use App\Http\Controllers\User\Trainee\TraineeController;
use App\Http\Controllers\User\Trainer\TrainerProfileController;
use App\Http\Controllers\User\Trainer\SessionController;
use App\Http\Controllers\User\Trainer\TrainerController;
use App\Http\Controllers\User\CompletionData\UserCvController;
use App\Http\Controllers\User\CompletionData\TrainingExperienceController;
use App\Http\Controllers\User\CompletionData\VolunteeringController;
use App\Http\Controllers\User\CompletionData\WorkExperienceController;
use App\Http\Controllers\User\Trainee\EnrollmentController;
use App\Http\Controllers\User\Trainee\TraineeProfileController;
use App\Http\Controllers\User\Trainee\TrainerRatingController;
use App\Http\Controllers\User\Trainer\TrainingAnnouncementController;
use App\Http\Controllers\User\Trainer\TrainingParticipantsController;
use App\Http\Controllers\User\Trainer\TrainingAssistantController;
use App\Http\Controllers\User\Trainer\TrainingProgramInfoController;
use App\Http\Controllers\User\Trainer\TrainingProgramController;
use App\Models\Assistant;
use App\Models\Organization;
use App\Models\Trainee;
use App\Models\Trainer;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TrainingAnnouncementSessionService;
use App\Http\Controllers\Trainings\Trainings_CURD_Controller;
use App\Http\Controllers\User\Trainee\RegisteredTrainingsController;

// User Route - Adjusted for Session Authentication
Route::get('/user', function (Request $request) {
  return Auth::user();
})->middleware('auth');

Route::get('/', [HomeController::class, 'index']);

//home page
Route::get('/homePage', [AuthController::class, 'View'])->name('homePage');
Route::get('/homePageOrganization', [AuthController::class, 'ViewOrganization'])->name('homePageOrganization');

// Auth Controller Routes
Route::get('/register', [AuthController::class, 'RegisterView'])->name('register');
Route::get('/register-org', [AuthController::class, 'RegisterViewOrganization'])->name('register-org');
Route::post('/register', [AuthController::class, 'register']);


Route::get('/verify-user-page/{id}', [AuthController::class, 'verifyUserView'])->name('verify-user-blade');
Route::get('/verify-user/{id}', [AuthController::class, 'verifyUser'])->name('verify-user');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:web')->get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/resend-verification-email/{id}', [AuthController::class, 'resendVerificationEmail'])->name('resend-verification-email');

// Trainer Controller
Route::get('/complete-trainer-register/{id}', [TrainerController::class, 'showRegistrationForm'])
  ->name('complete-trainer-register');
Route::post('/complete-trainer-register/{id}', [TrainerController::class, 'completeRegister'])->name('trainer.complete-register');


// Trainee Controller
Route::get('/complete-trainee-register/{id}', [TraineeController::class, 'showRegistrationForm'])
  ->name('complete-trainee-register');
Route::post('/complete-trainee-register/{id}', [TraineeController::class, 'completeRegister'])->name('trainee.complete-register');


// Assistant Controller
Route::get('/complete-assistant-register/{id}', [AssistantController::class, 'showRegistrationForm'])
  ->name('complete-assistant-register');
Route::post('/complete-assistant-register/{id}', [AssistantController::class, 'completeRegister'])->name('assistant.complete-register');


// Organization Controller
Route::get('/complete-organization-register/{id}', [OrganizationController::class, 'showRegistrationForm'])
  ->name('complete-organization-register');
Route::post('/complete-organization-register/{id}', [OrganizationController::class, 'completeRegister'])->name('organization-complete-register');




// Middleware Group (Preserving Token Expiration Logic)
Route::middleware(['auth:web', 'CheckEmailVerified'])->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/users/search-by-name', [AuthController::class, 'searchbyName'])->name('users.searchbyName');
  Route::get('/users/search', [AuthController::class, 'search'])->name('users.search');


  //user cv
  Route::post('upload/userCv', [USerCvController::class, 'uploadCv'])->name('upload_cv');
  Route::delete('delete/userCv', [USerCvController::class, 'deleteCv'])->name('delete_cv');
  Route::get('/download-cv/{user}', [UserCvController::class, 'download'])->name('download.cv');

  //trainer previous training
  Route::view('/upload/previoustraing', 'user.trainer.store_pre_traing')->name('create_pre_trainig');
  Route::post('upload/previoustraing', [PreviousTrainingController::class, 'storePreviousTraining'])->name('upload_pre_training');
  Route::view('/edit/previoustraing/{id}', 'user.trainer.update_pre_traing')->name('edit_pre_trainig');
  Route::put('/edit/previoustraing/{id}', [PreviousTrainingController::class, 'updatePreviousTraining'])->name('update_pre_trainig');
  Route::delete('delete/previoustraing/{id}', [PreviousTrainingController::class, 'deletePreviousTraining'])->name('delete_pre_training');


  //trainer profile
  //Route::get('/show-trainer-profile/{id?}', [TrainerProfileController::class, 'showProfile'])->name('show_trainer_profile');
  Route::put('/edit-trainer-pesonal-info', [TrainerProfileController::class, 'updatePersonalInfo'])->name('update_personal_info');
  Route::put('/edit-trainer-exp', [TrainerProfileController::class, 'updateExperiance'])->name('update_experiance');
  Route::put('/edit-trainer-contact-info', [TrainerProfileController::class, 'updateContactinfo'])->name('update_contact_info');

  //trainee profile
  //Route::get('/show-trainee-profile/{id?}', [TraineeProfileController::class, 'showProfile'])->name('show_trainee_profile');
  Route::put('/edit-trainee-pesonal-info', [TraineeProfileController::class, 'updatePersonalInfo'])->name('update_personal_information');
  Route::put('/edit-trainee-pro-data', [TraineeProfileController::class, 'updateProfessionalData'])->name('update_pro-data');
  Route::put('/edit-trainee-preferred-times', [TraineeProfileController::class, 'updatePreferredTimes'])->name('update_preferred_times');

  //assistant profile
  //Route::get('/show-assistant-profile/{id?}', [AssistantProfileController::class, 'showProfile'])->name('show_assistant_profile');
  Route::put('/edit-assistant-pesonal-info', [AssistantProfileController::class, 'updatePersonalInfo'])->name('update_assistant_personal_information');
  Route::put('/edit-assistant-experience-and-education', [AssistantProfileController::class, 'updateExperienceAndEducation'])->name('update_experience_and_education');

  //organization profile
  Route::get('/show-organization-profile/{id?}', [OrganizationProfileController::class, 'showProfile'])->name('show_organization_profile');
  Route::put('/edit-organization-profile', [OrganizationProfileController::class, 'updateProfile'])->name('update_organization_profile');



  Route::prefix('training')->group(function () {
    // إنشاء جديد - عرض النموذج الأولي
    Route::get('/create', [Trainings_CURD_Controller::class, 'showBasicInformationForm'])->name('training.create');

    // الخطوة 1: المعلومات الأساسية
    Route::get('/basic-information/{trainingId?}', [Trainings_CURD_Controller::class, 'showBasicInformationForm'])
        ->name('training.basic');
    // POST - حفظ البيانات
    Route::post('/basic-information', [Trainings_CURD_Controller::class, 'storeBasicInformation'])
        ->name('training.store.basic');

Route::put('/training/basic/{id}', [Trainings_CURD_Controller::class, 'updateBasicInformation'])->name('training.update.basic');

    // الخطوة 2: الأهداف
    Route::get('/{trainingId}/goals', [Trainings_CURD_Controller::class, 'showGoalsForm'])->name('training.goals');
    Route::post('/{trainingId}/goals', [Trainings_CURD_Controller::class, 'storeGoals'])->name('training.store.goals');

    // الخطوة 3: الفريق
    Route::get('/{trainingId}/team', [Trainings_CURD_Controller::class, 'showTeamForm'])->name('training.team');
    Route::post('/{trainingId}/team', [Trainings_CURD_Controller::class, 'storeTeam'])->name('training.store.team');

    // الخطوة 4: الجدولة
    Route::get('/{trainingId}/schedule', [Trainings_CURD_Controller::class, 'showScheduleForm'])->name('training.schedule');
    Route::post('/{trainingId}/schedule', [Trainings_CURD_Controller::class, 'storeSchedule'])->name('training.store.schedule');

    // الخطوة 5: الإعدادات
    Route::get('/{trainingId}/settings', [Trainings_CURD_Controller::class, 'showSettingsForm'])->name('training.settings');
    Route::post('/{trainingId}/settings', [Trainings_CURD_Controller::class, 'storeSettings'])->name('training.store.settings');

    // الخطوة 6: المراجعة
    Route::get('/{trainingId}/review', [Trainings_CURD_Controller::class, 'showReviewForm'])->name('training.review');
    Route::post('/{trainingId}/publish', [Trainings_CURD_Controller::class, 'publishTraining'])->name('training.publish');

    // صفحة الإكمال
    Route::get('/{trainingId}/completed', [Trainings_CURD_Controller::class, 'showCompletionPage'])->name('training.completed');
});




  Route::get('/trainings', [TrainingProgramController::class, 'index'])->name('trainings.index');
  // Route::get('/trainings/edit/{id}', [TrainingProgramController::class, 'edit'])->name('trainings.edit');
  Route::post('/trainings/update/{id}', [TrainingProgramController::class, 'update'])->name('trainings.update');
  Route::delete('/trainings/delete/{id}', [TrainingProgramController::class, 'destroy'])->name('trainings.destroy');
  Route::post('/trainings/stop-sharing/{id}', [TrainingProgramController::class, 'stopSharing'])->name('trainings.stopSharing');
  Route::post('/trainings/re-publish/{id}', [TrainingProgramController::class, 'rePublish'])->name('trainings.rePublish');
  Route::get('trainings/stopped', [TrainingProgramController::class, 'showStoppedPrograms'])->name('trainings.stopped');

  Route::post('/enrollments/{program_id}', [EnrollmentController::class, 'enrolle'])->name('enrolle');
  Route::get('/enrollment/confirmation', function () {
    return view('trainingAnnouncement.enrollment-confirmation');
  })->name('enrollment.confirmation');

  Route::get('/training/details/review/{id}', [TrainingProgramController::class, 'show'])->name('training.details');

  Route::post('/participants/{program}/{participant}/action', [TrainingParticipantsController::class, 'handleAction'])->name('participants.handleAction');
  Route::post('/participants/{program}/bulk-accept', [TrainingParticipantsController::class, 'bulkAccept'])->name('participants.bulkAccept');
  Route::post('/programs/{program}/participants/{participant}/reason', [TrainingParticipantsController::class, 'submitReason'])->name('participants.submitReason');
  Route::delete('/trainee/{trainee_id}/delete/{program_id}', [TrainingParticipantsController::class, 'deleteAcceptedTrainee'])->name('acceptedTrainee.delete');


  Route::delete('sessions/{id}/delete', [SessionController::class, 'destroy'])->name('sessions.destroy');
  Route::put('sessions/{id}/update', [SessionController::class, 'update'])->name('sessions.update');
  Route::post('scheduling-training-sessions/{program_id}/store', [SessionController::class, 'store'])->name('session.store');
  Route::get('/sessions/{session}/attendance', [SessionController::class, 'selectSessionAttendece'])->name('sessions.attendance');
  Route::post('/sessions/{session}/attendance', [SessionController::class, 'storeSessionAttendece'])->name('attendance.store');

  Route::delete('assistant/{assistant_id}/delete/{program_id}', [TrainingAssistantController::class, 'deleteProgramAssistant'])->name('training.assistant.destroy');
  Route::post('assistant/{assistant_id}/add/{program_id}', [TrainingAssistantController::class, 'addProgramAssistant'])->name('training.assistant.store');

  Route::post('/training/{program_id}/upload-files', [TrainingProgramInfoController::class, 'uploadTrainingFiles'])
    ->name('training.file.upload');
  Route::delete('training/{program_id}/attachment/{file_index}', [TrainingProgramInfoController::class, 'deleteTrainigFile'])->name('training.file.delete');

  Route::post('/trainer/{trainer_id}/rate', [TrainerRatingController::class, 'store'])
    ->name('trainer.rating.store');

  Route::put('/training/{id}', [TrainingProgramInfoController::class, 'updateTrainingInfo'])->name('trainingInfo.update');


  Route::delete('/programs/{program_id}/delete-photo', [TrainingProgramInfoController::class, 'deleteProgramPhoto'])->name('program.photo.delete');
  Route::post('/programs/{program_id}/update-photo', [TrainingProgramInfoController::class, 'updateOrCreateProgramPhoto'])->name('program.photo.update');

  Route::get('/trainees/{trainee_id}/trainings', [RegisteredTrainingsController::class, 'trainings'])->name('trainee.trainings');

  Route::post('/feedback', [HomeController::class, 'sendFeedback'])->name('feedback.store');

});

Route::post('/feedback', [HomeController::class, 'sendFeedback'])->name('feedback.store');


Route::get('/trainings/announcements', [TrainingsController::class, 'index'])->name('trainings_announcements');
Route::get('/trainings/announcements/show/{id}', [TrainingsController::class, 'show'])->name('show_trainings_announcements');

//profiles users
  Route::get('/show-trainer-profile/{id?}', [TrainerProfileController::class, 'showProfile'])->name('show_trainer_profile');
  Route::get('/show-trainee-profile/{id?}', [TraineeProfileController::class, 'showProfile'])->name('show_trainee_profile');
  Route::get('/show-assistant-profile/{id?}', [AssistantProfileController::class, 'showProfile'])->name('show_assistant_profile');
  Route::get('/show-organization-profile/{id?}', [OrganizationProfileController::class, 'showProfile'])->name('show_organization_profile');



require __DIR__ . '/front_fetch.php';
