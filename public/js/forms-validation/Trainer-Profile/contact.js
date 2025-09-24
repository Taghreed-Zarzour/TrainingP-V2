document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");

    form.addEventListener("submit", function (e) {
        let valid = true;

        // ✅ أسماء الحقول الصحيحة حسب الـ HTML
        const phone = form.elements["phone_number"];
        const country = form.elements["country_id"];
        const city = form.elements["city"];
        const website = form.elements["website"];
        const phoneField = form.querySelector(".phone-container"); // ← هذه هي اللفافة الصحيحة لرقم الهاتف

        // Remove previous error styles/messages
        [country, city, website].forEach((input) => {
            if (!input) return;
            input.classList.remove("error");
            const oldMsg = input.parentNode.querySelector(".error-msg");
            if (oldMsg) oldMsg.remove();
        });

        // Remove previous phone error
        if (phoneField) {
            phoneField.classList.remove("error");
            const next = phoneField.nextElementSibling;
            if (next && next.classList.contains("error-msg")) {
                next.remove();
            }
        }

        // ✅ التحقق من رقم الهاتف
        if (validator.isEmpty(phone.value.trim())) {
            valid = false;
            showPhoneError(phoneField, "يرجى إدخال رقم الهاتف");
        } else if (
            !validator.isMobilePhone(phone.value.trim(), "any", {
                strictMode: false,
            })
        ) {
            valid = false;
            showPhoneError(phoneField, "يرجى إدخال رقم هاتف صحيح");
        }

        // ✅ التحقق من الدولة
        if (!country.value) {
            valid = false;
            showError(country, "يرجى اختيار الدولة");
        }

        // ✅ التحقق من المدينة
        if (!city.value) {
            valid = false;
            showError(city, "يرجى اختيار المدينة");
        }

        // ✅ التحقق من الموقع الإلكتروني (اختياري)
        if (
            website.value.trim() &&
            !validator.isURL(website.value.trim(), { require_protocol: false })
        ) {
            valid = false;
            showError(website, "يرجى إدخال رابط موقع إلكتروني صحيح");
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    function showPhoneError(wrapper, message) {
        wrapper.classList.add("error");
        const next = wrapper.nextElementSibling;
        if (next && next.classList.contains("error-msg")) {
            next.remove();
        }
        const errorMsg = document.createElement("div");
        errorMsg.className = "error-msg";
        errorMsg.style.color = "#e00";
        errorMsg.style.fontSize = "0.95em";
        errorMsg.style.marginTop = "4px";
        errorMsg.textContent = message;
        wrapper.insertAdjacentElement("afterend", errorMsg);
    }

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
