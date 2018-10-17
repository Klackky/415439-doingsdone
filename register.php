<?php
require_once('config.php');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $register = $_POST;
  if (empty(trim($register['name']))) {
    $errors['name'] = 'Введите имя';
  }
  if (empty(trim($register['password']))) {
    $errors['password'] = 'Придумайте пароль';
  }
  if (empty(trim($register['email']))) {
    $errors['email'] = 'Введите адрес электронной почты';
  }
  else {
    $register['email'] = filter_var($register['email'], FILTER_VALIDATE_EMAIL);
    if (!$register['email']) {
      $errors['email'] = 'Введите корректный адрес электронной почты';
    }
    elseif (check_if_email_already_exists($connect, $register['email'])) {
      $errors['email'] = 'Пользователь с адресом этой электронной почты уже зарегистрирован';
    }
  }

  if (!count($errors)) {
    $sql = 'INSERT INTO users (registration_date, email, name, password) VALUES (NOW(), ?, ?, ?)';
    $email = $register['email'];
    $name = $register['name'];
    $password = password_hash($register['password'], PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $email, $name, $password);
    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
      $error = mysqli_error($connect);
      $content = include_template('error.php', ['error' => $error]);
    }
    else {
      header("Location: index.php");
    }
  }
}
$sidebar = include_template('sidebar.php', []);
$content = include_template('register-form.php', ['errors' => $errors]);
print include_template('layout.php', ['content' => $content, 'sidebar' => $sidebar, 'title' => 'Дела в порядке - регистрация']);
