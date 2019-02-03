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

//check if query is not empty if it is return 404 page
if (isset($_GET['query'])) {
    $query = $_GET['query'];

} else {
    //show 404 error page
    return new NotFoundHttpException();
}


//access doctrine's entity manager
$entityManager = (new Database())->getEntityManager();

//try to find post by query
$posts = $entityManager->getRepository(Post::class)->findBySearchQuery($query);


return new Template('search', ['posts' => $posts, 'query' => $query]);
