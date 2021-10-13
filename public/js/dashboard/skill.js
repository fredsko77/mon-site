const createForm = document.querySelector('#skill-create-form');
const editForm = document.querySelector('#skill-edit-form');
const deleteSkill = document.querySelectorAll('.skill-delete');
const addSkill = document.querySelector('#add-skill');

if (addSkill !== null) {
    addSkill.addEventListener('click', (event) => {
        event.preventDefault();
        const container = document.querySelector('#skills-container');
        const count = document.querySelectorAll('.skill').length;

        const template = document.querySelector('#skills-template');
        const clone = template.content.cloneNode(true);
        clone.querySelector('label').setAttribute('for', `skill_${count}`);
        clone.querySelector('[data-skill]').setAttribute('data-skill', count);
        clone.querySelector('[data-skill]').innerText = (count + 1);
        clone.querySelector('input').setAttribute('id', `skill_${count}`);

        container.appendChild(clone);
    });
}

if (editForm !== null) {
    editForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const form = event.target;
        const url = form.action;
        const data = getValues(form);
        let skills = [];
        const skillInputs = form.querySelectorAll('[name="skills[]"]');
        skillInputs.forEach((skill) => {
            skills.push(skill.value);
        });
        data['skills'] = skills;
        delete data['skills[]'];

        axios
            .put(url, data)
            .then(({ data, status, headers }) => {
                console.log({ data, status, headers });
            })
            .catch(({ response }) => {
                console.error(response)
                errorHTTPRequest();
            })
    });
}

if (createForm !== null) {
    createForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const form = event.target;
        const url = form.action;
        const data = getValues(form);
        const modal = form.closest('.modal.show');

        axios
            .post(url, data)
            .then(({ headers, status, data }) => {
                if (status === 201) {
                    validateAll(form);
                    flash('Nouvelle compétence enregistrée ! 👍');
                    setTimeout(() => {
                        closeModal(modal);
                    }, 1000);
                    if (headers.hasOwnProperty('location')) {
                        setTimeout(() => {
                            window.location = headers.location;
                        }, 2500);
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

    });
}

const closeModal = (modal) => {
    if (modal !== null) {
        modal.querySelector('[data-bs-dismiss]').click();
    }
}

if (deleteSkill instanceof NodeList) {
    deleteSkill.forEach((btn) => {
        btn.addEventListener('click', (event) => {
            event.preventDefault();
            const a = event.target;
            const url = a.href;
            const row = a.closest('tr');
            const choice = confirm('Êtes-vous sûr de supprimer cette compétence ?');

            if (choice) {
                axios
                    .delete(url)
                    .then(({ status }) => {
                        if (status === 204) {
                            flash('Compétence supprimé', 'info');
                            row.remove();
                        }
                    })
                    .catch(({ response }) => {
                        console.error(response);
                        errorHTTPRequest();
                    });
            }
        });
    });
}