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
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
} else {
    return new NotFoundHttpException("Not found something here");
}


//access entitymanager
$entityManager = (new Database())->getEntityManager();

//try to find post
$post = $entityManager->getRepository(Post::class)->findOneBy(['slug' => $slug]);

//check if something has been found if not throw 404 page
if (!$post)
    return new NotFoundHttpException();

return new Template('detail', ['post' => $post]);
