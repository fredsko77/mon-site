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

        axios
            .put(url)
            .then(({ headers, status }) => {
                if (status === 200) {
                    flash('Le room a bien été modifié ! 🚀', 'info');
                    setTimeout(() => window.location = window.location.href, 2000);
                }
            })
            .catch(({ response }) => {
                console.error(response);
            })

    });
});

const nbItems = document.querySelector('#nbItems');

nbItems.addEventListener('change', (event) => {
    event.preventDefault();

    const url = new URL(window.location.href);
    const value = event.target.value;

    if (value === "5" && getUrlParams().has('nbItems')) {
        return deleteState('nbItems');
    }
    return pushState('nbItems', value);
});

const getUrlParams = () => (new URL(window.location.href)).searchParams;

const filters = document.querySelectorAll('[data-filter-key]');

window.onload = () => {
    let urlNbItems = getUrlParams().has('nbItems') === true ? getUrlParams().get('nbItems') : '5';
    nbItems.querySelector(`option[value="${urlNbItems}"]`).setAttribute('selected', true);


    filters.forEach((filter) => {
        if (filter.dataset.hasOwnProperty('filterKey')) {
            if (getUrlParams().has(filter.dataset.filterKey)) {
                if (getUrlParams().get(filter.dataset.filterKey) === filter.dataset.filterValue) {
                    filter.classList.add('active');
                }
            }
            if (!getUrlParams().has(filter.dataset.filterKey) && filter.dataset.filterKey === "isOpen" && filter.dataset.filterValue === "1") {
                filter.classList.add('active');
            }
        }
    });
}

filters.forEach((filter) => {
    filter.addEventListener('click', (event) => {
        event.preventDefault();

        if (filter.dataset.hasOwnProperty('filterKey') && filter.dataset.hasOwnProperty('filterValue')) {
            if (filter.dataset.filterKey === 'isOpen' && filter.dataset.filterValue === '1') {
                if (getUrlParams().get(filter.dataset.filterKey)) {
                    const url = new URL(window.location.href);
                    url.searchParams.delete(filter.dataset.filterKey);

                    return window.location = url.href;
                }
            }
            return pushState(filter.dataset.filterKey, filter.dataset.filterValue)
        }
    })
});

const pushState = (key, value) => {
    let url = new URL(window.location.href);
    url.searchParams.set(key, value);
    return window.location = url.href;
}

const deleteState = (key) => {
    let url = new URL(window.location.href);
    url.searchParams.delete(key);
    return window.location = url.href;
}