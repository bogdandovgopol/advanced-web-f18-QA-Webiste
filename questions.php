<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:18 AM
 */

namespace App;

use App\Helper\Template;
use App\Repository\PostRepository;

include "vendor/autoload.php";


$postRepository = new PostRepository();
$posts = $postRepository->getAllPosts();

return new Template('home', ['posts' => $posts]);
