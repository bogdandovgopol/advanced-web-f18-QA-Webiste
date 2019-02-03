<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:18 AM
 */

namespace App;

use App\Entity\Post;
use App\Helper\Database;
use App\Helper\Exception\NotFoundHttpException;
use App\Helper\Template;

include "vendor/autoload.php";

//check if slug is empty, if yes return 404 page
if (isset($_GET['name'])) {
    $name = $_GET['name'];
} else {
    return new NotFoundHttpException("Not found something here");
}


//access entitymanager
$entityManager = (new Database())->getEntityManager();

//try to find post
$posts = $entityManager->getRepository(Post::class)->getPostsByTagName($name);

//check if something has been found if not throw 404 page
if (!$posts)
    return new NotFoundHttpException();

return new Template('tag', ['posts' => $posts, 'tag' => $name]);
