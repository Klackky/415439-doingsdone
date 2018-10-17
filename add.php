<?php
require_once('config.php');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $task = $_POST;

  if (empty($task['title'])) {
    $errors['title'] = 'Укажите название задачи';
  }
  elseif (mb_strlen($task['title'])> 30) {
    $errors['title'] = 'Длина названия задачи не может превышать 30 символов';
  }

  if (!empty($task['deadline'])) {
    $task['deadline'] = date('Y-m-d', strtotime( htmlspecialchars($task['deadline'])));
    if (!$task['deadline']) {
      $errors['deadline'] = 'Дата должна быть в формате Д.М.Г.';
    }
  }

  if (!empty($_FILES['preview']['name'])) {
    $tmp_name = $_FILES['preview']['tmp_name'];
    $path = $_FILES['preview']['name'];
    $file_type = mime_content_type($tmp_name);
    $types = array("text/plain", "text/html");
  //  if (!in_array($file_type, $types)) {
    if (strpos($file_type, 'text') !== 0) {
      $errors['file'] = 'Загрузите текстовый файл';
    }
    else {
      $name_extension = pathinfo($_FILES['preview']['name'], PATHINFO_EXTENSION);
      $new_name = uniqid() . '.' . $name_extension;
      move_uploaded_file($tmp_name, './uploaded/'.$new_name);
      $task['path'] = $path;
    }
  }


  if (!count($errors)) {
    $sql = 'INSERT INTO tasks (project_id, user_id, created, completed, deadline, title, link) VALUES (?, ?, NOW(), 0, ?, ?, ?)';
    $project_id = $task['project_id'] ?: null;
    $user_id = $_SESSION['user']['user_id'];
    $deadline = $task['deadline'] ?: null;
    $title = $task['title'];
    $link = $task['path'] ?? null;
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'iisss', $project_id, $user_id, $deadline, $title, $link);
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

$sidebar = include_template('sidebar.php', [
  'projects' => $projects,
  'default_tasks' => $default_tasks,
]);

$content = include_template('add-task.php', [
  'projects' => $projects,
  'errors' => $errors
]);

$layout_content = include_template('layout.php', [
  'content' => $content,
  'sidebar' => $sidebar,
  'tasks' => $tasks,
  'title' => 'Дела в порядке - добавление задачи'
]);

print($layout_content);


