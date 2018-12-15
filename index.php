<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:18 AM
 */

include_once "vendor/autoload.php";

$postClass = new \QAClasses\Post();
$posts = $postClass->getAllPosts();
//$post = $postClass->getPostById(1);
//var_dump($posts);

return new Template('home', ['posts' => $posts]);
