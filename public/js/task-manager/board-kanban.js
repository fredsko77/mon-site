const bookmarkBoard = (event) => {
    event.preventDefault();
    const el = event.target.tagName === 'I' ? event.target.closest('a') : event.target;
    const bookmark = event.target.tagName === 'I' ? event.target : event.target.querySelector('i');
    const url = el.href;

    axios
        .put(url)
        .then(({ data, status }) => {
            if (status === 200) {
                flash('Le tableau a bien été modifié ! 🚀', 'info');
                if (data.hasOwnProperty('isBookmarked')) {
                    bookmark.classList = 'bi bi-bookmark' + (data.isBookmarked === true ? '-fill' : '');
                }
            }
        })
        .catch(({ response }) => {
            console.error(response);
        });
}