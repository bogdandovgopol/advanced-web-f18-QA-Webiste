<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:26 AM
 */


class Template
{
    public function __construct($fileName, $parameters) {
        $loader = new Twig_Loader_Filesystem('templates');
        $twig = new Twig_Environment($loader, array(
            'cache' => 'Cache'
        ));

        $template = $twig->load("$fileName.twig");
        echo $template->render($parameters);
    }
}