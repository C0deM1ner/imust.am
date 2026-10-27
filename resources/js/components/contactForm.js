// Contact form: client-side validation only. Sending is not wired to a backend yet.
const contactForm = () => {
    const form = document.querySelector('[data-contact-form]');

    if (!form) {
        return;
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        let firstInvalid = null;

        form.querySelectorAll('[data-validate]').forEach((field) => {
            const error = form.querySelector(`#${field.id}-error`);
            const valid = field.checkValidity();

            field.setAttribute('aria-invalid', String(!valid));
            error?.classList.toggle('hidden', valid);

            if (!valid && !firstInvalid) {
                firstInvalid = field;
            }
        });

        const status = form.querySelector('[data-form-status]');

        if (firstInvalid) {
            status.classList.add('hidden');
            firstInvalid.focus();

            return;
        }

        status.classList.remove('hidden');
        status.focus();
    });
};

export default contactForm;
