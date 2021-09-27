const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();

    const data = getValues(form);
    const url = form.action;

    if (data.hasOwnProperty('telephone')) {
        if (data.telephone === '') {
            data['telephone'] = null;
        }
    }

    axios
        .post(url, data)
        .then(({ data, status, headers }) => {
            if (status === 201) {
                validateAll(form);
                flash('Votre compte a été enregistré avec succès !');
                if (headers.hasOwnProperty('location')) {
                    setTimeout(() => window.location = headers.location, 4000);
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
        })

    console.log({ data: getValues(event.target), axios });
});