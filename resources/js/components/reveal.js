// Scroll animations. [data-reveal] fades in once; [data-fade] fades in on entering the viewport
// and back out on leaving it (both scroll directions). Styles: base/_reveal.scss.
const reveal = () => {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -8% 0px' });

    document.querySelectorAll('[data-reveal]').forEach((el) => revealObserver.observe(el));

    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => entry.target.classList.toggle('is-visible', entry.isIntersecting));
    }, { threshold: 0.15 });

    document.querySelectorAll('[data-fade]').forEach((el) => fadeObserver.observe(el));
};

export default reveal;
