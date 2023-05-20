import {openPopUpConnexion, openPopUpInscription} from "./pop-up";

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
if (window.location.search.includes('message')) {
    const urlParams = new URLSearchParams(window.location.search);
    const containerMessage = urlParams.get('c');

    switch (containerMessage) {
        case 'connexion':
            openPopUpConnexion();
            break;
        case 'inscription':
            openPopUpInscription();
            break;
        case 'inscription-intervenant':
            const form = document.querySelector('#form');
            form.scrollIntoView();
            break;
        case 'msg-success':
            openNotification(urlParams.get('message'), 'success');
            break;
        case 'msg-error':
            openNotification(urlParams.get('message'), 'error');
            break;
        case 'msg-warning':
            openNotification(urlParams.get('message'), 'warning');
            break;
        case 'msg-info':
            openNotification(urlParams.get('message'), 'info');
            break;
        default:
            openNotification(urlParams.get('message'));
    }
}


let modalHovered = false;
modal.addEventListener('mouseenter', () => {
    modalHovered = true;
});
modal.addEventListener('mouseleave', () => {
    modalHovered = false;
    setNotificationTimeout();
});

function setNotificationTimeout(type) {
    setTimeout(() => {
        if (!modalHovered) {
            modal.classList.remove('--active');
            setTimeout(() => {
                modal.classList.remove('--' + type);
                modalContent.children[0].innerHTML = '';
                removeErrorInURL();
            }, 300);
        }
    }, 5000);
}

function openNotification(content, type = 'info') {
    modal.classList.add('--active');
    modal.classList.add('--' + type);
    modalContent.children[0].innerHTML = content;

    setNotificationTimeout(type);
}



export function removeErrorInURL() {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.delete('message');
    urlParams.delete('c');
    let newUrl = '';
    if (urlParams.toString() === '') {
        newUrl = window.location.pathname;
    } else {
        newUrl = window.location.pathname + '?' + urlParams.toString();
    }
    window.history.pushState({path: newUrl}, '', newUrl);
}

export function addErrorInURL(message, container) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('message', message);
    urlParams.set('c', container);
    let newUrl = '';
    if (urlParams.toString() === '') {
        newUrl = window.location.pathname;
    } else {
        newUrl = window.location.pathname + '?' + urlParams.toString();
    }
    window.history.pushState({path: newUrl}, '', newUrl);
}