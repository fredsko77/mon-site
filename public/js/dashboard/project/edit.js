const form = document.getElementById('project-informations-store');
const projectLink = document.getElementById('project-link');
const taskForm = document.getElementById('task-form');
const editTaskButtons = document.querySelectorAll('.task-edit');
const deleteTaskButtons = document.querySelectorAll('.task-delete');
const closeModalButtons = document.querySelectorAll('[data-bs-form]');
const imageNew = document.getElementById('image-new');
const imageEdit = document.querySelectorAll('.project-image-edit');
const imageDelete = document.querySelectorAll('.project-image-delete');
const isMain = document.querySelectorAll('.project-image-main');

window.onload = () => {
    if (window.location.hash !== '') {
        document.querySelector('[data-bs-target="#images"]').click();
    }
}

imageNew.addEventListener('change', (event) => {
    event.preventDefault();
    const form = event.target.closest('form');
    const formData = new FormData(form);
    const url = form.action;
    const tab = form.closest('.tab-pane');
    axios
        .post(url, formData)
        .then(({ status }) => {
            if (status === 201) {
                window.location.hash = tab.id;
                window.location.reload();
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
});

form.addEventListener('submit', (event) => {
    event.preventDefault();

    const form = event.target;
    const data = getValues(form);
    const url = form.action;

    axios
        .put(url, data)
        .then(({ headers, status, data }) => {
            if (status === 200) {
                window.location.hash = tab.id;
                window.location.reload();
            }
            resetValidation(form);
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

taskForm.addEventListener('submit', (event) => {
    event.preventDefault();

    const form = event.target;
    const data = getValues(form);
    const url = form.action;
    const action = form.dataset.formAction;
    const closeButton = form.querySelector('[data-bs-dismiss="modal"]');

    if (action === 'create') {
        axios
            .post(url, data)
            .then(({ data, headers, status }) => {
                if (status === 201) {
                    resetValidation();
                    closeButton.click();
                    if (headers.hasOwnProperty('task-link')) {
                        data['link'] = headers['task-link'];
                    }
                    addTask(data);
                    if (status === 200) {
                        window.location.hash = tab.id;
                        window.location.reload();
                    }
                }
                resetTaskForm();
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
    } else {

        axios
            .put(url, data)
            .then(({ data, status }) => {
                if (status === 200) {
                    resetValidation();
                    closeButton.click();
                    window.location.hash = tab.id;
                    window.location.reload();
                }
                resetTaskForm();
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
    }
});

editTaskButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();

        const button = event.target.closest('.link');
        const url = button.href;
        const container = button.closest('.task-item');
        const name = container.querySelector('[data-col-task="name"]').innerText;
        const index = container.dataset.taskIndex;

        return hydrateTaskForm({ name, url, index });
    });
});

deleteTaskButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();

        const button = event.target.closest('.link');
        const url = button.href;
        const choice = confirm("Êtes-vous sûr de supprimer cette tâche");
        const container = button.closest('.task-item');

        if (choice === true) {
            axios
                .delete(url)
                .then(({ status }) => {
                    if (status === 204) {
                        // To Do supprimer la tâche dans le vue;
                        container.remove();
                    }
                })
                .catch(({ response }) => {
                    errorHTTPRequest();
                })
        }
    });
});

closeModalButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
        return resetTaskForm();
    });
});

const resetTaskForm = () => {
    const taskForm = document.getElementById('task-form');
    taskForm.reset();
    taskForm.action = formUrls.base;
    taskForm.querySelector('#modal-task-title').innerText = "Nouvelle tâche";
    return taskForm.setAttribute('data-form-action', 'create');
}

const hydrateTaskForm = (data) => {
    const form = document.getElementById('task-form');
    form.setAttribute('action', data.url);
    form.setAttribute('data-form-action', 'edit');
    form.querySelector(`[name]`).value = data.name;
    return form.querySelector('#modal-task-title').innerText = `Modifier la tâche ${data.index}`;
};

const addTask = (data = {}) => {

    const template = document.getElementById('task-template');
    const container = document.getElementById('project-task-list');

    const task = template.content.cloneNode(true);
    task.querySelector('[data-task-index]').setAttribute('data-task-index', data.id);
    task.querySelector('.task-edit').setAttribute('href', data.link);
    task.querySelector('.task-delete').setAttribute('href', data.link);
    task.querySelector('[data-col-task]').innerText = data.name;

    return container.appendChild(task);
}

imageEdit.forEach((inputFile) => {
    inputFile.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const data = new FormData();
        const url = event.target.closest('label').getAttribute('data-action-url');
        const tab = event.target.closest('.tab-pane');
        if (file instanceof File) {
            data.append('image', file, file.name);
            axios
                .post(url, data)
                .then(({ status }) => {
                    if (status === 200) {
                        window.location.hash = tab.id;
                        window.location.reload();
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
        }
        console.log({ file, data, url });
    });
});

isMain.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
        const elt = event.target
        const a = elt.closest('a');
        const tab = elt.closest('.tab-pane');
        const is_main = a.dataset.colImage;

        if (a.dataset.imageMain !== "1") {
            axios
                .post(a.href, { is_main })
                .then(({ status }) => {
                    if (status === 200) {
                        window.location.hash = tab.id;
                        window.location.reload();
                    }
                })
                .catch(({ response }) => {
                    errorHTTPRequest();
                })
        } else {
            flash('Cette image est déjà l\'image pricipale !', 'info');
        }

    });
});

imageDelete.forEach((button) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
        const url = event.target.closest('a').href;
        const choice = confirm('Êtes-vous sûr de supprimer cette image ?');
        const tab = button.closest('.tab-pane');

        if (choice === true) {
            axios
                .delete(url)
                .then(({ headers, status }) => {
                    if (status === 204) {
                        window.location.hash = tab.id;
                        window.location.reload();
                    }
                })
                .catch(({ response }) => {
                    errorHTTPRequest();
                })
            console.log(event);
        }
    });
});