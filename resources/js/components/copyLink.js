// Blog post: copy the article link, briefly confirm in the button label.
const copyLink = () => {
    document.querySelectorAll('[data-copy-link]').forEach((button) => {
        const label = button.querySelector('[data-copy-label]');
        const original = label.textContent;

        button.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(window.location.href);
                label.textContent = button.dataset.copiedLabel;
                setTimeout(() => { label.textContent = original; }, 2000);
            } catch {
                window.prompt('', window.location.href);
            }
        });
    });
};

export default copyLink;
