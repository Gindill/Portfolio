<?php
  $link = mysqli_connect("localhost", "root", "", "shop_movies");

  if (!$link)
  {
    exit('Нет соединения с БД');
  }
