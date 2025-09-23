<div class="container py-5">
    <!-- منطقة تحميل الملفات -->
    <div class="upload-container" id="dropArea">
        <img src="{{ asset('images/icons/upload.svg') }}" alt="رفع ملف" class="upload-icon">
        <h3 class="upload-title">أسحب ملفاتك لبدء الرفع</h3>
        <div class="or-divider">أو</div>
        <form action="{{ route('orgTraining.file.upload', $OrgProgramDetail->trainingProgram->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <button type="button" class="browse-btn" id="browseBtn">تصفح الملفات</button>
            <input type="file" id="fileInput" name="training_files[]" multiple class="visually-hidden">
        </form>
    </div>

    <!-- الملفات المرفوعة -->
    @if(!empty($attachments) && count($attachments) > 0)
        <div class="mt-4">
            <h5>الملفات المرفوعة:</h5>
            <ul class="list-group mt-3">
                @foreach($attachments as $file)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-file-alt me-2"></i>
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-decoration-none">
                                {{ $file->file_name }}
                            </a>
                        </div>
                        <form method="POST" action="{{ route('orgTraining.file.delete', $file->id) }}">
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="border-0 bg-transparent p-0" onclick="return confirm('هل أنت متأكد من حذف هذا الملف؟')">
                                <img src="{{ asset('images/cources/delete_x.svg') }}" alt="حذف" title="حذف" style="width: 32px;">
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="alert alert-info mt-4">
            <i class="fas fa-info-circle me-2"></i>
            لا توجد ملفات مرفوعة حالياً
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('fileInput');
    const browseBtn = document.getElementById('browseBtn');
    const uploadForm = document.getElementById('uploadForm');

    // عند النقر على زر التصفح
    browseBtn.addEventListener('click', () => fileInput.click());
    
    // عند اختيار الملفات
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            uploadForm.submit();
        }
    });

    // منع السلوك الافتراضي لأحداث السحب
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // إضافة تأثير عند السحب
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropArea.style.borderColor = '#003090';
        dropArea.style.backgroundColor = '#F8FAFC';
    }

    function unhighlight() {
        dropArea.style.borderColor = '#D1D5DB';
        dropArea.style.backgroundColor = '';
    }

    // معالجة إفلات الملفات
    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        if (files.length > 0) {
            uploadForm.submit();
        }
    }
});
</script>