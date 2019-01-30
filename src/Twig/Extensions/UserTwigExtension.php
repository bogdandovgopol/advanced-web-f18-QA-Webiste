<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 23:54
 */

namespace App\Twig\Extensions;

use App\Managers\UserManager;

class UserTwigExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals()
    {

        return [
            'user' => UserManager::getActiveUser()
        ];
    }
}