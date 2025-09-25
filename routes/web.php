<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrgTrainings\OrgTrainingController;
use App\Http\Controllers\OrgTrainings\OrgTrainingFilesController;
use App\Http\Controllers\OrgTrainings\OrgTrainingManagerController;
use App\Http\Controllers\OrgTrainings\TrainingDetailController;
use App\Http\Controllers\OrgTrainings\UpdateTrainingController;
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
use App\Http\Controllers\User\Trainee\MyTrainingsController;
use App\Http\Controllers\User\Trainee\RegisteredTrainingsController;

// User Route - Adjusted for Session Authentication
Route::get('/user', function (Request $request) {
  return Auth::user();
})->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('index');

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

Route::get('/link-expired', function () {
  return view('link-expired');
})->name('link.expired');

Route::middleware(['check.link.expiration'])->group(function () {
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
});



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

    Route::get('/start-create-training', function () {
      return view('trainings.start_training');
    })->name('startCreateTraining');

        Route::get('/start-create-training-org', function () {
      return view('trainings.start_training_org');
    })->name('startCreateTraining-org');


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
    Route::post('/publish/{trainingId}', action: [Trainings_CURD_Controller::class, 'publishTraining'])->name('training.publish');
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
  Route::delete('training/{program_id}/attachment/{file_index}', [TrainingProgramInfoController::class, 'deleteTrainingFile'])->name('training.file.delete');

  Route::post('/trainer/{trainer_id}/rate', [TrainerRatingController::class, 'store'])
    ->name('trainer.rating.store');

  Route::put('/training/{id}', [TrainingProgramInfoController::class, 'updateTrainingInfo'])->name('trainingInfo.update');


  Route::delete('/programs/{program_id}/delete-photo', [TrainingProgramInfoController::class, 'deleteProgramPhoto'])->name('program.photo.delete');
  Route::post('/programs/{program_id}/update-photo', [TrainingProgramInfoController::class, 'updateOrCreateProgramPhoto'])->name('program.photo.update');

  Route::get('/trainees/{trainee_id}/trainings', [RegisteredTrainingsController::class, 'trainings'])->name('trainee.trainings');

  Route::post('/feedback', [HomeController::class, 'sendFeedback'])->name('feedback.store');


  Route::prefix('org-training')->group(function () {

    Route::get('/start-create-training', function () {
      return view('orgTrainings.start_org_trainings');
    })->name('startCreateOrgTrainings');


    Route::get('/basic-information', [OrgTrainingController::class, 'showBasicInformationForm'])->name('orgTraining.create');
    Route::get('/basic-information/{orgTrainingId}', [OrgTrainingController::class, 'showBasicInformationForm'])->name('orgTraining.basicInformation');

    Route::post('/basic-information', [OrgTrainingController::class, 'storeBasicInformation'])->name('orgTraining.storeBasicInformation');
    Route::put('/basic-information/{orgTrainingId}', [OrgTrainingController::class, 'updateBasicInformation'])->name('orgTraining.updateBasicInformation');

    Route::get('/goals/{orgTrainingId}', [OrgTrainingController::class, 'showGoalsForm'])->name('orgTraining.goals');
    Route::post('/goals/{orgTrainingId}', [OrgTrainingController::class, 'storeGoals'])->name('orgTraining.storeGoals');

    Route::get('/training-detail/{orgTrainingId}', [OrgTrainingController::class, 'showTrainingDetailForm'])->name('orgTraining.trainingDetail');
    Route::post('/training-detail/{orgTrainingId}', [OrgTrainingController::class, 'storeTrainingDetails'])->name('orgTraining.storeTrainingDetails');

    Route::get('/assistants/{orgTrainingId}', [OrgTrainingController::class, 'showAssistantForm'])->name('orgTraining.assistants');
    Route::post('/assistants/{orgTrainingId}', [OrgTrainingController::class, 'storeAssistants'])->name('orgTraining.storeAssistants');

    Route::get('/settings/{orgTrainingId}', [OrgTrainingController::class, 'showSettingsForm'])->name('orgTraining.settings');
    Route::post('/settings/{orgTrainingId}', [OrgTrainingController::class, 'storeSettings'])->name('orgTraining.storeSettings');

    Route::get('/review/{orgTrainingId}', [OrgTrainingController::class, 'showReviewForm'])->name('orgTraining.review');
    Route::post('/publish/{orgTrainingId}', [OrgTrainingController::class, 'publishTraining'])->name('orgTraining.publish');
    Route::get('/completed/{trainingId}', [OrgTrainingController::class, 'showCompletionPage'])->name('orgTrainings.completed');


  });


  Route::get('/organization-training-manager', [OrgTrainingManagerController::class, 'index'])->name('orgTrainingsManager.index');
  Route::get('organization-training-manager/{id}', [OrgTrainingManagerController::class, 'show'])->name('orgTrainingsManager.show');
  Route::get('organization-training-manager/detail/{id}', [OrgTrainingManagerController::class, 'showProgramDetail'])->name('orgTrainingsDetailManager.show');
  Route::delete('organization-training-manager/destroy/{id}', [OrgTrainingManagerController::class, 'destroy'])->name('orgTrainingsManager.destroy');
  Route::delete('organization-training-manager/destroy-training/{id}', [OrgTrainingManagerController::class, 'deleteOrgTraining'])->name('orgTraining.destroy');

  Route::put('/training-detail/{id}', [TrainingDetailController::class, 'updateInfo'])->name('training-detail.update');
  Route::put('/training-detail/{id}/clear', [TrainingDetailController::class, 'deleteInfo'])->name('training-detail.clear');

  Route::post('/training-assistant/{id}', [TrainingDetailController::class, 'addAssistant'])->name('training-assistant.create');
  Route::get('/training-assistant/{id}', [TrainingDetailController::class, 'viewAssistant'])->name('training-assistant.view');
  Route::put('/training-assistant-delete/{id}', [TrainingDetailController::class, 'deleteAssistant'])->name('training-assistant.delete');


