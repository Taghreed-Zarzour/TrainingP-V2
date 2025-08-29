<style>
    .tr-trainees-container {
        margin-top: 20px;
    }
    .tr-sessions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .tr-sessions-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
    }
    .tr-trainees-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 10px;
        margin-bottom: 20px;
    }
    .tr-trainees-table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .tr-trainees-table {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }
    .tr-trainees-table thead th {
        background-color: #DAE3FF;
        color: #003090;
        font-weight: 400;
        padding: 12px 15px;
        text-align: right;
    }
    .tr-trainees-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f1f1;
    }
    .tr-trainees-table tbody tr:last-child td {
        border-bottom: none;
    }
    .tr-trainee-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tr-trainee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    .tr-details-btn {
        background-color: #003090;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .tr-details-btn:hover {
        background-color: #002b80;
    }
    .custom-btn {
        background-color: #003090;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .custom-btn:hover {
        background-color: #002b80;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
    .empty-state img {
        width: 100px;
        opacity: 0.5;
        margin-bottom: 15px;
    }
    @media (max-width: 767px) {
        .tr-trainees-table {
            min-width: 100%;
            border: none;
        }
        .tr-trainees-table thead {
            display: none;
        }
        .tr-trainees-table tbody,
        .tr-trainees-table tr,
        .tr-trainees-table td {
            display: block;
            width: 100%;
            text-align: right;
        }
        .tr-trainees-table tr {
            position: relative;
            background: #fff;
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 12px 12px 40px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
        .tr-trainees-table td {
            padding: 5px 0px !important;
            position: relative;
            font-size: 0.95rem;
            border: none;
            border-bottom: 1px solid #f5f5f5;
        }
        .tr-trainees-table td:last-child {
            border-bottom: none;
        }
        .tr-trainees-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 4px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="tr-trainees-container">
    <div class="tr-sessions-header">
        <h1 class="tr-sessions-title">ميسرو المسار التدريبي</h1>
        <button type="button" class="custom-btn" data-bs-toggle="modal" data-bs-target="#chooseAssistantModal">
            <img src="/images/cources/plus.svg">
            إضافة ميسر
        </button>
    </div>
    
    <div class="tr-trainees-card">
        @if($OrgProgram->assistantUsers->isEmpty())
            <div class="empty-state">
                <h5>لا يوجد ميسرين مضافين لهذا المسار التدريبي</h5>
                <p>يمكنك إضافة ميسرين من خلال زر إضافة ميسر</p>
            </div>
        @else
            <div class="tr-trainees-table-container">
                <table class="tr-trainees-table">
                    <thead>
                        <tr>
                            <th>رقم تسلسلي</th>
                            <th>اسم الميسر</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>التفاصيل</th>
                            <th>تفاعل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($OrgProgram->assistantUsers as $assistant)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <div class="tr-trainee-name">
                                    @if ($assistant->photo)
                                        <img src="{{ asset('storage/' . $assistant->photo) }}" alt="صورة الميسر" class="tr-trainee-avatar">
                                    @else
                                        <img src="{{ asset('images/icons/user.svg') }}" alt="ميسر" class="tr-trainee-avatar">
                                    @endif
                                    <span>{{ $assistant->name }} {{ $assistant->assistant->last_name }}</span>
                                </div>
                            </td>
                            <td>{{ $assistant->email }}</td>
                            <td>{{ $assistant->phone_number }}</td>
                            <td><button class="tr-details-btn">عرض التفاصيل</button></td>
                            <td class="text-center">
                                <form action="{{ route('orgAssistant.destroy', ['assistant_id'=> $assistant->id, 'orgTraining_id'=>$OrgProgram->id]) }}" method="POST" style="display:inline;">
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

<!-- مودال اختيار الميسر -->
<div class="modal fade" id="chooseAssistantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-3 py-3">
            <div class="modal-header border-0 pb-0 justify-content-end align-self-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="addAssistantForm" method="POST" class="p-0">
                    @csrf
                    
                    <h5 class="modal-title mb-4">اختر ميسرًا لإضافته</h5>
                    
                    @if($assistants->isEmpty())
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle mb-2"></i>
                            لا يوجد ميسرين متاحين حاليًا للإضافة.
                        </div>
                    @else
                        <div class="input-group mb-4">
                            <div class="d-flex flex-column-reverse">
                                <label class="w-100">الميسر <span class="required">*</span></label>
                            </div>
                            <select name="assistant_id" class="form-select w-100" required>
                                <option value="">-- اختر الميسر --</option>
                                @foreach ($assistants as $assistant)
                                    <option value="{{ $assistant->id }}">
                                        {{ $assistant->getTranslation('name', 'ar') ?? '—'}} {{ $assistant->assistant->getTranslation('last_name', 'ar')?? '' }}

                                    </option>
                                @endforeach
                            </select>
                            <div id="assistantError" class="invalid-feedback d-none">يرجى اختيار ميسر</div>
                        </div>
                    @endif
                    <input type="hidden" name="orgTraining_id" value="{{ $OrgProgram->id }}">

                    <div class="modal-footer border-0 px-0">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">إلغاء</button>
                        @if(!$assistants->isEmpty())
                            <button type="submit" class="custom-btn">
                                إضافة الميسر
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
        const alreadyAddedIds = @json($OrgProgram->assistantUsers->pluck('id'));
        let hasError = false;
        
        // تحقق من الاختيار
        if (!selectedId) {
            select.classList.add('is-invalid');
            assistantError.textContent = 'يرجى اختيار ميسر لإضافته.';
            assistantError.classList.remove('d-none');
            hasError = true;
        }
        
        // تحقق من التكرار
        if (alreadyAddedIds.includes(parseInt(selectedId))) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'هذا الميسر مضاف مسبقًا لهذا المسار التدريبي.',
                confirmButtonText: 'موافق'
            });
            hasError = true;
        }
        
        // لا ترسل إذا في خطأ
        if (hasError) return;
        
        // تعيين الرابط الصحيح ثم إرسال النموذج يدويًا
form.action = "{{ route('orgAssistant.store', ['id' => $OrgProgram->id]) }}";
form.submit();

    });
});
</script>