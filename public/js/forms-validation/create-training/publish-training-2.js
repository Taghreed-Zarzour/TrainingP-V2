document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("publish-training-2-form");

    // Add submit event listener to form
    form.addEventListener("submit", function (e) {
        let valid = true;

        // Clear previous errors
        clearAllErrors();

        // Validate learning outcomes (requires at least 1)
        const learningOutcomes = form.querySelectorAll('input[name="learning_outcomes[]"]');
        
        // Validate each learning outcome
        learningOutcomes.forEach((input, index) => {            
            if (input.value.trim() === '') {
                valid = false;
                showFieldError(input, "يرجى إدخال ما سيتعلمه المشاركون في هذا التدريب");
            } else if (input.value.trim() !== '' && input.value.trim().length < 10) {
                valid = false;
                showFieldError(input, "يجب أن يكون هدف التعلم 10 أحرف على الأقل");
            }
        });

        // Validate requirements (requires at least 1)
        const requirements = form.querySelectorAll('input[name="requirements[]"]');
        
        // Validate each requirement
        requirements.forEach((input, index) => {
            if (input.value.trim() === '') {
                valid = false;
                showFieldError(input, "يرجى إدخال المتطلبات أو الشروط اللازمة للالتحاق");
            } else if (input.value.trim() !== '' && input.value.trim().length < 10) {
                valid = false;
                showFieldError(input, "يجب أن يكون المتطلب 10 أحرف على الأقل");
            }
        });

        // Validate target audience (requires at least 1)
        const targetAudience = form.querySelectorAll('input[name="target_audience[]"]');
        
        // Validate each target audience
        targetAudience.forEach((input, index) => {
            if (input.value.trim() === '') {
                valid = false;
                showFieldError(input, "يرجى إدخال الفئة المستهدفة");
            } else if (input.value.trim() !== '' && input.value.trim().length < 5) {
                valid = false;
                showFieldError(input, "يجب أن تكون الفئة المستهدفة 5 أحرف على الأقل");
            }
        });

        // Validate features (requires at least 1)
        const features = form.querySelectorAll('input[name="benefits[]"]');
        
        // Validate each feature
        features.forEach((input, index) => {
            if (input.value.trim() === '') {
                valid = false;
                showFieldError(input, "يرجى إدخال ميزات التدريب");
            } else if (input.value.trim() !== '' && input.value.trim().length < 5) {
                valid = false;
                showFieldError(input, "يجب أن تكون الميزة 5 أحرف على الأقل");
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });

    // Function to clear all error messages
    function clearAllErrors() {
        const errorMessages = form.querySelectorAll('p.error');
        const errorInputs = form.querySelectorAll('input.error');
        
        errorMessages.forEach(msg => msg.remove());
        errorInputs.forEach(input => input.classList.remove('error'));
    }

    // Function to show error for a specific field
    function showFieldError(input, message) {
        if (!input) return;
        
        input.classList.add('error');
        
        // Remove existing error message if any
        const existingError = input.parentNode.querySelector('.error');
        if (existingError && existingError.tagName === 'P') {
            existingError.remove();
        }
        
        // Create and add new error message
        const errorMsg = document.createElement('p');
        errorMsg.className = 'error';
        errorMsg.textContent = message;
        
        // Insert error message after the input
        const inputContainer = input.closest('.input-with-remove');
        if (inputContainer) {
            inputContainer.appendChild(errorMsg);
        } else {
            input.parentNode.appendChild(errorMsg);
        }
    }
});