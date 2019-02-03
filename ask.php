<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:18 AM
 */

namespace App;

use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use App\Helper\Database;
use App\Helper\Exception\NotFoundHttpException;
use App\Helper\Template;
use App\Managers\SessionManager;
use App\Managers\UserManager;

include "vendor/autoload.php";

$activeUser = UserManager::getActiveUser();

if ($activeUser == null) {
    header("location:/signin.php");
}

//access doctrine's entity manager
$entityManager = (new Database())->getEntityManager();

//repositories
$userRepository = $entityManager->getRepository(User::class);
$tagRepository = $entityManager->getRepository(Tag::class);

//get all tags
$tags = $tagRepository->findAll();

//check if POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //get data from submitted form
    $title = $_POST['title'];
    $body = $_POST['content'];
    $selectedTags = $_POST['tags'];

    //pushing data into database
    insertPost($title, $body, $selectedTags, $entityManager, $tagRepository, $userRepository);

}

/**
 * @param $title
 * @param $body
 * @param $selectedTags
 * @param \Doctrine\ORM\EntityManager $entityManager
 * @param $tagRepository
 * @param $userRepository
 */
function insertPost($title, $body, $selectedTags, \Doctrine\ORM\EntityManager $entityManager, $tagRepository, $userRepository): void
{
//insert post into db
    $post = new Post();
    $post->setTitle($title);
    $post->setBody($body);

    //get user object based on stored use_id in session
    $post->setAuthor($userRepository->getUserById(SessionManager::getVars()['user_id']));

    //loop through selected tags
    foreach ($selectedTags as $selectedTag) {
        $tag = $tagRepository->find($selectedTag);

        //bind tag with post
        $post->addTag($tag);
    }

    try {
        //push data into database
        $entityManager->persist($post);
        $entityManager->flush();

        //redirect to created post(question)
        header("location:/post.php?slug={$post->getSlug()}");
    } catch (\Exception $exception) {
        //TODO: NOTIFY USER ABOUT AN ERROR
    }
}


return new Template('ask', ['tags' => $tags]);
