let navbar = document.querySelectorAll('.js-account-nav');
const js_specialite = document.querySelector('.js-specialite');
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

console.log(urlParams);

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
    if(urlParams.has("intervenant")){
        document.querySelector('#intervenant').classList.add('--display');
        document.querySelector('#perso').classList.remove('--display');
        document.querySelector('#intervenant-nav').classList.add('--active');
        document.querySelector('#perso-nav').classList.remove('--active');
    }
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


const vehicule = document.querySelector('#js-vehicule');
if(vehicule) {
    vehicule.addEventListener('change', (e) => {
        const img_vehicule = document.querySelector('#img-vehicule');
        img_vehicule.src = `/assets/img/vehicules/${e.target.value}.png`;
        img_vehicule.alt = e.target.value;
        const nom = e.target.querySelector(':checked');
        const label = document.querySelector('#vehicule-label');
        label.innerHTML = nom.innerHTML;
    });
}


const profilInput = document.querySelector('.myaccount__pfp__input input#picture');
if (profilInput) {
    profilInput.addEventListener('change', previewImage);
}
function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function () {
        const image = new Image();

        image.onload = function() {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            const size = 300;

            canvas.width = size;
            canvas.height = size;

            const imageAspectRatio = image.width / image.height;
            const canvasAspectRatio = canvas.width / canvas.height;
            let renderableWidth, renderableHeight, xStart, yStart;

            if (imageAspectRatio < canvasAspectRatio) {
                renderableWidth = canvas.width;
                renderableHeight = renderableWidth / imageAspectRatio;
                xStart = 0;
                yStart = (canvas.height - renderableHeight) / 2;
            } else if (imageAspectRatio > canvasAspectRatio) {
                renderableHeight = canvas.height;
                renderableWidth = renderableHeight * imageAspectRatio;
                yStart = 0;
                xStart = (canvas.width - renderableWidth) / 2;
            } else {
                renderableHeight = canvas.height;
                renderableWidth = canvas.width;
                xStart = 0;
                yStart = 0;
            }
            context.drawImage(image, xStart, yStart, renderableWidth, renderableHeight);

            const previewOriginal = document.querySelector(".myaccount__pfp__original img#previewOriginal");
            const previewDisplay = document.querySelector(".myaccount__pfp__display img#previewDisplay");
            previewOriginal.src = canvas.toDataURL('image/jpeg');
            previewDisplay.src = canvas.toDataURL('image/jpeg');
        };

        image.src = reader.result;
    };
    reader.readAsDataURL(file);
}
