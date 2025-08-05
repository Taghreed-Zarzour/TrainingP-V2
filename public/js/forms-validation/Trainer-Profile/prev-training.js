document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("prevTrainingForm");

    form.addEventListener("submit", function (e) {
        let valid = true;

        // ✅ الحقول بالأسماء الصحيحة من HTML
        const videoInput = form.elements["video_link"];
        const titleInput = form.elements["training_title"];
        const descInput = form.elements["description"];

        // إزالة الأخطاء السابقة
        [videoInput, titleInput, descInput].forEach((input) => {
            input.classList.remove("error");
            const msg = input.parentNode.querySelector(".error-msg");
            if (msg) msg.remove();
        });

        // التحقق من رابط الفيديو
        if (
            !validator.isURL(videoInput.value.trim(), {
                require_protocol: false,
            })
        ) {
            valid = false;
            showError(videoInput, "يرجى إدخال رابط فيديو صحيح");
        }

        // التحقق من عنوان التدريب
        if (validator.isEmpty(titleInput.value.trim())) {
            valid = false;
            showError(titleInput, "يرجى إدخال عنوان التدريب");
        }

        // التحقق من وصف التدريب
        if (validator.isEmpty(descInput.value.trim())) {
            valid = false;
            showError(descInput, "يرجى إدخال وصف التدريب");
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    function showError(input, message) {
        input.classList.add("error");
        const errorMsg = document.createElement("div");
        errorMsg.className = "error-msg";
        errorMsg.style.color = "#e00";
        errorMsg.style.fontSize = "0.95em";
        errorMsg.style.marginTop = "4px";
        errorMsg.textContent = message;
        input.parentNode.appendChild(errorMsg);
    }
});
