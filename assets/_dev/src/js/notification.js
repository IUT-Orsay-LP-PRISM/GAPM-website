import {openPopUpConnexion,openPopUpInscription} from "./popUp";

const modal = document.querySelector('#notificationModal');
const modalClose = document.querySelector('#notificationModal .notification__close');
const modalContent = document.querySelector('#notificationModal .notification__content');
modalClose.addEventListener('click', () => {
    modal.classList.remove('--active');
    modalContent.childNodes.forEach((child) => {
        child.innerHTML = '';
    });
    removeErrorInURL();
});


// gestion des erreurs
if (window.location.search.includes('message')  ) {
    const urlParams = new URLSearchParams(window.location.search);
    const containerError = urlParams.get('c');
    if (containerError === 'connexion') {
        openPopUpConnexion();
    } else if (containerError === 'inscription') {
        console.log('inscription');
        openPopUpInscription();
    } else if (containerError === 'inscription-intervenant') {
        const form = document.querySelector('#form');
        form.scrollIntoView();
    } else {
        openNotification(urlParams.get('message'));
    }
}



function openNotification($content) {
    modal.classList.add('--active');
    modalContent.children[1].innerHTML = $content;
}

export function removeErrorInURL() {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.delete('message');
    urlParams.delete('c');
    let newUrl = '';
    if(urlParams.toString() === '') {
        newUrl = window.location.pathname;
    } else{
        newUrl = window.location.pathname + '?' + urlParams.toString();
    }
    window.history.pushState({path: newUrl}, '', newUrl);
}