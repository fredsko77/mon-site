const deleteUser = event => {
    event.preventDefault();
    const url = event.target.href;
    const row = event.target.closest('tr');
    const consent = confirm('Êtes-vous sûr de supprimer cet utilisateur ?');

    console.log({ url, row, consent });
    if (consent) {
        axios
            .delete(url)
            .then((result) => {

            }).catch((err) => {

            });
    }
}