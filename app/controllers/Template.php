<?php

namespace App\controllers;

use Twig\Extension\DebugExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class Template
{

    /**
     * Fonction render du moteur de template Twig.
     * En gros un moteur de template, c'est pour simplifier l'implémentation de PHP dans les vues.
     * Ca évite d'avoir des balises <?php ?> partout.
     *
     * @param string $template Le nom du template à charger
     * @param array $data Les données à passer au template
     */

    public static function render(string $view, array $data = null)
    {
        $loader = new FilesystemLoader('app/views');
        $loader->addPath('assets');
        $twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);
        $twig->addExtension(new DebugExtension());

        echo $twig->render($view, $data);
    }


}