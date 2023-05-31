const header = document.querySelector('.header .header__nav');
const headerMobileB = document.querySelector('.header__mobile');
const banner = document.querySelector('.hp__banner');
const windowHeight = header ? header.offsetHeight : 0;
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

if (header) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > windowHeight) {
            header.classList.add('down');
            headerMobileB.classList.add('down');
            if (banner) {
                header.classList.remove('transparent');
                headerMobileB.classList.remove('transparent');
            }
        } else {
            header.classList.remove('down');
            headerMobileB.classList.remove('down');
            if (banner) {
                header.classList.add('transparent');
                headerMobileB.classList.add('transparent');
            }
        }
    });

    if (document.querySelector('.home') && window.scrollY === 0 && header) {
        header.classList.add('transparent');
        headerMobileB.classList.add('transparent');
    } else if (document.querySelector('.home')) {
        header.classList.add('down');
        headerMobileB.classList.add('down');
    }
}


const headerMobileBg = document.querySelector('.header__mobile');
const headerMobile = document.querySelector('.header__mobile__menu-content');
const headerMobileButton = document.querySelector('.header__mobile__menu-btn');

if (headerMobileButton) {
    headerMobileButton.addEventListener('click', () => {
        headerMobileBg.classList.add('--fade');
        headerMobile.classList.add('--open');
    });

    document.querySelector('.js-close-menu').addEventListener('click', () => {
        headerMobileBg.classList.remove('--fade');
        headerMobile.classList.remove('--open');
    })
}

document.body.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
        headerMobileBg.classList.remove('--fade');
        headerMobile.classList.remove('--open');
    }
});

if (urlParams.get('action')){
    var page = urlParams.get('action');
}
else{
    var page = 'accueil';
}

var navElements = document.querySelectorAll('.menu-item');
navElements.forEach(element => {
    if(element.dataset.page == page && element.parentNode.classList.contains("header__menu")){
        element.querySelector('a.link').classList.add('--active');
    }
}); 