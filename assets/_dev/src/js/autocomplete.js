// auto_completion specialite inscription intervenant
const Ac_input_specialite = document.querySelectorAll('.AC.input_specialite');
if(Ac_input_specialite) {
    Ac_input_specialite.forEach(input => {
        const div_auto_complete = input.parentNode.querySelector('.auto_completion');
        input.addEventListener('keyup', () => {
            ajaxSpecialite(div_auto_complete, input);
        });
        input.addEventListener('focus', () => {
            ajaxSpecialite(div_auto_complete, input);
        });
    });
}

// auto_completion villes
const AC_input_ville = document.querySelectorAll('.AC.input_ville');
if (AC_input_ville) {
    AC_input_ville.forEach(input => {
        const div_auto_complete = input.parentNode.querySelector('.auto_completion');
        input.addEventListener('keyup', () => {
            ajaxVille(div_auto_complete, input);
        });
        input.addEventListener('focus', () => {
            ajaxVille(div_auto_complete, input);
        });
    });
}


function ajaxSpecialite(div_auto_complete,input) {
    const xhr = new XMLHttpRequest();
    const url = "?action=autocompleteSpecialite&query=" + input.value;
    xhr.open("GET", url, true);
    xhr.onload = () => callback(xhr);
    xhr.send();

    function callback(xhr) {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            div_auto_complete.innerHTML = '';

            if (data.length === 0) {
                const p = document.createElement('p');
                p.innerHTML = 'Aucune spécialité trouvée';
                p.classList.add('AC_specialite');
                div_auto_complete.appendChild(p);
            } else {
                const tag_container = document.querySelector('#tag-container .container');
                data.forEach(element => {
                    const p = document.createElement('p');
                    p.classList.add('AC_specialite');
                    p.innerHTML = element.libelle.toUpperCase();
                    // if tag exist in tag_container don't add it
                    if (tag_container.querySelector(`[data-id="${element.idSpecialite}"]`)) {
                        return;
                    } else {
                        div_auto_complete.appendChild(p);
                    }

                    p.addEventListener('click', () => {
                        tag_container.appendChild(createTag(element.libelle.toUpperCase(), element.idSpecialite));
                        const input_specialites_hidden = input.parentNode.querySelector('input[name="specialites"]');
                        if (input_specialites_hidden) {
                            const value = input_specialites_hidden.value;
                            if (value === 'null') {
                                input_specialites_hidden.value = element.idSpecialite;
                            } else {
                                input_specialites_hidden.value = value + '-' + element.idSpecialite;
                            }
                        }
                        input.value = '';
                        div_auto_complete.classList.add('notVisible');
                    });
                });
            }
        }
    }

    // if input is not focused && input is not empty => show auto_completion
    if (input.value.length < 1 && input !== document.activeElement) {
        div_auto_complete.classList.add('notVisible');
    } else {
        div_auto_complete.classList.remove('notVisible');
    }

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
// end



function ajaxVille(div_auto_complete, input) {
    const xhr = new XMLHttpRequest();
    const url = "?action=autocompleteVille&query=" + input.value;
    xhr.open("GET", url, true);
    xhr.onload = () => callback(xhr);
    xhr.send();

    function callback(xhr) {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            div_auto_complete.innerHTML = '';
            if (data.length === 0) {
                const p = document.createElement('p');
                p.innerHTML = 'Aucune ville trouvée';
                p.classList.add('AC_ville');
                div_auto_complete.appendChild(p);
            } else {
                data.forEach(element => {
                    const p = document.createElement('p');
                    p.classList.add('AC_ville');
                    p.innerHTML = element.nom.toUpperCase() + ` (${element.code_postal})`;
                    div_auto_complete.appendChild(p);
                    p.addEventListener('click', () => {
                        input.value = '';
                        input.value = element.nom.toUpperCase();
                        const span = input.parentNode.querySelector('span.code_postal')
                        span ? span.innerHTML = element.code_postal : null;

                        const input_city_hidden = input.parentNode.querySelector('input[name="city"]') || input.parentNode.querySelector('input[name="cityPro"]');
                        input_city_hidden ? input_city_hidden.value = element.idVille : null;
                        div_auto_complete.classList.add('notVisible');
                    });
                });
            }
        }
    }

    // if input is not focused && input is not empty => show auto_completion
    if (input.value.length < 1 && input !== document.activeElement) {
        div_auto_complete.classList.add('notVisible');
    } else {
        div_auto_complete.classList.remove('notVisible');
    }
}
// end