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

        function callback(xhr) {
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
// end