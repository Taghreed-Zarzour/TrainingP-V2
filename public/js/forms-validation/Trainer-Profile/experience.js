document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("experienceForm");

    form.addEventListener("submit", function (e) {
        let valid = true;

        const sector = form.elements["work_sectors[]"];
        const services = form.elements["provided_services[]"];
        const fields = form.elements["work_fields[]"];
        const topics = form.elements["important_topics[]"];
        const international = form.elements["international_exp[]"];

        // Remove previous error styles/messages
        [sector, services, fields, topics, international].forEach((input) => {
            if (!input) return;
            input.classList.remove("error");
            if (input.parentNode.querySelector(".error-msg")) {
                input.parentNode.querySelector(".error-msg").remove();
            }
        });

        // Require at least one selection for each field except international
        if (!sector || sector.selectedOptions.length === 0) {
            valid = false;
            showError(sector, "يرجى اختيار قطاع العمل");
        }

        if (!services || services.selectedOptions.length === 0) {
            valid = false;
            showError(services, "يرجى اختيار الخدمات المقدمة");
        }

        if (!fields || fields.selectedOptions.length === 0) {
            valid = false;
            showError(fields, "يرجى اختيار مجالات العمل");
        }

        if (!topics || topics.selectedOptions.length === 0) {
            valid = false;
            showError(topics, "يرجى اختيار أهم المواضيع");
        }

          if (!international || international.selectedOptions.length === 0) {
            valid = false;
            showError(international, "يرجى اختيار الخبرات الدولية");
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
