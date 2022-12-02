const header = document.querySelector('.header .header__nav');
const banner = document.querySelector('.hp__banner');
const windowHeight = header.offsetHeight;

window.addEventListener('scroll', () => {
    if (window.scrollY > windowHeight) {
        header.classList.add('down');
        header.classList.remove('transparent');
    } else {
        header.classList.remove('down');
        header.classList.add('transparent');
    }
});

