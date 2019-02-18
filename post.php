<?php
/**
 * Created by PhpStorm.
 * User: 6472
 * Date: 11/12/2018
 * Time: 10:18 AM
 */

namespace App;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Helper\Database;
use App\Helper\Exception\NotFoundHttpException;
use App\Helper\Template;
use App\Helper\Validator;
use App\Managers\SessionManager;
use App\Managers\UserManager;

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

//get user object
$user = $entityManager->getRepository(User::class)->getUserById(SessionManager::getVars()['user_id']);

//+1 view
$post->setViews($post->getViews() + 1);

try {
    //check if submitAnswer POST button is clicked
    if (isset($_POST['submitAnswer'])) {
        //check if logged in
        if (UserManager::getActiveUser() != null) {

            //preparing comment(answer) before pushing into database
            $leaveCommentResponse = leaveComment($post, $user);

            //check if comment(answer) has been successfuly prepared to be pushed
            if ($leaveCommentResponse['success'] == true) {
                //push comment(answer) into database
                $entityManager->flush();
                //refresh page
                header("Refresh:0");
            }
        }
    }
    //check if acceptAnswer POST button is clicked
    if (isset($_POST['acceptAnswer'])) {
        $commentID = $_POST['acceptAnswer'];



        //find comment based on ID
        $comment = $entityManager->getRepository(Comment::class)->find($commentID);

        $post->setAnswered(true);
        $comment->setAnswer(true);


        header("Refresh:0");

    }



    //update views
    $entityManager->flush();

} catch (\Exception $exception) {
    return new NotFoundHttpException();
}


function leaveComment(Post $post, User $user)
{

    $comment = $_POST['comment'];

    //define errors array
    $errors = [];

    //validate comment
    $validComment = Validator::comment($comment);
    if ($validComment['success'] == false) {
        $errors['comment'] = $validComment['errors'];
    }

    //array for result
    $response = [];

    //check if there are errors
    if (count($errors) > 0) {
        //signup not successful
        $response['success'] = false;
        $response['errors'] = $errors;
    } else {
        $newComment = new Comment();
        $newComment->setContent($comment);
        $newComment->setAuthor($user);
        $newComment->setPost($post);

        $post->addComment($newComment);

        $response['success'] = true;
    }

    return $response;

}

return new Template('detail', ['post' => $post, 'response' => $leaveCommentResponse]);
