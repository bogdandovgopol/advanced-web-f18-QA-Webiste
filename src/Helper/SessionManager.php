<?php
/**
 * Created by PhpStorm.
 * User: bogdandovgopol
 * Date: 16/12/18
 * Time: 2:30 PM
 */

namespace App\Helper;


class SessionManager
{
    public static $sessionId;

    //create session variables
    public static function setVars(Array $vars)
    {
        self::initSession();
        foreach ($vars as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    //return session variables as an associative array
    public static function getVars()
    {
        self::initSession();
        $sessionVars = array();
        foreach ($_SESSION as $name => $value) {
            $sessionVars[$name] = $value;
        }
        return $sessionVars;
    }

    public static function initSession()
    {
        // if session has not been initialised then start it
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        self::$sessionId = session_id();
    }

    public static function regenerate()
    {
        self::initSession();
        session_regenerate_id();
        self::$sessionId = session_id();
    }

    public static function destroy()
    {
        //clears all variables in session
        self::initSession();
        $length = count($_SESSION);
        foreach ($_SESSION as $name => $value) {
            unset($_SESSION[$name]);
        }
        session_destroy();
    }

    public static function getId()
    {
        return self::$sessionId;
    }
}