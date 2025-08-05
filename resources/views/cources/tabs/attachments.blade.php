
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
            <img src="../images/icons/upload.svg" alt="رفع ملف" class="upload-icon">
            <h3 class="upload-title">أسحب ملفات (ملفاتك) لبدء التحصيل</h3>
          
            
            <div class="or-divider">أو</div>
            
            <button type="button" class="browse-btn" id="browseBtn">تصفح الملفات</button>
            <input type="file" id="fileInput" class="visually-hidden">
        </div>
        
        <!-- شريط التقدم -->
        <div class="progress-container">
            <div class="progress-header">
                <span class="progress-title">جار التحصيل...</span>
                <div class="d-flex align-items-center">
                    <span class="progress-percentage me-3">65%</span>
                    <div class="progress-actions">
                        <button class="progress-action" title="إيقاف مؤقت">
                            <i class="fas fa-stop"></i>
                        </button>
                        <button class="progress-action" title="إلغاء">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
        
        <!-- الملفات المرفوعة -->
        <div class="uploaded-file">
            <img src="../images/icons/pdf-icon.svg" alt="ملف PDF" class="file-icon">
            <span class="file-name">أساسيات تجربة المستخدم.pdf</span>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('dropArea');
            const fileInput = document.getElementById('fileInput');
            const browseBtn = document.getElementById('browseBtn');
            const stopBtn = document.querySelector('.fa-stop').closest('button');
            const cancelBtn = document.querySelector('.fa-times').closest('button');
            const progressFill = document.querySelector('.progress-fill');
            const progressPercentage = document.querySelector('.progress-percentage');
            
            // التعامل مع زر تصفح الملفات
            browseBtn.addEventListener('click', () => {
                fileInput.click();
            });
            
            // التعامل مع سحب وإفلات الملفات
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
            
            // التعامل مع الملفات المختارة
            dropArea.addEventListener('drop', handleDrop, false);
            fileInput.addEventListener('change', handleFiles, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles({ target: { files } });
            }
            
            function handleFiles(e) {
                const files = e.target.files;
                // console.log('تم اختيار الملفات:', files);
                // بدء محاكاة التقدم
                simulateProgress();
            }
            
            // محاكاة شريط التقدم
            function simulateProgress() {
                let progress = 0;
                const interval = setInterval(() => {
                    progress += Math.random() * 10;
                    if (progress > 65) progress = 65;
                    progressFill.style.width = `${progress}%`;
                    progressPercentage.textContent = `${Math.round(progress)}%`;
                    
                    if (progress >= 65) {
                        clearInterval(interval);
                    }
                }, 500);
            }
            
            // زر الإيقاف
            stopBtn.addEventListener('click', () => {
                alert('تم إيقاف التحميل مؤقتًا');
            });
            
            // زر الإلغاء
            cancelBtn.addEventListener('click', () => {
                if (confirm('هل أنت متأكد من إلغاء التحميل؟')) {
                    progressFill.style.width = '0%';
                    progressPercentage.textContent = '0%';
                    alert('تم إلغاء التحميل');
                }
            });
        });
    </script>
