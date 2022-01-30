window.onload = () => {
    const fileUploader = document.querySelector('#shelf_uploadedFile');

    fileUploader.addEventListener('change', (event) => {
        event.preventDefault();

        const file = event.target.files[0];
        const acceptedExtensions = ["gif", "jpg", "jpeg", "png", "svg"];
        const fileExtension = (file.name.split('.')[1]).toLowerCase();
        const previewContainer = document.querySelector('#preview-container');
        const previewError = document.querySelector('#preview-error');


        if (acceptedExtensions.includes(fileExtension)) {
            previewError.classList.add('hidden');
            return previewImage(previewContainer, file);
        }

        previewContainer.classList.add('hidden');
        previewError.innerText = 'Ce fichier ne peut pas être prévisualiser !';
        return previewError.classList.remove('hidden');
    });
}