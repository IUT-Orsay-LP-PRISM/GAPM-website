const header = document.querySelector('.header .header__nav');
const banner = document.querySelector('.hp__banner');
const windowHeight = header ? header.offsetHeight : 0;

if (header) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > windowHeight) {
            header.classList.add('down');
            if (banner) {
                header.classList.remove('transparent');
            }
        } else {
            header.classList.remove('down');
            if (banner) {
                header.classList.add('transparent');
            }
        }
    });

    if (document.querySelector('.demandeur.home') && window.scrollY === 0 && header) {
        header.classList.add('transparent');
    } else if (document.querySelector('.demandeur.home')) {
        header.classList.add('down');
    }
}
