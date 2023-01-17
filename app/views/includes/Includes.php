<?php

namespace App\Views\Includes;


class Includes
{

    private static $logIcon = "assets/svg/user.svg";
    private static $regIcon = "assets/svg/user_add.svg";

    public static function getHeader($navbarType = null)
    {

        return include_once "header.php";
    }

    public static function getFooter($userType = "demandeur")
    {
        return include_once "footer.php";
    }
}