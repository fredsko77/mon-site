const toggler = document.querySelector('.header-menu-toggler');
const mobiNav = document.querySelector('.mobi-nav');

if (toggler !== undefined || toggler !== null) {
    toggler.addEventListener('click', () => {
        const menu = document.querySelector(`${toggler.dataset.appTarget}`);
        return menu.classList.toggle('open');
    });
}

if (mobiNav !== undefined || mobiNav !== null) {
    mobiNav.addEventListener('click', () => {
        return mobiNav.classList.toggle('open');
    });
}