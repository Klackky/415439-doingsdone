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
    var_dump($register);

    if (empty($register['name'])) {
      $errors['name'] = 'Введите имя';
    }
    if (empty($register['password'])) {
     $errors['password'] = 'Придумайте пароль';
    }
    if (empty($register['email']) || !filter_var($register['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Введите действительный адрес электронной почты';
    }

    $email = mysqli_real_escape_string($connect, $register['email']);
    $sql_result = "SELECT user_id FROM users WHERE email = $email";
    $email_result = mysqli_query($connect, $sql_result);
    var_dump($email_result);
    if ($email_result) {
      $errors['used_email'] = 'Введенный e-mail уже зарегестрирован';
    }
    if (!count($errors)) {
    $sql = 'INSERT INTO users (registration_date, email, name, password) VALUES (NOW(), ?, ?, ?)';
    $email = $register['email'];
    $name = $register['name'];
    $password = $register['password'];
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
