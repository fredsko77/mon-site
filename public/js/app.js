// Get Params in current url 
const getSearchParams = () => (new URL(window.location.href)).searchParams;

const validate = (violations, form = null) => {

    let fields = document.querySelectorAll('.form-control[name], .form-select[name], .form-check-input[name]');
    if (form !== null) {
        fields = form.querySelectorAll('.form-control[name], .form-select[name], .form-check-input[name]')
    }
    fields.forEach((field) => {
        const feedback = field.nextElementSibling;
        if (feedback === null || feedback === undefined) {
            const elt = document.createElement('small');
            const container = field.closest('.form-group');
            elt.innerText = violations[field.name];
            elt.classList.add('invalid-feedback');
            container.appendChild(elt);
        }
        if (!violations.hasOwnProperty(field.name)) {
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.innerText = "";
                feedback.style.display = "none";
            }
            validInput(field);
        } else {
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.innerText = violations[field.name];
                feedback.style.display = "unset";
            }

            invalidInput(field);
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

    return inputs.forEach(input => validInput(input))
}

const resetValidation = (form = null) => {
    let inputs = document.querySelectorAll('.form-control[name]');
    if (form !== null) {
        inputs = form.querySelectorAll('.form-control[name]')
    }

    inputs.forEach((input) => {
        input.classList.remove('is-valid');
        input.classList.remove('is-invalid');
    });

    return;
}

const getValues = (form = null) => {
    let object = {};
    let inputs = form !== null ? form.querySelectorAll('.form-select, .btn-check, .form-control, .form-check-input') : document.querySelectorAll('.form-select, .form-control');

    inputs.forEach((input) => {
        if (input.type === 'checkbox') {
            object[input.name] = (input.checked) ? input.value : null;
        } else if (input.type === 'radio') {
            object[input.name] = document.querySelector(`[name="${input.name}"]:checked`).value;
        } else {
            object[input.name] = input.value === "" ? null : input.value;
        }
    });

    return object;
}

const errorHTTPRequest = () => flash('Une érreur est survenue lors du traitement de la requête !', 'danger');

const getCookie = cname => {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

const previewImage = (container, image) => {
    container.classList.remove('hidden');
    container.src = URL.createObjectURL(image);
    container.srcset = URL.createObjectURL(image);
    return container.onload = () => URL.revokeObjectURL(container.src); // Free memory 
}

const checkFileValid = (file, type = 'image') => {

    const listFiles = {
        image: ["gif", "jpg", "jpeg", "png", "svg"],
        resume: ['doc', 'docx', '.odt', 'pdf']
    };

    let acceptedFile = null;

    const fileExtension = (file.name.split('.')[1]).toLowerCase();

    if (type === 'image') {
        acceptedFile = listFiles[type];
    }

    return acceptedFile.includes(fileExtension);
}

const fillErrorMessage = (container, content = null) => {

    if (content !== '' && content !== null) {
        container.classList.remove('hidden')
        return container.innerHTML = content;
    }

    container.classList.add('hidden');
    return container.innerHTML = '';
}