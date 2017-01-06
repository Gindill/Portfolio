<?php
/**
 * Created by PhpStorm.
 * User: Dusty
 * Date: 16.12.2016
 * Time: 21:59
 */

require_once "functions.php";

session_start();
$username = null;
$password = null;

if (isset($_SESSION['username']) && isset($_SESSION['password']))
{
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}
else
{
    if ((isset($_COOKIE['username']) && (isset($_COOKIE['password']))))
    {
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['password'] = $_COOKIE['password'];

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    }
    else
    {
        if (($_SERVER['REQUEST_URI'] !== '/login.php') and ($_SERVER['REQUEST_URI'] !== '/register.php'))
        {
            header('Location: /login.php');
            exit();
        }
    }
}

if ($username !== null)
{
    if (!check_auth($username, $password, true))
    {
        logout();
        header('Location: /login.php');
        exit();
    }
}
