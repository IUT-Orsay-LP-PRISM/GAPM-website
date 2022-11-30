<?php
require 'vendor/autoload.php';

?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="assets/prod/css/main.min.css">
        <title>Page d'accueil • GAPM</title>
    </head>
    <body>
        <header class="header">
            <nav class="header__nav down">
                <ul class="header__menu menu-left">
                    <li class="menu-item"><a href="#">Accueil</a></li>
                    <li class="menu-item"><a href="#">Besoin d'aide ?</a></li>
                    <li class="menu-item"><a href="#">A propos</a></li>
                </ul>
                <ul class="header__menu menu-right">
                    <li class="menu-item"><a href="#" class="btn btn-primary-nb">
                            <?php include "assets/svg/user.svg" ?>&nbsp;Se
                            connecter
                        </a></li>
                    <li class="menu-item"><a href="#" class="btn btn-secondary-nb">
                            <?php include "assets/svg/user_add.svg" ?>
                            &nbsp;S'inscrire
                        </a></li>
                </ul>
            </nav>
        </header>

        <section class="hp__banner">
            <img src="assets/img/banner_gradient.png" alt="Banner">

            <section class="hp__banner-text">
                <section class="hp__banner-title">
                    <h1 class="text__underline">G.A.P.M</h1>
                    <p>
                        Rechercher un prestataire<br>
                        <span class="text__underline">correspondant à vos besoins.</span>
                    </p>
                    <section class="hp__banner-inputs">
                        <div class="hp__banner-inputs-list">
                            <div class="input-container">
                                <i><?php include "assets/svg/zoom-search.svg" ?></i>
                                <input id="name" class="input" type="text" required/>
                                <label class="label" for="name">Nom, spécialité</label>
                            </div>
                            <div class="input-container">
                                <i><?php include "assets/svg/city.svg" ?></i>
                                <input id="city" class="input" type="text" required/>
                                <label class="label" for="city">Ville</label>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary-nb">Rechercher</a>

                    </section>
                </section>
                <section class="hp__banner-img">
                    <?php include "assets/svg/illu_banner.svg " ?>
                </section>
            </section>
        </section>

        <section class="hp__content">
            <!-- TODO: Faire le contenu : img - texte en grid ou flex, plus les pilules en absolute : le footer pour finir -->
        </section>
    </body>
</html>
