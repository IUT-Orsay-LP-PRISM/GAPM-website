<?php
require 'vendor/autoload.php';

use App\views\includes\Includes;

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
<body class="bg__secondary intervenant">

<?= Includes::getHeader() ?>

<section class="search__inputs">
    <div class="input-container">
        <i><?php include "assets/svg/zoom-search.svg" ?></i>
        <input id="name" class="input" type="text" required value="Jane Doe"/>
        <label class="label" for="name">Nom, spécialité</label>
    </div>
    <div class="input-container">
        <i><?php include "assets/svg/city.svg" ?></i>
        <input id="city" class="input" type="text" required value="Orsay"/>
        <label class="label" for="city">Ville</label>
    </div>
    <a href="#" class="btn btn-primary-nb">Rechercher</a>
</section>

<section class="search__contents">
    <h2>Résultats pour la recherche : <span class="text__light">"Jane doe, ORL"</span>&nbsp;Ville : <span
                class="text__light">"Orsay"</span></h2>

    <div class="search__contents-list">
        <!-- Bloc foreach de tous les médecins correspondant à la recherche -->
        <div class="search__contents-user">
            <div class="search__contents-user-img">
                <img src="assets/img/profils/exemple_doctor.jpg" alt="User">
            </div>
            <div class="search__contents-user-info">
                <div class="search__contents-user-name">
                    <p class="title">
                        Nom
                    </p>
                    <p class="desc">
                        Jane Doe
                    </p>
                </div>
                <div class="search__contents-user-speciality">
                    <p class="title">
                        Spécialité
                    </p>
                    <p class="desc">
                        ORL
                    </p>
                </div>
                <div class="search__contents-user-city">
                    <p class="title">
                        Ville
                    </p>
                    <p class="desc">
                        Orsay, 91400
                    </p>
                </div>
            </div>
            <div class="search__contents-user-btn">
                <a href="#" class="btn btn-primary">
                    <?php include "assets/svg/plus_small_white.svg" ?>&nbsp;
                    Prendre rendez-vous</a>
            </div>
        </div>
        <div class="search__contents-user">
            <div class="search__contents-user-img">
                <img src="assets/img/profils/exemple_doctor_2.jpg" alt="User">
            </div>
            <div class="search__contents-user-info">
                <div class="search__contents-user-name">
                    <p class="title">
                        Nom
                    </p>
                    <p class="desc">
                        Jon Doe
                    </p>
                </div>
                <div class="search__contents-user-speciality">
                    <p class="title">
                        Spécialité
                    </p>
                    <p class="desc">
                        ORL
                    </p>
                </div>
                <div class="search__contents-user-city">
                    <p class="title">
                        Ville
                    </p>
                    <p class="desc">
                        Gif-Sur-Yvette, 91190
                    </p>
                </div>
            </div>
            <div class="search__contents-user-btn">
                <a href="#" class="btn btn-primary">
                    <?php include "assets/svg/plus_small_white.svg" ?>&nbsp;
                    Prendre rendez-vous</a>
            </div>
        </div>
        <div class="search__contents-user">
            <div class="search__contents-user-img">
                <img src="assets/img/profils/example_doctor_3.jpg" alt="User">
            </div>
            <div class="search__contents-user-info">
                <div class="search__contents-user-name">
                    <p class="title">
                        Nom
                    </p>
                    <p class="desc">
                        Jacqueline Test
                    </p>
                </div>
                <div class="search__contents-user-speciality">
                    <p class="title">
                        Spécialité
                    </p>
                    <p class="desc">
                        ORL
                    </p>
                </div>
                <div class="search__contents-user-city">
                    <p class="title">
                        Ville
                    </p>
                    <p class="desc">
                        Saclay, 9400
                    </p>
                </div>
            </div>
            <div class="search__contents-user-btn">
                <a href="#" class="btn btn-primary">
                    <?php include "assets/svg/plus_small_white.svg" ?>&nbsp;
                    Prendre rendez-vous</a>
            </div>
        </div>
        <div class="search__contents-user">
            <div class="search__contents-user-img">
                <img src="assets/img/profils/exemple_docto_4r.jpg" alt="User">
            </div>
            <div class="search__contents-user-info">
                <div class="search__contents-user-name">
                    <p class="title">
                        Nom
                    </p>
                    <p class="desc">
                        Stanislas De La Roche
                    </p>
                </div>
                <div class="search__contents-user-speciality">
                    <p class="title">
                        Spécialité
                    </p>
                    <p class="desc">
                        ORL
                    </p>
                </div>
                <div class="search__contents-user-city">
                    <p class="title">
                        Ville
                    </p>
                    <p class="desc">
                        Saclay, 9400
                    </p>
                </div>
            </div>
            <div class="search__contents-user-btn">
                <a href="#" class="btn btn-primary">
                    <?php include "assets/svg/plus_small_white.svg" ?>&nbsp;
                    Prendre rendez-vous</a>
            </div>
        </div>
    </div>
</section>
<i id="popUp-connexion"><?php include "app/views/includes/popUpConnexion.php"; ?></i>
<i id="popUp-inscription"><?php include "app/views/includes/popUpInscription.php"; ?></i>
<?= Includes::getFooter() ?>

<script src="assets/prod/js/main.min.js"></script>
</body>
</html>