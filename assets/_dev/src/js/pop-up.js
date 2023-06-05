const openPopUpInsc = document.querySelector('#openPopUpInsc');
const popUp_connexion = document.querySelector('#popUp-connexion');
const popUp_inscription = document.querySelector('#popUp-inscription');
const popUp_prendreRDV = document.querySelector('#popUp-prendre-RDV');
const popUp_ajouterAvis = document.querySelector('#popUp-avis-RDV');
const btn_cross = document.querySelectorAll('.cross');
const btn_connexion = document.querySelector('#btn-connexion');
const btn_inscription = document.getElementById('btn-inscription');
const lien_connexion = document.querySelector('#lien-connexion');
const lien_inscription = document.getElementById('lien-inscription');
const div_errorConnexion = document.querySelector('#popUp-connexion .error');
const div_errorInscription = document.querySelector('#popUp-inscription .error');
import {removeErrorInURL} from './notification';
import {ajaxPopupAvis} from "./autocomplete";

if (openPopUpInsc) {
    openPopUpInsc.addEventListener('click', () => {
        openPopUpInscription();
    });
}

btn_cross.forEach(btn => btn
    .addEventListener('click', () => {
        popUp_connexion && popUp_connexion.classList.remove('visible');
        popUp_inscription && popUp_inscription.classList.remove('visible');

        popUp_prendreRDV && popUp_prendreRDV.classList.remove('visible');
        popUp_ajouterAvis && popUp_ajouterAvis.classList.remove('visible');
        removeErrorInURL();
        div_errorConnexion ? div_errorConnexion.innerHTML = '' : null;
        div_errorInscription ? div_errorInscription.innerHTML = '' : null;

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

if (lien_connexion && lien_inscription) {
    lien_connexion.addEventListener('click', function (e) {
        e.preventDefault();
        openPopUpConnexion();
    });

    lien_inscription.addEventListener('click', function (e) {
        e.preventDefault();
        openPopUpInscription();
    });
}

// close div auto_completion when click outside
const AC = document.querySelectorAll('.AC');
window.onclick = function (event) { // When the user clicks anywhere outside of the modal, close it
    if (event.target == popUp_connexion || event.target == popUp_inscription || event.target == popUp_prendreRDV || event.target == popUp_ajouterAvis) {
        popUp_connexion && popUp_connexion.classList.remove('visible');
        popUp_inscription && popUp_inscription.classList.remove('visible');
        popUp_prendreRDV && popUp_prendreRDV.classList.remove('visible');
        popUp_ajouterAvis && popUp_ajouterAvis.classList.remove('visible');
        removeErrorInURL();
        div_errorConnexion ? div_errorConnexion.innerHTML = '' : null;
        div_errorInscription ? div_errorInscription.innerHTML = '' : null;
    }
    if (AC) {
        AC.forEach(div => {
            if (!Array.from(event.target.classList).includes('AC')) {
                div.parentNode.querySelector('.auto_completion').classList.add('notVisible');
            }
        });
    }
}


export function openPopUpConnexion() {
    popUp_connexion.classList.toggle('visible');
    popUp_inscription.classList.remove('visible');
}

export function openPopUpInscription() {
    popUp_inscription.classList.toggle('visible');
    popUp_connexion.classList.remove('visible');
}


/*  Ajouter un avis popup  */
let btn_ajouterAvis = document.querySelectorAll('.js-addnotice-rdv');
if (btn_ajouterAvis.length > 0) {
    btn_ajouterAvis.forEach(btn => {
        btn.addEventListener('click', () => {
            let dataRdvId = btn.dataset.rdvId;
            ajaxPopupAvis(dataRdvId);
        })
    })
}
