<?php

namespace App\controllers;

use App\models\entity\Session;
use Doctrine\ORM\Query\FilterCollection;
use Twig\Extension\DebugExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Markup;
use Twig\TwigFilter as Filter;


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
        $twig->addGlobal('message', $_GET['message'] ?? null);
        $twig->addGlobal('containerMessage', $_GET['c'] ?? null);
        $twig->addGlobal('modeIntervenant', Session::get("modeIntervenant") ?? null);

        if (Session::isLogged()) {
            $twig->addGlobal('user', Session::get('user'));
        }
        $twig->addExtension(new DebugExtension());
        $twig->addFilter(new Filter('str_repeat', function ($string, $times) {
            return str_repeat(new Markup($string, 'UTF-8'), $times);
        }));

        echo $twig->render($view, $data);
    }

    public static function addMessageToUrl($message, $containerMessage): string
    {
        $referer = $_SERVER['HTTP_REFERER'];
        $referer_parts = parse_url($referer);
        if (isset($referer_parts['query'])) {
            parse_str($referer_parts['query'], $query_params);
            $query_params['message'] = $message;
            $query_params['c'] = $containerMessage;
            $referer_parts['query'] = http_build_query($query_params);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . $referer_parts['path'] . '?' . $referer_parts['query'];

            if (isset($query_params['nav'])) {
                unset($query_params['nav']);
                $referer_parts['query'] = http_build_query($query_params);
                $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . $referer_parts['path'] . '?' . $referer_parts['query'];
            }

        } else {
            $referer .= '?message=' . $message . '&c=' . $containerMessage;
        }
        return $referer;
    }
}