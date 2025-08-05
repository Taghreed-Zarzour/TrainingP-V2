document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("publish-training-3-form");

    form.addEventListener("submit", function (e) {
        let valid = true;

        clearAllErrors();

        // Validate main trainer presence
        const mainTrainer = form.querySelector('.trainer-main');
        if (!mainTrainer || !mainTrainer.querySelector('.trainer-name')) {
            valid = false;
            showFieldError(mainTrainer, "يجب أن يكون هناك مدرب رئيسي");
        }

        // ✅ استخدم الحقول الجديدة:
        const joinedTrainersInputs = form.querySelectorAll('input[name="trainer_ids[]"]');
        const joinedTrainersValues = Array.from(joinedTrainersInputs).map(input => input.value.trim()).filter(value => value !== '');

        const assistantsInputs = form.querySelectorAll('input[name="assistant_ids[]"]');
        const assistantsValues = Array.from(assistantsInputs).map(input => input.value.trim()).filter(value => value !== '');

        // if (joinedTrainersValues.length === 0) {
        //     valid = false;
        //     const joinedTrainersGroup = form.querySelector('.input-group:nth-of-type(2)');
        //     showFieldError(joinedTrainersGroup, "يرجى إدخال مدرب واحد على الأقل.");
        // }

        // if (assistantsValues.length === 0) {
        //     valid = false;
        //     const assistantsGroup = form.querySelector('.input-group:nth-of-type(3)');
        //     showFieldError(assistantsGroup, "يرجى إدخال مساعد واحد على الأقل.");
        // }

        if (!valid) {
            e.preventDefault();
        }
    });

    function clearAllErrors() {
        const errorMessages = form.querySelectorAll('p.error');
        const errorInputs = form.querySelectorAll('input.error, .trainer-main.error');
        errorMessages.forEach(msg => msg.remove());
        errorInputs.forEach(input => input.classList.remove('error'));
    }

    function showFieldError(element, message) {
        if (!element) return;
        element.classList.add('error');

        const existingError = element.parentNode.querySelector('p.error');
        if (existingError) existingError.remove();

        const errorMsg = document.createElement('p');
        errorMsg.className = 'error';
        errorMsg.textContent = message;

        element.parentNode.appendChild(errorMsg);
    }

    // Real-time validation
    form.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-more-btn') || e.target.classList.contains('trainer-main-remove')) {
            setTimeout(() => {
                validateTrainerSelections();
            }, 100);
        }
    });

    // function validateTrainerSelections() {
    //     clearAllErrors();

    //     const joinedTrainersInputs = form.querySelectorAll('input[name="trainer_ids[]"]');
    //     const assistantsInputs = form.querySelectorAll('input[name="assistant_ids[]"]');

    //     const joinedTrainersValues = Array.from(joinedTrainersInputs).map(input => input.value.trim()).filter(value => value !== '');
    //     const assistantsValues = Array.from(assistantsInputs).map(input => input.value.trim()).filter(value => value !== '');

    //     const total = joinedTrainersValues.length + assistantsValues.length;

    //     if (total === 0) {
    //         const joinedTrainersGroup = form.querySelector('.input-group:nth-of-type(2)');
    //         showFieldError(joinedTrainersGroup, "يرجى إضافة مدرب مشارك أو مساعد واحد على الأقل.");
    //     }
    // }
});
