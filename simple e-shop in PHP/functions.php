<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "db.php";

function get_row_by_id($table, $id)
{
  global $link;
  $row = NULL;

  $query = "SELECT * FROM `{$table}` WHERE `id` = '{$id}'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_assoc($result);

  return $row;
}

function get_id_by_name($table, $name)
{
  global $link;
  $row = NULL;

  $query = "SELECT `id` FROM `{$table}` WHERE `name` = '{$name}'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_assoc($result);

  return $row['id'];
}

function get_genres()
{
    global $link;
    $genres = [];

    $query = "SELECT * FROM `genres` WHERE 1";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_assoc($result))
    {
      $genres[] = $row;
    }

    return $genres;
}

function get_genre_by_id($id)
{
  return get_row_by_id('genres', $id);
}

function get_movie_by_id($id)
{
  return get_row_by_id('movies', $id);
}

function get_movies_by_genre($genre = NULL)
{
    global $link;
    $movies = [];

    $where = 1;
    if ($genre)
    {
        $where = '`movie_genre_id` = ' . $genre;
    }

    $query = "SELECT * FROM `movies`
    WHERE $where ORDER BY `popularity` DESC, `name`";
    $result = mysqli_query($link, $query);
    while($row = mysqli_fetch_assoc($result))
    {
        $movies[] = $row;
    }

    return $movies;
}

function movie_popularity_up($id)
{
    global $link;

    $query = "UPDATE `movies` SET `popularity` = `popularity` + 1 WHERE `id` = '{$id}'";
    $result = mysqli_query($link, $query);

    return $result;
}

function get_user_id($name) {
  return get_id_by_name('users', $name);
}

function check_auth($login, $password, $md5 = false)
{
    global $link;
    if (!$md5) $password = md5($password);

    $query = "SELECT COUNT(*) FROM `users` WHERE `name` = '$login' AND `password` = '$password'";

    $result = mysqli_query($link, $query);
    if ($result)
    {
        if ($row = mysqli_fetch_row($result))
        {
            if ($row[0] > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return NULL;
        }
    }
    else
    {
        return NULL;
    }
}

function logout()
{
    if (count($_COOKIE))
    {
        setcookie('username', '', time()-3600);
        setcookie('password', '', time()-3600);
    }
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    session_destroy();
}
