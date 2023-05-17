# Projet G.A.P.M.

# ⚠️ À chaque "git pull" + Setup projet ⚠️
- Pensez à faire `composer update` pour mettre à jour les dépendances PHP.
- Réimportez la DB si le fichier a été modifié dernièrement.
- Vérifiez que le fichier **.env.local** est bien présent
- Avoir une version **PHP >= 8.0**
- Si WampServer (xampp, uwamp, ...) faire un **Virtual Host**

## Description
Projet GAPM avancement : **50%**


## Installation
Afin d'installer le projet proprement, il faut **IMPÉRATIVEMENT** suivre les étapes suivantes :

### Cloner le projet
Pour cela, il faut tout d'abord avoir **git** d'installé sur votre machine.
1. Installer [GIT](https://git-scm.com/download/win).
2. Ouvrir un terminal (CMD, PowerShell, Git Bash, etc.).
3. Se placer dans le dossier où vous voulez cloner le projet.
4. Cloner le projet avec la commande suivante :
```bash
git clone https://github.com/IUT-Orsay-LP-PRISM/GAPM-website.git
```

### Installer les dépendances
Le projet utilise principalement **2** gestionnaires de dépendances :
- [Composer](https://getcomposer.org/download/) pour PHP.
- [NPM](https://nodejs.org/download/release/v14.21.1/) pour NodeJS `(ici v14.21.1).`

#### Composer
Composer est le gestionnaire des dépendances de PHP, il va nous permettre d'intégrer directement des bibliothèques dans notre projet. Comme, PHPMailer, un système d'envoi d'email. 

##### Installation de Composer
Aller sur le site de composer (lien plus haut), puis télécharger "Composer-Setup.exe" et l'installer.
Une fois que celui-ci est installé, pensez à redémarrer votre ordinateur.

Lorsque votre installation a été faite, exécutez la commande suivante dans le dossier du projet :
```bash
composer install
```

Faites ce qu'il faut pour l'installation du Virtual Host si vous avez WampServer.
Normalement tout est bon, vous pouvez maintenant lancer le projet. 

### <span style="color:orange;">Attention ⚠️ :</span> 
Cependant, aucune modification du CSS sera possible. 
En effet, pour démarrer le projet il suffit juste d'avoir **Composer**. La suite node.js est nécessaire pour compiler le SCSS en CSS avec Webpack.

### NPM - Node.JS
NPM est le gestionnaire de dépendances de NodeJS, il va nous permettre d'intégrer directement des bibliothèques JavaScript dans notre projet. Les futurs libs de Stats par exemple.

##### Installation de Node.JS
Pour pouvoir utiliser NPM, il faut télécharger NodeJS, il faut aller sur leur site (lien plus haut), puis télécharger le msi (`node-v14.21.1-x64.msi` **ou** `node-v14.21.1-x86.msi`) et l'installer.
Une fois installé, pensez à redémarrer votre PC.

Normalement, tout est bon, NPM ne vous servira uniquement que si vous souhaitez faire du CSS ou du JavaScript, sinon pour seulement du PHP il n'a aucun intérêt.


## Utilisation de NodeJS - Webpack

Après avoir installé NodeJS vous pouvez utiliser Webpack pour compiler les fichiers SCSS et JS.

### Installation de Webpack
```bash
npm install
```

### Compilation des fichiers SCSS et JS
#### Mode dév : Compile un fichier automatiquement à chaque modification
```bash
npm run dev 
```
#### Mode prod : Compile tous les fichiers une seule fois
```bash
npm run build
```