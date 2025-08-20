document.addEventListener('DOMContentLoaded', function() {
        const descriptionTextarea = document.getElementById('description');
        const charCounter = document.getElementById('description-counter');
        const maxLength = 500;

        // تحديث العداد عند الكتابة
        descriptionTextarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            
            // تحديث العداد بالشكل المطلوب (عدد الأحرف المكتوبة/الحد الأقصى)
            charCounter.textContent = `${currentLength}/${maxLength}`;
            
            // تغيير مظهر العداد حسب الحالة
            if (currentLength > maxLength) {
                charCounter.classList.add('char-counter-danger');
                charCounter.classList.remove('char-counter-warning');
            } 
            else if (currentLength > (maxLength - 50)) {
                charCounter.classList.add('char-counter-warning');
                charCounter.classList.remove('char-counter-danger');
            }
            else {
                charCounter.classList.remove('char-counter-danger', 'char-counter-warning');
            }
        });

        // التحقق الأولي عند تحميل الصفحة
        if (descriptionTextarea.value) {
            descriptionTextarea.dispatchEvent(new Event('input'));
        }
    });