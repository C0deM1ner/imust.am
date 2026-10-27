// Contact form: checks the required fields in the browser, then sends with fetch so the page stays put.
// Without JS the form posts normally and the server renders the errors or the "sent" message.
const contactForm = () => {
    const form = document.querySelector('[data-contact-form]');

    if (!form) {
        return;
    }

    const status = form.querySelector('[data-form-status]');
    const statusText = form.querySelector('[data-form-status-text]');
    const statusIcon = status.querySelector('i');
    const submit = form.querySelector('[data-form-submit]');
    const sentMessage = statusText.textContent;

    const showError = (field, message) => {
        const error = form.querySelector(`#${field.id}-error`);
        field.setAttribute('aria-invalid', String(Boolean(message)));
        error?.classList.toggle('hidden', !message);
        if (message && error) {
            error.textContent = message;
        }
    };

    const showStatus = (message, isError) => {
        statusText.textContent = message;
        status.classList.toggle('is-error', isError);
        statusIcon.className = isError ? 'ph ph-warning-circle' : 'ph ph-check-circle';
        status.classList.remove('hidden');
        status.focus();
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        let firstInvalid = null;

        form.querySelectorAll('[data-validate]').forEach((field) => {
            const valid = field.checkValidity();
            const error = form.querySelector(`#${field.id}-error`);
            field.setAttribute('aria-invalid', String(!valid));
            error?.classList.toggle('hidden', valid);

            if (!valid && !firstInvalid) {
                firstInvalid = field;
            }
        });

        if (firstInvalid) {
            status.classList.add('hidden');
            firstInvalid.focus();

            return;
        }

        submit.disabled = true;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { Accept: 'application/json' },
                body: new FormData(form),
            });

            if (response.status === 422) {
                const { errors } = await response.json();
                let focused = false;

                form.querySelectorAll('[data-validate]').forEach((field) => {
                    showError(field, errors[field.name]?.[0]);
                    if (errors[field.name] && !focused) {
                        field.focus();
                        focused = true;
                    }
                });
                status.classList.add('hidden');

                return;
            }

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            form.reset();
            showStatus(sentMessage, false);
        } catch {
            showStatus(status.dataset.failed, true);
        } finally {
            submit.disabled = false;
        }
    });
};

export default contactForm;
