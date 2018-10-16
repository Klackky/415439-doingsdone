<?php
require_once('config.php');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $task = $_POST;

  if (empty($task['title'])) {
    $errors['title'] = 'Укажите название задачи';
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
    if (!in_array($file_type, $types)) {
      $errors['file'] = 'Загрузите текстовый файл';
    }
    else {
      move_uploaded_file($tmp_name, './uploaded/'.$path);
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
      header("Location: /doingsdone");
    }
  }
}
$sidebar = include_template('sidebar.php', [
  'projects' => $projects,
  'default_tasks' => $default_tasks,
]);
$content = include_template('add-task.php', ['projects' => $projects, 'errors' => $errors]);
print include_template('layout.php', ['content' => $content, 'sidebar' => $sidebar, 'tasks' => $tasks, 'title' => 'Дела в порядке - добавление задачи']);
