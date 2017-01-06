<?php
/**
 * Created by PhpStorm.
 * User: Dusty
 * Date: 16.12.2016
 * Time: 21:17
 */
  require_once "functions.php";
  require_once "auth.php";
  require_once "db.php";

  if (isset($_POST['logout']))
  {
      logout();
      header("Location: login.php");
  }
  header("Location: index.php");
