<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 21:50
 */

namespace App;


use App\Managers\SessionManager;
use App\Managers\UserManager;

include "vendor/autoload.php";

if (UserManager::getActiveUser()) {
    //destroy session => logout
    SessionManager::destroy();

    //redirect to previous page
    header('Location: /');
}