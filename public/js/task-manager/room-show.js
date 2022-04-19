const deleteButtons = document.querySelectorAll('[data-action="board-delete"]');

deleteButtons.forEach((button, index, value) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();

        const url = button.href;
        const confirmation = confirm('Voulez-vous vraiment supprimer ce tableau ? ');

        if (confirmation === true) {
            axios
                .delete(url)
                .then(({ headers, status }) => {
                    if (status === 204) {
                        flash('Le tableau a bien été supprimé ! 🚀', 'info');
                        setTimeout(() => window.location = window.location.href, 2000);
                    }
                })
                .catch(({ response }) => {
                    console.error(response);
                })
        }

    });
});
const toggleButtons = document.querySelectorAll('[data-action="board-toggle"]');

toggleButtons.forEach((button, index, value) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();

        const url = button.href;
        const confirmation = confirm('Voulez-vous vraiment modifier ce tableau ? ');

        if (confirmation === true) {
            axios
                .put(url)
                .then(({ headers, status }) => {
                    if (status === 204) {
                        flash('Le room a bien été modifié ! 🚀', 'info');
                        setTimeout(() => window.location = window.location.href, 2000);
                    }
                })
                .catch(({ response }) => {
                    console.error(response);
                })
        }

    });
});