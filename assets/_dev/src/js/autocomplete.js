// auto_completion specialite inscription intervenant
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

        function callback(xhr) {
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
// end


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
            data.forEach(element => {
                const p = document.createElement('p');
                p.classList.add('AC_ville');
                p.innerHTML = element.nom.toUpperCase();
                div_auto_complete.appendChild(p);
                p.addEventListener('click', () => {
                    input.value = '';
                    input.value = element.nom.toUpperCase();

                    const span = input.parentNode.querySelector('span.code_postal')
                    if (span !== null) {
                        span.innerHTML = element.code_postal;
                    }
                    div_auto_complete.classList.add('notVisible');
                });
            });
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