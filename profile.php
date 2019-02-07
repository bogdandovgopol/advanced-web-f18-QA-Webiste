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

//check if slug is empty, if yes return 404 page-
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    return new NotFoundHttpException("Not found something here");
}


//access entitymanager
$entityManager = (new Database())->getEntityManager();


//try to find post
$user = $entityManager->getRepository(User::class)->getUserById($id);

//check if something has been found if not throw 404 page
if (!$user)
    return new NotFoundHttpException();

return new Template('profile', ['post' => $user]);