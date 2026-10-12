import '@phosphor-icons/web/regular';
import '@phosphor-icons/web/light';
import Swiper from 'swiper';
import { A11y, Keyboard, Navigation } from 'swiper/modules';
import 'swiper/css';

// Reveal on scroll
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { rootMargin: '0px 0px -8% 0px' });

document.querySelectorAll('[data-reveal]').forEach((el) => revealObserver.observe(el));

// Fade in on entering the viewport and back out on leaving it (both scroll directions).
const fadeObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => entry.target.classList.toggle('is-visible', entry.isIntersecting));
}, { threshold: 0.15 });

document.querySelectorAll('[data-fade]').forEach((el) => fadeObserver.observe(el));

// Header gets a solid background once the top sentinel leaves the viewport
const header = document.querySelector('[data-header]');
const sentinel = document.querySelector('[data-header-sentinel]');

if (header && sentinel) {
    new IntersectionObserver(([entry]) => {
        header.classList.toggle('is-scrolled', !entry.isIntersecting);
    }).observe(sentinel);
}

// Mobile menu
const menuToggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');

const setMenu = (open) => {
    menu.classList.toggle('hidden', !open);
    menuToggle.setAttribute('aria-expanded', String(open));
    menuToggle.querySelector('i').className = open ? 'ph ph-x text-[24px]' : 'ph ph-list text-[24px]';
    header.classList.toggle('menu-open', open);
};

menuToggle?.addEventListener('click', () => setMenu(menu.classList.contains('hidden')));
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menu && !menu.classList.contains('hidden')) {
        setMenu(false);
        menuToggle.focus();
    }
});

// Project gallery (About page): Swiper with the page's own arrow buttons.
document.querySelectorAll('[data-gallery]').forEach((gallery) => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const prevEl = gallery.querySelector('[data-gallery-prev]');
    const nextEl = gallery.querySelector('[data-gallery-next]');

    new Swiper(gallery.querySelector('[data-gallery-swiper]'), {
        modules: [Navigation, Keyboard, A11y],
        slidesPerView: 'auto',
        spaceBetween: 16,
        speed: reduceMotion ? 0 : 600,
        grabCursor: true,
        watchOverflow: true,
        keyboard: { enabled: true, onlyInViewport: true },
        navigation: { prevEl, nextEl, disabledClass: 'is-disabled' },
        // Reuse the buttons' translated aria-labels (Swiper's a11y module would otherwise replace them).
        a11y: {
            prevSlideMessage: prevEl.getAttribute('aria-label'),
            nextSlideMessage: nextEl.getAttribute('aria-label'),
        },
        breakpoints: {
            768: { spaceBetween: 24 },
        },
    });
});

// Blog post: copy the article link, briefly confirm in the button label.
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

// Language dropdown (<details>): close on outside click or Escape
const langMenus = document.querySelectorAll('[data-lang-menu]');

document.addEventListener('click', (event) => {
    langMenus.forEach((details) => {
        if (details.open && !details.contains(event.target)) {
            details.open = false;
        }
    });
});
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        langMenus.forEach((details) => { details.open = false; });
    }
});

// Contact form: client-side validation only. Sending is not wired to a backend yet.
const form = document.querySelector('[data-contact-form]');

form?.addEventListener('submit', (event) => {
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
