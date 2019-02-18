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
        $name = strip_tags($name);
        if (false === $name || (empty($name) && '0' != $name)) {
            array_push($errors, 'Cannot be empty');
        }

        if (strlen($name) < 5) {
            array_push($errors, 'Cannot be shorter than 5 characters');
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
            array_push($errors, 'Minimum 6 characters');
        }
        if (ctype_alnum($password)) {
            array_push($errors, 'Need to contain a symbol');
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
            array_push($errors, 'Invalid email address');
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

    public static function image($file, string $targetDir = 'public/images/avatars/')
    {
        $errors = [];

        $fileName = uniqid() . '-' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($targetFile)) {
            array_push($errors, 'Sorry, file already exists.');
        }
        // Check file size
        if ($file["size"] > 500000) {
            array_push($errors, 'Sorry, your file is too large.');
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            array_push($errors, 'Sorry, only JPG, JPEG, PNG files are allowed.');
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

    public static function comment($comment)
    {
        $errors = [];
        $name = strip_tags($comment);
        if (false === $name || (empty($name) && '0' != $name)) {
            array_push($errors, 'Cannot be empty');
        }

        if (strlen($name) < 30) {
            array_push($errors, 'Cannot be shorter than 30 characters');
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