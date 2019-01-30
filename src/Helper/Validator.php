<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 2019-01-30
 * Time: 21:52
 */

namespace App\Helper;


class Validator
{
    public static function name($name)
    {
        $errors = [];
        if (false === $name || (empty($name) && '0' != $name)) {
            array_push($errors, 'Cannot be empty');
        }

        if (strlen($name) < 5) {
            array_push($errors, 'Cannot shorter than 5 characters');
        }

        $result = [];
        if (count($errors) > 0) {
            $result['success'] = false;
            $result['errors'] = $errors;
        } else {
            $result['success'] = true;
        }
        return $result;
    }

    public static function password($password)
    {
        $errors = [];
        if (strlen($password) < 6) {
            array_push($errors, 'minimum 6 characters');
        }
        if (ctype_alnum($password)) {
            array_push($errors, 'need to contain a symbol');
        }
        $result = [];
        if (count($errors) > 0) {
            $result['success'] = false;
            $result['errors'] = $errors;
        } else {
            $result['success'] = true;
        }
        return $result;
    }

    public static function email($email)
    {
        $errors = [];
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            array_push($errors, 'invalid email address');
        }
        $result = [];
        if (count($errors) > 0) {
            $result['success'] = false;
            $result['errors'] = $errors;
        } else {
            $result['success'] = true;
        }
        return $result;
    }
}