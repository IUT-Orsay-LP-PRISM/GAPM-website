const sidebar_container = document.querySelector('#sidebar-add-depense');
const sidebar = document.querySelector('#sidebar-add-depense--content');
const btn_create = document.querySelector('.noteFrais button#create');
const selectNature = document.querySelector('#nature.sidebar-add-depense-row__content--input');
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

window.addEventListener('click', (e) => {
        if (sidebar_container.style.visibility === "visible" && e.target === sidebar_container && e.target !== sidebar && e.target !== btn_create) {
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
    form.reset();
}

if (selectNature) {
    selectNature.addEventListener('change', () => {
        const title = document.querySelector('#sidebar-add-depense--content__form--title > p');
        const selectedOption = selectNature.options[selectNature.selectedIndex].innerHTML;
        title.innerHTML = selectedOption
    });
}