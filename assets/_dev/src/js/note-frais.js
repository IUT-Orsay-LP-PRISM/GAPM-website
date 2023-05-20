const sidebar_container = document.querySelector('#sidebar-add-depense');
const sidebar = document.querySelector('#sidebar-add-depense--content');
const btn_create = document.querySelector('.notefrais button#create');
const selectNature = document.querySelector('#nature.sidebar-add-depense-row__content--input');
const urlJustificatifInput = document.getElementById('urlJustificatif');

if (sidebar) {
    const btn_close = sidebar.querySelectorAll('.close-btn');
    btn_close.forEach(btn => {
        btn.addEventListener('click', () => {
            closeSidebar();
        });
    });
}

if (btn_create) {
    btn_create.addEventListener('click', () => {
        openSidebar();
    });
}

if (urlJustificatifInput) {
    urlJustificatifInput.addEventListener('change', previewImage);
}


window.addEventListener('click', (e) => {
        if (sidebar_container && sidebar_container.style.visibility === "visible" && e.target === sidebar_container && e.target !== sidebar && e.target !== btn_create) {
            closeSidebar();
        }
    }
)

function openSidebar() {
    sidebar_container.style.visibility = "visible";
    sidebar_container.style.opacity = "1";
    sidebar.style.right = "0";
}

function closeSidebar() {
    sidebar_container.style.visibility = "hidden";
    sidebar_container.style.opacity = "0";
    sidebar.style.right = "-60%";
    const form = document.querySelector('#sidebar-add-depense--content__form');
    const preview = document.getElementById('preview');
    const content = preview.parentElement.parentElement.querySelector('.justificatif--content__container');
    form.reset();
    form.action = `?action=add-depense`;
    form.querySelector('#sidebar-add-depense--content__form--btnSubmit__row > button > p').innerHTML = 'Enregistrer la dépense'
    preview.src = "#";
    preview.parentElement.style.display = 'none';
    content.style.display = 'block';
}

if (selectNature) {
    selectNature.addEventListener('change', () => {
        const title = document.querySelector('#sidebar-add-depense--content__form--title > p');
        const selectedOption = selectNature.options[selectNature.selectedIndex].innerHTML;
        title.innerHTML = selectedOption
    });
}

const depenses = document.querySelectorAll('.notefrais__table__content--Adeclarer, .notefrais__table__content--Atraiter');

depenses.forEach(depense => {
    depense.addEventListener('click', (event) => {
        const target = event.target;
        if (target.classList.contains('icon-fi-rr-trash')) {
            event.stopPropagation(); // Arrête la propagation de l'événement
        } else {
            const id = depense.dataset.id;
            const form = document.querySelector('#sidebar-add-depense--content__form');
            form.action = `?action=edit-depense&idDepense=${id}`;
            ajaxEditDepense(id);
        }
    });
});


function ajaxEditDepense(depenseId) {
    const xhr = new XMLHttpRequest();
    const url = '/?action=get-depense&idDepense=' + depenseId;
    xhr.open("GET", url, false);
    xhr.onload = () => callback(xhr);
    xhr.send();

    function callback(xhr) {
        if (xhr.status === 200) {
            const depense = JSON.parse(xhr.responseText);
            const form = document.querySelector('#sidebar-add-depense--content__form');

            const select = form.querySelector('#nature')
            const optionSelected = depense.nature;
            Array.from(select.options).forEach(option => {
                if (option.value === optionSelected) {
                    option.selected = true;
                }
            });

            form.querySelector('#datePaiement').value = depense.datePaiement;
            form.querySelector('#montant').value = depense.montant;
            form.querySelector('#fournisseur').value = depense.fournisseur;
            form.querySelector('#commentaire').value = depense.commentaire;
            form.querySelector('#sidebar-add-depense--content__form--btnSubmit__row > button > p').innerHTML = 'Modifier la dépense'

            const preview = form.querySelector('#preview');
            if(depense.urlJustificatif) {
                preview.src = depense.urlJustificatif;
                preview.parentElement.style.display = 'flex';
                preview.parentElement.parentElement.querySelector('.justificatif--content__container').style.display = 'none';
            } else {
                preview.parentElement.style.display = 'none';
                preview.parentElement.parentElement.querySelector('.justificatif--content__container').style.display = 'block';
            }

            openSidebar();
        } else {
            console.log('Erreur');
        }
    }
}

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.parentElement.style.display = 'flex';

        const content = preview.parentElement.parentElement.querySelector('.justificatif--content__container');
        content.style.display = 'none';
    }
    reader.readAsDataURL(event.target.files[0]);
}

