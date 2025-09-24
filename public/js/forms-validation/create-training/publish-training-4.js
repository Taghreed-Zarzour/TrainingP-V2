document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("publish-training-4-form");
    const submitBtn = document.getElementById("publish-training-4-submit-btn");

    if (!form || !submitBtn) return;

    submitBtn.addEventListener("click", function (e) {
        e.preventDefault();
        clearAllErrors();

        let isValid = true;

        // 👇 تأكد أننا نحدد فقط العناصر التي تحتوي على الجلسات (تاريخ ومدة)
        const sessionGroups = form.querySelectorAll(".session-fields-container > .input-group-2col");

        sessionGroups.forEach((group, index) => {
            const sessionNumber = index + 1;

            const dateInput = group.querySelector('input[type="date"]');
            const durationInput = group.querySelector('input[type="number"]');

            // التحقق من التاريخ
            if (!dateInput || dateInput.value.trim() === "") {
                isValid = false;
                showFieldError(dateInput, `يرجى إدخال تاريخ الجلسة رقم ${sessionNumber}`);
            }

            // التحقق من مدة الجلسة
            const durationValue = parseFloat(durationInput.value);
            if (!durationInput || durationInput.value.trim() === "") {
                isValid = false;
                showFieldError(durationInput, `يرجى إدخال مدة الجلسة رقم ${sessionNumber}`);
            } else if (isNaN(durationValue) || durationValue < 1) {
                isValid = false;
                showFieldError(durationInput, `مدة الجلسة رقم ${sessionNumber} يجب أن تكون 1 دقيقة على الأقل`);
            }
        });

        if (isValid) {
            form.submit();
        } else {
            const firstError = form.querySelector('.field-error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        }
    });

    function clearAllErrors() {
        form.querySelectorAll('.field-error').forEach(el => el.remove());
        form.querySelectorAll('input').forEach(input => input.classList.remove('error-border'));
    }

    function showFieldError(input, message) {
        if (!input) return;

        input.classList.add('error-border');

        const existingError = input.parentNode.querySelector('.field-error');
        if (existingError) return;

        const errorDiv = document.createElement("div");
        errorDiv.className = "field-error";
        errorDiv.style.color = "red";
        errorDiv.style.fontSize = "0.85em";
        errorDiv.style.marginTop = "4px";
        errorDiv.innerText = message;

        input.insertAdjacentElement("afterend", errorDiv);
    }
});
