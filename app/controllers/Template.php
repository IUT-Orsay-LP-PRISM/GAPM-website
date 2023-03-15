<?php

namespace App\controllers;

use App\models\entity\Session;
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
        $twig->addGlobal('userLogged', Session::isLogged());
        $twig->addGlobal('error', $_GET['error'] ?? null);
        $twig->addGlobal('containerError', $_GET['c'] ?? null);
        if (Session::isLogged()) {
            $twig->addGlobal('user', Session::get('user'));
        }
        $twig->addExtension(new DebugExtension());

        echo $twig->render($view, $data);
    }

    public static function addErrorToUrl($error, $containerError): string
    {
        $referer = $_SERVER['HTTP_REFERER'];
        $referer_parts = parse_url($referer);
        if (isset($referer_parts['query'])) {
            parse_str($referer_parts['query'], $query_params);
            $query_params['message'] = $error;
            $query_params['c'] = $containerError;
            $referer_parts['query'] = http_build_query($query_params);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . $referer_parts['path'] . '?' . $referer_parts['query'];
        } else {
            $referer .= '?message=' . $error . '&c=' . $containerError;
        }
        return $referer;
    }
}