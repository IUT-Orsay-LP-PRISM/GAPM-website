let navbar = document.querySelectorAll('.js-rdv-nav');

if (navbar.length){
    navbar.forEach((element) => {
        element.addEventListener('click', (el) => {
            document.querySelector('.js-rdv-nav.--active').classList.remove('--active');
            document.querySelector('.js-rdv-content.--display').classList.remove('--display');
            el.target.classList.add('--active');
            document.querySelector('.js-rdv-content[id=' + el.target.dataset.id + ']').classList.add('--display');
        });
    });
}