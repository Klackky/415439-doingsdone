<?php
$connect = new mysqli('localhost', 'root', 'rootpassword', 'doingsdone');
mysqli_set_charset($connect, "utf8");

if (!$connect) {
  $error = mysqli_connect_error();
  $content = include_template('error.php', ['error' => $error]);
}

session_start();

if(isset($_SESSION['user'])) {
  $user_id = $_SESSION['user']['user_id'];
  $user = $_SESSION['user'];
}
?>
