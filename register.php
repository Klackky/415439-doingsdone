<?php
require_once('functions.php');
require_once('sql-requests.php');
$errors = [];
if (!$connect) {
  $error = mysqli_connect_error();
  $content = include_template('error.php', ['error' => $error]);
}

else {
  $user_id = 2;
  $sql_projects = get_projects_array($user_id);
  $projects = get_array_from_sql($connect, $sql_projects);

  $sql_tasks = get_tasks_array($user_id);
  $tasks = get_array_from_sql($connect, $sql_tasks);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $register = $_POST;

	  $required = ['email', 'password', 'name'];

    if (empty($register['name'])) {
      $errors['name'] = 'Введите имя';
    }
    if (empty($register['password'])) {
      $errors['password'] = 'Придумайте пароль';
    }
    if (empty($register['email'])) {
      $errors['email'] = 'Введите адрес электронной почты';
    } else {
      var_dump($register['email']);
      $register['email'] = filter_var($register['email'], FILTER_VALIDATE_EMAIL);
      if (!$register['email']) {
          $errors['email'] = 'Введите корректный адрес электронной почты';
      } elseif (check_if_email_already_exists($connect, $register['email'])) {
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
      header("Location: /doingsdone");
      }
    }
  }
  $content = include_template('register-form.php', ['errors' => $errors]);
}

print include_template('layout.php', ['content' => $content, 'projects' => $projects, 'tasks' => $tasks, 'default_tasks' => $tasks, 'title' => 'Дела в порядке - регистрация']);
