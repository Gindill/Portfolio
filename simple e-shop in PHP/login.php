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
      if (check_auth($_POST['username'],$_POST['password']))
      {
          $_SESSION['username'] = $_POST['username'];
          $_SESSION['password'] = md5($_POST['password']);

          if (isset($_POST['remember']))
          {
              setcookie("username", $_POST['username'], time() + 60 * 60 * 24 * 30);
              setcookie("password", md5($_POST['password']), time() + 60 * 60 * 24 * 30);
          }
          header("Location: index.php");
          exit();
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
      <input type="checkbox" name="remember"/> Запомнить меня <br/>
      <button>Авторизоваться</button>
  </form>

  <form action="register.php" method="post">
    <button>Новый пользователь</button>
  </form>
</body>
</html>
