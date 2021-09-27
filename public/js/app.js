// Get Params in current url 
const getSearchParams = () => (new URL(window.location.href)).searchParams;

const validate = (violations, form = null) => {

    let inputs = document.querySelectorAll('.form-control[name]');
    if (form !== null) {
        inputs = form.querySelectorAll('.form-control[name]')
    }
    inputs.forEach((input) => {
        const feedback = input.nextElementSibling;
        if (!violations.hasOwnProperty(input.name)) {
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.innerText = "";
                feedback.style.display = "none";
            }

            validInput(input);
        } else {
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.innerText = violations[input.name];
                feedback.style.display = "unset";
            }

            invalidInput(input);
        }
    });

    return;
}

const validInput = (input) => {
    if (input.classList.contains('is-invalid')) {
        return input.classList.replace('is-invalid', 'is-valid');
    }

    return input.classList.add('is-valid');
}

const invalidInput = (input) => {
    if (input.classList.contains('is-valid')) {
        return input.classList.replace('is-valid', 'is-invalid');
    }

    return input.classList.add('is-invalid');
}

const validateAll = (form = null) => {
    let inputs = document.querySelectorAll('.form-control[name]');
    if (form !== null) {
        inputs = form.querySelectorAll('.form-control[name]')
    }

    inputs.forEach(input => validInput(input))
}

const getValues = (form = null) => {
    let object = {};
    let inputs = form !== null ? form.querySelectorAll('.form-select, .btn-check, .form-control, .form-check-input') : document.querySelectorAll('.form-select, .form-control');

    inputs.forEach(input => {
        if (input.type === 'checkbox') {
            object[input.name] = (input.checked) ? input.value : null;
        } else if (input.type === 'radio') {
            object[input.name] = document.querySelector(`[name="${input.name}"]:checked`).value;
        } else {
            object[input.name] = input.value;
        }
    });

    return object;
}

const errorHTTPRequest = () => flash('Une érreur est survenue lors du traitement de la requête !', 'danger');