<?php
require_once('config.php');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST['title'])) {
    $errors['title'] = 'Укажите название проекта';
  }
  elseif (mb_strlen($_POST['title'])> 30) {
    $errors['title'] = 'Длина названия проекта не может превышать 30 символов';
  }
  elseif (check_if_project_already_exists($connect, $_POST['title'], $user_id))  {
    $errors['title'] = 'Проект с таким именем уже существует';
  }

  if (!count($errors)) {
    $sql = 'INSERT INTO projects (title, user_id) VALUES (?, ?)';
    $title = $_POST['title'];
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $title, $user_id);
    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
      $error = mysqli_error($connect);
      $content = include_template('error.php', ['error' => $error]);
      $layout_content = include_template('layout.php', [
      'title' => 'Дела в порядке',
      'content' => $content
      ]);
      print ($layout_content);
      die();
    }
    else {
      header("Location: index.php");
    }
  }
}
$sidebar = include_template('sidebar.php', [
  'projects' => $projects,
  'default_tasks' => $tasks,
]);
$content = include_template('add-project.php', ['projects' => $projects, 'errors' => $errors]);
$layout_content = include_template('layout.php', [
  'content' => $content,
  'sidebar' => $sidebar,
  'title' => 'Дела в порядке - добавление проекта'
]);
print($layout_content);

