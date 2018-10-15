<?php
require_once('config.php');

if (!empty($_SESSION)) {
  $default_tasks = get_array_from_sql($connect, $sql_tasks);
  $project_id = false;
  if (isset($_GET['project_id'])) {
    $filtered_project = true;

      $project_id = $_GET['project_id'] ? (int) $_GET['project_id'] : null;
      $request_project = "SELECT `title`, `project_id` FROM projects WHERE project_id = $project_id and user_id = $user_id";
      $filtered_project = get_array_from_sql($connect, $request_project);


    if(!$filtered_project) {
      $error = http_response_code(404);
      $page_content = include_template('error.php', ['error' => $error]);
    }
  }

  $filter_type = null;
  if (isset($_GET['filter_type'])) {
    $filter_type = $_GET['filter_type'];
  }

  $show_completed_tasks = 0;
  if (isset($_GET['show_completed'])) {
    $show_completed_tasks = $_GET['show_completed'] ? null : 0;
  }

  if (isset($_GET['task_id'])) {
    intval($_GET['task_id']);
    $status =  !empty($_GET['check']);
    $result = update_task_status($connect, $status, $_GET['task_id']);
  }

  $sql_tasks = get_tasks_array_by($user_id, $project_id, $show_completed_tasks, $filter_type);
  $tasks = get_array_from_sql($connect, $sql_tasks);
  $page_content = include_template('index.php', [
    'tasks' => $tasks,
    'show_completed_tasks' => $show_completed_tasks,
  ]);

  $layout_content = include_template('layout.php', [
    'content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'default_tasks' => $default_tasks,
  	'title' => 'Дела в порядке - Главная страница'
  ]);
}

else {
  $page_content = include_template('guest.php', []);
  $layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Дела в порядке - Главная страница'
  ]);
}

print($layout_content);
?>
