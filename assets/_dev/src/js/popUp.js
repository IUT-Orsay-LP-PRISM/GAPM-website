const openPopUpInsc = document.querySelector('#openPopUpInsc');
const popUp_connexion = document.querySelector('#popUp-connexion');
const popUp_inscription = document.querySelector('#popUp-inscription');
const btn_cross = document.querySelectorAll('.cross');
const btn_connexion = document.querySelector('#btn-connexion');
const btn_inscription = document.getElementById('btn-inscription');
const div_error = document.querySelector('#popUp-connexion .error');

openPopUpInsc.addEventListener('click', () => {
    openPopUpInscription();
});

btn_cross.forEach(btn => btn
    .addEventListener('click', () => {
        popUp_connexion.classList.remove('visible');
        popUp_inscription.classList.remove('visible');
        document.body.style.overflowY = "auto";
        removeErrorInURL();
        div_error ? div_error.innerHTML = '' : null;
    })
);

if (btn_connexion && btn_inscription) {
    btn_connexion.addEventListener('click', () => {
        openPopUpConnexion();
    });

    btn_inscription.addEventListener('click', () => {
        openPopUpInscription();
    });
}

window.onclick = function (event) {
    if (event.target == popUp_connexion || event.target == popUp_inscription) {
        popUp_connexion.classList.remove('visible');
        popUp_inscription.classList.remove('visible');
        document.body.style.overflowY = "auto";
        removeErrorInURL();
        div_error ? div_error.innerHTML = '' : null;
    }
}
if (document.querySelector('.demandeur.home') && window.location.search.includes('error')) {
    openPopUpConnexion();
}


function openPopUpConnexion() {
    popUp_connexion.classList.toggle('visible');
    popUp_inscription.classList.remove('visible');
    if (popUp_connexion.classList.contains('visible')) {
        document.body.style.overflowY = "hidden";
    } else {
        document.body.style.overflowY = "auto";
    }
    window.scrollTo(0, 0);
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

function removeErrorInURL() {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.delete('error');
    const newUrl = window.location.pathname + '?' + urlParams.toString();
    window.history.pushState({path: newUrl}, '', newUrl);
}
