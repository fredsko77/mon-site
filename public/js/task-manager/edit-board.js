const boardDescription = document.querySelector('#description');
const cancelDescription = document.querySelector('.board-description-actions button[type="button"]');
const boardIsOpen = document.querySelector('#boardIsOpen');
const boardDeadline = document.querySelector('#boardDeadline');
const cancelCreateTag = document.querySelector('#cancelCreateTag');

cancelCreateTag.addEventListener('click', (event) => {
    const form = event.target.closest('form');
    form.reset();
    return console.log(event);
    const tagCreateCollapse = document.querySelector('#tagCreateCollapse');
    classList = tagCreateCollapse.classList.value.replace('hidden', '');
    console.log(tagCreateCollapse.classList.value);
    return tagCreateCollapse.classList.value = classList;
});

tagCreateCollapse.addEventListener('click', (event) => event.target.classList.add('hidden'));

boardDescription.addEventListener('focus', ({ target }) => {
    const form = target.closest('form');
    const actions = form.querySelector('.board-description-actions');

    return actions.classList.toggle('hidden');
});

cancelDescription.addEventListener('click', ({ target }) => {
    return target.closest('.board-description-actions').classList.toggle('hidden')
});

boardIsOpen.addEventListener('click', (event) => {
    event.preventDefault();

    const url = event.target.href;
    const button = event.target;

    axios
        .put(url)
        .then(({ data, status }) => {
            if (status === 200) {
                if (data.hasOwnProperty('isOpen')) {
                    button.innerHTML = data.isOpen === true ? 'Fermer le tableau' : 'Ouvrir le board';
                }
            }
        }).catch(({ response }) => {
            console.error(response);
            flash('Une erreur est survenu 🤕!', 'danger');
        });
});

boardDeadline.addEventListener('change', ({ target }) => {
    let deadline = target.value;
    const url = target.closest('form').action;
    deadline = (new Date(deadline)).toJSON();

    axios
        .put(url, { deadline })
        .then(({ data, headers, status }) => {

        }).catch(({ response }) => {
            console.error(response.data);
        });
});

cancelCreateTag.addEventListener('click', ({ target }) => document.querySelector(`#${target.getAttribute('aria-target')}`).click());

const handleEditBoard = (event) => {
    event.preventDefault();
    const form = event.target;
    const url = form.action;
    const data = getValues(form);

    axios
        .put(url, data)
        .then(({ data, status, headers }) => {
            if (status === 200) {
                cancelDescription.click();
            }
        }).catch(({ response }) => {
            console.error(response);
            flash('Une erreur est survenue 🤕 !', 'danger');
        });
}

const handleBoardDelete = (event) => {
    event.preventDefault();

    const el = event.target;
    const url = el.href;

    axios
        .delete(url)
        .then(({ headers, status }) => {
            if (status === 204) {
                if (headers.hasOwnProperty('location')) {
                    setTimeout(() => {
                        flash('Tableau supprimé 🚀!', 'info');
                        window.location = headers.location;
                    }, 2000);
                }
            }
        }).catch(({ response }) => {
            console.error(response);
            flash('Une erreur est survenue 🤕 !', 'danger');
            validate(response.data.violations, form);
        });

}

const handleEditTag = (event) => {
    event.preventDefault();

    const form = event.target;
    const url = form.action;
    const data = getValues(form);
    const tagContainer = form.closest('[id^=edit_tag_form_]').previousElementSibling;

    if (data.hasOwnProperty('description') && data.description === '') {
        data.description = null;
    }

    axios
        .put(url, data)
        .then(({ data, headers, status }) => {
            if (status === 200) {
                updateTagContainer(tagContainer, data);
                form.reset();
                form.remove();
            }
        }).catch(({ response }) => {
            console.error(response);
            flash('Une erreur est survenue 🤕 !', 'danger');
            if (response.status === 400) {
                if (response.data.hasOwnProperty('violations')) {
                    validate(response.data.violations, form);
                }
            }
        });
}

const handleCreateTag = (event) => {
    event.preventDefault();

    const form = event.target;
    const url = form.action;
    const data = getValues(form);

    if (data.hasOwnProperty('description') && data.description === '') {
        data.description = null;
    }

    axios
        .post(url, data)
        .then(({ data, headers, status }) => {
            if (status === 201) {
                data.id = 1;
                if (headers.hasOwnProperty('location')) {
                    data.link = headers.location;
                }
                addTag(data);
                form.reset();
                cancelCreateTag.click();
            }
        })
        .catch(({ response }) => {
            flash('Une erreur est survenue 🤕 !', 'danger');
            if (response.status === 400) {
                if (response.data.hasOwnProperty('violations')) {
                    validate(response.data.violations, form);
                }
            }
        });
}

const addTag = (tag = {}) => {
    const template = document.querySelector('#tagTemplate');
    const clone = document.importNode(template.content, true);
    const container = document.querySelector('.board-tags-container');

    clone.querySelector('.badge').innerHTML = tag.name;
    clone.querySelector('.badge').classList.add(`badge-${tag.color}`);
    clone.querySelector('.tag-description').innerHTML = tag.description;
    clone.querySelector('#tag_update_').href = tag.link;
    clone.querySelector('#tag_delete_').href = tag.link;
    clone.querySelector('#tag_update_').id += tag.id;
    clone.querySelector('#tag_delete_').id += tag.id;
    clone.querySelector('#edit_tag_form_').id += tag.id;

    return container.appendChild(clone);
}

const editTag = async(event) => {
    event.preventDefault();

    const el = event.target;
    const url = el.href;
    const container = el.closest('.board-tag').nextElementSibling;
    const alreadyOpen = document.querySelector('#tagEditForm');


    if (alreadyOpen !== null) {
        alreadyOpen.remove();
    }

    try {
        const res = await axios.get(url);
        return openEditForm(container, res.data);
    } catch ({ response }) {
        console.error(response);
        flash('Une erreur est survenue 🤕 !', 'danger');
    }
}

const openEditForm = (container, { tag, link } = {}) => {
    const template = document.querySelector('#tagFormTemplate');
    const clone = document.importNode(template.content, true);

    clone.querySelector('form').action = link;
    clone.querySelector('[name="name"]').value = tag.name;
    clone.querySelector('[name="description"]').value = tag.description;
    clone.querySelector(`option[value="${tag.color}"]`).setAttribute('selected', 'selected');

    return container.appendChild(clone);
};

const updateTagContainer = (container, { description, name, color } = {}) => {
    const badge = container.querySelector('.badge');
    badge.classList = `badge badge-${color}`;
    badge.innerHTML = name;

    return container.querySelector('.tag-description').innerHTML = description;
}

const cancelEditTag = ({ target }) => target.closest('form').remove();

const deleteTag = async(event) => {
    event.preventDefault();
    const el = event.target;
    const container = el.closest('.list-group-item');
    const url = el.href;

    try {
        let res = await axios.delete(url);

        if (res.status === 204) {
            container.remove();
        }
        return flash('Tag supprimé 🚀!', 'success');
    } catch ({ response }) {
        console.error(response);
        flash('Une erreur est survenue 🤕!', 'danger')
    }
}