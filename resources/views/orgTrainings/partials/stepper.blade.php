@php
    // دالة مساعدة للتحقق من اكتمال الخطوات
    $isStepCompleted = function($stepNumber) use ($trainingId) {
        if (!$trainingId) return false;
        
        try {
            $training = \App\Models\OrgTrainingProgram::find($trainingId);
            if (!$training) return false;
            
            switch ($stepNumber) {
                case 1: // معلومات التدريب الأساسية
                    return !empty($training->title) && !empty($training->program_description);
                    
                case 2: // الأهداف ومحتوى التدريب
                    $detail = $training->detail()->first();
                    return $detail && (
                        !empty($detail->learning_outcomes) || 
                        !empty($detail->target_audience)  
                    );
                    
                case 3: // إدارة المدربين والمساعدين
                    return $training->assistants()->count() > 0;
                    
                case 4: // جدولة الجلسات التدريبية
                    return $training->schedules_later || $training->sessions()->count() > 0;
                    
                case 5: // الإعدادات الإضافية
                    return $training->AdditionalSetting()->exists();
                    
                case 6: // المراجعة النهائية
                    return false; // لا يمكن إكمال هذه الخطوة لأنها الأخيرة
                    
                default:
                    return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    };

    $steps = [
        1 => [
            'title' => 'معلومات البرنامج الأساسية',
            'route' => isset($trainingId) ? route('orgTraining.basicInformation', $trainingId) : route('orgTraining.create'),
            'accessible' => true // الخطوة الأولى دائماً متاحة
        ],
        2 => [
            'title' => 'أهداف البرنامج',
            'route' => isset($trainingId) ? route('orgTraining.goals', $trainingId) : null,
            'accessible' => isset($trainingId) // متاحة فقط إذا كان هناك معرف تدريب
        ],
        3 => [
            'title' => 'محتوى البرنامج',
            'route' => isset($trainingId) ? route('orgTraining.trainingDetail', $trainingId) : null,
            'accessible' => isset($trainingId)
        ],
        4 => [
            'title' => 'ميسرو البرنامج',
            'route' => isset($trainingId) ? route('orgTraining.assistants', $trainingId) : null,
            'accessible' => isset($trainingId)
        ],
        5 => [
            'title' => 'التسجيل والمتطلبات',
            'route' => isset($trainingId) ? route('orgTraining.settings', $trainingId) : null,
            'accessible' => isset($trainingId)
        ],
        6 => [
            'title' => 'المراجعة النهائية',
            'route' => isset($trainingId) ? route('orgTraining.review', $trainingId) : null,
            'accessible' => isset($trainingId)
        ]
    ];
@endphp

@foreach ($steps as $stepNumber => $step)
    @php
        $stepClass = '';
        $circleContent = '';
        $isAccessible = $step['accessible'];
        $isCompleted = $isStepCompleted($stepNumber);
        
        if ($isCompleted) {
            $stepClass = 'completed';
            $circleContent = '<img src="'.asset('images/icons/check.svg').'" alt="✓" />';
        } elseif ($currentStep == $stepNumber) {
            $stepClass = 'current';
        }
        
        // إضافة كلاس للخطوات غير المتاحة
        if (!$isAccessible) {
            $stepClass .= ' disabled';
        }
    @endphp
      
    <div class="step {{ $stepClass }}">
        <span class="circle">
            {!! $circleContent !!}
        </span>
        <span class="label">
            @if($isAccessible && $step['route'])
                <a href="{{ $step['route'] }}">{{ $step['title'] }}</a>
            @else
                <span class="step-title">{{ $step['title'] }}</span>
                @if(!$isAccessible)
                    <span class="tooltip">يجب إكمال الخطوات السابقة أولاً</span>
                @endif
            @endif
        </span>
        
        @if($stepNumber < 6)
            <span class="connector"></span>
        @endif
    </div>
@endforeach

<style>
    .step.disabled {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .label a{
      color: #333333;
      font-weight: 400;
    }
    .step.disabled .label {
        color: #999;
    }
    
    .step .tooltip {
        display: none;
        position: absolute;
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        z-index: 10;
    }
    
    .step.disabled:hover .tooltip {
        display: block;
    }
    
</style>
