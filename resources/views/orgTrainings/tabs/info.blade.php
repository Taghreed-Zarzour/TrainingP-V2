<style>
    .training-type {
        background-color: white;
        color: #003090;
        display: inline-block;
        padding: 3px 10px;
        border-radius: 5px;
        font-weight: bold;
        font-size: 14px;
        margin-left: 8px;
        vertical-align: middle;
    }
    .list-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    .list-item img {
        margin-left: 10px;
        margin-top: 3px;
    }
    .payment-box {
        border: 2px solid #EFF0F6;
        border-radius: 32px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .free-training-badge {
        background-color: #28a745;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
        margin-right: 10px;
    }
    @media (max-width: 768px) {
        .two-columns {
            display: block !important;
        }
        .two-columns>div {
            width: 100% !important;
        }
    }
    .empty-state {
        text-align: center;
        padding: 20px;
        color: #6c757d;
        font-style: italic;
    }
    .info-block {
        margin-bottom: 20px;
    }
    .info-block-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #003090;
    }
    .clickable-title {
        cursor: pointer;
    }
    .info-block-content {

        border-radius: 8px;
        padding: 15px;
    }
    .audience-question {
        margin-bottom: 15px;
    }
    .audience-question-title {
        display: flex;
        align-items: center;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .audience-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .audience-tag {
        background-color: #e6f0ff;
        color: #003090;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 14px;
        display: inline-block;
    }
</style>
<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <div class="edit-btn">
          <button type="button" 
        style="background: transparent;" 
        title="تعديل"
        onclick="window.location='{{ route('orgTraining.goals', $OrgProgram->id) }}'">
    <img src="{{ asset('images/cources/edit.svg') }}">
</button>
        </div>
    </div>
    
    <div class="two-columns" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
        <!-- العمود الأول -->
        <div style="flex: 1; min-width: 300px;">
            <!-- الفئة المستهدفة -->
            <div class="mb-5">
                <div class="info-block gap-0">
                    <div class="info-block-title clickable-title"
                        onclick="window.location.href='{{ route('orgTraining.goals', $OrgProgram->id) }}'">
                        <h3 class="section-title m-0">الفئة المستهدفة من المسار التدريبي</h3>
                    </div>
                    <div class="info-block-content">
                        <!-- المستوى العلمي -->
                        @if(isset($education_levels) && count($education_levels))
                            <div class="audience-question">
                                <div class="audience-question-title">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                    المستوى العلمي
                                </div>
                                <div class="audience-tags">
                                    @foreach($education_levels as $education_level)
                                        <span class="audience-tag">{{ $education_level }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- الحالة الوظيفية -->
                        @php
                            $work_statuses = [];
                            foreach($OrgProgram->goals as $goal) {
                                if(isset($goal->work_status) && is_array($goal->work_status)) {
                                    $work_statuses = array_merge($work_statuses, $goal->work_status);
                                }
                            }
                            $work_statuses = array_unique($work_statuses);
                        @endphp
                        @if(count($work_statuses))
                            <div class="audience-question">
                                <div class="audience-question-title">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                    الحالة الوظيفية
                                </div>
                                <div class="audience-tags">
                                    @foreach($work_statuses as $status)
                                        <span class="audience-tag">
                                            @if($status == 'working')
                                                يعمل
                                            @elseif($status == 'not_working')
                                                لا يعمل
                                            @else
                                                {{ $status }}
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- قطاع العمل -->
                        @if(isset($work_sectors) && count($work_sectors))
                            <div class="audience-question">
                                <div class="audience-question-title">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                    قطاع العمل
                                </div>
                                <div class="audience-tags">
                                    @foreach($work_sectors as $work_sector)
                                        <span class="audience-tag">{{ $work_sector }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- المستوى الوظيفي -->
                        @php
                            $job_positions = [];
                            foreach($OrgProgram->goals as $goal) {
                                if(isset($goal->job_position) && is_array($goal->job_position)) {
                                    $job_positions = array_merge($job_positions, $goal->job_position);
                                }
                            }
                            $job_positions = array_unique($job_positions);
                        @endphp
                        @if(count($job_positions))
                            <div class="audience-question">
                                <div class="audience-question-title">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                    المستوى الوظيفي
                                </div>
                                <div class="audience-tags">
                                    @foreach($job_positions as $job)
                                        <span class="audience-tag">{{ $job }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- الجنسية/ المنطقة -->
                        @php
                            $countries = [];
                            foreach($OrgProgram->goals as $goal) {
                                if(isset($goal->countries) && is_array($goal->countries)) {
                                    $countries = array_merge($countries, $goal->countries);
                                }
                            }
                            $countries = array_unique($countries);
                        @endphp
                        @if(count($countries))
                            <div class="audience-question">
                                <div class="audience-question-title">
                                    <img src="{{ asset('images/icons/check-circle.svg') }}" class="me-2">
                                    الجنسية/ المنطقة
                                </div>
                                <div class="audience-tags">
                                    @foreach($countries as $countryId)
                                        @php
                                            $country = \App\Models\Country::find($countryId);
                                        @endphp
                                        @if($country)
                                            <span class="audience-tag">{{ $country->name }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- المتطلبات -->
            @php
                $requirements = json_decode($OrgProgram->registrationRequirements->requirements, true);
            @endphp
            @if(is_array($requirements) && count($requirements))
            <div class="mb-5">
                <h3 class="section-title">المتطلبات أو الشروط اللازمة للالتحاق بالمسار التدريبي</h3>
                <ul>
                    @foreach ($requirements as $requirement)
                        <li class="list-item">
                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20" height="20">
                            <span>{{ $requirement }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <!-- ميزات المسار -->
            @php
                $benefits = json_decode($OrgProgram->registrationRequirements->benefits, true);
            @endphp
            @if(is_array($benefits) && count($benefits))
            <div class="mb-5">
                <h3 class="section-title">ميزات المسار التدريبي</h3>
                <ul>
                    @foreach ($benefits as $benefit)
                        <li class="list-item">
                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20" height="20">
                            <span>{{ $benefit }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        
        <!-- العمود الثاني -->
        <div style="flex: 1; min-width: 300px;">
            <!-- وصف المسار -->
            @if(!empty($OrgProgram->program_description))
            <div class="mb-5">
                <h3 class="section-title">وصف المسار التدريبي</h3>
                <p>{{ $OrgProgram->program_description }}</p>
            </div>
            @endif
            
            <!-- ما الذي سيتعلمه المشاركون -->
            @php
                $learning_outcomes = [];
                foreach($OrgProgram->goals as $goal) {
                    if(isset($goal->learning_outcomes) && is_array($goal->learning_outcomes)) {
                        $learning_outcomes = array_merge($learning_outcomes, $goal->learning_outcomes);
                    }
                }
                $learning_outcomes = array_unique($learning_outcomes);
            @endphp
            @if(count($learning_outcomes))
            <div class="mb-5">
                <h3 class="section-title">ما الذي سيتعلمه المشاركون في هذا المسار التدريبي؟</h3>
                <ul>
                    @foreach($learning_outcomes as $learning_outcome)
                        <li class="list-item">
                            <img src="{{ asset('images/icons/check-circle.svg') }}" alt="check" width="20" height="20">
                            <span>{{ $learning_outcome }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    
    <!-- آلية الدفع والرسالة الترحيبية -->
    @if(isset($OrgProgram->registrationRequirements))
        <!-- عرض آلية الدفع -->
        @if(!empty($OrgProgram->registrationRequirements->payment_method))
        <div class="payment-box mb-5">
            <h3 class="section-title">آلية الدفع</h3>
            <p>{{ $OrgProgram->registrationRequirements->payment_method }}</p>
        </div>
        @endif
        
        <!-- الرسالة الترحيبية -->
        @if(!empty($OrgProgram->registrationRequirements->welcome_message))
            <div class="welcome-box mb-5">
                <h3 class="section-title">رسالة ترحيبية</h3>
                <div class="welcome-message">
                    <p>{{ $OrgProgram->registrationRequirements->welcome_message }}</p>
                </div>
            </div>
        @endif
    @endif
</div>

@section('scripts')
@endsection