<?php

require_once "functions.php";
require_once "auth.php";
require_once "db.php";

if ($username !== null)
{

    header("Location: index.php");
}

if (count($_POST))
{
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = "INSERT INTO `users` VALUES (NULL, '$username', '$password', 4, NULL)";
    $result = mysqli_query($link, $query);
    if ($result)
    {
        header("Location: login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Вход</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="login">
  <form method="post">
      <input type="text" name="username" value="" placeholder="Логин"><br/>
      <input type="password" name="password" value="" placeholder="Пароль"><br/>
      <button>Зарегистрироваться</button>
  </form>
</body>
</html>
