// Language dropdown (<details>): close on outside click or Escape.
const languageMenu = () => {
    const menus = document.querySelectorAll('[data-lang-menu]');

    if (!menus.length) {
        return;
    }

    document.addEventListener('click', (event) => {
        menus.forEach((details) => {
            if (details.open && !details.contains(event.target)) {
                details.open = false;
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            menus.forEach((details) => { details.open = false; });
        }
    });
};

export default languageMenu;
