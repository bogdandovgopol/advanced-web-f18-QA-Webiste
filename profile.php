<?php
/**
 * Created by PhpStorm.
 * User: henrique
 * Date: 7/02/2019
 * Time: 2:14 PM
 */

namespace App;

use App\Entity\User;
use App\Helper\Database;
use App\Helper\Exception\NotFoundHttpException;
use App\Helper\Template;
use App\Managers\UserManager;

include "vendor/autoload.php";

//check if slug is empty, if yes return 404 page-
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    return new NotFoundHttpException("Not found something here");
}


//access entitymanager
$entityManager = (new Database())->getEntityManager();

//try to find profile by provided ID
$user = $entityManager->getRepository(User::class)->getUserById($id);

//check if something has been found if not throw 404 page
if (!$user)
    return new NotFoundHttpException();

//handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //handle POST variables
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $avatar = $_FILES['avatar'];

    //sign up
    $response = UserManager::editProfile($user, $firstName, $lastName, $email, $password, $avatar);
    //check if signup was successful
    if ($response['success'] == true) {
        //signup is successful
        //refresh page
        header("Refresh:0");
    }
}

return new Template('profile', ['user' => $user, 'response' => $response]);