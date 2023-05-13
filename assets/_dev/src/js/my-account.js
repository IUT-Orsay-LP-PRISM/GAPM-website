let navbar = document.querySelectorAll('.js-account-nav');
const js_specialite = document.querySelector('.js-specialite');

if (navbar.length){
    navbar.forEach((element) => {
        element.addEventListener('click', (event) => {
            event.preventDefault();
            document.querySelector('.js-account-nav.--active').classList.remove('--active');
            document.querySelector('.js-account-content.--display').classList.remove('--display');
            document.querySelector(event.target.getAttribute('href')).classList.add('--display');
            event.target.classList.add('--active');
        });
    });
}

if(js_specialite) {
    js_specialite.querySelectorAll('.tag').forEach((element) => {
        element.querySelector('.tag-close').addEventListener('click', (e) => {
            e.preventDefault();
            element.remove();

            const input_specialites_hidden = document.querySelector("#hiddenValueSpecialites")
            if (input_specialites_hidden) {
                const value = input_specialites_hidden.value;
                const id = element.dataset.id;
                const regexString = id.indexOf('-') === -1 ? `${id}-|${id}` : `-${id}`;
                const regex = new RegExp(regexString, 'g');
                const newValue = value.replace(regex, '');
                input_specialites_hidden.value = newValue === '' ? 'null' : newValue;
            }
        });
    });
}