const uploadForm = document.querySelector('#upload-form');
const infoForm = document.querySelector('#info-form');
const passwordForm = document.querySelector('#password-form');
const deleteImage = document.querySelector('#deleteImage');
const editImageButton = document.querySelector('#edit-image-button');
const deleteImageButton = document.querySelector('#delete-image-button');
const profileImage = document.querySelector('#profile-image');
const image = document.querySelector('#image');

profileImage.addEventListener('click', () => {
    editImageButton.click();
    console.log(editImageButton);
});

uploadForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;
    const data = getValues(form);
    const url = form.action;
});

infoForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;
    const data = getValues(form);
    const url = form.action;

    // return console.log({ data, form, url });

    axios
        .put(url, data)
        .then(({ status }) => {
            if (status === 200) {
                validateAll(form);
                flash('Votre compte a bien été modifié !');
                setTimeout(() => {
                    window.location = window.location.href;
                }, 4000);
            }
        })
        .catch(({ response }) => {
            if (response.status === 400) {
                if (response.data.hasOwnProperty('violations')) {
                    validate(response.data.violations, form);
                }
            } else {
                errorHTTPRequest();
            }
        })

});

passwordForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;
    const data = getValues(form);
    const url = form.action;
});

image.addEventListener('change', (event) => {
    event.preventDefault();
    console.log(event);

    const file = event.target.files[0];
    const imageContainer = document.querySelector('#uploaded-image');
    const uploadError = document.querySelector('#error-upload');

    // return console.warn({ file, imageContainer, uploadError });

    if (file) {
        let extension = (file.name.split('.')[1]).toLowerCase();
        if (checkFileValid(file, 'image')) {
            previewImage(imageContainer, file);
            fillErrorMessage(uploadError, null)
        } else {
            imageContainer.classList.add('hidden');
            fillErrorMessage(uploadError, `Seuls les fichiers .gif, .jpg, .jpeg, .png ou .svg sont acceptés, votre fichier est fichier <em>.${extension}</em>`)
        }
    }
});

deleteImageButton.addEventListener('click', (event) => {
    event.preventDefault();
});