{{-- <div class="tr-trainees-container">
    <!-- سطر البحث والفلترة -->
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="d-flex align-items-center justify-content-between px-3 py-2 shadow-sm bg-white custom-search-bar">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/cources/search.svg') }}" alt="search icon">
                    <input type="text" class="form-control border-0 flex-grow-1" placeholder="ابحث عن أي شيء" style="box-shadow: none; background: transparent;">
                </div>
                <button class="btn custom-filter-btn d-flex align-items-center gap-2" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <img src="/images/cources/filter.svg">
                    <span>فلترة</span>
                    <img src="/images/cources/arrow-down.svg">
                </button>
            </div>
        </div>
    </div>

    <!-- سطر التحكم -->
    <div class="row justify-content-center">
        <div class="controls-row col-md-11 d-flex justify-content-lg-between justify-content-center align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <div class="form-check">
                    <input class="form-check-input me-2" type="checkbox" id="selectAll">
                    <label class="form-check-label" for="selectAll">تحديد الكل</label>
                </div>
                <form method="POST" action="{{ route('orgEnrollment.bulkAccept', $OrgProgramDetail->trainingProgram->id) }}" class="mb-0 p-0" id="bulkAcceptForm">
                    @csrf
                    <button type="submit" class="btn-agree" id="bulkAcceptBtn" onclick="return confirm('هل أنت متأكد من قبول جميع المتدربين؟')">
                        قبول كل الأشخاص المحددين (<span id="selectedCount">0</span> متدرب)
                    </button>
                </form>
            </div>

            <div class="d-flex align-items-center gap-3 w-auto">
                <span class="total-trainees-badge">
                    عدد المسجلين: {{ count($participants) }}
                </span>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary view-toggle-btn active" data-view="grid" title="عرض شبكي">
                        <img src="/images/cources/grid.svg">
                    </button>
                    <button type="button" class="btn btn-outline-primary view-toggle-btn" data-view="list" title="عرض قائمة">
                        <img src="/images/cources/list.svg">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة المتدربين -->
    <div class="trainees-container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 p-3" id="traineesGrid">
            @foreach ($participants as $participant)
                @php
                    $pivot = $participant->enrollments->firstWhere('org_training_programs_id', $OrgProgramDetail->trainingProgram->id);
                    $isRejected = $pivot && $pivot->status === 'rejected';
                    $isAccepted = $pivot && $pivot->status === 'accepted';
                @endphp

                <div class="col">
                    <div class="card trainee-card position-relative">
                        <!-- حالة المتدرب -->
                        @if ($isRejected)
                            <div class="status-badge rejected">مرفوض</div>
                        @elseif($isAccepted)
                            <div class="status-badge accepted">مقبول</div>
                        @else
                            <div class="status-badge new">جديد</div>
                        @endif

                        <div class="trainee-content align-content-center">
                            <div class="trainee-info">
                                <img src="{{ $participant->user->photo ? asset('storage/' . $participant->user->photo) : asset('images/icons/user.svg') }}" class="rounded-circle" width="60" height="60">
                                <div class="trainee-details">
                                    <h5 class="mb-1">
                                        {{ $participant->user->getTranslation('name', 'ar') }} 
                                        {{ $participant->getTranslation('last_name', 'ar') }}
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        سجّل بتاريخ
                                        {{ $pivot?->registered_at ? \Carbon\Carbon::parse($pivot->registered_at)->locale('ar')->translatedFormat('d F Y') : 'غير معروف' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($isRejected)
                            <div class="trainee-actions">
                                <button class="action-btn reject-reason-btn" data-bs-toggle="modal" data-bs-target="#rejectReasonModal" data-participant="{{ $participant->id }}" data-program="{{ $OrgProgramDetail->trainingProgram->id }}">
                                    @if ($pivot?->rejection_reason)
                                        تحديث سبب الرفض
                                    @else
                                        إرسال سبب الاعتذار
                                    @endif
                                </button>
                            </div>
                        @elseif($isAccepted)
                            <div class="trainee-actions">
                                <div class="accepted-label">
                                    <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.67188 10.9961L7.94219 15.2368L17.5504 5.69531" stroke="white" stroke-width="1.73481" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    تم القبول
                                </div>
                            </div>
                        @else
                            <div class="trainee-actions">
                                <form class="d-flex flex-row w-100 p-0" method="POST" action="{{ route('orgEnrollment.handleAction', ['program' => $OrgProgramDetail->trainingProgram->id, 'participant' => $participant->id]) }}">
                                    @csrf
                                    <button type="submit" name="action" value="accept" class="action-btn accept-btn">قبول</button>
                                    <button type="submit" name="action" value="reject" class="action-btn reject-btn">اعتذار</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- مودال إرسال سبب الرفض -->
<div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body ">
                <div class="text-center mb-3">
                    <img src="{{ asset('images/cources/reason.svg') }}" class="img-fluid">
                </div>
                <h4 class="modal-title text-center mb-3 fw-bold custom-style">
                    سبب رفض الطلب
                </h4>

                <form id="rejectReasonForm" class="p-0" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="3" required placeholder="يرجى توضيح سبب رفض الطلب لبنم إبلغ المتدرب بشكل مناسب.">{{ $pivot->rejection_reason ?? '' }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 justify-content-center flex-row-reverse w-100 d-flex">
                <button type="button" class="btn-cancel mx-2 flex-fill" data-bs-dismiss="modal">
                    إلغاء
                </button>
                <button type="submit" form="rejectReasonForm" class="custom-btn  mx-2 flex-fill">
                    إرسال السبب للمتدرب
                    <img src="{{ asset('images/cources/arrow-left.svg') }}">
                </button>
            </div>
        </div>
    </div>
</div> --}}