// المسارات الجديدة
Route::post('/training-detail/{id}/update-field', [TrainingDetailController::class, 'updateField'])->name('training-detail.update-field');
Route::post('/training-detail/{id}/delete-field', [TrainingDetailController::class, 'deleteField'])->name('training-detail.delete-field');



  Route::delete('organization-training-manager/destroy-session/{id}', [OrgTrainingManagerController::class, 'deleteOrgSession'])->name('orgSessions.destroy');
  Route::put('organization-training-manager/update-session/{id}', [OrgTrainingManagerController::class, 'updateOrgSession'])->name('orgSessions.update');
  Route::delete('organization-training-manager/delete-image/{id}', [OrgTrainingManagerController::class, 'deleteOrgImage'])->name('orgImage.delete');
  Route::put('organization-training-manager/update-image/{id}', [OrgTrainingManagerController::class, 'updateOrgImage'])->name('orgImage.update');
  Route::post('organization-training-manager/assistant/store/{id}', [OrgTrainingManagerController::class, 'storeOrgAssistant'])->name('orgAssistant.store');
  Route::delete('organization-training-manager/delete-assistant/{orgTraining_id}/{assistant_id}', [OrgTrainingManagerController::class, 'deleteOrgAssistant'])
    ->name('orgAssistant.destroy');
  Route::post('/enroll/{OrgProgram_id}', [OrgTrainingManagerController::class, 'enroll'])->name('orgEnrollment.enroll');
  Route::get('organization-training-manage/sessions/{session}/attendance', [OrgTrainingManagerController::class, 'selectSessionAttendance'])->name('orgSession.attendance');
  Route::post('organization-training-manage/sessions/{session}/attendance', [OrgTrainingManagerController::class, 'storeSessionAttendance'])->name('orgSession.attendance.store');
  Route::post('organization-training-manage/{program_id}/upload-files', [OrgTrainingFilesController::class, 'uploadOrgTrainingFiles'])->name('orgTraining.file.upload');
  Route::delete('organization-training-manage/delete-file/{id}', [OrgTrainingFilesController::class, 'deleteOrgTrainingFile'])->name('orgTraining.file.delete');


  Route::post('/stop-sharing/{id}', [OrgTrainingManagerController::class, 'stopSharing'])->name('orgtrainings.stopSharing');
  Route::post('/re-publish/{id}', [OrgTrainingManagerController::class, 'rePublish'])->name('orgtrainings.rePublish');
  Route::get('/stopped', [OrgTrainingManagerController::class, 'showStoppedPrograms'])->name('orgtrainings.stopped');


  Route::get('/trainee-trainings/manager', [MyTrainingsController::class, 'index'])->name('trainee.trainings.manager');

  Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

  Route::get('/enrollments/filter', [EnrollmentController::class, 'filterByStatus'])->name('enrollments.filter');

  Route::get('/organization-show-training/{id}',[UpdateTrainingController::class,'show'])->name('organization.showSpecificTraining');
  Route::put('/organization-training/update-training/{id}', [UpdateTrainingController::class, 'update'])->name('organizationTraining.update');
  Route::post('organization-training/sessions/store/{orgTrainingDetailId}', [UpdateTrainingController::class, 'storeSession'])->name('organizationSessions.store');

});

