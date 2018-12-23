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
        if ($code == 404 || $code == 500) {
            http_response_code($code);
            return new Template("/exceptions/$code", ['message' => $message]);
        } else {
            return http_response_code($code);
        }
    }
}