<?php
require_once('config.php');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $task = $_POST;

  if (empty($task['title'])) {
    $errors['title'] = 'Укажите название задачи';
  }
  elseif (mb_strlen($task['title']) > 100) {
    $errors['title'] = 'Длина названия задачи не может превышать 100 символов';
  }

  if (!empty($task['deadline'])) {
    $task['deadline'] = date('Y-m-d', strtotime( htmlspecialchars($task['deadline'])));
    if (!$task['deadline']) {
      $errors['deadline'] = 'Дата должна быть в формате Д.М.Г.';
    }
    elseif (strtotime($task['deadline']) <= strtotime('-1 day')) {
      $errors['deadline'] = 'Дата выполнения не может быть раньше даты создания';
    }
  }

  if (!empty($task['project_id'])) {
    if (!check_if_project_id_exists($connect, $task['project_id'], $user_id)) {
      $errors['project'] = 'Выберите существующий проект';
    }
  }


  if (!empty($_FILES['preview']['name'])) {
    $tmp_name = $_FILES['preview']['tmp_name'];
    $path = $_FILES['preview']['name'];
    $file_type = mime_content_type($tmp_name);
    $types = array("text/plain", "text/html");
    if (strpos($file_type, 'text') !== 0) {
      $errors['file'] = 'Загрузите текстовый файл';
    }
    else{
      $name_extension = pathinfo($_FILES['preview']['name'], PATHINFO_EXTENSION);
      $new_name = uniqid() . '.' . $name_extension;
      $uploaded_file = './uploaded/'.$new_name;
      move_uploaded_file($tmp_name, $uploaded_file);
      $task['file'] = $path;
      $task['path'] = $new_name;
    }
  }
  elseif ($task['uploaded_file']) {
    if (file_exists('./uploaded/'. $task['uploaded_file'])) {
      $task['path'] = $task['uploaded_file'];
    }
  }


  if (!count($errors)) {
    $sql = 'INSERT INTO tasks (project_id, user_id, created, completed, deadline, title, link, file) VALUES (?, ?, NOW(), 0, ?, ?, ?, ?)';
    $project_id = $task['project_id'] ?: null;
    $user_id = $_SESSION['user']['user_id'];
    $deadline = $task['deadline'] ?: null;
    $title = $task['title'];
    $link = $task['path'] ?? null;
    $file = $task['file'] ?? null;
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'iissss', $project_id, $user_id, $deadline, $title, $link, $file);
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
  'default_tasks' => $default_tasks,
]);

$content = include_template('add-task.php', [
  'projects' => $projects,
  'errors' => $errors,
  'uploaded_file' => $uploaded_file ?? '',
  'path' => $task['path'] ?? ''
]);

$layout_content = include_template('layout.php', [
  'content' => $content,
  'sidebar' => $sidebar,
  'tasks' => $tasks,
  'title' => 'Дела в порядке - добавление задачи'
]);

print($layout_content);


