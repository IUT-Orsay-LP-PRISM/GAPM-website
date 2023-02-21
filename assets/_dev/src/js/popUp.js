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

// close div auto_completion when click outside
const AC = document.querySelectorAll('.AC');
window.onclick = function (event) { // When the user clicks anywhere outside of the modal, close it
    if (event.target == popUp_connexion || event.target == popUp_inscription) {
        popUp_connexion.classList.remove('visible');
        popUp_inscription.classList.remove('visible');
        document.body.style.overflowY = "auto";
        removeErrorInURL();
        div_error ? div_error.innerHTML = '' : null;
    }
    if (AC) {
        AC.forEach(div => {
            if (!Array.from(event.target.classList).includes('AC')) {
                div.parentNode.querySelector('.auto_completion').classList.add('notVisible');
            }
        });
    }
}


if (window.location.search.includes('error')) {
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
    let newUrl = '';
    if(urlParams.toString() === '') {
        newUrl = window.location.pathname;
    } else{
        newUrl = window.location.pathname + '?' + urlParams.toString();
    }
    window.history.pushState({path: newUrl}, '', newUrl);
}

