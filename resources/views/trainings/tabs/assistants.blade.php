<!-- قائمة المساعدين -->
<div class="tr-trainees-container">


          <div class="tr-sessions-header">
            <h1 class="tr-sessions-title">مساعدو المدرب</h1>
            <button type="button" class="custom-btn" data-bs-toggle="modal" data-bs-target="#chooseAssistantModal">
                <img src="/images/cources/plus.svg">
                إضافة مساعد
            </button>
        </div>

    <div class="tr-trainees-card">
        @if($assistants->isEmpty())
            <div class="text-center py-4">
                
                <h5>لا يوجد مساعدين مضافين لهذا التدريب</h5>
                <p class="mb-0">يمكنك إضافة مساعدين من خلال زر إضافة مساعد</p>
            </div>
        @else
            <div class="tr-trainees-table-container">
                <table class="tr-trainees-table">
                    <thead>
                        <tr>
                            <th>رقم تسلسلي</th>
                            <th>اسم المساعد</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>التفاصيل</th>
                            <th>تفاعل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($assistants as $assistant)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <div class="tr-trainee-name">
                                    @if ($assistant->photo)
                                        <img src="{{ asset('storage/' . $assistant->photo) }}" alt="صورة المساعد" class="tr-trainee-avatar">
                                    @else
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="مساعد" class="tr-trainee-avatar">
                                    @endif
                                    <span>{{ $assistant->getTranslation('name', 'ar') }} {{ $assistant->assistant->getTranslation('last_name', 'ar') }}</span>
                                </div>
                            </td>
                            <td>{{ $assistant->email }}</td>
                            <td>{{ $assistant->phone_number }}</td>
                            <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                            <td class="text-center">
                                <form action="{{ route('training.assistant.destroy', ['program_id' => $program->id, 'assistant_id' => $assistant->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        <img src="{{ asset('images/cources/trash.svg') }}">
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>


<!-- مودال اختيار المساعد -->
<div class="modal fade" id="chooseAssistantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-3 py-3">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="addAssistantForm" method="POST" class="p-0">
                    @csrf
                    
                    <h5 class="modal-title mb-4">اختر مساعدًا لإضافته</h5>
                    
                    @if($availableAssistants->isEmpty())
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle mb-2"></i>
                            لا يوجد مساعدين متاحين حاليًا للإضافة.
                        </div>
                    @else
                        <div class="input-group mb-4">
                            <div class="d-flex flex-column-reverse">
                                <label class="w-100">المساعد <span class="required">*</span></label>
                            </div>
                            <select name="assistant_id" class="form-select w-100" required>
                                <option value="">-- اختر المساعد --</option>
                                @foreach ($availableAssistants as $assistant)
                                    <option value="{{ $assistant->id }}">
                                        {{ $assistant->user->getTranslation('name', 'ar') }} {{ $assistant->user->getTranslation('last_name', 'ar') }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="assistantError" class="invalid-feedback d-none">يرجى اختيار مساعد</div>
                        </div>
                    @endif
                    
                    <div class="modal-footer border-0 px-0">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">إلغاء</button>
                        @if(!$availableAssistants->isEmpty())
                            <button type="submit" class="custom-btn">
                                إضافة المساعد
                                <img src="{{ asset('images/cources/arrow-left.svg') }}">
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- سكريبت التعامل مع التحقق والرسائل -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addAssistantForm');
    const select = form.querySelector('select[name="assistant_id"]');
    const assistantError = document.getElementById('assistantError');

form.addEventListener('submit', function (e) {
    e.preventDefault(); // امنع الإرسال أولًا للتحقق

    // Reset error messages
    select.classList.remove('is-invalid');
    assistantError.classList.add('d-none');

    const selectedId = select.value;
    const alreadyAddedIds = @json(optional($program->assistants)->pluck('id') ?? []);
    let hasError = false;

    // تحقق من الاختيار
    if (!selectedId) {
        select.classList.add('is-invalid');
        assistantError.textContent = 'يرجى اختيار مساعد لإضافته.';
        assistantError.classList.remove('d-none');
        hasError = true;
    }

    // تحقق من التكرار
    if (alreadyAddedIds.includes(parseInt(selectedId))) {
        Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: 'هذا المساعد مضاف مسبقًا لهذا التدريب.',
            confirmButtonText: 'موافق'
        });
        hasError = true;
    }

    // لا ترسل إذا في خطأ
    if (hasError) return;

    // تعيين الرابط الصحيح ثم إرسال النموذج يدويًا
    const programId = "{{ $program->id }}";
    form.action = `/assistant/${selectedId}/add/${programId}`;
    form.submit(); // ✅ هنا النقطة المهمة
});

});
</script>
