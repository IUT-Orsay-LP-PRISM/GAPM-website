<?php

namespace App\controllers;

use Twig\Extension\DebugExtension;
use \Twig\Loader;
use \Twig\Environment;
use Twig\Loader\FilesystemLoader;


class TwigController
{

    public static function render(string $view, array $data = null)
    {
        $loader = new FilesystemLoader('app/views');
        $twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);
        $twig->addExtension(new DebugExtension());

        echo $twig->render($view, $data);
    }


}