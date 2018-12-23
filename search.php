<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:18 AM
 */

namespace App;

use App\Helper\Exception\NotFoundHttpException;
use App\Helper\Template;
use App\Repository\PostRepository;

include "vendor/autoload.php";

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
} else {
    return new NotFoundHttpException("Not found something here");
}



$postRepository = new PostRepository();
$post = $postRepository->getPostBySlug($slug);

if($post == null)
    return new NotFoundHttpException();

return new Template('detail', ['post' => $post]);
