const header = document.querySelector('.header .header__nav');
const banner = document.querySelector('.hp__banner');
const windowHeight = header ? header.offsetHeight : 0;

const btn_connexion = document.querySelector('#btn-connexion');
const btn_inscription = document.getElementById('btn-inscription');
const popUp_connexion = document.querySelector('#popUp-connexion');
const popUp_inscription = document.querySelector('#popUp-inscription');

const btn_cross = document.querySelectorAll('.cross');
const openPopUpInsc = document.querySelector('#openPopUpInsc');

if (document.querySelector('.demandeur.home') && window.scrollY === 0) {
    header.classList.add('transparent');
} else if (document.querySelector('.demandeur.home')) {
    header.classList.add('down');
}

window.addEventListener('load', function () {
    document.querySelector('#loader').classList.add('--hidden');
});

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
window.onclick = function (event) {
    if (event.target == popUp_connexion || event.target == popUp_inscription) {
        popUp_connexion.classList.remove('visible');
        popUp_inscription.classList.remove('visible');
        document.body.style.overflowY = "auto";
    }
}

btn_connexion.addEventListener('click', () => {
    popUp_connexion.classList.toggle('visible');
    popUp_inscription.classList.remove('visible');

    if (popUp_connexion.classList.contains('visible')) {
        document.body.style.overflowY = "hidden";
    } else {
        document.body.style.overflowY = "auto";
    }
    window.scrollTo(0, 0);
});

btn_inscription.addEventListener('click', () => {
    openPopUpInscription();
});
openPopUpInsc.addEventListener('click', () => {
    openPopUpInscription();
});

btn_cross.forEach(btn => btn
    .addEventListener('click', () => {
        popUp_connexion.classList.remove('visible');
        popUp_inscription.classList.remove('visible');
        document.body.style.overflowY = "auto";
    }));


function changeColor() {
    document.body.classList.toggle('demandeur');
    document.body.classList.toggle('intervenant');
}

function openPopUpInscription() {
    popUp_inscription.classList.toggle('visible');
    popUp_connexion.classList.remove('visible');
    if (popUp_inscription.classList.contains('visible')) {
        document.body.style.overflowY = "hidden";
    } else {
        document.body.style.overflowY = "auto";
    }
    window.scrollTo(0, 0);
}

