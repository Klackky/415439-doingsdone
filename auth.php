<?php
require_once('config.php');
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST['password'])) {
    $errors['password'] = 'Введите пароль';
  }
  if (empty($_POST['email'])) {
    $errors['email'] = 'Введите адрес электронной почты';
  }

  $email = mysqli_real_escape_string($connect, $_POST['email']);
	$sql = "SELECT * FROM users WHERE email = '$email'";
  $res = mysqli_query($connect, $sql);
  $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
  if(!empty($_POST['email']) && empty($user)) {
    $errors['email'] = 'Такой пользователь не найден';
  }
  if(empty($errors) and !empty($user)) {
    if (password_verify($_POST['password'], $user['password'])) {
      $_SESSION['user'] = $user;
      header("Location: index.php");
      exit();
    }
    else {
      $errors['password'] = 'Неверный пароль';
    }
  }
}
$sidebar = include_template('sidebar.php', []);

$page_content = include_template('auth-form.php',
  ['errors' => $errors
]);

$layout_content = include_template('layout.php', [
 'content' => $page_content,
 'sidebar' => $sidebar,
 'title' => 'Дела в порядке - вход на сайт']);

print($layout_content);
