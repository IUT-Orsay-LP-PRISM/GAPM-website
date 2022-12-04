const header = document.querySelector('.header .header__nav');
const banner = document.querySelector('.hp__banner');
const windowHeight = header.offsetHeight;

const btn_connexion = document.querySelector('#btn-connexion');
const btn_inscription = document.getElementById('btn-inscription');
const popUp_connexion = document.querySelector('#popUp-connexion');
const popUp_inscription = document.querySelector('#popUp-inscription');

const btn_cross = document.querySelectorAll('.cross');


window.addEventListener('scroll', () => {
    if (window.scrollY > windowHeight) {
        header.classList.add('down');
        if (banner) {
            header.classList.remove('transparent');
        }
    } else {
        header.classList.remove('down');
        if (banner) {
            header.classList.add('transparent');
        }
    }
});
window.onclick = function (event) {
    if (event.target == popUp_connexion || event.target == popUp_inscription) {
        popUp_connexion.style.display = "none";
        popUp_inscription.style.display = "none";
        document.body.style.overflowY = "auto";
    }
}

btn_connexion.addEventListener('click', () => {
    const style = popUp_connexion.style.display;
    popUp_connexion.style.display = style === "block" ? 'none' : 'block';
    popUp_inscription.style.display = 'none';
    window.scrollTo(0, 0);
    document.body.style.overflowY = style === "block" ? 'auto' : 'hidden';
});

console.log(btn_inscription);
console.log(btn_connexion);

btn_inscription.addEventListener('click', () => {
    const style = popUp_inscription.style.display;
    popUp_inscription.style.display = style === "block" ? 'none' : 'block';
    popUp_connexion.style.display = 'none';
    window.scrollTo(0, 0);
    document.body.style.overflowY = style === "block" ? 'auto' : 'hidden';
});

btn_cross.forEach(btn => btn
    .addEventListener('click', () => {
        popUp_connexion.style.display = 'none';
        popUp_inscription.style.display = 'none';
        document.body.style.overflowY = 'auto';
    }));



