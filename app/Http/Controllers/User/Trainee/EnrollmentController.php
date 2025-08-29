<?php

namespace App\Http\Controllers\User\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Auth;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Laravel\Pail\ValueObjects\Origin\Console;
use App\Models\TrainingProgram;
class EnrollmentController extends Controller
{
  protected $enrollmentService;

  public function __construct(EnrollmentService $enrollmentService)
  {
    $this->enrollmentService = $enrollmentService;
  }

  public function enrolle($program_id)
  {

    $response = $this->enrollmentService->store(program_id: $program_id, orgProgram_id: null);

    if ($response['success'] == true) {

      return redirect()->route('enrollment.confirmation', ['program_id' => $program_id])
        ->with('success', $response['msg']);
    } else {
      return back()->withErrors(['error' => $response['msg']]);
    }

  }
}
