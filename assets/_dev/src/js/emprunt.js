let navbar = document.querySelectorAll('.js-emprunt-nav');

if (navbar.length) {
    navbar.forEach((element) => {
        element.addEventListener('click', (el) => {
            document.querySelector('.js-emprunt-nav.--active').classList.remove('--active');
            document.querySelector('.js-emprunt-content.--display').classList.remove('--display');
            el.target.classList.add('--active');
            document.querySelector('.js-emprunt-content[id=' + el.target.dataset.id + ']').classList.add('--display');
        });
    });
}