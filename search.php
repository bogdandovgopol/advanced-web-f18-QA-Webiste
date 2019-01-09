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

if (isset($_GET['query'])) {
    $query = $_GET['query'];

} else {
    return new NotFoundHttpException();
}


$postRepository = new PostRepository();
$posts = $postRepository->search($query);


return new Template('search', ['posts' => $posts, 'query' => $query]);
