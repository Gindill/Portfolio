<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('PICTURES_JSON', 'json/pictures.json');
define('PREVIEW_SIZE', 200);
define('IMG_PATH', 'img/');
define('PREVIEW_PATH', 'img/preview/');

// читаем список файлов картинок из json-файла
$pictures = [];
if (file_exists(PICTURES_JSON)) {
  $pictures = json_decode(file_get_contents(PICTURES_JSON), true);
}

$action = '';
if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

// добавляем картинку в галерею
if ($action === 'insert') {

  // принимаем файл с картинкой
  if (isset($_FILES['pic_file'])) {
    if ($_FILES['pic_file']['error'] === UPLOAD_ERR_OK) {
      // получаем размер картинки и проверяем ее тип
      list($width, $height, $imgtype) = getimagesize($_FILES['pic_file']['tmp_name']);
      if ($imgtype === IMAGETYPE_JPEG) {
        // сохраняем принятый файл картинки
        $filename = date("ymdHis") . '.jpg';
        if (!move_uploaded_file($_FILES['pic_file']['tmp_name'], IMG_PATH . $filename)) {
          exit('Картинка не сохранилась!');
        }
      }
      else {
        exit('Это не картинка!');
      }
    }
    else if ($_FILES['pic_file']['error'] === UPLOAD_ERR_FORM_SIZE) {
      exit('Файл больше 5 мб!');
    }
    else {
      exit('Картинка не загрузилась!');
    }
  }

  // добавляем информацию о файле в список
  $caption = ($_POST['caption']) ? $_POST['caption'] : $_FILES['pic_file']['name'];
  $pictures[] = ['name' => $filename, 'caption' => $caption];
  
  // создаем превьюшку
  $new_width = $new_height = PREVIEW_SIZE;
  if ($width >= $height) {
    $new_height = (int) ($height * $new_width / $width);
  }
  else {
    $new_width = (int) ($width * $new_height / $height);
  }
  $thumb = imagecreatetruecolor($new_width, $new_height);
  $source = imagecreatefromjpeg(IMG_PATH . $filename);
  imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
  imagejpeg($thumb, PREVIEW_PATH . $filename);

  file_put_contents(PICTURES_JSON, json_encode($pictures));
  header('Location: /index.php');
  exit();
}

// удаляем картинку
if ($action === 'delete') {
  foreach ($pictures as $key => $pic) {
    if($pic['name'] === $_POST['file_delete']) {
      unset($pictures[$key]);
      @unlink(IMG_PATH . $_POST['file_delete']);
      @unlink(PREVIEW_PATH . $_POST['file_delete']);
      break;
    }
  }

  file_put_contents(PICTURES_JSON, json_encode($pictures));
  header('Location: /index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Галерея</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <aside>
    <form action="index.php?action=insert" method="post" enctype="multipart/form-data">
      <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
      <p>
        <label for="id_file">Выберите картинку для загрузки: <br></label>
        <input type="file" name="pic_file" id="id_file" accept="image/jpeg"><br>
      </p>
      <p>
        <label for="id_name">Введите подпись к картинке: <br></label>
        <input type="text" name="caption" id="id_caption"><br>
      </p>
      <button>Отправить</button>
    </form>
    <form action="index.php?action=delete" method="post" enctype="multipart/form-data">
      <p>
        <label for="id_list">Выберите картинку для удаления: <br></label>
        <select name="file_delete" id="id_list">
          <?php // выводим список картинок для удаления
            foreach ($pictures as $pic) {
              echo "<option value=\"{$pic['name']}\">{$pic['caption']}</option>";
            }
          ?>
        </select>
      </p>
      <button>Удалить</button>
    </form>
  </aside>
<?php // выводим превьюшки на страницу
      foreach ($pictures as $pic) {
?>
      <article>
        <a href="<?= IMG_PATH . $pic['name'] ?>" target="_blank">
          <img src="<?= PREVIEW_PATH . $pic['name'] ?>">
        </a>
        <cite><?= $pic['caption'] ?></cite>
      </article>
<?php
      }
?>
</body>
</html>
