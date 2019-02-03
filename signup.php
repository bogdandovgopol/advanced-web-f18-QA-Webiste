<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 21:50
 */

namespace App;

use App\Helper\Template;
use App\Managers\SessionManager;
use App\Managers\UserManager;

include "vendor/autoload.php";

//start session
SessionManager::initSession();

//check if user is already logged in
if (UserManager::getActiveUser()) {
    //redirect to the homepage
    header("location:/");
}


//handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //handle POST variables
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $avatar = $_FILES['avatar'];

    //sign up
    $response = UserManager::signUp($firstName, $lastName, $email, $password, $avatar);

    //check if signup was successful
    if ($response['success'] == true) {
        //signup is successful
        //create session variables for user_id
        SessionManager::setVars(['user_id' => $response['user_id']]);
        //redirect user to home page
        header("location:/");
    }
}

return new Template('signup', ['response' => $response]);

