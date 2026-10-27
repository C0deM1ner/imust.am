// Portfolio tag filter. The pills are plain links (?tag=video) that the server already filters,
// so they work without JS; here they filter the grid in place and keep the tag in the address bar.
const portfolioFilter = () => {
    const root = document.querySelector('[data-portfolio]');

    if (!root) {
        return;
    }

    const pills = root.querySelectorAll('[data-filter]');
    const items = root.querySelectorAll('[data-tags]');
    const grid = root.querySelector('[data-portfolio-grid]');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let timer;

    const apply = (tag) => {
        pills.forEach((pill) => {
            const isActive = pill.dataset.filter === tag;
            pill.classList.toggle('is-active', isActive);
            if (isActive) {
                pill.setAttribute('aria-current', 'true');
            } else {
                pill.removeAttribute('aria-current');
            }
        });

        let shown = 0;
        items.forEach((item) => {
            const isShown = tag === 'all' || item.dataset.tags.split(' ').includes(tag);
            item.hidden = !isShown;
            if (isShown) {
                item.style.setProperty('--d', shown++ % 3);
            }
        });

        grid.classList.remove('is-switching');
    };

    root.addEventListener('click', (event) => {
        const pill = event.target.closest('[data-filter]');

        // Let modified clicks open the filtered page in a new tab.
        if (!pill || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
        }

        event.preventDefault();
        history.replaceState(null, '', pill.href);
        clearTimeout(timer);

        if (reduceMotion.matches) {
            apply(pill.dataset.filter);
            return;
        }

        grid.classList.add('is-switching');
        timer = setTimeout(() => apply(pill.dataset.filter), 200);
    });
};

export default portfolioFilter;
