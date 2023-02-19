<section class="popup">
    <i class="cross"></i>

    <section class="popup-container">
        <h1 class="text__underline-light">Connexion</h1>
        <form method="post" action="?action=loginUser">
            <p>Vous n'avez pas de compte ? <a class="link" id="openPopUpInsc">Inscrivez-vous .</a></p>
            <div class="popup-container-col">
                <div class="input-container">
                    <i class="icon icon-fi-rr-at"></i>
                    <input id="loginPopUp" name="login" class="input" type="text" required/>
                    <label class="label" for="loginPopUp">Votre adresse e-mail</label>
                </div>
                <div class="input-container">
                    <i class="icon icon-fi-rr-key"></i>
                    <input id="mdpPopUp" name="password" class="input" type="password" required/>
                    <label class="label" for="mdpPopUp">Votre mot de passe</label>
                </div>
            </div>
            <p class="italic">Mots de passe oublié ? Cliquez <a class="link">ici</a></p>

            <input class="btn btn-primary-nb" type="submit" value="Se connecter">
        </form>
    </section>

</section>