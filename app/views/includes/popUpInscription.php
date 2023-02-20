<section class="popup popup-inscription">
    <i class="cross"></i>

    <section class="popup-container">
        <h1 class="text__underline-light">Inscription</h1>
        <form method="post" action="?action=register-user">
            <p>Vous êtes praticien <a href="?action=inscription-intervenant" class="link">Voir Formulaire</a></p>

            <div class="popup-container-row">
                <div class="input-container">
                    <i class="icon icon-fi-rr-text"></i>
                    <input id="namePopUp" class="input" type="text" name="lastname" required/>
                    <label class="label" for="namePopUp">Votre nom</label>
                </div>
                <div class="input-container">
                    <i class="icon icon-fi-rr-text"></i>
                    <input id="first-namePopUp" class="input" type="text" name="firstname" required/>
                    <label class="label" for="first-namePopUp">Votre Prénom</label>
                </div>
            </div>

            <div class="popup-container-row">
                <div class="input-container">
                    <i class="icon icon-fi-rr-at"></i>
                    <input id="e-mailPopUp" class="input" type="text" name="mail" required/>
                    <label class="label" for="e-mailPopUp">Votre adresse e-mail</label>
                </div>
                <div class="input-container">
                    <i class="icon icon-fi-rr-calendar"></i>
                    <input id="birthdayPopUp" class="input" type="date" name="birthday" required/>
                    <label class="label" for="birthdayPopUp">Votre date de naissance</label>
                </div>
            </div>
            <div class="popup-container-row">
                <div class="input-container">
                    <i class="icon icon-fi-rr-home-location-alt"></i>
                    <input id="adressPopUp" class="input" type="text" name="address" required/>
                    <label class="label" for="adressPopUp">Votre adresse (Numéro, Rue)</label>
                </div>
            </div>
            <div class="popup-container-row">
                <div class="input-container">
                    <i class="icon icon-fi-rr-map-marker"></i>
                    <input id="villePopUp" class="input" type="text" required/>
                    <label class="label" for="villePopUp">Ville</label>
                    <input id="hiddenValueCity" name="city" type="number" hidden="hidden" required/>
                    <div id="auto_completion_ville" class="notVisible"></div>
                </div>
                <div class="input-container">
                    <i class="icon icon-fi-rr-thumbtack"></i>
                    <input id="cpPopUp" class="input" type="text" name="cp" required/>
                    <label class="label" for="cpPopUp">Code postal</label>
                </div>
            </div>
            <div class="popup-container-row">
                <div class="input-container">
                    <i class="icon icon-fi-rr-key"></i>
                    <input id="mdp-inscPopUp" class="input" type="text" name="password" required/>
                    <label class="label" for="mdp-inscPopUp">Votre mot de passe</label>
                </div>
                <div class="input-container">
                    <i class="icon icon-fi-rr-phone-call"></i>
                    <input id="telPopUp" class="input" type="text" name="phone" required/>
                    <label class="label" for="telPopUp">Téléphone portable</label>
                </div>
            </div>
            <button class="btn btn-primary-nb" type="submit">
                <i class="icon-w icon-fi-rr-user-add"></i>
                S'inscrire
            </button>
        </form>
    </section>

</section>