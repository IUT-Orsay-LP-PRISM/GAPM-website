const btn_RDVS = document.querySelectorAll('.js-btn-RDV');

if (btn_RDVS) {
    btn_RDVS.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const idDemandeur = btn.getAttribute('data-id');
            const isLogged = document.body.getAttribute('data-log');
            if (isLogged != 1) {
                const currentUrl = window.location.href;
                const currentQueryString = window.location.search;
                const newUrl = currentQueryString + '&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion';
                window.location.href = newUrl;
            } else{
                console.log(idDemandeur);
                console.log(isLogged);
            }
        });
    });
}