Route::post('/feedback', [HomeController::class, 'sendFeedback'])->name('feedback.store');


Route::get('/trainings/announcements', [TrainingsController::class, 'index'])->name('trainings_announcements');

Route::get('/org/trainings/show/{id}', [OrgTrainingController::class, 'show'])->name('org.training.show');
Route::get('/org/trainings/show/program/{id}', [OrgTrainingController::class, 'showProgram'])->name('org.training.show.program');
Route::get('/trainings/announcements/show/{id}', [TrainingsController::class, 'show'])->name('show_trainings_announcements');
Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
Route::get('/assistants', [AssistantController::class, 'index'])->name('assistants.index');

//profiles users
Route::get('/show-trainer-profile/{id?}', [TrainerProfileController::class, 'showProfile'])->name('show_trainer_profile');
Route::get('/show-trainee-profile/{id?}', [TraineeProfileController::class, 'showProfile'])->name('show_trainee_profile');
Route::get('/show-assistant-profile/{id?}', [AssistantProfileController::class, 'showProfile'])->name('show_assistant_profile');
Route::get('/show-organization-profile/{id?}', [OrganizationProfileController::class, 'showProfile'])->name('show_organization_profile');


//reset password
Route::get('forgot-password', [ResetPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
Route::get('complete-reset-password', [ResetPasswordController::class, 'showCompleteResetPassword'])->name('password.reset.complete');

  Route::get('/subscriptions/trainer', function () {
    return view('subscriptions.trainer');
  })->name('subscriptions.trainer');

  Route::get('/subscriptions/organization', function () {
    return view('subscriptions.organization');
  })->name('subscriptions.organization');





Route::middleware('auth')->group(function () {
    // طرق الإشعارات
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/refresh', [NotificationController::class, 'refresh'])->name('notifications.refresh');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::post('/notifications/send', [NotificationController::class, 'sendNotification'])->name('notifications.send');
    Route::post('/notifications/fcm-token', [NotificationController::class, 'saveFcmToken'])->name('notifications.fcmToken');
    // طرق معالجة الإشعارات
    Route::post('/participants/{program}/{participant}/handle-action', [TrainingParticipantsController::class, 'handleAction'])->name('participants.handleAction');
});


Route::get('/test-notification', function () {
    try {
        $notification = \App\Helpers\NotificationHelper::sendToCurrentUser(
            'هذا إشعار اختباري',
            'test'
        );

        if ($notification) {
            \Log::info('Test notification created successfully', [
                'notification_id' => $notification->id,
                'user_id' => auth()->id(),
                'data' => $notification->data
            ]);

            return 'تم إرسال الإشعار بنجاح. ID: ' . $notification->id;
        } else {
            \Log::error('Failed to create test notification');
            return 'فشل إرسال الإشعار';
        }
    } catch (\Exception $e) {
        \Log::error('Error creating test notification: ' . $e->getMessage());
        return 'خطأ: ' . $e->getMessage();
    }
})->middleware('auth');

Route::get('/test-views-notification', function () {
    try {
        $organization = \App\Models\User::find(auth()->id());
        $views = rand(30, 60);

        $notification = \App\Helpers\NotificationHelper::sendNotification(
            $organization->id,
            'لقد تم مشاهدة برنامجك ' . $views . ' مرة.',
            'views',
            ['views' => $views, 'program_id' => 1]
        );

        if ($notification) {
            \Log::info('Views notification created successfully', [
                'notification_id' => $notification->id,
                'user_id' => $organization->id,
                'data' => $notification->data
            ]);

            return 'تم إرسال إشعار المشاهدات بنجاح. ID: ' . $notification->id;
        } else {
            \Log::error('Failed to create views notification');
            return 'فشل إرسال إشعار المشاهدات';
        }
    } catch (\Exception $e) {
        \Log::error('Error creating views notification: ' . $e->getMessage());
        return 'خطأ: ' . $e->getMessage();
    }
})->middleware('auth');


require __DIR__ . '/front_fetch.php';
