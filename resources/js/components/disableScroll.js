// Page scroll lock (pattern from the Sep project). body becomes position: fixed (see
// base/_no_scroll.scss), which is what stops iOS Safari from scrolling the page underneath;
// --st holds the scroll offset so it can be restored.
const disableScroll = () => {
    document.body.style.setProperty('--st', `${-window.scrollY}px`);
    document.body.classList.add('noscroll');
};

const enableScroll = () => {
    const top = parseInt(document.body.style.getPropertyValue('--st') || '0', 10);

    document.body.classList.remove('noscroll');
    document.body.style.removeProperty('--st');
    window.scrollTo({ top: -top, behavior: 'instant' });
};

export { disableScroll, enableScroll };
