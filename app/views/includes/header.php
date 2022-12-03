<?php

namespace App\Views\Includes;


class Header {

    private static $logIcon = "assets/svg/user.svg";
    private static $regIcon = "assets/svg/user_add.svg";

    public static function getHeader($type = null)
    {
        $logIcon = file_get_contents(self::$logIcon);
        $regIcon = file_get_contents(self::$regIcon);

        return '<header class="header">
                        <nav class="header__nav ' . $type . '">
                            <ul class="header__menu menu-left">
                                <li class="menu-item"><a href="/" class="--active">Accueil</a></li>
                                <li class="menu-item"><a href="#">Besoin d\'aide ?</a></li>
                                <li class="menu-item"><a href="#">A propos</a></li>
                            </ul>
                            <ul class="header__menu menu-right">
                                <li class="menu-item"><a id="btn-connexion" href="javascript:void()" class="btn btn-primary-nb">
                                       ' . $logIcon . '&nbsp;Se
                                        connecter
                                    </a></li>
                                <li class="menu-item"><a href="#" class="btn btn-secondary-nb">
                                        ' . $regIcon . '
                                        &nbsp;S\'inscrire
                                    </a></li>
                            </ul>
                        </nav>
                    </header>';
    }
}