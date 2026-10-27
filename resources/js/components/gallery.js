import Swiper from 'swiper';
import { A11y, Keyboard, Navigation } from 'swiper/modules';
import 'swiper/css';

// Project gallery (About page): Swiper with the page's own arrow buttons.
const gallery = () => {
    document.querySelectorAll('[data-gallery]').forEach((section) => {
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const prevEl = section.querySelector('[data-gallery-prev]');
        const nextEl = section.querySelector('[data-gallery-next]');

        new Swiper(section.querySelector('[data-gallery-swiper]'), {
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
};

export default gallery;
