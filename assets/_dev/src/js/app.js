const header = document.querySelector('.header .header__nav');
const banner = document.querySelector('.hp__banner');
const windowHeight = header ? header.offsetHeight : 0;

const btn_connexion = document.querySelector('#btn-connexion');
const btn_inscription = document.getElementById('btn-inscription');
const popUp_connexion = document.querySelector('#popUp-connexion');
const popUp_inscription = document.querySelector('#popUp-inscription');

const btn_cross = document.querySelectorAll('.cross');
const openPopUpInsc = document.querySelector('#openPopUpInsc');

if (document.querySelector('.demandeur.home') && window.scrollY === 0 && header) {
    header.classList.add('transparent');
} else if (document.querySelector('.demandeur.home')) {
    header.classList.add('down');
}

window.addEventListener('load', function () {
    document.querySelector('#loader').classList.add('--hidden');
});

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
}

window.onclick = function (event) {
    if (event.target == popUp_connexion || event.target == popUp_inscription) {
        popUp_connexion.classList.remove('visible');
        popUp_inscription.classList.remove('visible');
        document.body.style.overflowY = "auto";
        removeErrorInURL();
        document.querySelector('#popUp-connexion .error').innerHTML = '';
    }
}

if (btn_connexion && btn_inscription) {
    btn_connexion.addEventListener('click', () => {
        openPopUpConnexion();
    });

    btn_inscription.addEventListener('click', () => {
        openPopUpInscription();
    });
}

openPopUpInsc.addEventListener('click', () => {
    openPopUpInscription();
});

btn_cross.forEach(btn => btn
    .addEventListener('click', () => {
        popUp_connexion.classList.remove('visible');
        popUp_inscription.classList.remove('visible');
        document.body.style.overflowY = "auto";
        removeErrorInURL();
        document.querySelector('#popUp-connexion .error').innerHTML = '';
    }));

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


const auto_completion = document.querySelector('#auto_completion');
const specialite_input = document.querySelector('#specialite');
const tag_container = document.querySelector('#tag-container .container');
if (specialite_input && auto_completion) {
    specialite_input.addEventListener('keyup', () => {

        const xhr = new XMLHttpRequest();
        const url = "?action=autocompleteService&query=" + specialite_input.value;
        xhr.open("GET", url, true);
        xhr.onload = () => callback(xhr);
        xhr.send();

        callback = (xhr) => {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                auto_completion.innerHTML = '';
                data.forEach(element => {
                    const p = document.createElement('p');
                    p.innerHTML = element.libelle.toUpperCase();
                    // if tag exist in tag_container don't add it
                    if (tag_container.querySelector(`[data-id="${element.id_service}"]`)) {
                        return;
                    } else {
                        auto_completion.appendChild(p);
                    }

                    p.addEventListener('click', () => {
                        tag_container.appendChild(createTag(element.libelle.toUpperCase(), element.id_service));
                        specialite_input.value = '';
                        auto_completion.classList.add('notVisible');
                    });
                });
            }
        }

        if (specialite_input.value.length < 1) {
            auto_completion.classList.add('notVisible');
        } else {
            auto_completion.classList.remove('notVisible');
        }
    });

    function createTag(text, id) {
        const tag = document.createElement("div");
        tag.className = "tag";
        tag.dataset.id = id;
        tag.innerHTML = `<span class="tag-text">${text}</span><i class="icon icon-fi-rr-cross-small tag-close"></i>`;
        const closeBtn = tag.querySelector(".tag-close");
        closeBtn.addEventListener("click", () => tag.remove());
        return tag;
    }
}

function removeErrorInURL(){
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.delete('error');
    const newUrl = window.location.pathname + '?' + urlParams.toString();
    window.history.pushState({path: newUrl}, '', newUrl);
}

function addErrorInURL(msg){
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('error', msg);
    const newUrl = window.location.pathname + '?' + urlParams.toString();
    window.history.pushState({path: newUrl}, '', newUrl);
}

if (document.querySelector('.demandeur.home') && window.location.search.includes('error')) {
    openPopUpConnexion();
}




// auto_completion popup inscription

const input_villePopUp = document.querySelector('#villePopUp');
const auto_completion_ville = document.querySelector('#auto_completion_ville');
const input_cpPopUp = document.querySelector('#cpPopUp');
const input_hidden_value_ville = document.querySelector('#hiddenValueCity');

if (input_villePopUp && auto_completion_ville) {
    input_villePopUp.addEventListener('keyup', () => {
        const xhr = new XMLHttpRequest();
        const url = "?action=autocompleteVille&query=" + input_villePopUp.value;
        xhr.open("GET", url, true);
        xhr.onload = () => callback(xhr);
        xhr.send();

        callback = (xhr) => {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                auto_completion_ville.innerHTML = '';
                data.forEach(element => {
                    const p = document.createElement('p');
                    p.innerHTML = element.nom.toUpperCase();
                    auto_completion_ville.appendChild(p);
                    p.addEventListener('click', () => {
                        input_villePopUp.value = '';
                        input_villePopUp.value = element.nom.toUpperCase();
                        input_hidden_value_ville.value = element.id_ville;
                        input_cpPopUp.value = element.code_postal;
                        auto_completion_ville.classList.add('notVisible');
                    });
                });
            }
        }

        if (input_villePopUp.value.length < 1) {
            auto_completion_ville.classList.add('notVisible');
        } else {
            auto_completion_ville.classList.remove('notVisible');
        }
    });
}