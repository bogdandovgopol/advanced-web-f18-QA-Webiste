<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 23/12/18
 * Time: 3:27 PM
 */

namespace App\Helper\Exception;


class NotFoundHttpException extends HttpException
{
    public function __construct(?string $message = null)
    {
        parent::__construct(404, $message);
    }
}