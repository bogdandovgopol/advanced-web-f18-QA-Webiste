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


//check if category is not empty and if category is valid, if it is return 404 page
if (isset($_GET['category'])) {

    $category = $_GET['category'];

    if (($category == 1 || $category == 2)) {

        //set the title based on category
        switch ($category) {
            case 1:
                $categoryName = 'Programming Questions';
                break;

            case 2:
                $categoryName = 'Design Questions';
                break;

            default:
                $categoryName = 'All Questions';
                break;

        }
    } else {
        return new NotFoundHttpException();
    }

} else {
    $categoryName = 'All Questions';
}

//access doctrine's entity manager
$entityManager = (new Database())->getEntityManager();

//get all posts
$posts = $entityManager->getRepository(Post::class)->getPostsByTagCategory($category);

return new Template('questions', ['posts' => $posts, 'categoryName' => $categoryName]);
