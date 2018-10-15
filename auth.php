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
    if (empty($_POST['password'])) {
      $errors['password'] = 'Введите пароль';
    }
    if (empty($_POST['email'])) {
      $errors['email'] = 'Введите адрес электронной почты';
    }
    $auth['email'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
	  $sql = "SELECT * FROM users WHERE email = '$email'";
  	$res = mysqli_query($connect, $sql);
    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    if(empty($user)) {
      $errors['email'] = 'Такой пользователь не найден';
    }
    if(empty($errors) and !empty($user)) {
      if (password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: /doingsdone");
        exit();
      }
      else {
        $errors['password'] = 'Неверный пароль';
      }
    }
  }
  $content = include_template('auth-form.php', ['projects' => $projects, 'errors' => $errors]);
}
print include_template('layout.php', ['content' => $content, 'projects' => $projects, 'tasks' => $tasks, 'default_tasks' => $tasks, 'title' => 'Дела в порядке - вход на сайт']);
