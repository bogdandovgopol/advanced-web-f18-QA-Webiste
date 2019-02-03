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
    //destroy session
    SessionManager::destroy();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}