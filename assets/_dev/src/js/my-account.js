let navbar = document.querySelectorAll('.js-account-nav');

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