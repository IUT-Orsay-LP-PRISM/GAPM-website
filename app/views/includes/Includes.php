<?php

namespace App\Views\Includes;


class Includes
{

    private static $logIcon = "assets/svg/user.svg";
    private static $regIcon = "assets/svg/user_add.svg";

    public static function getHeader($navbarType = null)
    {

        return '<header class="header">
                        <nav class="header__nav ' . $navbarType . '">
                            <ul class="header__menu menu-left">
                                <li class="menu-item"><a href="/" class="--active">Accueil</a></li>
                                <li class="menu-item"><a href="#">Besoin d\'aide ?</a></li>
                                <li class="menu-item"><a href="#">A propos</a></li>
                            </ul>
                                                        <button id="switch" >Change color </button>
                            <ul class="header__menu menu-right">
                                <li class="menu-item"><a id="btn-connexion" href="javascript:void()" class="btn btn-primary-nb">
                                       <i class="icon-w icon-fi-rr-user"></i>
                                       Se connecter
                                    </a></li>
                                <li class="menu-item"><a id="btn-inscription" href="javascript:void()" class="btn btn-secondary-nb">
                                         <i class="icon icon-fi-rr-user-add"></i>
                                        &nbsp;S\'inscrire
                                    </a></li>
                            </ul>
                        </nav>
                    </header>';
    }

    public static function getFooter($userType = "demandeur")
    {
        return '<footer class="footer">
                    <div class="footer__about">
                        <p>A propos de</p>
                        <ul>
                            <li><a href="/">Accueil</a></li>
                            <li><a href="#">Nous contacter</a></li>
                            <li><a href="#">Spécialités</a></li>
                            <li><a href="#">Rechercher un praticien</a></li>
                        </ul>
                    </div>
                    <div class="footer__misc">
                        <p>Divers</p>
                        <ul>
                            <li><a href="#">Besoin d\'aide ?</a ></li >
                            <li ><a href="#">A propos </a ></li >
                            <li ><a href="#">Se connecter </a ></li >
                            <li ><a href="#">S\'inscrire</a></li>
                        </ul>
                    </div>
                    <div class="footer__social">
                        <p>Suivez-nous</p>
                        <ul>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Linkedin</a></li>
                            <li><a href="#">YouTube</a></li>
                        </ul>
                    </div>
                    <div class="footer__access">
                        <p>Accès</p>
                        <ul>
                            <li><a href="#">Mon compte</a></li>
                            <li><a href="#">Devenir praticien</a></li>
                            <li><a href="#">Personnel administratif</a></li>
                            <li><a href="#">Administrateur</a></li>
                        </ul>
                    </div>
                </footer>
                <section class="footer__pre">
                    Projet Sujet 2 G.A.P.M. - M. Gagné • Christopher D, Louis L, Frédéric D., Mathieu M. Valentin, Taisong, Enolah, Joël.
                </section>';
    }
}