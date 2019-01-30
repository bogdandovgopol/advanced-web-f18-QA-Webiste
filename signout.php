<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 21:50
 */

namespace App;

use App\Helper\SessionManager;

include "vendor/autoload.php";

//start session
SessionManager::destroy();
header("location:/");