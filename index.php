<?php
require_once('config.php');

if (!empty($_SESSION)) {
  $default_tasks = get_array_from_sql($connect, $sql_tasks);
  // проверяем есть ли project_id
  if (isset($_GET['project_id'])) {
    $filtered_project = true;
    if ($_GET['project_id']) {
      $project_id = intval($_GET['project_id']);
      $request_project = "SELECT `title`, `project_id` FROM projects WHERE project_id = $project_id and user_id = $user_id";
      $filtered_project = get_array_from_sql($connect, $request_project);
    }

    if(!$filtered_project) {
      $error = http_response_code(404);
      $page_content = include_template('error.php', ['error' => $error]);
    }
    else {
      if (isset($project_id)) {
        $tasks_request = "SELECT `title`, `deadline`, `project_id`, `completed` FROM tasks WHERE project_id = $project_id and user_id = $user_id";
      }
      // если project_id нет, то показываем у отфильтрованного проекта все задачи без project_id
      else {
        $tasks_request = "SELECT `title`, `deadline`, `project_id`, `completed` FROM tasks WHERE project_id IS NULL and user_id = $user_id";
      }
    $tasks = get_array_from_sql($connect, $tasks_request);
    }
  }

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
