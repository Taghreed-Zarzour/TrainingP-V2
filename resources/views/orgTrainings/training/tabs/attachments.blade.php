<!-- resources/views/orgTrainings/tabs/attachments.blade.php -->
<style>
    .upload-container {
        border: 2px dashed #D1D5DB;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }
    
    .upload-container:hover {
        border-color: #003090;
        background-color: #F8FAFC;
    }
    
    .upload-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
    }
    
    .upload-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #003090;
        margin-bottom: 10px;
    }
    
    .or-divider {
        display: flex;
        align-items: center;
        margin: 20px 0;
        color: #6B7280;
    }
    
    .or-divider::before,
    .or-divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .or-divider::before {
        margin-left: 10px;
    }
    
    .or-divider::after {
        margin-right: 10px;
    }
    
    .browse-btn {
        background-color: #003090;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .browse-btn:hover {
        background-color: #001f5a;
    }
    
    .progress-container {
        margin: 30px 0;
    }
    
    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .progress-title {
        color: #003090;
        font-weight: 500;
    }
    
    .progress-percentage {
        color: #003090;
        font-weight: 600;
    }
    
    .progress-actions {
        display: flex;
        gap: 10px;
    }
    
    .progress-action {
        background: none;
        border: none;
        color: #6B7280;
        cursor: pointer;
        font-size: 1rem;
        transition: color 0.3s ease;
    }
    
    .progress-action:hover {
        color: #003090;
    }
    
    .progress-bar {
        height: 8px;
        background-color: #E5E7EB;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        width: 65%;
        background-color: #003090;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    
    .uploaded-file {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        margin-top: 20px;
    }
    
    .file-icon {
        width: 40px;
        height: 40px;
        margin-left: 15px;
    }
    
    .file-name {
        flex: 1;
        color: #1F2937;
        font-weight: 500;
    }
    
    @media (max-width: 576px) {
        .upload-container {
            padding: 30px 20px;
        }
        
        .upload-icon {
            width: 50px;
            height: 50px;
        }
        
        .progress-actions {
            gap: 8px;
        }
    }
</style>

<div class="container py-5">
    <!-- منطقة تحميل الملفات -->
    <div class="upload-container" id="dropArea">
        <img src="{{ asset('images/icons/upload.svg') }}" alt="رفع ملف" class="upload-icon">
        <h3 class="upload-title">أسحب ملفاتك لبدء الرفع</h3>
        <div class="or-divider">أو</div>
        <form action="{{ route('training.file.upload', $OrgProgramDetail->trainingProgram->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
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
                        <form method="POST" action="{{ route('training.file.delete', ['file_id' => $file->id, 'program_id' => $OrgProgramDetail->trainingProgram->id]) }}">
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
        
        browseBtn.addEventListener('click', () => fileInput.click());
        
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                uploadForm.submit();
            }
        });
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
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