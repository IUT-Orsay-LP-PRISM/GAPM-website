const header = document.querySelector('.header .header__nav');
const banner = document.querySelector('.hp__banner');
const windowHeight = header.offsetHeight;

const btn_connexion = document.querySelector('#btn-connexion');
const popUp_connexion = document.querySelector('#popUp-connexion');
const btn_cross = document.querySelector('.cross');


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

btn_connexion.addEventListener('click', () => {
    const style = popUp_connexion.style.display;
    popUp_connexion.style.display = style === "block" ? 'none' : 'block';
    document.body.style.overflowY = style === "block" ? 'auto' : 'hidden';
});

btn_cross.addEventListener('click', () => {
    popUp_connexion.style.display = 'none';
    document.body.style.overflowY = 'auto';
});



