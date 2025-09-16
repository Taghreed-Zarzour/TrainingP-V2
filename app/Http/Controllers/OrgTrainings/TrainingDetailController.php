<?php

namespace App\Http\Controllers\OrgTrainings;

use App\Http\Controllers\Controller;
use App\Models\OrgTrainingDetail;
use Illuminate\Http\Request;

class TrainingDetailController extends Controller
{
    public function update($id){
        $programDetail = OrgTrainingDetail::where('id', $id)->get();
    }
}
