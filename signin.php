<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 23:03
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
    //redirect to homepage
    header("location:/");
}


//check if post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //get POST variables
    $email = $_POST['email'];
    $password = $_POST['password'];

    //sign in
    $response = UserManager::signIn($email, $password);

    //check if signin was successful
    if ($response['success'] == true) {
        SessionManager::setVars(['user_id' => $response['user_id']]);
        //redirect user to the home page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

}

return new Template('signin', ['response' => $response]);
