<?php
  require_once "db.php";
  require_once "functions.php";
  require_once "auth.php";

  // добавляем заказ в базу
  $user_id = get_user_id($username);
  $sum = $_SESSION['sum'];
  $query = "INSERT INTO `orders` VALUES (NULL, '$user_id', NOW(), '$sum')";
  $result = mysqli_query($link, $query);
  $order_id = mysqli_insert_id($link);

  // добавляем подробности заказа в базу
  foreach ($_SESSION['basket'] as $movie_id) {
    $count = 1;
    // извлекаем из сессии данные о количестве экземпляров фильма
    if (isset($_SESSION['count'])) {
      foreach ($_SESSION['count'] as $key => $value) {
        if ((int) $movie_id === (int) $key) {
          $count = $value;
        }
    }
  }
    $query = "INSERT INTO `order_content`
          VALUES ('$order_id', '$movie_id', '$count')";
    $result = mysqli_query($link, $query);
  }

  // чистим корзину и данные заказа
  unset($_SESSION['basket']);
  unset($_SESSION['count']);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Заказ</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <h2><?= $username ?>, спасибо за сделанный заказ!</h2>
  <form action="index.php">
    <button>На главную</button>
  </form>
</body>
</html>
