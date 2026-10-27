// Header gets a solid background once the top sentinel leaves the viewport.
const header = () => {
    const siteHeader = document.querySelector('[data-header]');
    const sentinel = document.querySelector('[data-header-sentinel]');

    if (!siteHeader || !sentinel) {
        return;
    }

    new IntersectionObserver(([entry]) => {
        siteHeader.classList.toggle('is-scrolled', !entry.isIntersecting);
    }).observe(sentinel);
};

export default header;
