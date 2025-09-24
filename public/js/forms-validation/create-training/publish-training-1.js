document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("publish-training-1-form");

    form.addEventListener("submit", function (e) {
        let valid = true;

        const title = form.elements["title"];
        const language = form.elements["language_type_id"];
        const programType = form.elements["program_type_id"];
        const category = form.elements["training_classification_id"];
        const level = form.elements["training_level_id"];
        const delivery = form.elements["program_presentation_method_id"];
        const description = form.elements["description"];

        [title, language, programType, category, level, delivery, description].forEach((input) => {
            if (!input) return;
            input.classList.remove("error");
            if (input.parentNode.querySelector(".error")) {
                input.parentNode.querySelector(".error").remove();
            }

        });

        if (!title.value) {
            valid = false;
            showError(title, "يرجى إدخال عنوان التدريب");
        }
        // console.log(language.value);
        
        if (!language.value) {
            valid = false;
            showError(language, "يرجى إدخال لغة التدريب");
        }

        if (!programType.value) {
            valid = false;
            showError(programType, "يرجى إدخال نوع البرنامج");
        }

        if (!category.value) {
            valid = false;
            showError(category, "يرجى إدخال تصنيف التدريب");
        }

        if (!level.value) {
            valid = false;
            showError(level, "يرجى إدخال مستوى التدريب");
        }

        if (!delivery.value) {
            valid = false;
            showError(delivery, "يرجى إدخال طريقة تقديم التدريب");
        }

        if (!description.value) {
            valid = false;
            showError(description, "يرجى إدخال وصف التدريب");
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    function showError(input, message) {
        input.classList.add("error");
        const errorMsg = document.createElement("p");
        errorMsg.className = "error";
        errorMsg.textContent = message;
        input.parentNode.appendChild(errorMsg);
    }
    
});