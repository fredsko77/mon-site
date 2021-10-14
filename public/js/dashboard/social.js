const deleteSocials = document.querySelectorAll('.social-delete');

deleteSocials.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
        const a = event.target;
        const url = a.href;
        const row = a.closest('[data-social-index]');
        const choice = confirm('Êtes-vous sûr de vouloir supprimer ce profil ?');

        if (choice) {
            axios
                .delete(url)
                .then(({ status }) => {
                    if (status === 204) {
                        row.remove();
                    }
                })
                .catch(({ response }) => {
                    errorHTTPRequest()
                    console.error(response)
                })
        }
    });
});