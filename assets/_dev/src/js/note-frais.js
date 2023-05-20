const sidebar_container = document.querySelector('#sidebar-add-depense');
const sidebar = document.querySelector('#sidebar-add-depense--content');
const btn_create = document.querySelector('.notefrais button#create');
const selectNature = document.querySelector('#nature.sidebar-add-depense-row__content--input');
const urlJustificatifInput = document.getElementById('urlJustificatif');
import {addMessageInURL} from "./notification.js";

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
        if (target.classList.contains('icon-fi-rr-trash') || target.classList.contains('notefrais__table__content--Adeclarer__checkbox')) {
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
            if (depense.urlJustificatif) {
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


const btn_prepare = document.querySelector('.notefrais button#prepare');
const checkbox_total = document.querySelector('.notefrais-checkbox.--total');
const checkboxs = document.querySelectorAll('.notefrais-checkbox:not(.--total)');
const lbl_total = document.querySelector('.notefrais div#lbl-total');

if (btn_prepare) {
    btn_prepare.addEventListener('click', () => {
        if (!btn_prepare.classList.contains('--active')) {
            checkbox_total.checked = true;
            checkboxs.forEach(checkbox => {
                checkbox.checked = true;
            });
            changeTextButton();
            btn_prepare.classList.add('--active');
        } else {
            const checkboxs_checked = [...checkboxs].filter(checkbox => checkbox.checked);

            if (checkboxs_checked.length != 0) {
                const arrayIds = checkboxs_checked.map(checkbox => checkbox.dataset.id);

                const xhr = new XMLHttpRequest();
                const url = '/?action=prepare-depenses';
                xhr.open("POST", url, false);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = () => callback(xhr);
                xhr.send(`arrayIds=${arrayIds}`);

                function callback(xhr) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            addMessageInURL('Note de frais préparée avec succès', 'msg-success');
                        } else {
                            addMessageInURL('Erreur lors de la préparation de la note de frais', 'msg-error');
                        }
                    } else {
                        addMessageInURL('Erreur lors de la préparation de la note de frais', 'msg-error');
                    }
                    window.location.reload();
                }
            }
        }
    });
}

if (checkbox_total) {
    checkbox_total.addEventListener('change', () => {
        checkboxs.forEach(checkbox => {
            checkbox.checked = checkbox_total.checked;
        });
        changeTextButton();
    });
}

if (checkboxs.length > 0) {
    checkboxs.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (!checkbox.checked) {
                checkbox_total.checked = [...checkboxs].some(checkbox => checkbox.checked);
            } else {
                checkbox_total.checked = true;
            }
            changeTextButton();
        });
    });
}

function changeTextButton() {
    const nbChecked = [...checkboxs].filter(checkbox => checkbox.checked).length;
    const container = lbl_total.querySelector('.notefrais__row--total');
    const value_selected = container.querySelector('#value-selected');

    if (nbChecked > 0) {
        const txt = nbChecked > 1 ? 'les dépenses' : 'la dépense';
        btn_prepare.innerHTML = 'Déclarer ' + txt;

        const total = [...checkboxs].filter(checkbox => checkbox.checked).reduce((acc, checkbox) => {
            const montant = parseFloat(checkbox.dataset.montant);
            return acc + montant;
        }, 0);

        const txt_total = total % 1 === 0 ? total.toFixed(0) + ' €' : total.toFixed(2) + ' €';
        container.querySelector('p').innerHTML = "Total sélectionné";
        value_selected.innerHTML = txt_total;
        container.querySelector('#value-total').style.display = 'none';
        value_selected.style.display = 'block';

        btn_prepare.classList.add('--active');
    } else {
        btn_prepare.innerHTML = 'Préparer la note de frais';
        if (btn_prepare.classList.contains('--active')) {
            btn_prepare.classList.remove('--active');
        }

        container.querySelector('p').innerHTML = "Total des dépenses";
        value_selected.innerHTML = '';
        container.querySelector('#value-total').style.display = 'block';
        value_selected.style.display = 'none';
    }
}

