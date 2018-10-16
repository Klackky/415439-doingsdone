<?php
require_once('config.php');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST['title'])) {
    $errors['title'] = 'Укажите название проекта';
  }
  var_dump($_POST);
  if (!count($errors)) {
    $sql = 'INSERT INTO projects (title, user_id) VALUES (?, ?)';
    $title = $_POST['title'];
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $title, $user_id);
    $result = mysqli_stmt_execute($stmt);
    var_dump($result);
    if (!$result) {
      $error = mysqli_error($connect);
      $content = include_template('error.php', ['error' => $error]);
    }
    else {
      header("Location: /doingsdone");
    }
  }
}
$sidebar = include_template('sidebar.php', [
  'projects' => $projects,
  'default_tasks' => $tasks,
]);
$content = include_template('add-project.php', ['projects' => $projects, 'errors' => $errors]);
print include_template('layout.php', [
  'content' => $content,
  'sidebar' => $sidebar,
  'title' => 'Дела в порядке - добавление проекта'
]);
