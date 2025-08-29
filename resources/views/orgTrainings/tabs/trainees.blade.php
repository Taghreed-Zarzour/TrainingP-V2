<style>
    .tr-trainees-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 10px;
        margin-bottom: 20px;
    }
    .tr-trainees-header {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }
    @media (min-width: 768px) {
        .tr-trainees-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
    .tr-trainees-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
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

@if (count($trainees) > 0)
    <div class="tr-trainees-container">
        <div class="tr-trainees-card">
            <div class="tr-trainees-table-container">
                <table class="tr-trainees-table">
                    <thead>
                        <tr>
                            <th>الرقم التسلسلي</th>
                            <th>اسم المتدرب</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>نسبة الحضور</th>
                            <th>التفاصيل</th>
                            <th>تفاعل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trainees as $index => $trainee)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="tr-trainee-name">
                                        <img src="{{ $trainee->user->photo ? asset('storage/' . $trainee->user->photo) : asset('images/icons/user.svg') }}"
                                            class="tr-trainee-avatar" alt="صورة المتدرب">
                                        <span>{{ $trainee->user->getTranslation('name', 'ar') }}
                                            {{ $trainee->getTranslation('last_name', 'ar') }}</span>
                                    </div>
                                </td>
                                <td>{{ $trainee->user->email }}</td>
                                <td>{{ $trainee->user->phone_number }}</td>
                                <td>{{ $attendanceStats[$trainee->id] ?? '0' }}%</td>
                                <td>
                                    <button type="button"
                                        onclick="window.location='{{ route('show_trainee_profile', $trainee->id) }}'"
                                        class="tr-details-btn">
                                        عرض التفاصيل
                                    </button>
                                </td>
                                <td class="text-center">
                                    <form
                                        action="{{ route('acceptedTrainee.delete', ['trainee_id' => $trainee->id , 'program_id'=> $OrgProgram->id]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                            <input type="hidden" name="is_org" value="{{ $OrgProgram->id ? 1 : 0 }}">

                                        <button type="submit" class="btn btn-link p-0"
                                            onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                            <img src="{{ asset('images/cources/trash.svg') }}">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <!-- رسالة عدم وجود متدربين -->
    <div class="alert alert-info text-center py-4"
        style="border-radius: 22px; background-color: #f8f9fa; border: 1px dashed #ddd;">
        <h5 class="text-muted">لا يوجد متدربين مقبولين حتى الآن</h5>
        <p class="text-muted small mt-2">سيظهر المتدربون هنا بمجرد قبولهم في المسار التدريبي</p>
    </div>
@endif