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
        //check if error code is 400 or 500
        if ($code == 404 || $code == 500) {
            http_response_code($code);
            return new Template("/exceptions/$code", ['code' => $code, 'message' => $message]);
        } else {
            return new Template("/exceptions/custom_error", ['code' => $code, 'message' => $message]);

        }
    }
}