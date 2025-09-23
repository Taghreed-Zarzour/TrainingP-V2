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
                                        <img src="{{ $trainee->user->photo ? asset('storage/' . $trainee->user->photo) : asset('images/icons/user.svg') }}" class="tr-trainee-avatar" alt="صورة المتدرب">
                                        <span>{{ $trainee->user->getTranslation('name', 'ar') }} {{ $trainee->getTranslation('last_name', 'ar') }}</span>
                                    </div>
                                </td>
                                <td>{{ $trainee->user->email }}</td>
                                <td>{{ $trainee->user->phone_number }}</td>
                                <td>{{ $attendanceStats[$trainee->id] ?? '0' }}%</td>
                                <td>
                                    <button type="button" onclick="window.location='{{ route('show_trainee_profile', $trainee->id) }}'" class="tr-details-btn">
                                        عرض التفاصيل
                                    </button>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('orgEnrollment.deleteTrainee', ['trainee_id' => $trainee->id, 'program_id' => $OrgProgramDetail->trainingProgram->id]) }}" method="POST" style="display:inline;">
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
        </div>
    </div>
@else
    <!-- رسالة عدم وجود متدربين -->
    <div class="alert alert-info text-center py-4" style="border-radius: 22px; background-color: #f8f9fa; border: 1px dashed #ddd;">
        <h5 class="text-muted">لا يوجد متدربين مقبولين حتى الآن</h5>
        <p class="text-muted small mt-2">سيظهر المتدربون هنا بمجرد قبولهم في المتدربين</p>
    </div>
@endif