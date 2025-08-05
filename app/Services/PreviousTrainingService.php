<?php

namespace App\Services;

use App\Models\PreviousTraining;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PreviousTrainingService
{
    public function store($data){
        try{
            $userId = Auth::id();
            $data['trainer_id'] = $userId;
            $pre_trauning = PreviousTraining::create($data);
            return [
                'msg' => 'تم تخزين البيانات.',
                'success' => true,
                'data' => $pre_trauning
            ];

        }catch(\Exception $e){
            return [
                'msg' => $e->getMessage(),
                'success'=> false,
                'data' => []
            ];
        }
    }

    public function update($data, $id){
        try{
            $pre_trauning = PreviousTraining::findOrFail($id);
            $pre_trauning->update($data);
            return [
                'msg' => 'تم تعديل البيانات.',
                'success' => true,
                'data' => $pre_trauning
            ];

        }catch(\Exception $e){
            return [
                'msg' => $e->getMessage(),
                'success'=> false,
                'data' => []
            ];
        }
    }

    public function delete($id){
        try{
            $pre_trauning = PreviousTraining::findOrFail($id);
            $pre_trauning->delete();
            return [
                'msg' => 'تم مسح البيانات.',
                'success' => true,
                'data' => null
            ];

        }catch(\Exception $e){
            return [
                'msg' => $e->getMessage(),
                'success'=> false,
                'data' => []
            ];
    }
}
}

