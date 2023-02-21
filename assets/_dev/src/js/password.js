const eyes_icon = document.querySelectorAll('.js-iconEyePassword');
eyes_icon.forEach((eye) => {
    eye.addEventListener('click', () => {
        PassShowHide(eye);
    });
});

function PassShowHide(eye){
    const input = eye.parentElement.querySelector('input');
    if(input.type == 'password'){
        input.type = 'text';
        eye.classList.remove('icon-fi-rr-eye-crossed');
        eye.classList.add('icon-fi-rr-eye');
    } else {
        input.type = 'password';
        eye.classList.add('icon-fi-rr-eye-crossed');
        eye.classList.remove('icon-fi-rr-eye');
    }
}