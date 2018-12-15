<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:18 AM
 */

namespace QAClasses;

include_once "vendor/autoload.php";

$postClass = new Post();
$posts = $postClass->getAllPosts();


return new Template('home', ['posts' => $posts]);
