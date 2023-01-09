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
<body class="bg__secondary demandeur">

<?= Includes::getHeader() ?>

<form method="get">
    <section class="search__inputs">
        <input type="hidden" name="action" value="search">
        <div class="input-container">
            <i class="icon icon-fi-rr-search"></i>
            <input id="name" class="input" name="s_name" type="text" required value="<?php if (isset($nom)) {
                echo $nom;
            } ?>"/>
            <label class="label" for="name">Nom, spécialité</label>
        </div>
        <div class="input-container">
            <i class="icon icon-fi-rr-map-marker"></i>
            <input id="city" class="input" name="s_city" type="text" required value="<?php if (isset($city)) {
                echo $city;
            } ?>"/>
            <label class="label" for="city">Ville</label>
        </div>
        <button type="submit" class="btn btn-primary-nb">Rechercher</button>
    </section>
</form>

<section class="search__contents">
    <h2>Résultats pour la recherche : <span class="text__light">"<?= $nom ?>"</span>&nbsp;Ville : <span
                class="text__light">"<?= $city ?>"</span></h2>

    <div class="search__contents-list">
        <?php if (!empty($demandeursRecherches)) { ?>
            <?php foreach ($demandeursRecherches as $unDemandeur) { ?>
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
                                <?= $unDemandeur->getNom() . " " . $unDemandeur->getPrenom() ?>
                            </p>
                        </div>
                        <div class="search__contents-user-speciality">
                            <p class="title">
                                Spécialité
                            </p>
                            <p class="desc">
                                <?= $unDemandeur->getTelephone() ?>
                            </p>
                        </div>
                        <div class="search__contents-user-city">
                            <p class="title">
                                Ville
                            </p>
                            <p class="desc">
                                <?= $unDemandeur->getAdresse() ?>
                            </p>
                        </div>
                    </div>
                    <div class="search__contents-user-btn">
                        <a href="#" class="btn btn-primary">
                            <?php include "assets/svg/plus_small_white.svg" ?>&nbsp;
                            Prendre rendez-vous</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else {
            echo "<p>Aucun médecin trouvé avec les champs données !</p>";
        }
        ?>
    </div>
</section>
<i id="popUp-connexion"><?php include "app/views/includes/popUpConnexion.php"; ?></i>
<i id="popUp-inscription"><?php include "app/views/includes/popUpInscription.php"; ?></i>
<?= Includes::getFooter() ?>

<script src="assets/prod/js/main.min.js"></script>
</body>
</html>