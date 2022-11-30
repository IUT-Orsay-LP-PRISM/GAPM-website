<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Composants</title>
</head>
<body>

<h1 style="margin: 15px">Boutons</h1>
<div class="list">
    <a href="#" class="btn btn-primary">btn-primary</a>
    <a href="#" class="btn btn-primary-nb">btn-primary-nb</a>
    <a href="#" class="btn btn-secondary">btn-secondary</a>
    <a href="#" class="btn btn-secondary-nb">btn-secondary-nb</a>
</div>

<h1 style="margin: 15px">Boutons avec icônes</h1>
<div class="list">
    <a href="#" class="btn btn-primary"><?php include "assets/svg/list.svg" ?>&nbsp;A propos</a>
    <a href="#" class="btn btn-primary-nb"><?php include "assets/svg/user.svg" ?>&nbsp;Se connecter</a>
    <a href="#" class="btn btn-secondary"><?php include "assets/svg/medic.svg" ?>&nbsp;Besoin d'aide ?</a>
    <a href="#" class="btn btn-secondary-nb"><?php include "assets/svg/user_add.svg" ?>&nbsp;S'inscrire</a>
</div>

<h1 style="margin: 15px">Input</h1>
<div class="list">
    <div class="input-container">
        <i><?php include "assets/svg/text_input.svg" ?></i>
        <input id="name" class="input" type="text" required/>
        <label class="label" for="name">Nom</label>
    </div>
</div>
<script src="assets/prod/css/main.min.css"></script>
</body>
</html>