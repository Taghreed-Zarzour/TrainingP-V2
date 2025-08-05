<div class="container">
    @forelse($stoppedPrograms as $program)
        <div class="card">
            <img src="{{ $program->AdditionalSetting->profile_image ?? 'https://via.placeholder.com/280x150' }}" alt="صورة التدريب">
            <div class="card-body">
                <h3>{{ $program->title }}</h3>
                <p><strong>الوصف:</strong> {{ Str::limit($program->description, 100) }}</p>
                <p><strong>عدد الجلسات:</strong> {{ $program->sessions->count() }}</p>
                <p><strong>عدد المساعدين:</strong> {{ $program->assistants->count() }}</p>
                <p><strong>الحالة:</strong> {{ $program->status }}</p>

                <!-- ✅ زر استرجاع داخل كل كرت -->
                <form method="POST" action="{{ route('trainings.rePublish', $program->id) }}" style="margin-top: 10px;">
                    @csrf
                    <button style="background-color: #28a745; color: white; border: none; padding: 8px 12px; border-radius: 4px;" onclick="return confirm('هل تريد استرجاع الإعلان؟')">
                        استرجاع
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p style="text-align:center;">لا توجد برامج موقفة حالياً.</p>
    @endforelse
</div>
