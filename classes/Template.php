<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:26 AM
 */

namespace QAClasses;

class Template
{
    public function __construct($fileName, $parameters = null) {
        $loader = new \Twig_Loader_Filesystem('templates');
        $twig = new \Twig_Environment($loader, []);

        $template = $twig->load("$fileName.twig");

        echo $template->render($parameters);
    }
}