<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 23/12/18
 * Time: 3:15 PM
 */

namespace App\Helper\Exception;


use App\Helper\Template;

class HttpException
{
    public function __construct(int $code, ?string $message = null)
    {
        http_response_code($code);

        return new Template("/exceptions/$code", ['message' => $message]);
    }
}