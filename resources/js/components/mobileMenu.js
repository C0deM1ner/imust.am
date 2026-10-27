import { disableScroll, enableScroll } from './disableScroll';

// Mobile menu: full-screen overlay (pattern from the Sep project).
const mobileMenu = () => {
    const menu = document.querySelector('[data-menu]');
    const openButton = document.querySelector('[data-menu-open]');
    const closeButton = menu?.querySelector('[data-menu-close]');

    if (!menu || !openButton) {
        return;
    }

    const setMenu = (open) => {
        if (menu.classList.contains('is-open') === open) {
            return;
        }

        menu.classList.toggle('is-open', open);
        openButton.setAttribute('aria-expanded', String(open));

        if (open) {
            disableScroll();
            closeButton?.focus({ preventScroll: true });
        } else {
            enableScroll();
            openButton.focus({ preventScroll: true });
        }
    };

    openButton.addEventListener('click', () => setMenu(true));
    closeButton?.addEventListener('click', () => setMenu(false));

    // Close before following a link, so the page underneath is unlocked (also covers #anchors).
    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setMenu(false)));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenu(false);
        }
    });

    // The overlay is hidden from lg up; don't leave the page locked after rotating or resizing.
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => {
        if (event.matches) {
            setMenu(false);
        }
    });

    // Back/forward cache restores the page as it was; make sure it never comes back locked.
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            setMenu(false);
        }
    });
};

export default mobileMenu;
