<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 19:33
 *
 * This file is required by Doctrine to enable command line functionality(create/update/drop database)
 */

namespace App;

use App\Helper\Database;

$database = new Database();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($database->getEntityManager());