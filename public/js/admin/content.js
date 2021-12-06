// const image = document.querySelector('#image');
const deleteButtons = document.querySelectorAll('a[data-role="delete"]');

deleteButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();

        const url = button.href;
        const answer = confirm('Êtes vous sûr de vouloir supprimer ce contenu ?');

        if (answer === true) {
            axios
                .delete(url)
                .then(({ headers, status }) => {
                    if (status === 204) {
                        // if (headers.hasOwnProperty('location')) {
                        setTimeout(() => {
                            // window.location = headers.location
                            window.location.reload();
                        }, 1000);
                        // }
                    }
                })
                .catch(({ response }) => {
                    console.log(response)
                })
        }
    });
});

// image.addEventListener('change', (event) => {
//     event.preventDefault();
//     console.log(event);

//     const file = event.target.files[0];
//     const imageContainer = document.querySelector('#uploaded-image');
//     const uploadError = document.querySelector('#error-upload');

//     if (file) {
//         let extension = (file.name.split('.')[1]).toLowerCase();
//         if (checkFileValid(file, 'image')) {
//             previewImage(imageContainer, file);
//             fillErrorMessage(uploadError, null)
//         } else {
//             imageContainer.classList.add('hidden');
//             fillErrorMessage(uploadError, `Seuls les fichiers .gif, .jpg, .jpeg, .png ou .svg sont acceptés, votre fichier est fichier <em>.${extension}</em>`)
//         }
//     }
// });