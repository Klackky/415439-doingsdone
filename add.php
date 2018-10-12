<?php
require_once('functions.php');
require_once('sql-requests.php');
$errors = [];

if (!$connect) {
    $errors[] = mysqli_connect_error();
}
else {
    $user_id = 2;
    $sql_projects = get_projects_array($user_id);
    $projects = get_array_from_sql($connect, $sql_projects);

    $sql_tasks = get_tasks_array($user_id);
    $tasks = get_array_from_sql($connect, $sql_tasks);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $task = $_POST;

      if (empty($task['title'])) {
        $errors['title'] = 'Укажите название задачи';
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
          $sql = 'INSERT INTO tasks (project_id, created, completed, deadline, title, link) VALUES (?, NOW(), NULL, ?, ?, ?)';
          $project_id = $task['project_id'] ?: null;
          $deadline = $task['deadline'] ? date("Y-m-d",strtotime($task['deadline'])) : null;
          $title = $task['title'];
          $file_path = $task['path'] ?? null;
          $stmt = mysqli_prepare($connect, $sql);
          mysqli_stmt_bind_param($stmt, 'isss', $project_id, $deadline, $title, $file_path);
          $result = mysqli_stmt_execute($stmt);
          header("Location: /doingsdone");
          if (!$result) {
            $errors[] = mysqli_error($connect);
          }

        }
    }
    $content = include_template('add-task.php', ['projects' => $projects, 'errors' => $errors]);
}
print include_template('layout.php', ['content' => $content, 'projects' => $projects, 'default_tasks' => $tasks]);
