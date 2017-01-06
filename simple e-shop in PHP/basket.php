<?php
  require_once "db.php";
  require_once "functions.php";
  require_once "auth.php";

  // формируем список фильмов в корзине, данные берем из сессии
  $basket_list = [];
  if (isset($_SESSION['basket'])) {
    foreach ($_SESSION['basket'] as $basket_id) {
      if ($basket_id) {
        $basket_list[] = get_movie_by_id($basket_id);
      }
    }
  }

  // при пересчете корзины формируем массив количества экземпляров фильмов;
  // данные о количестве получаем из полей ввода и сохраняем их в сессии
  $count = [];
  if (isset($_POST['calc'])) {
    if (isset($_POST['count'])) {
      foreach ($_POST['count'] as $movie_id => $count) {
        $_SESSION['count'][$movie_id] = (int) $count;
      }
    }
  }
  // затем формируем массив для обратного использования в полях ввода
  if (isset($_SESSION['count'])) {
    foreach ($_SESSION['count'] as $key => $value) {
      $count[$key] = (int) $value;
    }
  }

  // удаление фильма из корзины
  if (isset($_POST['out_basket'])) {
    foreach ($_SESSION['basket'] as $key => $basket) {
      if ((int) $basket === (int) $_POST['mov_id']) {
        unset($_SESSION['basket'][$key]);
        header('Location: basket.php');
        exit();
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Корзина</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="basket">
  <table>
    <thead>
      <tr>
        <td>Название</td>
        <td>Цена</td>
        <td>Количество</td>
        <td>Стоимость</td>
        <td></td>
      </tr>
    </thead>
    <?php
      $cost = []; // массив стоимостей фильмов
      $sum = 0;   // сумма заказа
      foreach ($basket_list as $movie) {
        $value = 1; // заказываемое количество экземпляров фильма
        $movie_id = $movie['id'];
        if (isset($count[$movie_id])) {
          // при пересчете корзины в поле ввода отображается введенное ранее значение
          $value = (int) $count[$movie_id];
        }
        $cost[$movie_id] = (int) $movie['price'] * $value;
        echo <<<HTML
        <tr>
          <td>{$movie['name']}</td>
          <td>{$movie['price']} руб.</td>
          <!-- поле ввода количества экземпляров фильма -->
          <td><input type="text" form="recalc_id" name="count[{$movie_id}]" value="{$value}"></td>
          <td>{$cost[$movie_id]} руб.</td>
          <td>
            <form action="basket.php" method="post">
              <input type="hidden" name="mov_id" value="{$movie_id}">
              <button name="out_basket">Удалить из корзины</button>
            </form>
          </td>
        </tr>
HTML;
        $sum += $cost[$movie_id];
        $_SESSION['sum'] = $sum;
      }
      echo "</table>\r\n
          <p><b>Итого: </b>" . count($basket_list) . " фильмов на сумму {$sum} руб.</p>";
  ?>

  <form action="index.php">
    <button>Вернуться</button>
  </form>

  <form id="recalc_id" action="basket.php" method="post">
    <button name="calc">Пересчитать</button>
  </form>

  <form action="order.php">
    <?php
      $disabled = '';
      if (!isset($_SESSION['basket']))
      {
        $disabled = ' disabled';
      }
      echo "<button {$disabled}>Оформить заказ</button>";
    ?>
  </form>
</body>
</html>
