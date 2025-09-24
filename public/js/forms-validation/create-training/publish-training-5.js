document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("publish-training-5-form");

    // Add submit event listener to form
    form.addEventListener("submit", function (e) {
        let valid = true;

        // Clear previous errors
        clearAllErrors();

        // Validate training cost
        const trainingCost = form.querySelector('input[name="training_cost"]');
        if (!trainingCost || !trainingCost.value.trim()) {
            valid = false;
            showFieldError(trainingCost, "يرجى إدخال تكلفة التدريب");
        } else if (isNaN(trainingCost.value.trim()) || parseFloat(trainingCost.value.trim()) < 0) {
            valid = false;
            showFieldError(trainingCost, "يرجى إدخال تكلفة صحيحة");
        }

        // Validate currency
        const currency = form.querySelector('select[name="currency"]');
        if (!currency || !currency.value) {
            valid = false;
            showFieldError(currency, "يرجى اختيار العملة");
        }

        // Validate payment mechanism
        const paymentMechanism = form.querySelector('textarea[name="payment_mechanism"]');
        if (!paymentMechanism || !paymentMechanism.value.trim()) {
            valid = false;
            showFieldError(paymentMechanism, "يرجى إدخال آلية الدفع");
        } else if (paymentMechanism.value.trim().length < 20) {
            valid = false;
            showFieldError(paymentMechanism, "يجب أن تكون آلية الدفع 20 حرف على الأقل");
        }

        // Validate location (country, city, address)
        const countrySelect = form.querySelector('select[name="country"]');
        const citySelect = form.querySelector('select[name="city"]');
        const addressInput = form.querySelector('input[name="address"]');

        if (!countrySelect || !countrySelect.value) {
            valid = false;
            showFieldError(countrySelect, "يرجى اختيار الدولة");
        }

        if (!citySelect || !citySelect.value) {
            valid = false;
            showFieldError(citySelect, "يرجى اختيار المدينة");
        }

        if (!addressInput || !addressInput.value.trim()) {
            valid = false;
            showFieldError(addressInput, "يرجى إدخال العنوان بالتفصيل");
        } else if (addressInput.value.trim().length < 10) {
            valid = false;
            showFieldError(addressInput, "يجب أن يكون العنوان 10 أحرف على الأقل");
        }

        // Validate application deadline
        const applicationDeadline = form.querySelector('input[name="application_deadline"]');
        if (!applicationDeadline || !applicationDeadline.value) {
            valid = false;
            showFieldError(applicationDeadline, "يرجى إدخال تاريخ انتهاء التقديم");
        } else {
            const deadlineDate = new Date(applicationDeadline.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (deadlineDate <= today) {
                valid = false;
                showFieldError(applicationDeadline, "يجب أن يكون تاريخ انتهاء التقديم في المستقبل");
            }
        }

        // Validate max participants
        const maxParticipants = form.querySelector('input[name="max_participants"]');
        if (!maxParticipants || !maxParticipants.value.trim()) {
            valid = false;
            showFieldError(maxParticipants, "يرجى إدخال العدد الأقصى للمتدربين");
        } else if (isNaN(maxParticipants.value.trim()) || parseInt(maxParticipants.value.trim()) <= 0) {
            valid = false;
            showFieldError(maxParticipants, "يرجى إدخال عدد صحيح أكبر من صفر");
        }

        // Validate participation method (radio buttons)
        const participationMethod = form.querySelector('input[name="participation_method"]:checked');
        if (!participationMethod) {
            valid = false;
            const radioGroup = form.querySelector('.radio-group');
            showFieldError(radioGroup, "يرجى اختيار طريقة استقبال طلبات المشاركة");
        }

        // Validate registration link (only if out_platform is selected)
        if (participationMethod && participationMethod.value === 'out_platform') {
            const registrationLink = form.querySelector('input[name="registration_link"]');
            if (!registrationLink || !registrationLink.value.trim()) {
                valid = false;
                showFieldError(registrationLink, "يرجى إدخال رابط التسجيل");
            } else if (!isValidUrl(registrationLink.value.trim())) {
                valid = false;
                showFieldError(registrationLink, "يرجى إدخال رابط صحيح");
            }
        }

        // Validate training image
        const trainingImage = form.querySelector('input[name="training_image"]');
        if (!trainingImage || !trainingImage.files || trainingImage.files.length === 0) {
            valid = false;
            const fileUploadWrapper = form.querySelector('.file-upload-wrapper');
            showFieldError(fileUploadWrapper, "يرجى اختيار صورة تعريفية للتدريب");
        } else {
            const file = trainingImage.files[0];
            if (!file.type.startsWith('image/')) {
                valid = false;
                const fileUploadWrapper = form.querySelector('.file-upload-wrapper');
                showFieldError(fileUploadWrapper, "يجب أن يكون الملف صورة");
            }
        }

        // Validate welcome message
        const welcomeMessage = form.querySelector('textarea[name="welcome_message"]');
        if (!welcomeMessage || !welcomeMessage.value.trim()) {
            valid = false;
            showFieldError(welcomeMessage, "يرجى إدخال رسالة الترحيب");
        } else if (welcomeMessage.value.trim().length < 50) {
            valid = false;
            showFieldError(welcomeMessage, "يجب أن تكون رسالة الترحيب 50 حرف على الأقل");
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    // Function to clear all error messages
    function clearAllErrors() {
        const errorMessages = form.querySelectorAll('p.error');
        const errorInputs = form.querySelectorAll('input.error, select.error, textarea.error, .file-upload-wrapper.error, .radio-group.error');
        
        errorMessages.forEach(msg => msg.remove());
        errorInputs.forEach(input => input.classList.remove('error'));
    }

    // Function to show error for a specific field
    function showFieldError(element, message) {
        if (!element) return;
        
        element.classList.add('error');
        
        // Remove existing error message if any
        const existingError = element.parentNode.querySelector('p.error');
        if (existingError) {
            existingError.remove();
        }
        
        // Create and add new error message
        const errorMsg = document.createElement('p');
        errorMsg.className = 'error';
        errorMsg.textContent = message;
        
        // Insert error message after the element
        element.parentNode.appendChild(errorMsg);
    }

    // Function to validate URL
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    // Real-time validation for inputs and selects
    form.addEventListener('input', function(e) {
        const input = e.target;
        
        // Remove error styling on input
        input.classList.remove('error');
        
        // Remove error message if input is valid
        const errorMsg = input.parentNode.querySelector('p.error');
        if (errorMsg) {
            errorMsg.remove();
        }
    });

    // Real-time validation for select elements
    form.addEventListener('change', function(e) {
        if (e.target.tagName === 'SELECT') {
            const select = e.target;
            
            // Remove error styling on select
            select.classList.remove('error');
            
            // Remove error message if select is valid
            const errorMsg = select.parentNode.querySelector('p.error');
            if (errorMsg) {
                errorMsg.remove();
            }
        }
    });

    // Real-time validation for radio buttons
    form.addEventListener('change', function(e) {
        if (e.target.name === 'participation_method') {
            const radioGroup = form.querySelector('.radio-group');
            radioGroup.classList.remove('error');
            
            const errorMsg = radioGroup.parentNode.querySelector('p.error');
            if (errorMsg) {
                errorMsg.remove();
            }
            
            // Show/hide registration link field based on selection
            const registrationLinkGroup = form.querySelector('.input-group:has(input[name="registration_link"])');
            if (e.target.value === 'out_platform') {
                registrationLinkGroup.style.display = 'block';
            } else {
                registrationLinkGroup.style.display = 'none';
                // Clear registration link when switching to in_platform
                const registrationLink = form.querySelector('input[name="registration_link"]');
                if (registrationLink) {
                    registrationLink.value = '';
                    registrationLink.classList.remove('error');
                    const linkErrorMsg = registrationLink.parentNode.querySelector('p.error');
                    if (linkErrorMsg) {
                        linkErrorMsg.remove();
                    }
                }
            }
        }
    });

    // Real-time validation for file upload
    form.addEventListener('change', function(e) {
        if (e.target.name === 'training_image') {
            const fileUploadWrapper = form.querySelector('.file-upload-wrapper');
            fileUploadWrapper.classList.remove('error');
            
            const errorMsg = fileUploadWrapper.parentNode.querySelector('p.error');
            if (errorMsg) {
                errorMsg.remove();
            }
            
            if (e.target.files && e.target.files.length > 0) {
                const file = e.target.files[0];
                if (!file.type.startsWith('image/')) {
                    showFieldError(fileUploadWrapper, "يجب أن يكون الملف صورة");
                }
            }
        }
    });
}); 