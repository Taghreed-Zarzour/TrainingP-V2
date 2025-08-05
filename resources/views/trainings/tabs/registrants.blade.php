                      <style>
                          .trainee-card {
                              transition: all 0.3s ease;
                              border-radius: 22px;
                              border: 1px solid #D6D6D6;
                              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                              margin-bottom: 20px;
                              height: 100%;
                              display: flex;
                              flex-direction: column;
                          }


                          .trainee-card:hover {
                              transform: none !important;
                              box-shadow: none !important;
                              /* أي تأثيرات أخرى تريد إلغاءها */
                          }

                          .trainee-img {
                              width: 70px;
                              height: 70px;
                              object-fit: cover;
                              border-radius: 50%;
                              border: 2px solid #f0f0f0;
                          }

                          .trainee-content {
                              padding: 0px 15px;
                              flex-grow: 1;
                          }

                          .trainee-info {
                              display: flex;
                              align-items: center;
                              gap: 15px;
                          }

                          .trainee-details {
                              flex-grow: 1;
                              text-align: right;

                          }

                          .trainee-details h5 {
                              margin-left: 30px;

                          }

                          .trainee-actions {
                              display: flex;
                              margin: 0px 15px 15px 10px;
                              gap: 10px;
                          }

                          .trainees-container {
                              max-height: calc(3 * (70px + 15px + 15px + 45px + 20px));
                              /* 3 كروت */
                              overflow-y: auto;
                              padding-left: 10px;
                              overflow-x: clip;
                          }

                          /* تخصيص شريط التمرير */
                          .trainees-container::-webkit-scrollbar {
                              width: 8px;
                              background-color: #e1f5fe;
                          }

                          .trainees-container::-webkit-scrollbar-thumb {
                              background-color: #003090;
                              border-radius: 4px;
                          }

                          .trainees-container::-webkit-scrollbar-thumb:hover {
                              background-color: #0277bd;
                          }

                          .view-toggle-btn.active {

                              border-color: #D2D5D5;
                              background-color: #00309018 !important;
                          }

                          .action-btn {
                              flex: 1;
                              padding: 8px 0;
                              border-radius: 5px;
                          }

                          .accept-btn {
                              background-color: #198754;
                              color: white;
                              border: none;
                          }

                          .accept-btn:hover {
                              background-color: #176f46;
                          }

                          .reject-btn {
                              background-color: #dc3545;
                              color: white;
                              border: none;
                          }

                          .reject-btn:hover {
                              background-color: #ae333f;

                          }

                          .selected-indicator {
                              position: absolute;
                              top: 10px;
                              left: 10px;
                              width: 20px;
                              height: 20px;
                              border-radius: 50%;
                              background-color: #003090;
                              display: flex;
                              align-items: center;
                              justify-content: center;
                              color: white;
                              font-size: 12px;
                          }

                          .total-trainees-badge {
                              padding: 10px 20px;
                              border-radius: 10px;
                              text-align: center;
                              border: 1px solid #003090;
                              color: #003090;
                              background-color: white;

                              font-size: 1rem;

                          }

                          .filter-row {
                              margin-bottom: 15px;
                          }

                          .controls-row {

                              padding: 20px;
                              border-radius: 8px;

                          }

                          @media (max-width: 768px) {
                              .trainee-info {
                                  flex-direction: column;
                                  text-align: center;
                              }

                              .trainee-details {
                                  text-align: center;
                              }

                              #traineesGrid.list-view .trainee-details {
                                  text-align: right;
                              }
                          }

                          .form-check {
                              white-space: nowrap;
                          }

                          .form-check-input {
                              border-radius: 50% !important;
                              border-color: #504f4f;
                              width: 20px;
                              height: 20px;


                          }


                          .btn-agree {
                              padding: 10px 10px;
                              border-radius: 10px;
                              text-align: center;
                              cursor: pointer;
                              border: 1px solid #00AF6C;
                              color: #029a60;
                              background-color: white;
                              transition: background-color 0.3s ease;

                          }

                          .btn-agree:hover {
                              background-color: #00AF6C;
                              border: 2px solid white;
                              color: white;
                          }

                          .btn-outline-primary {

                              border-color: #D2D5D5;
                          }

                          .btn-outline-primary:hover {

                              background-color: #00309018 !important;
                              border-color: #D2D5D5;
                          }

                          /* بطاقات الحالة */
                          .status-badge {
                              position: absolute;
                              top: 10px;
                              left: 10px;
                              padding: 2px 7px;
                              border-radius: 5px;
                              font-size: 12px;
                              font-weight: bold;
                              color: #fff;
                              z-index: 1;
                              max-width: 80px;
                          }




                          .status-badge.new {
                              background-color: #FFC62A40;
                              /* أصفر */
                              color: #FFC62A;
                          }

                          .status-badge.rejected {
                              background-color: #F5515759;
                              /* أحمر */
                              color: #F55157;
                          }

                          .status-badge.accepted {
                              background-color: #00AF6C45;
                              /* أخضر */
                              color: #00AF6C;
                          }

                          /* أزرار خاصة بالحالات */
                          .reject-reason-btn {
                              width: 100%;
                              background-color: transparent;
                              color: #F55157;
                              border: 1px solid #F55157;
                              border-radius: 5px;
                              padding: 8px 0;
                          }

                          .reject-reason-btn:hover {
                              background-color: #F55157;
                              color: white;

                          }

                          .accepted-label {
                              width: 100%;
                              background-color: #00AF6C;
                              color: white;
                              border: none;
                              border-radius: 5px;
                              padding: 8px 0;
                              text-align: center;
                          }

                          /* تعديل على أزرار البطاقة العادية */
                          .trainee-actions {
                              display: flex;
                              margin: 0px 15px 15px 10px;
                              gap: 10px;
                              width: calc(100% - 25px);
                          }




                          /* وضع القائمة (list-view) */
                          #traineesGrid.list-view .trainee-card {
                              display: flex;
                              flex-direction: row;
                              /* صورة يسار والنص يمين */
                              align-items: center;
                              padding: 15px;
                              gap: 15px;
                              border-radius: 12px;

                          }


                          #traineesGrid.list-view .trainee-info {
                              flex: 1;
                              /* النصوص تأخذ باقي المساحة */
                              display: flex;
                              align-items: center;
                              gap: 15px;
                          }


                          #traineesGrid.list-view .trainee-info img {
                              width: 70px;
                              height: 70px;
                              border-radius: 50%;
                              flex-shrink: 0;
                              /* منع تمدد الصورة */
                          }

                          #traineesGrid.list-view .trainee-details {
                              text-align: right;
                              flex-grow: 1;
                          }

                          #traineesGrid.list-view .trainee-details h5 {
                              font-size: 1rem;
                              margin-bottom: 5px;
                          }

                          #traineesGrid.list-view .trainee-actions {
                              display: flex;
                              flex-direction: row;
                              gap: 8px;
                              margin: 0;
                              width: auto;
                          }

                          #traineesGrid.list-view .accepted-label,
                          #traineesGrid.list-view .reject-reason-btn,
                          #traineesGrid.list-view .action-btn {
                              min-width: 90px;
                              padding: 7px 15px;
                          }

                          /* ✅ تحسين استجابة القائمة على الجوال */
                          @media (max-width: 768px) {
                              #traineesGrid.list-view .trainee-card {
                                  flex-direction: column;
                                  align-items: center;
                                  text-align: center;
                              }

                              #traineesGrid.list-view .trainee-details {
                                  text-align: center;
                              }

                              #traineesGrid.list-view .trainee-info {
                                  width: 100%;
                                  flex-direction: column;
                                  text-align: center;
                              }

                              #traineesGrid.list-view .trainee-actions {
                                  width: 100%;
                                  justify-content: center;
                                  margin-top: 10px;
                              }
                          }

                          /* وضع القائمة (list-view) */
                          #traineesGrid.list-view {
                              display: block !important;
                          }

                          #traineesGrid.list-view .col {
                              flex: 0 0 100% !important;
                              max-width: 100% !important;
                              padding: 10px !important;
                          }



                          #traineesGrid.list-view .trainee-actions {
                              width: auto !important;
                              margin: 10px 25px 0 25px !important;

                          }
                      </style>
                      <div class="tr-trainees-container">
                          <!-- سطر البحث والفلترة -->
                          <div class="row justify-content-center">
                              <div class="col-md-11">
                                  <div
                                      class="d-flex align-items-center justify-content-between px-3 py-2 shadow-sm bg-white custom-search-bar">
                                      <div class="d-flex align-items-center">
                                          <img src="{{ asset('images/cources/search.svg') }}" alt="search icon">
                                          <input type="text" class="form-control border-0 flex-grow-1"
                                              placeholder="ابحث عن أي شيء"
                                              style="box-shadow: none; background: transparent;">
                                      </div>
                                      <button class="btn custom-filter-btn d-flex align-items-center gap-2"
                                          type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                                          <img src="/images/cources/filter.svg">
                                          <span>فلترة</span>
                                          <img src="/images/cources/arrow-down.svg">
                                      </button>
                                  </div>
                              </div>
                          </div>

                          <!-- سطر التحكم -->
                          <div class="row justify-content-center">
                              <div
                                  class="controls-row col-md-11 d-flex justify-content-lg-between justify-content-center align-items-center flex-wrap gap-2">
                                  <div class="d-flex align-items-center gap-3">
                                      <div class="form-check">
                                          <input class="form-check-input me-2" type="checkbox" id="selectAll">
                                          <label class="form-check-label" for="selectAll">تحديد الكل</label>
                                      </div>
                                      <form method="POST" action="{{ route('participants.bulkAccept', $program->id) }}"
                                          class="mb-0 p-0" id="bulkAcceptForm">
                                          @csrf
                                          <button type="submit" class="btn-agree" id="bulkAcceptBtn"
                                              onclick="return confirm('هل أنت متأكد من قبول جميع المتدربين؟')">
                                              قبول كل الأشخاص المحددين (<span id="selectedCount">0</span> متدرب)
                                          </button>
                                      </form>
                                  </div>

                                  <div class="d-flex align-items-center gap-3 w-auto">
                                      <span class="total-trainees-badge">
                                          عدد المسجلين: {{ count($participants) }}
                                      </span>
                                      <div class="btn-group" role="group">
                                          <button type="button" class="btn btn-outline-primary view-toggle-btn active"
                                              data-view="grid" title="عرض شبكي">
                                              <img src="/images/cources/grid.svg">
                                          </button>
                                          <button type="button" class="btn btn-outline-primary view-toggle-btn"
                                              data-view="list" title="عرض قائمة">
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

                                          $pivot = $participant->trainingPrograms->firstWhere('id', $program->id)
                                              ?->pivot;
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
                                                      <img src="{{ $participant->user->photo ? asset('storage/' . $participant->user->photo) : asset('images/icons/user.svg') }}"
                                                          class="rounded-circle" width="60" height="60">
                                                      <div class="trainee-details">
                                                          <h5 class="mb-1">
                                                              {{ $participant->user->getTranslation('name', 'ar') }}
                                                              {{ $participant->getTranslation('last_name', 'ar') }}</h5>
                                                          <p class="text-muted small mb-0">
                                                              سجّل بتاريخ
                                                              {{ $pivot?->registered_at ? \Carbon\Carbon::parse($pivot->registered_at)->locale('ar')->translatedFormat('d F Y') : 'غير معروف' }}


                                                          </p>
                                                      </div>
                                                  </div>
                                              </div>

                                              @if ($isRejected)
                                                  <div class="trainee-actions">
                                                      <button class="action-btn reject-reason-btn"
                                                          data-bs-toggle="modal" data-bs-target="#rejectReasonModal"
                                                          data-participant="{{ $participant->id }}"
                                                          data-program="{{ $program->id }}">

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
                                                          <svg width="22" height="21" viewBox="0 0 22 21"
                                                              fill="none" xmlns="http://www.w3.org/2000/svg">
                                                              <path d="M3.67188 10.9961L7.94219 15.2368L17.5504 5.69531"
                                                                  stroke="white" stroke-width="1.73481"
                                                                  stroke-linecap="round" stroke-linejoin="round" />
                                                          </svg>
                                                          تم القبول
                                                      </div>
                                                  </div>
                                              @else
                                                  <div class="trainee-actions">
                                                      <form class="d-flex flex-row w-100 p-0" method="POST"
                                                          action="{{ route('participants.handleAction', ['program' => $program->id, 'participant' => $participant->id]) }}">
                                                          @csrf
                                                          <button type="submit" name="action" value="accept"
                                                              class="action-btn accept-btn">قبول</button>
                                                          <button type="submit" name="action" value="reject"
                                                              class="action-btn reject-btn">اعتذار</button>
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
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"
                                          aria-label="إغلاق"></button>
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
                                              <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="3" required
                                                  placeholder="يرجى توضيح سبب رفض الطلب لبنم إبلغ المتدرب بشكل مناسب.">{{ $pivot->rejection_reason ?? '' }}</textarea>
                                          </div>
                                      </form>
                                  </div>
                                  <div
                                      class="modal-footer border-0 justify-content-center flex-row-reverse w-100 d-flex">
                                      <button type="button" class="btn-cancel mx-2 flex-fill"
                                          data-bs-dismiss="modal">
                                          إلغاء
                                      </button>
                                      <button type="submit" form="rejectReasonForm"
                                          class="custom-btn  mx-2 flex-fill">
                                          إرسال السبب للمتدرب
                                          <img src="{{ asset('images/cources/arrow-left.svg') }}">

                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <script>
                          //التبديل بين عرش الشبكة والقائمة
                          document.addEventListener("DOMContentLoaded", function() {
                              const buttons = document.querySelectorAll(".view-toggle-btn");
                              const traineesGrid = document.getElementById("traineesGrid");

                              buttons.forEach(btn => {
                                  btn.addEventListener("click", function() {
                                      buttons.forEach(b => b.classList.remove("active"));
                                      this.classList.add("active");

                                      const view = this.getAttribute("data-view");

                                      if (view === "list") {
                                          traineesGrid.classList.add("list-view");
                                          traineesGrid.classList.remove("row-cols-1", "row-cols-md-2",
                                              "row-cols-lg-3", "g-3");

                                          // إضافة كلاسات عرض القائمة
                                          traineesGrid.classList.add("list-container");

                                          traineesGrid.querySelectorAll(".col").forEach(col => {
                                              col.classList.add("col-12");
                                              col.classList.remove("col");
                                          });
                                      } else {
                                          traineesGrid.classList.remove("list-view", "list-container");
                                          traineesGrid.classList.add("row-cols-1", "row-cols-md-2", "row-cols-lg-3",
                                              "g-3");

                                          traineesGrid.querySelectorAll(".col-12").forEach(col => {
                                              col.classList.remove("col-12");
                                              col.classList.add("col");
                                          });
                                      }
                                  });
                              });
                          });
                      </script>

                      <script>
                        document.addEventListener("DOMContentLoaded", function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const bulkAcceptBtn = document.getElementById('bulkAcceptBtn');
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkAcceptForm = document.getElementById('bulkAcceptForm');
    
    // إخفاء الزر بشكل ابتدائي
    bulkAcceptForm.style.display = 'none';

    // إنشاء أنماط CSS
    const style = document.createElement('style');
    style.innerHTML = `
        .img-check-container {
            position: relative;
            display: inline-block;
        }
        
        .selection-circle {
            position: absolute;
            bottom: -5px;
            right: -5px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background-color: #003090;
            border: 2px solid white;
            display: none;
            z-index: 2;
        }
        
        .selection-circle::after {
            content: "✓";
            color: white;
            font-size: 10px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        .trainee-card.has-selection-circle {
            transition: border-color 0.3s ease;
        }
        
        .trainee-card.has-selection-circle.selected {
            border-color: #003090 !important;
            box-shadow: 0 0 0 1px #003090 !important;
        }
    `;
    document.head.appendChild(style);

    // إضافة حاوية للصورة والدائرة لكل متدرب جديد
    document.querySelectorAll('.trainee-card .status-badge.new').forEach(badge => {
        const card = badge.closest('.trainee-card');
        const img = card.querySelector('.trainee-info img');
        const container = document.createElement('div');
        container.className = 'img-check-container';

        // إضافة كلاس للبطاقة للإشارة إلى وجود دائرة تحديد
        card.classList.add('has-selection-circle');

        // نقل الصورة إلى الحاوية الجديدة
        img.parentNode.insertBefore(container, img);
        container.appendChild(img);

        // إضافة دائرة التحديد
        const circle = document.createElement('div');
        circle.className = 'selection-circle';
        container.appendChild(circle);
    });

    // عند النقر على تحديد الكل
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        const newTrainees = document.querySelectorAll('.trainee-card.has-selection-circle');
        
        newTrainees.forEach(card => {
            const circle = card.querySelector('.selection-circle');
            
            if (isChecked) {
                circle.style.display = 'block';
                card.classList.add('selected');
            } else {
                circle.style.display = 'none';
                card.classList.remove('selected');
            }
        });
        
        // تحديث العدد على الزر وإظهار/إخفاء الفورم
        const selectedCount = isChecked ? newTrainees.length : 0;
        selectedCountSpan.textContent = selectedCount;
        bulkAcceptForm.style.display = selectedCount > 0 ? 'block' : 'none';
    });


});
                      </script>

                      <script>
                          //سبب رفض الطلب 
                          const rejectModal = document.getElementById('rejectReasonModal');
                          rejectModal.addEventListener('show.bs.modal', function(event) {
                              const button = event.relatedTarget;
                              const participantId = button.getAttribute('data-participant');
                              const programId = button.getAttribute('data-program');

                              const form = document.getElementById('rejectReasonForm');
                              const routeTemplate =
                                  "{{ route('participants.submitReason', ['program' => 'PROGRAM_ID', 'participant' => 'PARTICIPANT_ID']) }}";
                              const newAction = routeTemplate
                                  .replace('PROGRAM_ID', programId)
                                  .replace('PARTICIPANT_ID', participantId);

                              form.setAttribute('action', newAction);
                          });
                      </script>
