const form = document.querySelector('#project-create-form');
const deleteProject = document.querySelectorAll('.project-delete')

form.addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;
    const data = getValues(form);
    const url = form.action;

    axios
        .post(url, data)
        .then(({ status, headers }) => {
            if (status === 201) {
                flash('Le projet a bien été crée !');
                validateAll(form);
                if (headers.hasOwnProperty('location')) {
                    setTimeout(() => {
                        window.location = headers.location;
                    }, 4000);
                }
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
        });

    return;

});

deleteProject.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();

        const url = event.target.href;
        const row = event.target.closest('[data-project-index]');

        axios
            .delete(url)
            .then(({ status }) => {
                if (status === 204) {
                    row.remove();
                }
            })
            .catch(({ response }) => {
                console.error(response);
                errorHTTPRequest();
            })
    });
});