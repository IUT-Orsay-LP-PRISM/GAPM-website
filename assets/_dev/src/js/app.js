import './header'
import './popUp'
import './autocomplete'

window.addEventListener('load', function () {
    document.querySelector('#loader').classList.add('--hidden');
});

const eyeConnexion = document.getElementById('eyeConnexion');
const eyeInscription = document.getElementById('eyeInscription');
eyeConnexion.addEventListener('click', () => {
    connectPassShowHide();
});

eyeInscription.addEventListener('click', () => {
    inscriptPassShowHide();
});


function inscriptPassShowHide(){
    let mdp = document.getElementById("mdp-inscPopUp");
    
    if(mdp.type == 'password'){
        mdp.type = 'text';
        eyeInscription.classList.remove('icon-fi-rr-eye-crossed');
        eyeInscription.classList.add('icon-fi-rr-eye');
    }
    else{
        mdp.type = 'password';
        eyeInscription.classList.add('icon-fi-rr-eye-crossed');
        eyeInscription.classList.remove('icon-fi-rr-eye');
    }
}

function connectPassShowHide(){
    let mdp = document.getElementById("mdpPopUp");
    
    if(mdp.type == 'password'){
        mdp.type = 'text';
        eyeConnexion.classList.remove('icon-fi-rr-eye-crossed');
        eyeConnexion.classList.add('icon-fi-rr-eye');
    }
    else{
        mdp.type = 'password';
        eyeConnexion.classList.add('icon-fi-rr-eye-crossed');
        eyeConnexion.classList.remove('icon-fi-rr-eye');
    }
}