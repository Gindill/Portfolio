<?php
  require_once "init.php";
  require_once "db.php";
  require_once "functions.php";
  require_once "auth.php";

  // получаем список фильмов в соответствии с выбранным жанром
  $genre_id = 0;
  $where = '1';
  if (isset($_POST['genre']) and ((int) $_POST['genre'] !== 0)) {
    $where = '`movie_genre_id` = ' . $_POST['genre'];
    $genre_id = (int) $_POST['genre'];
  }
  $movies = get_movies_by_genre($genre_id);

  // получаем список жанров
  $genres = get_genres();

  // при добавлении фильма в корзину, сохраняем данные в сессии
  if (isset($_POST['to_basket'])) {
    $_SESSION['basket'][] = $_POST['mov_id'];
  }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Галерея фильмов</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="gallery">
  <aside>
    <p>Добро пожаловать, <?= $username ?>!</p>
    <!-- выбираем жанр для отображения -->
    <form method="post">
      <label for="id_genre">Показать фильмы жанра:</label>
      <select name="genre" id="id_genre">
        <?php
          $selected = '';
          if($genre_id === 0) { // выбраны все жанры
            $selected = ' selected';
          }
          echo "<option value=\"0\"{$selected}>Все</option>";
          foreach ($genres as $genre) {
            $selected = '';
            if((int) $genre['id'] === $genre_id) {
              $selected = ' selected';
            }
            echo "<option value=\"{$genre['id']}\"{$selected}>{$genre['name']}</option>";
          }
        ?>
      </select>
      <button>ОК</button>
    </form>

    <form action="basket.php">
      <button>Перейти в корзину</button>
    </form>

    <form method="post" action="logout.php">
      <button name="logout">Выход</button>
    </form>
  </aside>

  <?php // выводим фильмы на страницу
    foreach ($movies as $mov) {
  ?>
      <article>
        <a href="movie_page.php?id=<?= $mov['id'] ?>" target="_blank">
          <img src="<?= PREVIEW_PATH . $mov['image'] ?>">
          <cite><?= $mov['name'] ?></cite><br>
        </a>
        <p><b>Цена: </b><?= $mov['price'] ?> руб.</p>
        <!-- кнопка добавления в корзину -->
        <form action="index.php" method="post">
          <input type="hidden" name="mov_id" value="<?= $mov['id'] ?>">
          <?php
            $basket_action = '<button name="to_basket">Добавить в корзину</button>';
            // если фильм уже в корзине, отображается надпись
            if(isset($_SESSION['basket']))
            {
              foreach ($_SESSION['basket'] as $movie) {
                if ((int) $movie === (int) $mov['id']) {
                  $basket_action = '<p>В корзине</p>';
                  break;
                }
              }
            }
            echo $basket_action;
          ?>
        </form>
      </article>
  <?php
    }
  ?>
</body>
</html>
