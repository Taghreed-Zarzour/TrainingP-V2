document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("personalInfoForm");

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Get fields by name
const firstNameAr = form.elements["name_ar"];
const lastNameAr = form.elements["last_name_ar"];
const firstNameEn = form.elements["name_en"];
const lastNameEn = form.elements["last_name_en"];
const headlineAr = form.elements["headline"];
const nationality = form.elements["nationality[]"]; // لأنها متعددة
const linkedin = form.elements["linkedin_url"];
const bio = form.elements["bio"];
const hourlyRate = form.elements["hourly_wage"];
const currency = form.elements["currency"];
const profileImage = form.elements["photo"];


        // Remove previous error styles/messages
        [
            firstNameAr,
            lastNameAr,
            firstNameEn,
            lastNameEn,
            headlineAr,
            nationality,
            linkedin,
            bio,
            hourlyRate,
            currency,
            profileImage,
        ].forEach((input) => {
            if (!input) return;
            input.classList.remove("error");
            if (input.parentNode.querySelector(".error-msg")) {
                input.parentNode.querySelector(".error-msg").remove();
            }
        });

        // Helper function to check if string contains Arabic
        function containsArabic(text) {
            const arabicRegex = /[\u0600-\u06FF]/;
            return arabicRegex.test(text);
        }

        // Helper function to check if string contains English
        function containsEnglish(text) {
            const englishRegex = /[A-Za-z]/;
            return englishRegex.test(text);
        }

        // Required fields
        if (validator.isEmpty(firstNameAr.value.trim())) {
            valid = false;
            showError(firstNameAr, "يرجى إدخال الاسم بالعربية");
        } else if (containsEnglish(firstNameAr.value.trim())) {
            valid = false;
            showError(firstNameAr, "الاسم العربي يجب أن يحتوي على أحرف عربية فقط");
        }

        if (validator.isEmpty(lastNameAr.value.trim())) {
            valid = false;
            showError(lastNameAr, "يرجى إدخال الكنية بالعربية");
        } else if (containsEnglish(lastNameAr.value.trim())) {
            valid = false;
            showError(lastNameAr, "الكنية العربية يجب أن تحتوي على أحرف عربية فقط");
        }

 if (containsArabic(firstNameEn.value.trim())) {
            valid = false;
            showError(firstNameEn, "الاسم الإنجليزي يجب أن يحتوي على أحرف إنجليزية فقط");
        }

 if (containsArabic(lastNameEn.value.trim())) {
            valid = false;
            showError(lastNameEn, "الكنية الإنجليزية يجب أن تحتوي على أحرف إنجليزية فقط");
        }

        if (validator.isEmpty(headlineAr.value.trim())) {
            valid = false;
            showError(headlineAr, "يرجى إدخال العنوان بالعربية");
        } else if (containsEnglish(headlineAr.value.trim())) {
            valid = false;
            showError(headlineAr, "العنوان العربي يجب أن يحتوي على أحرف عربية فقط");
        }

        // Nationality (at least one selected)
        if (
            !nationality.selectedOptions ||
            nationality.selectedOptions.length === 0
        ) {
            valid = false;
            showError(nationality, "يرجى اختيار الجنسية");
        }
        // Bio required
        if (validator.isEmpty(bio.value.trim())) {
            valid = false;
            showError(bio, "يرجى إدخال نبذة عنك");
        }
        // LinkedIn (optional, but if filled, must be a valid URL)
        if (
            linkedin.value.trim() &&
            !validator.isURL(linkedin.value.trim(), { require_protocol: false })
        ) {
            valid = false;
            showError(linkedin, "يرجى إدخال رابط لينكدان صحيح");
        }
        // Hourly rate (optional, but if filled, must be a number)
        if (
            hourlyRate.value.trim() &&
            !validator.isNumeric(hourlyRate.value.trim())
        ) {
            valid = false;
            showError(hourlyRate, "يرجى إدخال رقم صحيح للأجر في الساعة");
        }
        // Currency (optional, but if hourly rate is filled, currency must be selected)
        if (hourlyRate.value.trim() && !currency.value) {
            valid = false;
            showError(currency, "يرجى اختيار العملة");
        }
        // Profile image (optional, but if filled, must be jpg/png and <= 5MB)
        if (
            profileImage &&
            profileImage.files &&
            profileImage.files.length > 0
        ) {
            const file = profileImage.files[0];
            const allowedTypes = ["image/jpeg", "image/png"];
            if (!allowedTypes.includes(file.type)) {
                valid = false;
                showError(profileImage, "يرجى رفع صورة بصيغة JPG أو PNG فقط");
            }
            if (file.size > 5 * 1024 * 1024) {
                valid = false;
                showError(profileImage, "حجم الصورة يجب ألا يتجاوز 5MB");
            }
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
        // For selects and file inputs, append to parent
        if (input.type === "file" || input.tagName === "SELECT") {
            input.parentNode.appendChild(errorMsg);
        } else {
            input.parentNode.appendChild(errorMsg);
        }
    }
});