<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:26 AM
 */

namespace App\Helper;

use App\Twig\Extensions\UserTwigExtension;

class Template
{
    public function __construct(string $fileName, array $parameters = null)
    {
        $loader = new \Twig_Loader_Filesystem('templates');
        $twig = new \Twig_Environment($loader, []);

        //enable extensions
        $twig->addExtension(new UserTwigExtension());

        $template = $twig->load("$fileName.twig");

        echo $template->render($parameters);
    }
}