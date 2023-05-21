let navbar = document.querySelectorAll('.js-account-nav');
const js_specialite = document.querySelector('.js-specialite');
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);


if (navbar.length) {
    navbar.forEach((element) => {
        element.addEventListener('click', (event) => {
            event.preventDefault();
            document.querySelector('.js-account-nav.--active').classList.remove('--active');
            document.querySelector('.js-account-content.--display').classList.remove('--display');
            document.querySelector(event.target.getAttribute('href')).classList.add('--display');
            event.target.classList.add('--active');
        });
    });


    if (urlParams.has("nav") && urlParams.get("nav") !== '') {
        const oldActive = document.querySelector('.js-account-nav.--active');
        const oldDisplay = document.querySelector('.js-account-content.--display');
        const newActive = document.querySelector('#' + urlParams.get("nav") + '-nav');
        const newDisplay = document.querySelector('#' + urlParams.get("nav"));

        if (newActive && newDisplay && oldActive && oldDisplay) {
            //remove old active and display
            oldActive.classList.remove('--active');
            oldDisplay.classList.remove('--display');

            //add new active and display
            newActive.classList.add('--active');
            newDisplay.classList.add('--display');
        } else {
            // out of condition => remove param
            urlParams.delete("nav");
            window.history.replaceState({}, '', `${location.pathname}?${urlParams}`);
        }
    }
}

if (js_specialite) {
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
if (vehicule) {
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

        image.onload = function () {
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
