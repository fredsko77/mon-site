const image = document.getElementById('image');
const addBlocButton = document.getElementById('add-bloc');
const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;
    const data = new FormData(form);
    const url = form.action;

    axios
        .post(url, data)
        .then(({ data, status }) => {
            // form.querySelector('#image').value = '';
            console.log({ data, status });
        })
        .catch(({ response }) => {
            console.log({ response });
        })

});

addBlocButton.addEventListener('click', (e) => {
    e.preventDefault();
    const template = document.getElementById('biography-blocs-template');
    const container = document.getElementById('bloc-container');
    const count = (container.querySelectorAll('.form-group').length) + 1;
    if (count <= 5) {

        const bloc = template.content.cloneNode(true);

        bloc.querySelector('span[data-bloc]').setAttribute('data-bloc', count);
        bloc.querySelector('span[data-bloc]').innerText = count;
        bloc.querySelector('label').setAttribute('for', `bloc_${count}`);
        bloc.querySelector('textarea').setAttribute('id', `bloc_${count}`);

        return container.appendChild(bloc);
    }

    return flash('Vous avez atteint le nombre maximum de bloc.', 'warning');
});

image.addEventListener('change', (event) => {
    event.preventDefault();
    console.log(event);

    const file = event.target.files[0];
    const imageContainer = document.getElementById('uploaded-image');
    const uploadError = document.getElementById('error-upload');

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