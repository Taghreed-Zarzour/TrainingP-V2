<?php

namespace App\Http\Controllers\User\Trainee;

use App\Http\Controllers\Controller;
use App\Models\TrainerRating;
use App\Http\Requests\TraineeRequests\TrainerRatingRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class TrainerRatingController extends Controller
{
    public function store(TrainerRatingRequest $request , $trainer_id)
{
    $data = $request->validated();
    $trainee_id = Auth::id();

    $rating = TrainerRating::where('trainee_id', $trainee_id)
    ->where('trainer_id', $trainer_id)
    ->first();

    if ($rating) {
        $rating->update([
        'clarity' => $data['clarity'],
        'interaction' => $data['interaction'],
        'organization' => $data['organization'],
        'comment' => $data['comment'],
        ]);

    } else {
        TrainerRating::create([
        'trainer_id' => $trainer_id,
        'trainee_id' => $trainee_id,
        'clarity' => $data['clarity'],
        'interaction' => $data['interaction'],
        'organization' => $data['organization'],
        'comment' => $data['comment'],
        ]);
}
    return back()->with('success', 'تم إرسال تقييمك بنجاح');
}

}
