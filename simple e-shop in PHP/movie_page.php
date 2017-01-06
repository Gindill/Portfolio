<?php
  require_once "init.php";
  require_once "db.php";
  require_once "functions.php";

  $id = isset($_GET['id']) ? (int) $_GET['id'] : NULL;

  $movie = get_movie_by_id($id);

  $genre = get_genre_by_id($movie['movie_genre_id']);

  // обновляем данные о просмотрах
  if (movie_popularity_up($id)) // TODO сообщение об ошибке
  {
    $popularity = $movie['popularity'] + 1;
  }
  else
  {
    $popularity = $movie['popularity'];
  }

  $description = nl2br($movie['description']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?= $movie['name']?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="movie_page">
    <article>
      <img src="<?= IMAGE_PATH.$movie['image'] ?>"><br>
      <cite><?= $movie['name'] ?></cite>
      <p><b>Жанр: </b><?= $genre['name'] ?></p>
      <p><?= $description ?></p>
      <p><b>Цена: </b><?= $movie['price'] ?> руб.</p>
      <p><?= $popularity ?> просмотров</p>
    </article>
</body>
</html>
